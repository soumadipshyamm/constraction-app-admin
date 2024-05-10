<?php

namespace App\Http\Controllers\Admin\cms;

use App\Http\Controllers\BaseController;
use App\Models\Admin\Cms\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Home Page Managment');
        $datas = HomePage::all();
        if (!empty($datas)) {
            return view('Admin.cms.homePage.blockContent.index', compact('datas'));
        }
        return view('Admin.cms.homePage.blockContent.index');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'content_title' => 'required',
                'content' => 'required',
                'img' => 'mimes:jpg,png,jpeg',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'home_pages');
                    // dd($id);
                    if ($request->hasFile('img')) {
                        deleteFile($id, 'home_pages', 'img', 'page_banner');
                        $isUpdated = HomePage::where('id', $id)->update([
                            'block_title' => $request->block_title,
                            'content_title' => $request->content_title,
                            'content' => $request->content,
                            'img' => getImgUpload($request->img, 'page_banner'),
                        ]);
                    } else {
                        $isUpdated = HomePage::where('id', $id)->update([
                            'block_title' => $request->block_title,
                            'content_title' => $request->content_title,
                            'content' => $request->content,
                        ]);
                    }

                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('admin.homePage.list')->with('success', 'Page Managment Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    // dd($e->getMessage());
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    // Session::flash('error', 'something want to be worng');
                    return redirect()->route('admin.homePage.list')->with('false', $e->getMessage());
                }
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function edit($uuid)
    {

        $id = uuidtoid($uuid, 'home_pages');
        $data = HomePage::where('id', $id)->first();
        if ($data) {
            return view('Admin.cms.homePage.blockContent.add-edit', compact('data'));
        }
        return redirect()->route('Admin.homePage.list')->with('error', 'something want to be worng');

    }

    public function uploadFile(Request $request)
    {
        // dd($request->hasFile('upload'));
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}

// "_token" => "aOl3pCEM6t2KwhLgD3uEvdDByxdXnZ0yO1maxCOh"
// "uuid" => "1009364f-8b02-4b94-ba03-3b57a90b83e3"
// "block_title" => null
// "content_title" => null
// "page_contented" => null
// "img" => Illuminate\Http\UploadedFile {#471 ▶}
// ]
