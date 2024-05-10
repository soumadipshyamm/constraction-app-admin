<?php
// company user add and update

public function addaa(Request $request)
{
$authCompany = auth('company')->user();
$companyId = searchCompanyId($authCompany->id);

if ($request->isMethod('post')) {
$validator = Validator::make($request->all(), [
'company_user_role' => 'required',
'name' => 'required',
'email' => 'required|email|unique:company_users,email,' . $request->uuid,
'phone' => 'required',
'address' => 'required',
'designation' => 'required',
'img' => 'mimes:jpeg,jpg,png',
]);

if ($validator->fails()) {
return redirect()->back()->withErrors($validator)->withInput();
}

DB::beginTransaction();

try {
$userData = [
'name' => $request->name,
'phone' => $request->phone,
'email' => $request->email,
'country' => $request->country,
'city' => $request->city,
'dob' => $request->dob,
'address' => $request->address,
'designation' => $request->designation,
'aadhar_no' => $request->aadhar_no,
'pan_no' => $request->pan_no,
'company_id' => $companyId,
'company_role_id' => $request->company_user_role,
'reporting_person' => $request->reporting_person,
];

if ($request->has('password')) {
$userData['password'] = Hash::make($request->password);
}

if ($request->hasFile('img')) {
$userData['profile_images'] = getImgUpload($request->img, 'profile_image');
}

if ($request->uuid) {
$id = uuidtoid($request->uuid, 'company_users');
CompanyUser::where('id', $id)->update($userData);
$message = 'User Updated Successfully';
} else {
$userData['uuid'] = Str::uuid();
CompanyUser::create($userData);

// You might want to associate a role here, as you did before
// CompanyUserRole::create([...]);

$message = 'User Created Successfully';
}

DB::commit();
return redirect()->route('company.userManagment.list')->with('success', $message);
} catch (\Exception $e) {
DB::rollBack();
logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
return redirect()->route('company.userManagment.list')->with('error', $e->getMessage());
}
}

return view('Company.userManagment.add-user');
}
