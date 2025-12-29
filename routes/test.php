<?php

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::controller(TestController::class)->prefix('test')->as('test.')->group(function () {
    // Route::get('/test', 'index')->name('testHome');
    Route::get('/test-export', 'exporttest')->name('testExport');
    // Route::get('/ajax_endpoint', 'ajax_endpoint')->name('ajax_endpoint');
    // Route::post('add-item', 'addItem')->name('add_item_endpoint');

    Route::get('bulk-import-export-upload', 'bulkbulkupload')->name('bulkbulkupload');

    Route::get('export', 'export')->name('export');
    Route::get('demo-export', 'DemoExportUnit')->name('demoExport');
    Route::get('importExportView', 'importExportView');
    Route::post('import', 'import')->name('import');
});
