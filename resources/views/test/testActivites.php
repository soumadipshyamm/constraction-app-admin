// class ActivitesImport implements ToModel, WithHeadingRow
// {
// protected $project;
// protected $subproject;

// public function __construct($project, $subproject)
// {
// $this->project = $project;
// $this->subproject = $subproject;
// }
// public function model(array $row)
// {
// $authConpany = Auth::guard('company')->user()->id;
// $companyId = searchCompanyId($authConpany);

// if ($row['type'] == 'heading' || $row['type'] == 'subheading' || $row['type'] == 'activites') {

// $parentId = null;


// $sl_No = explode(".", $row['sl_no']);
// $slNo = count(explode(".", $row['sl_no']));

// if ($slNo == 1 || $slNo == null) {
// $parentId = null;
// } elseif ($slNo == 2) {
// $parentId = getCheckParentId($sl_No[0], $companyId);
// } elseif ($slNo == 3) {
// $slno = $sl_No[0] . '.' . $sl_No[1];
// $parentId = getCheckParentId($slno, $companyId);
// }


// $data = new Activities([
// 'uuid' => Str::uuid(),
// 'project_id' => $this->project,
// 'subproject_id' => $this->subproject,
// 'type' => $row['type'],
// 'sl_no' => $row['sl_no'],
// 'parent_id' => $parentId,
// 'activities' => $row['activities'],
// 'unit_id' => nametoid($row['unit_id'], 'units') == false ? createunit($row['unit_id'], $companyId) :
nametoid($row['unit_id'], 'units'),
// 'qty' => $row['qty'],
// 'rate' => $row['rate'],
// 'amount' => $row['amount'],
// 'start_date' => $row['start_date'],
// 'end_date' => $row['end_date'],
// 'company_id' => $companyId,
// ]);
// return $data;
// }
// }
// }

<!-- **************************************************************************************************** -->
// class ActivitiesImport implements ToModel, WithHeadingRow
// {
// protected $project;
// protected $subproject;

// public function __construct($project, $subproject)
// {
// $this->project = $project;
// $this->subproject = $subproject;
// }

// public function model(array $row)
// {
// $authCompany = Auth::guard('company')->user()->id;
// $companyId = searchCompanyId($authCompany);

// if ($this->isValidRow($row)) {
// $parentId = $this->calculateParentId($row['sl_no'], $companyId);

// $data = new Activities([
// 'uuid' => Str::uuid(),
// 'project_id' => $this->project,
// 'subproject_id' => $this->subproject,
// 'type' => $row['type'],
// 'sl_no' => $row['sl_no'],
// 'parent_id' => $parentId,
// 'activities' => $row['activities'],
// 'unit_id' => $this->getUnitId($row['unit_id'], $companyId),
// 'qty' => $row['qty'],
// 'rate' => $row['rate'],
// 'amount' => $row['amount'],
// 'start_date' => $row['start_date'],
// 'end_date' => $row['end_date'],
// 'company_id' => $companyId,
// ]);

// return $data;
// }
// }

// protected function isValidRow(array $row)
// {
// return in_array($row['type'], ['heading', 'subheading', 'activites']);
// }

// protected function calculateParentId($slNo, $companyId)
// {
// $slNoParts = explode('.', $slNo);
// $slNoCount = count($slNoParts);

// if ($slNoCount === 1 || $slNoCount === null) {
// return null;
// } elseif ($slNoCount === 2) {
// return $this->getCheckParentId($slNoParts[0], $companyId);
// } elseif ($slNoCount === 3) {
// $slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
// return $this->getCheckParentId($slNoCombined, $companyId);
// }

// return null;
// }

// protected function getCheckParentId($slNo, $companyId)
// {
// // Implement your logic for retrieving the parent ID here
// // Example: return someParentId;
// }

// protected function getUnitId($unitName, $companyId)
// {
// $unitId = nametoid($unitName, 'units');
// if ($unitId === false) {
// $unitId = createunit($unitName, $companyId);
// }
// return $unitId;
// }
// }


<!-- ******************************************************************************************************* -->


{
protected $project;
protected $subproject;
protected $companyId;

public function __construct($project, $subproject, $companyId)
{
$this->project = $project;
$this->subproject = $subproject;
$this->companyId = $companyId;
}
public function model(array $row)
{
$companyId = $this->companyId;

if ($this->isValidRow($row)) {

if ($this->isValidSlNo($row, $companyId)) {

$parentId = $this->calculateParentId($row['sl_no'], $companyId);

$data = new Activities([
'uuid' => Str::uuid(),
'project_id' => $this->project,
'subproject_id' => $this->subproject,
'type' => $row['type'],
'sl_no' => $row['sl_no'],
'parent_id' => $parentId,
'activities' => $row['activities'],
'unit_id' => $this->getUnitId($row['unit_id'], $companyId),
'qty' => $row['qty'],
'rate' => $row['rate'],
'amount' => $row['amount'],
'start_date' => $row['start_date'],
'end_date' => $row['end_date'],
'company_id' => $companyId,
]);

return $data;
}
}
}

// *********************************************************************************
protected function isValidRow(array $row)
{
return in_array($row['type'], ['heading', 'subheading', 'activites']);
}

protected function isValidSlNo(array $row, $companyId)
{
$slNoParts = explode('.', $row['sl_no']);
$slNoCount = count($slNoParts);

if ($slNoCount === 1 || $slNoCount === null) {
$isvalid = true;
} elseif ($slNoCount === 2) {
$isvalid = $this->getCheckSlNo($slNoParts[0], $companyId);
} elseif ($slNoCount === 3) {
$slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
$isvalid = $this->getCheckSlNo($slNoCombined, $companyId);;
}
return $isvalid;
}

protected function calculateParentId($slNo, $companyId)
{
$slNoParts = explode('.', $slNo);
$slNoCount = count($slNoParts);

if ($slNoCount === 1 || $slNoCount === null) {
return null;
} elseif ($slNoCount === 2) {
return $this->getCheckParentId($slNoParts[0], $companyId);
} elseif ($slNoCount === 3) {
$slNoCombined = $slNoParts[0] . '.' . $slNoParts[1];
return $this->getCheckParentId($slNoCombined, $companyId);
}
return null;
}

protected function getCheckParentId($slNoParts, $companyId)
{
$data = Activities::where('sl_no', $slNoParts)->where('company_id', $companyId)->orderBy('id', 'DESC')->first();
if ($data == null) {
return null;
}
return $data->id;
}
protected function getCheckSlNo($slNoParts, $companyId)
{
$data = Activities::where('sl_no', $slNoParts)->where('company_id', $companyId)->orderBy('id', 'DESC')->first();
if ($data == null) {
return false;
}
return $data->id;
}

protected function getUnitId($unitName, $companyId)
{
$unitId = nametoid($unitName, 'units');
if ($unitId === false) {
$unitId = createunit($unitName, $companyId);
}
return $unitId;
}
}