<?php

namespace App\Listeners;

use App\Events\ExcelDataImported;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountImportedRows
{
    public function handle(ExcelDataImported $event)
    {
        // $importedRowCount = $event->importedRowCount;

        // You can now store, display, or log the imported row count as needed.
        // For example, you can log it using Laravel's logging system.
        // Log::info("Imported $importedRowCount rows from Excel.");

        // Or you can store it in a database table, display it to the user, etc.
    }
}
