<?php

namespace App\Http\Controllers\Admin\cms;

use App\Http\Controllers\BaseController;
use App\Models\Admin\PageManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageManagmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Pages Managment');
        $datas = PageManagment::where('slug', '!=', 'home')->get();
        if (!empty($datas)) {
            return view('Admin.cms.sitePageManagment.index', compact('datas'));
        }
        return view('Admin.cms.sitePageManagment.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'page_name' => 'required',
                'page_title' => 'required',
                'page_contented' => 'required',
                'page_banner' => 'mimes:jpg,png,jpeg',
            ]);
            DB::beginTransaction();
            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'page_managments');

                    $isUpdated = PageManagment::where('id', $id)->update([
                        'page_name' => $request->page_name,
                        'page_title' => $request->page_title,
                        'page_contented' => $request->page_contented,
                    ]);

                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('admin.pageManagment.list')->with('success', 'Page Managment Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.pageManagment.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    // $imgName = '';
                    $isPageCreated = PageManagment::create([
                        'page_name' => $request->page_name,
                        'page_title' => $request->page_title,
                        'page_contented' => $request->page_contented,
                        // 'page_banner' => getImgUpload($request->page_banner, 'page_banner'),
                    ]);

                    if ($isPageCreated) {
                        DB::commit();
                        return redirect()->route('admin.pageManagment.list')->with('success', 'Page Managment Created Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.pageManagment.list')->with('error', $e->getMessage());
                }
            }
        }
        return view('Admin.cms.sitePageManagment.add-edit');
    }

    public function edit(Request $request, $uuid)
    {
        $id = uuidtoid($uuid, 'page_managments');
        $data = PageManagment::where('id', $id)->first();
        if ($data) {
            return view('Admin.cms.sitePageManagment.add-edit', compact('data'));
        }
        return redirect()->route('Admin.pageManagment.list')->with('error', 'something want to be worng');
    }

    // ckeditor image upload
    public function uploadFile(Request $request)
    {
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
