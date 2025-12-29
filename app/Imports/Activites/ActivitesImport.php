<?php

namespace App\Imports\Activites;

use Illuminate\Support\Str;
use App\Models\Company\Activities;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ActivitesImport implements ToModel, WithHeadingRow
{
    protected $project;
    protected $subproject;
    protected $companyId;
    protected $tmpcachekey;

    public function __construct($project, $subproject, $companyId, $tmpcachekey)
    {
        $this->project     = $project;
        $this->subproject  = $subproject;
        $this->companyId   = $companyId;
        $this->tmpcachekey = $tmpcachekey;
    }

    public function model(array $row)
    {
        // --- Normalize & log
        $row = $this->normalizeRow($row);
        Log::info('[ActivitiesImport] Row', [
            'type' => $row['type'] ?? null,
            'sl_no' => $row['sl_no'] ?? null,
            'activities' => $row['activities'] ?? null,
            'units' => $row['units'] ?? null,
        ]);

        // --- Required checks
        if ($this->isNullRow($row)) {
            $this->cacheInvalidRow($row, 'Missing required "type" or "activities".');
            return null;
        }

        // --- Type
        $type = $this->normalizeType($row['type'] ?? null);

        // --- Parent decision:
        // heading => parent_id = null
        // activity => parent_id from sl_no ("2.1" → "2"), or if sl_no empty → latest heading above
        $parentId = $this->determineParentId($row['sl_no'] ?? null, $type);

        // Activities MUST have a parent
        if ($type === 'activity' && $parentId === null) {
            $this->cacheInvalidRow($row, 'Activity row requires a parent heading (no parent found).');
            return null;
        }

        // --- Validate sl_no structure for activity with dotted sl (parent must exist)
        if (!$this->isValidSlNo($row, $type)) {
            $this->cacheInvalidRow($row, 'Invalid SL No structure or missing parent for dotted child.');
            return null;
        }

        // --- Resolve fields
        $unitId = $this->getUnitId($row['units'] ?? null);
        $qty    = $this->toNumber($row['qty'] ?? 0);
        $rate   = $this->toNumber($row['rate'] ?? 0);
        $amount = $qty * $rate;

        $start  = $this->safeDate($row['start_datedd_mm_yyyy'] ?? null);
        $end    = $this->safeDate($row['end_datedd_mm_yyyy'] ?? null);

        // --- De-duplication: uuid → sl_no (scoped) → (parent_id + activities)
        $existing = $this->findExisting($row, $parentId);

        if ($existing) {
            $dirty =
                (int)$existing->parent_id !== (int)($parentId ?? 0) ||
                (string)$existing->type !== (string)$type ||
                (string)$existing->sl_no !== (string)($row['sl_no'] ?? null) ||
                (string)$existing->activities !== (string)$row['activities'] ||
                (int)$existing->unit_id !== (int)($unitId ?? 0) ||
                (float)$existing->qty !== (float)$qty ||
                (float)$existing->rate !== (float)$rate ||
                (float)$existing->amount !== (float)$amount ||
                (string)optional($existing->start_date) !== (string)$start ||
                (string)optional($existing->end_date) !== (string)$end;

            if ($dirty) {
                $existing->update([
                    'project_id'    => $this->project,
                    'subproject_id' => $this->subproject,
                    'type'          => $type,
                    'sl_no'         => $row['sl_no'] ?? null,
                    'parent_id'     => $parentId,
                    'activities'    => $row['activities'],
                    'unit_id'       => $unitId,
                    'qty'           => $qty,
                    'rate'          => $rate,
                    'amount'        => $amount,
                    'start_date'    => $start,
                    'end_date'      => $end,
                    'company_id'    => $this->companyId,
                ]);
                Log::info('[ActivitiesImport] Updated', ['id' => $existing->id, 'sl_no' => $row['sl_no'] ?? null]);
            }

            // ToModel: return null to skip creation
            return null;
        }

        // --- Create new row
        $data = new Activities([
            'uuid'          => $row['uuid'] ?? Str::uuid()->toString(),
            'project_id'    => $this->project,
            'subproject_id' => $this->subproject,
            'type'          => $type,
            'sl_no'         => $row['sl_no'] ?? null,
            'parent_id'     => $parentId,
            'activities'    => $row['activities'],
            'unit_id'       => $unitId,
            'qty'           => $qty,
            'rate'          => $rate,
            'amount'        => $amount,
            'start_date'    => $start,
            'end_date'      => $end,
            'company_id'    => $this->companyId,
        ]);

        Log::info('[ActivitiesImport] Creating', [
            'type' => $type,
            'sl_no' => $row['sl_no'] ?? null,
            'activities' => $row['activities']
        ]);

        return $data;
    }

    /* ================= Helpers ================= */

    protected function normalizeRow(array $row): array
    {
        // Drop accidental index/header columns like "", "#" etc.
        unset($row[''], $row['#']);

        foreach (['uuid', 'type', 'sl_no', 'activities', 'units'] as $k) {
            if (isset($row[$k]) && is_string($row[$k])) {
                $row[$k] = trim($row[$k]);
                if ($row[$k] === '') $row[$k] = null;
            }
        }

        // normalize type
        if (!empty($row['type'])) {
            $row['type'] = $this->normalizeType($row['type']);
        }

        return $row;
    }

    protected function normalizeType(?string $t): string
    {
        $t = strtolower(trim((string)$t));
        if ($t === 'activities') $t = 'activity';
        return in_array($t, ['heading', 'activity'], true) ? $t : 'activity';
    }

    protected function isNullRow(array $row): bool
    {
        return empty($row['activities']) || empty($row['type']);
    }

    protected function isValidSlNo(array $row, string $type): bool
    {
        $sl = $row['sl_no'] ?? null;

        // Headings can have null sl_no (your sheet shows this)
        if ($type === 'heading') {
            return true;
        }

        // For activities:
        // - null sl_no is OK (we attach to the latest heading)
        // - "x.y" or deeper requires that parent "x" (or "x.y") exists as heading
        if (empty($sl)) return true;

        $sl = (string)$sl;
        if (strpos($sl, '.') === false) {
            // Single-level child sl_no like "2" → allowed if a heading "2" exists
            return $this->headingExistsBySl($sl);
        }

        // Dotted child: parent must exist
        $parts = explode('.', $sl);
        array_pop($parts);
        $parentSl = implode('.', $parts);
        return $this->headingExistsBySl($parentSl);
    }

    protected function determineParentId($slNo, string $type): ?int
    {
        if ($type === 'heading') {
            return null;
        }

        $slNo = $slNo !== null ? (string)$slNo : null;

        // Activity with dotted sl_no → parent is left-side
        if (!empty($slNo) && strpos($slNo, '.') !== false) {
            $parts = explode('.', $slNo);
            array_pop($parts);
            $parentSl = implode('.', $parts);
            return $this->getHeadingIdBySl($parentSl);
        }

        // Activity with single-level sl_no (e.g., "2") → parent is heading "2" if exists
        if (!empty($slNo)) {
            $pid = $this->getHeadingIdBySl($slNo);
            if ($pid) return $pid;
        }

        // Activity with null sl_no → attach to latest heading above (in this project/subproject)
        return Activities::query()
            ->where('company_id', $this->companyId)
            ->where('project_id', $this->project)
            ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
            ->where('type', 'heading')
            ->orderByDesc('id')
            ->value('id');
    }

    protected function headingExistsBySl(string $sl): bool
    {
        return Activities::query()
            ->where('company_id', $this->companyId)
            ->where('project_id', $this->project)
            ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
            ->where('type', 'heading')
            ->where('sl_no', $sl)
            ->exists();
    }

    protected function getHeadingIdBySl(string $sl): ?int
    {
        return Activities::query()
            ->where('company_id', $this->companyId)
            ->where('project_id', $this->project)
            ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
            ->where('type', 'heading')
            ->where('sl_no', $sl)
            ->value('id');
    }

    protected function findExisting(array $row, ?int $parentId): ?Activities
    {
        // strongest: uuid
        if (!empty($row['uuid'])) {
            $x = Activities::query()
                ->where('company_id', $this->companyId)
                ->where('uuid', $row['uuid'])
                ->first();
            if ($x) return $x;
        }

        // sl_no scoped to project/subproject
        if (!empty($row['sl_no'])) {
            $x = Activities::query()
                ->where('company_id', $this->companyId)
                ->where('project_id', $this->project)
                ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
                ->where('sl_no', $row['sl_no'])
                ->first();
            if ($x) return $x;
        }

        // fallback: same parent + same activities name
        return Activities::query()
            ->where('company_id', $this->companyId)
            ->where('project_id', $this->project)
            ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
            ->where('parent_id', $parentId)
            ->where('activities', $row['activities'] ?? null)
            ->first();
    }

    protected function toNumber($v): float
    {
        // Ignore Excel formulas like "=I2*J2"
        if (is_string($v) && strlen($v) && $v[0] === '=') return 0.0;
        return is_numeric($v) ? (float)$v : 0.0;
    }

    protected function safeDate($v)
    {
        // If you already have excelDateToDate() helper, use it first
        try {
            $d = excelDateToDate($v);
            if ($d) return $d;
        } catch (\Throwable $e) {
            // ignore
        }

        // Accept ISO strings directly
        if (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) return $v;

        // Last resort parse
        if (is_string($v) && strtotime($v)) return date('Y-m-d', strtotime($v));

        return null;
    }

    protected function getUnitId(?string $unitName): ?int
    {
        if (!$unitName) return null;

        // Your helpers
        $unitId = nametoid($unitName, 'units');
        if ($unitId === false || $unitId === null) {
            $unitId = createunit($unitName, $this->companyId);
        }
        return $unitId ?: null;
    }

    protected function cacheInvalidRow(array $row, string $reason): void
    {
        $invalid = Cache::get($this->tmpcachekey, []);
        $invalid[] = ['row' => $row, 'reason' => $reason];
        Cache::put($this->tmpcachekey, $invalid);
        Log::warning('[ActivitiesImport] Invalid row', [
            'reason' => $reason,
            'type'   => $row['type'] ?? null,
            'sl_no'  => $row['sl_no'] ?? null,
            'act'    => $row['activities'] ?? null,
        ]);
    }
}

// namespace App\Imports\Activites;

// use Illuminate\Support\Str;
// use App\Models\Company\Activities;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Cache;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

// class ActivitesImport implements ToModel, WithHeadingRow
// {
//     protected $project;
//     protected $subproject;
//     protected $companyId;
//     protected $tmpcachekey;

//     // keep track of the latest heading sl_no during this import pass
//     protected ?string $currentHeadingSl = null;

//     public function __construct($project, $subproject, $companyId, $tmpcachekey)
//     {
//         $this->project     = $project;
//         $this->subproject  = $subproject;
//         $this->companyId   = $companyId;
//         $this->tmpcachekey = $tmpcachekey;
//     }

//     public function model(array $row)
//     {
//         $row = $this->normalizeRow($row);

//         Log::info('[ActivitiesImport] Row', [
//             'type' => $row['type'] ?? null,
//             'sl_no' => $row['sl_no'] ?? null,
//             'activities' => $row['activities'] ?? null,
//             'units' => $row['units'] ?? null,
//         ]);

//         // Required fields
//         if ($this->isNullRow($row)) {
//             $this->cacheInvalidRow($row, 'Missing required "type" or "activities".');
//             return null;
//         }

//         // Resolve unit/qty/rate/amount
//         $unitId = $this->getUnitId($row['units'] ?? null);
//         $qty    = $this->toNumber($row['qty'] ?? 0);
//         $rate   = $this->toNumber($row['rate'] ?? 0);
//         $amount = $qty * $rate;

//         $start  = $this->safeDate($row['start_datedd_mm_yyyy'] ?? null);
//         $end    = $this->safeDate($row['end_datedd_mm_yyyy'] ?? null);

//         // === PARENT/CHILD RULES ===
//         $type = $this->resolveType($row['type'] ?? null);

//         // Auto-numbering if SL No is empty:
//         if (empty($row['sl_no'])) {
//             if ($type === 'heading') {
//                 // next top-level integer (1,2,3…)
//                 $row['sl_no'] = $this->getNextHeadingSlNo();
//                 $this->currentHeadingSl = $row['sl_no']; // remember for children
//             } else { // activity => child of latest heading
//                 $parentSl = $this->getCurrentHeadingSlOrNull();
//                 if (!$parentSl) {
//                     $this->cacheInvalidRow($row, 'Activity row has no SL No and no preceding heading to attach to.');
//                     return null;
//                 }
//                 $row['sl_no'] = $this->getNextChildSlNo($parentSl);
//             }
//         } else {
//             // If they provided SL No, update our current heading marker when it's a heading (e.g., "2")
//             if ($type === 'heading' && $this->isTopLevelSl($row['sl_no'])) {
//                 $this->currentHeadingSl = $row['sl_no'];
//             }
//         }

//         // Find parent_id based on the SL No hierarchy (e.g., "2.1" → parent "2")
//         $parentId = $this->calculateParentIdScoped($row['sl_no']);

//         // Validate: activities must have a parent
//         if ($type === 'activity' && $parentId === null) {
//             $this->cacheInvalidRow($row, 'Activity row requires a parent heading (missing SL No parent or heading not created yet).');
//             return null;
//         }

//         // De-duplication: uuid → sl_no (scoped) → (parent_id + activities)
//         $existing = $this->findExisting($row, $parentId);

//         if ($existing) {
//             $dirty =
//                 (int)$existing->parent_id !== (int)($parentId ?? 0) ||
//                 (string)$existing->type !== (string)$type ||
//                 (string)$existing->sl_no !== (string)$row['sl_no'] ||
//                 (string)$existing->activities !== (string)$row['activities'] ||
//                 (int)$existing->unit_id !== (int)($unitId ?? 0) ||
//                 (float)$existing->qty !== (float)$qty ||
//                 (float)$existing->rate !== (float)$rate ||
//                 (float)$existing->amount !== (float)$amount ||
//                 (string)optional($existing->start_date) !== (string)$start ||
//                 (string)optional($existing->end_date) !== (string)$end;

//             if ($dirty) {
//                 $existing->update([
//                     'project_id'    => $this->project,
//                     'subproject_id' => $this->subproject,
//                     'type'          => $type,
//                     'sl_no'         => $row['sl_no'],
//                     'parent_id'     => $parentId,
//                     'activities'    => $row['activities'],
//                     'unit_id'       => $unitId,
//                     'qty'           => $qty,
//                     'rate'          => $rate,
//                     'amount'        => $amount,
//                     'start_date'    => $start,
//                     'end_date'      => $end,
//                     'company_id'    => $this->companyId,
//                 ]);
//                 Log::info('[ActivitiesImport] Updated', ['id' => $existing->id, 'sl_no' => $row['sl_no']]);
//             }

//             return null; // skip creation
//         }

//         // Create new
//         $data = new Activities([
//             'uuid'          => $row['uuid'] ?? Str::uuid()->toString(),
//             'project_id'    => $this->project,
//             'subproject_id' => $this->subproject,
//             'type'          => $type,
//             'sl_no'         => $row['sl_no'],
//             'parent_id'     => $parentId,
//             'activities'    => $row['activities'],
//             'unit_id'       => $unitId,
//             'qty'           => $qty,
//             'rate'          => $rate,
//             'amount'        => $amount,
//             'start_date'    => $start,
//             'end_date'      => $end,
//             'company_id'    => $this->companyId,
//         ]);

//         Log::info('[ActivitiesImport] Creating', [
//             'type' => $type,
//             'sl_no' => $row['sl_no'],
//             'activities' => $row['activities']
//         ]);

//         return $data;
//     }

//     /* ================= Helpers ================= */

//     protected function normalizeRow(array $row): array
//     {
//         // Drop "#" or accidental empty header column
//         unset($row[''], $row['#']);

//         foreach (['uuid', 'type', 'sl_no', 'activities', 'units'] as $k) {
//             if (isset($row[$k]) && is_string($row[$k])) {
//                 $row[$k] = trim($row[$k]);
//                 if ($row[$k] === '') $row[$k] = null;
//             }
//         }

//         // normalize type
//         if (!empty($row['type'])) {
//             $t = strtolower($row['type']);
//             if ($t === 'activities') $t = 'activity';
//             if (in_array($t, ['heading', 'activity'], true)) {
//                 $row['type'] = $t;
//             }
//         }

//         return $row;
//     }

//     protected function isNullRow(array $row): bool
//     {
//         return empty($row['activities']) || empty($row['type']);
//     }

//     protected function resolveType(?string $given): string
//     {
//         $given = $given ? strtolower($given) : null;
//         return in_array($given, ['heading', 'activity'], true) ? $given : 'activity';
//     }

//     protected function isTopLevelSl(string $sl): bool
//     {
//         return strpos($sl, '.') === false;
//     }

//     protected function looksLikeChild(string $sl): bool
//     {
//         return strpos($sl, '.') !== false;
//     }

//     protected function calculateParentIdScoped(?string $slNo): ?int
//     {
//         if (!$slNo) return null;
//         if ($this->isTopLevelSl($slNo)) return null;

//         $parts = explode('.', $slNo);
//         array_pop($parts);
//         $parentSl = implode('.', $parts);

//         return Activities::query()
//             ->where('company_id', $this->companyId)
//             ->where('project_id', $this->project)
//             ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//             ->where('sl_no', $parentSl)
//             ->value('id');
//     }

//     protected function findExisting(array $row, ?int $parentId): ?Activities
//     {
//         if (!empty($row['uuid'])) {
//             $x = Activities::query()
//                 ->where('company_id', $this->companyId)
//                 ->where('uuid', $row['uuid'])->first();
//             if ($x) return $x;
//         }

//         if (!empty($row['sl_no'])) {
//             $x = Activities::query()
//                 ->where('company_id', $this->companyId)
//                 ->where('project_id', $this->project)
//                 ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//                 ->where('sl_no', $row['sl_no'])->first();
//             if ($x) return $x;
//         }

//         return Activities::query()
//             ->where('company_id', $this->companyId)
//             ->where('project_id', $this->project)
//             ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//             ->where('parent_id', $parentId)
//             ->where('activities', $row['activities'])
//             ->first();
//     }

//     /* ---------- Auto numbering ---------- */

//     protected function getCurrentHeadingSlOrNull(): ?string
//     {
//         if ($this->currentHeadingSl) return $this->currentHeadingSl;

//         // fallback: last inserted heading for this project/subproject
//         $last = Activities::query()
//             ->where('company_id', $this->companyId)
//             ->where('project_id', $this->project)
//             ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//             ->where('type', 'heading')
//             ->orderByDesc('id')
//             ->value('sl_no');

//         $this->currentHeadingSl = $last ?: null;
//         return $this->currentHeadingSl;
//     }

//     protected function getNextHeadingSlNo(): string
//     {
//         // Find max integer sl_no with no dots
//         $max = Activities::query()
//             ->where('company_id', $this->companyId)
//             ->where('project_id', $this->project)
//             ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//             ->whereRaw("sl_no IS NULL OR INSTR(sl_no, '.') = 0")
//             ->pluck('sl_no')
//             ->map(function ($v) {
//                 return is_numeric($v) ? (int)$v : 0;
//             })
//             ->max();

//         $next = (int)$max + 1;
//         return (string)$next;
//     }

//     protected function getNextChildSlNo(string $parentSl): string
//     {
//         // Find max child index for sl_no like "parentSl.%"
//         $children = Activities::query()
//             ->where('company_id', $this->companyId)
//             ->where('project_id', $this->project)
//             ->when($this->subproject, fn($q) => $q->where('subproject_id', $this->subproject))
//             ->where('sl_no', 'like', $parentSl . '.%')
//             ->pluck('sl_no');

//         $maxChild = 0;
//         foreach ($children as $sl) {
//             $parts = explode('.', $sl);
//             if (count($parts) >= 2 && $parts[0] === $parentSl) {
//                 $idx = (int)end($parts);
//                 if ($idx > $maxChild) $maxChild = $idx;
//             }
//         }

//         return $parentSl . '.' . ($maxChild + 1);
//     }

//     /* ---------- Misc ---------- */

//     protected function toNumber($v): float
//     {
//         if (is_string($v) && strlen($v) && $v[0] === '=') return 0.0; // ignore formulas
//         return is_numeric($v) ? (float)$v : 0.0;
//     }

//     protected function safeDate($v)
//     {
//         try {
//             $d = excelDateToDate($v);
//             if ($d) return $d;
//         } catch (\Throwable $e) {
//         }
//         if (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) return $v;
//         if (is_string($v) && strtotime($v)) return date('Y-m-d', strtotime($v));
//         return null;
//     }

//     protected function getUnitId(?string $unitName): ?int
//     {
//         if (!$unitName) return null;
//         $unitId = nametoid($unitName, 'units');
//         if ($unitId === false || $unitId === null) {
//             $unitId = createunit($unitName, $this->companyId);
//         }
//         return $unitId ?: null;
//     }

//     protected function cacheInvalidRow(array $row, string $reason): void
//     {
//         $invalid = Cache::get($this->tmpcachekey, []);
//         $invalid[] = ['row' => $row, 'reason' => $reason];
//         Cache::put($this->tmpcachekey, $invalid);
//         Log::warning('[ActivitiesImport] Invalid row', ['reason' => $reason, 'sl_no' => $row['sl_no'] ?? null, 'type' => $row['type'] ?? null]);
//     }
// }
