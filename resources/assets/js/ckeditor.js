CKEDITOR.replace("page_contented", {
    filebrowserUploadUrl:
        "{{route('admin.pageManagment.uploadFile', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: "form",
});
