<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Admin\Cms\HomePage;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\PageManagment;
use App\Models\Company\CompanyUser;
use App\Models\Admin\Cms\BannerPage;
use App\Models\Company\Company_role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyuserRole;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BaseController;
use App\Mail\TestMail;
use App\Models\Admin\Settings\ContactReport;
use App\Models\Company\StoreWarehouse;
use App\Models\Subscription\SubscriptionPackage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


Validator::extend('valid_tld', function ($attribute, $value, $parameters, $validator) {
    $validTlds = ['com', 'org', 'net', 'edu', 'gov', 'mil']; // Add more valid TLDs as needed
    $domain = substr(strrchr($value, '.'), 1); // Get the domain part after the last dot
    return in_array($domain, $validTlds);
});
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Str;
class PageController extends BaseController
{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('companyLogout');
    // }
    /**
     * Display a listing of the resource.
     */
    // public function test()
    // {
    //     // return "testtttt";
    //     // return view('Frontend.home.test');
    // }

    public function index()
    {
        $banners = BannerPage::where('page_id', '1')->orderBy('id', 'desc')->first();
        // dd($banners);
        $datas = HomePage::all();
        // dd($datas->toArray());
        return view('Frontend.home.index', compact('datas', 'banners'));
    }
    // **************************************************************************
    public function about()
    {
        // $banners = BannerPage::all();
        $datas = PageManagment::with('banner')->where('slug', 'about')->first();
        // $datas = PageManagment::with(['banner' => function ($q) {
        //     $q->orderBy('page_id', 'desc');
        // }])->get();
        // dd($datas);
        return view('Frontend.aboutUs.index', compact('datas'));
    }
    // **************************************************************************
    public function page($page)
    {
        // dd($page.'/'.$uuid);
        $datas = PageManagment::where('slug', $page)->first();
        // $datas = PageManagment::where('slug', $page)->where('uuid', $uuid)->first();
        // dd($datas->toArray());
        return view('Frontend.aboutUs.index', compact('datas'));
    }
    // **************************************************************************
    public function contactUs(Request $request)
    {
        $banners = BannerPage::whereHas('pageManagment', function ($q) {
            $q->where('slug', 'contact-us');
        })->orderBy('id', 'desc')->first();
        // dd($banners);
        if ($request->isMethod('post')) {

            DB::beginTransaction();
            try {
                $findAdminId = findAdmin();
                // dd($findAdminId->id);
                $ContactReport = new ContactReport();
                $ContactReport->name = $request['name'];
                $ContactReport->email = $request['email'];
                $ContactReport->phone = $request['phone'];
                $ContactReport->subject = $request['subject'];
                $ContactReport->message = $request['message'];
                $ContactReport->save();
                /// email send to admin
                $to = $findAdminId->email;
                $subject = $ContactReport->subject;
                $template = 'emails.contactUs';
                $data = [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'subject' => $request['subject'],
                    'message' => $request['message'],
                ];
                // dd($data);

                Mail::to($to)->send(new TestMail($data, $subject, $template));

                adminNotifaction('Contact Us', $request['subject'], '', "", $findAdminId->id ?? '', $request['message']);

                if ($ContactReport) {
                    DB::commit();
                    // dd($ContactReport);
                    return redirect()->back()->with('success', 'Your Message Successfully Sending');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->back()->with('false', $e->getMessage());
            }
        }
        return view('Frontend.contactUs.index', compact('banners'));
    }
    // **************************************************************************
    public function product()
    {
        $datas = PageManagment::with('banner')->where('slug', 'product')->first();
        // dd($datas);
        return view('Frontend.product.index', compact('datas'));
    }
    // **************************************************************************
    public function login()
    {
        // dd("kjhgfds");
        // try {
        //code...
        return view('Frontend.auth.login');
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
    }
    // **************************************************************************
    public function registration(Request $request)
    {
        if ($request->isMethod('post')) {
            log_daily(
                'registration',
                'Registration request received with data.',
                'registration',
                'info',
                json_encode($request->all())
            );

            $validatedData = $request->validate([
                'registration_name' => 'required',
                'company_address' => 'required',
                "company_phone" => 'required',
                "company_country_code" => 'required',
                "country_code" => 'required',
                'phone' => 'required',
                'name' => 'required',
                'email' => 'required|email|max:250|valid_tld|unique:company_users,email',
                'password' => 'required|confirmed',
                'profile_images' => 'mimes:jpeg,jpg,png',
                'country' => 'required',
                'states' => 'required',
                'city' => 'required',
            ]);
            $is_subscribed = getFreeSubscribeId('');
            DB::beginTransaction();
            try {
                $isCompaniesCreated = CompanyManagment::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->registration_name,
                    'registration_no' => $request->company_registration_no,
                    'address' => $request->company_address,
                    'country_code' => $request->company_country_code,
                    'phone' => $request->company_phone,
                    'is_subscribed' => $is_subscribed->id,
                    'website_link' => $request->website_link,
                ]);
                // $isRoleCreated = Company_role::create([
                //     'name' => 'Super Admin',
                //     'slug' => createSlug('Super Admin'),
                //     'company_id' => $isCompaniesCreated->id
                // ]);
                $isCompanyUser = CompanyUser::create([
                    'uuid' => Str::uuid(),
                    'name' => $request->name,
                    'country_code' => $request->country_code,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'tps_code' => $request->password,
                    'password' => Hash::make($request->password),
                    'country' => $request->country,
                    'state' => $request->states,
                    'city' => $request->city,
                    // 'dob' => $request->dob,
                    'designation' => "Owner",
                    'company_id' => $isCompaniesCreated->id,
                    'company_role_id' => createSlug($isCompaniesCreated->id),
                    'profile_images' => getImgUpload($request->profile_images, 'profile_image'),
                ]);


                if ($isCompaniesCreated) {
                    DB::commit();
                    $domeData = domeData($isCompaniesCreated->id);
                    log_daily(
                        'registration',
                        'dome Data add ' . $isCompaniesCreated?->id,
                        'domeData',
                        'info',
                        json_encode($domeData)
                    );
                    return redirect()->route('company.login')->with('success', 'You have successfully Registration');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                logger($e->getMessage() . '--' . $e->getFile() . '--' . $e->getLine());
                return redirect()->route('company.registration')->with('error', $e->getMessage());
            }
        }
        return view('Frontend.auth.registration');
    }
    // **************************************************************************
    public function loginPost(Request $request)
    {
        log_daily(
            'login',
            'Login request received with data.',
            'loginPost',
            'info',
            json_encode($request->all())
        );
        $credentials = $request->validate([
            'email' => 'required|min:3|email',
            'password' => 'required',
        ]);

        // dd(Auth::guard('company')->attempt($credentials));
        if (Auth::guard('company')->attempt($credentials)) {
            $authConpany = Auth::guard('company')->user()->id;
            $companyId = searchCompanyId($authConpany);
            // $isSubscription = checkSubscribePackage($companyId);
            // dd($isSubscription);
            // if (isset($isSubscription->free_subscription) && $isSubscription->free_subscription != 1) {
            $request->session()->regenerate();
            return redirect()->route('company.home')
                ->withSuccess('You have successfully logged in!');
            // } else {
            //     return view('Frontend.auth.free-login-user');
            // }
        }
        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }
    // **************************************************************************
    public function logout(Request $request)
    {
        log_daily(
            'logout',
            'logout request received with data.' . auth()->user()?->id,
            'logout',
            'info',
            json_encode(Auth::guard('company')->user())
        );
        Auth::guard('company')->logout();
        // Auth::logout();
        // Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('company.login')
            ->withSuccess('You have logged out successfully!');
    }
    // **************************************************************************
    public function showForgetPasswordForm(Request $request)
    {
        return view('Company.auth.forgetPassword');
    }
    // **************************************************************************
    public function submitForgetPasswordForm(Request $request)
    {
        log_daily(
            'password',
            'submitForgetPasswordForm request received with data.',
            'submitForgetPasswordForm',
            'info',
            json_encode($request->all())
        );
        $request->validate([
            'email' => 'required|email|exists:company_users',
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email], // Condition to check for existing record
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        return back()->with('message', 'We have emailed your password reset link!');
    }
    // **************************************************************************
    public function showResetPasswordForm($token)
    {
        return view('Company.auth.forgetPasswordLink', ['token' => $token]);
    }
    // **************************************************************************
    public function submitResetPasswordForm(Request $request)
    {
        log_daily(
            'password',
            'submitResetPasswordForm request received with data.',
            'submitResetPasswordForm',
            'info',
            json_encode($request->all())
        );
        $request->validate([
            'email' => 'required|email|exists:company_users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        // dd($request->all());
        $updatePassword = DB::table('password_resets')
            ->where('email', $request->email)->where('token', $request->token)
            ->first();
        // dd($updatePassword);
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $user = CompanyManagment::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();
        return redirect()->route('company.login')->with('message', 'Your password has been changed!');
    }
    // **************************************************************************
    public function subscription(Request $request)
    {
        log_daily(
            'subscription',
            'subscription request received with data.',
            'subscription',
            'info',
            json_encode($request->all())
        );
        $isFetch = SubscriptionPackage::where('is_active', 1)->get();
        return view('Frontend.subscription.index', compact('isFetch'));
    }

    public function privacyPolicy(Request $request)
    {
        return view("Frontend.privacy-policy.index");
    }
}
