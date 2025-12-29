<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Company\Unit;
use Illuminate\Http\Request;
use App\Exports\MyDataExport;
use App\Imports\MyDataImport;
use App\Models\Company\Labour;
use App\Models\Company\Activities;
use App\Exports\Unit\DemoExportUnit;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function index()
    {
        // return view('test.dropdown');
        return view('test.test1');
    }
    public function ajax_endpoint(Request $request)
    {
        // Query your data source to retrieve the items
        $items = Activities::select('id', 'type')->get();

        // Format the data as JSON and return it
        return response()->json($items);
    }

    public function addItem(Request $request)
    {
        Session::put('navbar', 'show');
        $authConpany = Auth::guard('company')->user()->id;
        $companyId = searchCompanyId($authConpany);

        // Retrieve the item text from the request
        $itemText = $request->input('item_text');


        $isCompaniesCreated = Activities::create([
            'uuid' => Str::uuid(),
            'type' => $itemText,
            'unit_id' => 12,
            'company_id' => $companyId,
        ]);

        dd($itemText->type);
        // You can return a success message or response here if needed
        return response()->json(['message' => 'Item added successfully']);
    }

    public function exporttest()
    {
        // return "tredsa";
        return view('test.export');
    }

    // public function exportCsv(Request $request)
    // {
    //     $fileName = 'tasks.csv';
    //     $tasks = Labour::all();

    //     $headers = array(
    //         "Content-type" => "text/csv",
    //         "Content-Disposition" => "attachment; filename=$fileName",
    //         "Pragma" => "no-cache",
    //         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
    //         "Expires" => "0",
    //     );

    //     $columns = array('Title', 'Assign');

    //     $callback = function () use ($tasks, $columns) {
    //         $file = fopen('php://output', 'w');
    //         fputcsv($file, $columns);

    //         foreach ($tasks as $task) {
    //             $row['Title'] = $task->name;
    //             $row['Assign'] = $task->category;

    //             fputcsv($file, array($row['Title'], $row['Assign']));
    //         }

    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    // **************************************************************************************
    public function importExportView()
    {

        //         $labours = Labour::with('units')->get();
        // dd($labours);
        return view('test.ex_im');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new MyDataExport, 'users.xlsx');
    }

    /**
     * It will return \Illuminate\Support\Collection
     */
    // public function import()
    // {
    //     $import = new MyDataImport();

    //     $filePath = request()->file('file');

    //     Excel::filter('chunk')->load($filePath)->chunk(200, function ($results) use ($import) {
    //         // Get the highest data row in the chunk
    //         $highestDataRow = $results->getHighestDataRow();

    //         $import->setTotalRows($highestDataRow);

    //         Excel::import(new MyDataImport, $results);
    //     });

    //     $totalRows = $import->getTotalRows();
    //     dd($totalRows);
    // }

    public function DemoExportUnit()
    {
        return Excel::download(new DemoExportUnit, 'demo_unit_export.xlsx');

        return back();
    }


    // public function testSms()
    // {
    //     $otp = 1234;
    //     $number = 8972344111;
    //     return sendSms($otp, $number);
    // }
}
