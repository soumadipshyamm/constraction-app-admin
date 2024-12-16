<?php

namespace App\Http\Controllers\API\inventory;

use App\Http\Controllers\BaseController;
use App\Http\Resources\API\Inventory\inventor\InventoryResources;
use App\Http\Resources\API\Inventory\Quotes\QuotesDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialRequestSendVendorResource;
use App\Http\Resources\API\Inventory\Quotes\QuotesMaterialsDetailsresources;
use App\Http\Resources\API\Inventory\Quotes\Quotesresources;
use App\Http\Resources\API\Materials\MaterialsResources;
use App\Http\Resources\API\Vendor\VendorResources;
use App\Models\QuotesDetails;
use Illuminate\Http\Request;
use App\Models\Company\Quote;
use App\Models\QuotesMaterialRequest;
use App\Models\QuotesMaterialSendVendor;
use Google\Service\ShoppingContent\Resource\Collections;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class QuotesDetailsController extends BaseController
{
    public function index()
    {
        $authConpany = Auth::guard('company-api')->user()->company_id;
        $data = Quote::where('company_id', $authConpany)
            ->where('created_at', '>=', now()->subDays(15))
            ->orderBy('id', 'desc')
            ->get();
        if (isset($data)) {
            return $this->responseJson(true, 200, 'Fetch Quote List Successfullsy', InventoryResources::collection($data));
        } else {
            return $this->responseJson(true, 200, 'Quote List Data Not Found', []);
        }
    }

    public function add(Request $request)
    {
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            // 'quotes_id' => 'required',
            // 'materials_id' => 'required',
            // 'material_requests_id' => 'required',
            // 'material_request_details_id' => 'required',
            // 'date' => 'required',
            // 'remarkes' => 'required',
            // 'img' => 'required|image',
            // 'qty' => 'required|numeric',
            // 'request_qty' => 'required|numeric',
            // 'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            $quoteDetail = [];
            $datas = $request->all();
            // dd($datas);
            if (isset($datas['img'])) {
                $remarkes = $datas['remarkes'];
                $img = $request->img ? getImgUpload($request->img, 'upload') : null;
                $existingQuoteDetail = $datas['id'] != null ? QuotesDetails::where('id', $datas['id'])->first() : null;
                if ($existingQuoteDetail?->id != null) {
                    $quoteDetail = $existingQuoteDetail->update([
                        'date' => null,
                        'remarkes' => $remarkes,
                        'img' => $img ?? null
                    ]);
                } else {
                    $quoteDetail = QuotesDetails::create([
                        'company_id' => $authCompany,
                        'quotes_id' => $datas['quotes_id'],
                        'date' => $datas['date'],
                        'remarkes' => $remarkes,
                        'activities_id' => $datas['activities_id']->id,
                        'materials_id' => null,
                        'material_requests_id' => null,
                        'material_request_details_id' => null,
                        'img' => $img ?? null
                    ]);
                }
            } else {
                // dd($datas);
                foreach ($datas as $value) {
                    if (!empty($value['id'])) {
                        $quoteDetailItem = QuotesDetails::find($value['id']);
                        if (!$quoteDetailItem) {
                            return $this->responseJson(false, 404, 'Quote Detail not found', []);
                        }
                        $quoteDetail[] = $quoteDetailItem;
                        // Update existing quote detail
                        $quoteDetailItem->update([
                            'materials_id' => $value['materials'],
                            'material_requests_id' => $value['material_requests_id'],
                            'material_request_details_id' => $value['material_request_details_id'],
                            'date' => $value['date'],
                            'request_qty' => $value['request_qty'],
                            'price' => $value['price'],
                        ]);
                    } else {
                        // Create new quote detail
                        $quoteDetail[] = QuotesDetails::create([
                            'quotes_id' => $value['quotes_id'],
                            'materials_id' => $value['materials'],
                            'material_requests_id' => $value['material_requests_id'],
                            'material_request_details_id' => $value['material_request_details_id'],
                            'date' => $value['date'],
                            'qty' => $value['qty'],
                            'request_qty' => $value['request_qty'],
                            'price' => $value['price'],
                            'company_id' => $authCompany,
                        ]);
                    }
                }
            }
            DB::commit();
            return $this->responseJson(true, 200, 'Quote Detail Added Successfully', $quoteDetail);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add quote detail: ' . $e->getMessage());
            return $this->responseJson(false, 500, 'Failed to add quote detail', []);
        }
    }







    // *******************************************************************************************************

    public function edit(Request $request)
    {
        $fetchVendorDatas = [];
        $fetches = [];
        $dataimg = [];
        $fetchData = [];
        $id = $request->quotesId;
        $findId = Quote::find($id);

        if (!$findId) {
            return $this->responseJson(false, 404, 'ID Not Found', []);
        }

        $authCompany = Auth::guard('company-api')->user()->company_id;
        $data = Quote::with('quotesdetails')
            ->where('company_id', $authCompany)
            ->where('id', $id)
            ->first();

            // dd($data);
        $data->quotesdetails->each(function ($q) {
            $q->load(['materialsRequest']);
        });
        // dd($data);
        foreach ($data->quotesdetails as $value) {
            if ($value->material_requests_id) {
                $fetches = $value;
            } else {
                $dataimg = $value;
            }
        }
        // dd($fetches->quotes->materialrequestvendor);
        $fetchVendorData = $fetches?->quotes?->materialrequestvendor;
        // $fetchVendorDatas = $fetchVendorData->each(function ($value, $key) {
        //     return $value->vendorlist;
        //     // dd(->toArray());
        //     // $value->material_requests_id = $querssy->id;
        // });
        // dd($fetchVendorDatas);
        $fetchData['flage'] = empty($dataimg) ? 1 : 0;
        $fetchData['vendor_data'] = $fetchVendorData ? QuotesMaterialRequestSendVendorResource::collection($fetchVendorData) : [];
        $fetchData['data'] = empty($dataimg) ? ($fetches ? new QuotesMaterialsDetailsresources($fetches) : []) : ($dataimg ? new QuotesDetailsresources($dataimg) : []);

        return $this->responseJson(true, 200, 'Fetch Quote List Successfully', $fetchData);
    }

    // *******************************************************************************************************
    public function materialrequestSendToVendor(Request $request)
    {
        // Validate incoming request if needed
        $authCompany = Auth::guard('company-api')->user()->company_id;
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer',
            'vendor_id' => 'required|array',
            // 'quotes_details_id' => 'required|array',
        ]);
        if ($validator->fails()) {
            return $this->responseJson(false, 422, $validator->errors()->first(), []);
        }
        DB::beginTransaction();
        try {
            // dd($request->all());
            $quoteDetail = [];
            // Extract data from the request
            $type = $request->input('type');
            $vendorIds = $request->input('vendor_id');
            $quoteDetailsIds = $request->input('quotes_details_id');
            $quotes_id = $request->input('quotes_id');
            $material_request_details_id = $request->input('material_request_details_id');
            $material_requests_id = $request->input('material_requests_id');
            $materials_id = $request->input('materials_id');
            // $quoteDetailsId = $quoteDetailsIds[$index];
            foreach ($vendorIds as $index => $vendorId) {
                foreach ($quotes_id as $key => $qtrdetails) {
                    $quoteDetail[] = QuotesMaterialSendVendor::create([
                        'vendors_id' => $vendorId,
                        'materials_id' => $materials_id ? $materials_id[$key] : null,
                        'quotes_details_id' => $quoteDetailsIds ? $quoteDetailsIds[$key] : null,
                        'quotes_id' => $qtrdetails,
                        'material_request_details_id' => $material_request_details_id ? $material_request_details_id[$key] : null,
                        'type' => $type,
                        'company_id' => $authCompany
                    ]);
                }
            }

            DB::commit();
            $quoteDetailResource = QuotesMaterialRequestSendVendorResource::collection($quoteDetail);

            return $this->responseJson(true, 200, 'Quote Details Updated Successfully',  $quoteDetailResource);
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage() . ' on ' . $e->getFile() . ' in ' . $e->getLine());
            return $this->responseJson(false, 500, $e->getMessage(), []);
        }
    }
}



######################################################################################################################################
######################################################################################################################################
######################################################################################################################################
use App\Mail\VendorQuoteNotification; // Assuming this mail class is created
use Illuminate\Support\Facades\Mail;

public function materialrequestSendToVendor(Request $request)
{
    // Authenticate and retrieve the company ID
    $authCompany = Auth::guard('company-api')->user()->company_id;

    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'type' => 'required|integer',
        'vendor_id' => 'required|array',
        'quotes_details_id' => 'nullable|array',
        'quotes_id' => 'required|array',
        'material_request_details_id' => 'nullable|array',
        'materials_id' => 'nullable|array',
        'material_requests_id' => 'nullable|array',
    ]);

    if ($validator->fails()) {
        return $this->responseJson(false, 422, $validator->errors()->first(), []);
    }

    DB::beginTransaction();
    try {
        // Extract validated input
        $type = $request->input('type');
        $vendorIds = $request->input('vendor_id');
        $quotesIdList = $request->input('quotes_id');
        $quotesDetailsIdList = $request->input('quotes_details_id', []);
        $materialRequestDetailsIdList = $request->input('material_request_details_id', []);
        $materialsIdList = $request->input('materials_id', []);

        $quoteDetails = [];

        // Loop through vendors and quotes to create records
        foreach ($vendorIds as $vendorId) {
            foreach ($quotesIdList as $index => $quoteId) {
                $quoteDetails[] = QuotesMaterialSendVendor::create([
                    'vendors_id' => $vendorId,
                    'materials_id' => $materialsIdList[$index] ?? null,
                    'quotes_details_id' => $quotesDetailsIdList[$index] ?? null,
                    'quotes_id' => $quoteId,
                    'material_request_details_id' => $materialRequestDetailsIdList[$index] ?? null,
                    'type' => $type,
                    'company_id' => $authCompany,
                ]);
            }

            // After processing each vendor, send them an email
            $vendor = Vendor::find($vendorId); // Assuming the Vendor model exists
            if ($vendor && $vendor->email) {
                // Prepare data for the email
                $emailData = [
                    'vendor' => $vendor,
                    'type' => $type,
                    'quotes' => $quoteDetails, // You can pass specific details here
                ];

                // Send email using the mail class
                Mail::to($vendor->email)->send(new VendorQuoteNotification($emailData));
            }
        }

        // Commit transaction
        DB::commit();

        // Return resource collection
        $quoteDetailResource = QuotesMaterialRequestSendVendorResource::collection($quoteDetails);

        return $this->responseJson(true, 200, 'Quote Details Updated and Emails Sent Successfully', $quoteDetailResource);
    } catch (\Exception $e) {
        DB::rollBack();
        logger("Error: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        return $this->responseJson(false, 500, 'An error occurred while processing the request.', []);
    }
}


php artisan make:mail VendorQuoteNotification --markdown=emails.vendor_quote_notification


    namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorQuoteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Quote Request')
                    ->markdown('emails.vendor_quote_notification')
                    ->with('data', $this->data);
    }
}



resources/views/emails/vendor_quote_notification.blade.php

@component('mail::message')
# Quote Request for Vendor

Hello {{ $data['vendor']->name }},

We have a new quote request for you.

**Quote Type:** {{ $data['type'] }}

@component('mail::table')
| Material | Quantity | Quote ID |
| -------- | -------- | -------- |
@foreach ($data['quotes'] as $quote)
| {{ $quote->material->name ?? 'N/A' }} | {{ $quote->quantity ?? 'N/A' }} | {{ $quote->quotes_id }} |
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent



OoooooooooooooooooooooooooooRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
<!DOCTYPE html>
<html>
<head>
    <title>New Material Request</title>
</head>
<body>
    <h3>Hello {{ $data['vendorName'] }},</h3>
    <p>{{ $data['message'] }}</p>
    <p><strong>Quote ID:</strong> {{ $data['quoteId'] }}</p>
    <p><strong>Material ID:</strong> {{ $data['materialsId'] }}</p>
    <p><strong>Company:</strong> {{ $data['companyName'] }}</p>
    <br>
    <p>Thank you,</p>
    <p>Your Company</p>
</body>
</html>
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

php artisan make:job SendMaterialRequestMailJob

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaterialRequestMail;

class SendMaterialRequestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $vendorEmail;
    public $mailData;

    /**
     * Create a new job instance.
     *
     * @param string $vendorEmail
     * @param array $mailData
     */
    public function __construct($vendorEmail, $mailData)
    {
        $this->vendorEmail = $vendorEmail;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->vendorEmail)->send(new MaterialRequestMail($this->mailData));
    }
}



use App\Jobs\SendMaterialRequestMailJob;

public function materialrequestSendToVendor(Request $request)
{
    $authCompany = Auth::guard('company-api')->user()->company_id;

    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'type' => 'required|integer',
        'vendor_id' => 'required|array',
        'quotes_details_id' => 'nullable|array',
        'quotes_id' => 'required|array',
        'material_request_details_id' => 'nullable|array',
        'materials_id' => 'nullable|array',
    ]);

    if ($validator->fails()) {
        return $this->responseJson(false, 422, $validator->errors()->first(), []);
    }

    DB::beginTransaction();
    try {
        $type = $request->input('type');
        $vendorIds = $request->input('vendor_id');
        $quotesIdList = $request->input('quotes_id');
        $quotesDetailsIdList = $request->input('quotes_details_id', []);
        $materialRequestDetailsIdList = $request->input('material_request_details_id', []);
        $materialsIdList = $request->input('materials_id', []);

        $quoteDetails = [];

        foreach ($vendorIds as $vendorId) {
            foreach ($quotesIdList as $index => $quoteId) {
                $record = QuotesMaterialSendVendor::create([
                    'vendors_id' => $vendorId,
                    'materials_id' => $materialsIdList[$index] ?? null,
                    'quotes_details_id' => $quotesDetailsIdList[$index] ?? null,
                    'quotes_id' => $quoteId,
                    'material_request_details_id' => $materialRequestDetailsIdList[$index] ?? null,
                    'type' => $type,
                    'company_id' => $authCompany,
                ]);

                $quoteDetails[] = $record;

                // Prepare email data
                $vendor = Vendor::find($vendorId);
                if ($vendor && $vendor->email) {
                    $mailData = [
                        'vendorName' => $vendor->name,
                        'quoteId' => $quoteId,
                        'materialsId' => $materialsIdList[$index] ?? 'N/A',
                        'companyName' => $authCompany,
                        'message' => 'You have received a new material request.',
                    ];

                    // Dispatch job to send email
                    SendMaterialRequestMailJob::dispatch($vendor->email, $mailData);
                }
            }
        }

        DB::commit();

        $quoteDetailResource = QuotesMaterialRequestSendVendorResource::collection($quoteDetails);

        return $this->responseJson(true, 200, 'Quote Details Updated and Emails Queued Successfully', $quoteDetailResource);
    } catch (\Exception $e) {
        DB::rollBack();
        logger("Error: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
        return $this->responseJson(false, 500, 'An error occurred while processing the request.', []);
    }
}




QUEUE_CONNECTION=database

php artisan queue:table
php artisan migrate
php artisan queue:work


<!DOCTYPE html>
<html>
<head>
    <title>New Material Request</title>
</head>
<body>
    <h3>Hello {{ $data['vendorName'] }},</h3>
    <p>{{ $data['message'] }}</p>
    <p><strong>Quote ID:</strong> {{ $data['quoteId'] }}</p>
    <p><strong>Material ID:</strong> {{ $data['materialsId'] }}</p>
    <p><strong>Company:</strong> {{ $data['companyName'] }}</p>
    <br>
    <p>Thank you,</p>
    <p>Your Company</p>
</body>
</html>





