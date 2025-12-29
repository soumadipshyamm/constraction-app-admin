<?php

namespace App\Http\Controllers;

use App\Models\Company\Client;
use Illuminate\Http\Request;
use App\Traits\FlashMessages;
use Google\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;


class BaseController extends Controller
{
	use FlashMessages;

	protected $data = null;

    /**
     * @param $title
     * @param $subTitle
     */
    protected function setPageTitle($title, $subTitle='')
    {
        view()->share(['pageTitle' => $title, 'subTitle' => $subTitle]);
    }

    /**
     * @param int $errorCode
     * @param null $message
     * @return \Illuminate\Http\Response
     */
    protected function showErrorPage($errorCode = 404, $message = null)
    {
        $data['message'] = $message;
        return response()->view('errors.'.$errorCode, $data, $errorCode);
    }

    /**
     * @param bool $error
     * @param int $responseCode
     * @param array $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($status = true, $responseCode = 200, $message = [], $data = null)
    {
        return response()->json([
            'status'        =>  $status,
            'response_code' =>  $responseCode,
            'message'       =>  $message,
            'data'          =>  $data
        ],$responseCode);
    }

    /**
     * @param $route
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        if($type != 'noFlash'){
            $this->setFlashMessage($message, $type);
            $this->showFlashMessages();
        }

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        if(!empty($urlparams)){
            return redirect()->route($route,$urlparams);
        }else{
            return redirect()->route($route);
        }
    }

    /**
     * @param $route
     * @param $queryParams
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirectWithQueryString($route, $queryParams, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        return redirect()->route($route, $queryParams);
    }

    /**
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false, $anchor="")
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();
        $anchor = !empty($anchor) ? $anchor:'';
        return Redirect::to(URL::previous() . $anchor);
    }

     /**
     * setMetaDetails
     *
     * @param  mixed $meta
     * @return void
     */
    protected function setMetaDetails($meta){
        view()->share(['meta' => $meta]);
    }

    public function paginateResults($finalData, $perPage = 50): JsonResponse
    {
        // Determine the current page and the offset
        $page = request()->get('page', 1);  // Default to page 1 if no page parameter is provided
        $offset = ($page - 1) * $perPage;

        // Slice the data to simulate pagination
        $data = array_slice($finalData, $offset, $perPage);

        // Create a LengthAwarePaginator instance
        $paginator = new LengthAwarePaginator(
            $data,
            count($finalData),  // Total number of items
            $perPage,           // Number of items per page
            $page,              // Current page
            ['path' => request()->url()]  // Correct the pagination links
        );

        // Return paginated data as JSON response
        return response()->json($paginator);
    }


    public function otpSending($phno, $otp = null)
    {
        $client = new Client();
        $response = $client->post('https://hisocial.in/api/send', [
            'query' => [
                'number' => '20230216',
                'type' => '99bPFqXj',
                'send' => 'GRSGNL',
                'instance_id' => '1',
                'access_token' => $phno,
                'template'=>'OTP for Mobile Verification Template',
                'message' => 'Hello, please verify your mobile number with the OTP: '.$otp.'. From: GREEN SIGNAL TECHNOLOGIES (SAARTHI)',
            ],
            'headers' => [
                'Cookie' => 'ASP.NET_SessionId=uuq14otuddwvszseaefq5fhy'
            ]
        ]);
        return $response;
    }
}
