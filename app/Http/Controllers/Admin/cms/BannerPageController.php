<?php

namespace App\Http\Controllers\Admin\cms;

use App\Http\Controllers\BaseController;
use App\Models\Admin\Cms\BannerPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BannerPageController extends BaseController
{

    public function index()
    {
        $this->setPageTitle('Home Page Managment');
        // $datas = BannerPage::with('pageManagment')->get();
        $datas = BannerPage::all();
        // dd($datas);
        if (!empty($datas)) {
            return view('Admin.cms.banner.index', compact('datas'));
        }
        return view('Admin.cms.banner.index');
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'page_id' => 'required',
                'title' => 'required',
                'contented' => 'required',
                'banner' => 'mimes:jpg,png,jpeg',
            ]);
            DB::beginTransaction();

            if ($request->uuid) {
                try {
                    $id = uuidtoid($request->uuid, 'banner_pages');
                    // dd($id);
                    if ($request->hasFile('banner')) {
                        // deleteFile($id, 'banner_pages', 'banner', 'page_banner');
                        $isUpdated = BannerPage::where('id', $id)->update([
                            'page_id' => $request->page_id,
                            'title' => $request->title,
                            'contented' => $request->contented,
                            'banner' => getImgUpload($request->banner, 'page_banner'),
                        ]);
                    } else {
                        $isUpdated = BannerPage::where('id', $id)->update([
                            'page_id' => $request->page_id,
                            'title' => $request->title,
                            'contented' => $request->contented,
                        ]);
                    }
                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('admin.bannerManagment.list')->with('success', 'Page Banner  Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.bannerManagment.list')->with('false', $e->getMessage());
                }
            } else {
                try {
                    $isUpdated = BannerPage::create([
                        'uuid' => Str::uuid(),
                        'page_id' => $request->page_id,
                        'title' => $request->title,
                        'contented' => $request->contented,
                        'banner' => getImgUpload($request->banner, 'page_banner'),
                    ]);

                    if ($isUpdated) {
                        DB::commit();
                        return redirect()->route('admin.bannerManagment.list')->with('success', 'Page Banner  Updated Successfully');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                    return redirect()->route('admin.bannerManagment.list')->with('false', $e->getMessage());
                }
            }
        }
        return view('Admin.cms.banner.add-edit');
    }

    public function edit($uuid)
    {
        $id = uuidtoid($uuid, 'banner_pages');
        $data = BannerPage::where('id', $id)->first();
        if ($data) {
            return view('Admin.cms.banner.add-edit', compact('data'));
        }
        return redirect()->route('Admin.bannerManagment.list')->with('error', 'something want to be worng');
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
// array:6 [▼ // app\Http\Controllers\Admin\cms\BannerPageController.php:26
//   "_token" => "3WlLZmjuM7ncxa5F9MRS9315ynqgnWbPhyby29cH"
//   "uuid" => null
//   "page_id" => "16"
//   "title" => "about"
//   "contented" => "<p>page_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_idpage_id</p>"
//   "banner" => Illuminate\Http\UploadedFile {#487 ▶}
