<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    const DEFAULT_LIMIT_PER_PAGE = 15;
    protected $api_error = 0;
    protected $api_success = 1;
    public $data                = [];
    public $current_user_data   = [];
    public $user_id             = 1;
    public $lang_id             = 1;


    public function getErrorResponse($msg,$data)
    {
        $response=[
            'Status'    => $this->api_error,
            'Message'   => $msg,
            'Data'      => null,
        ];
        if($data)
        {
            $response['Errors'] = $data;
        }
        else{
            $response['Errors'] = null;
        }
        return $response;
    }
    public function getJsonSuccessResponse($msg = "", $data = []) {
        return response()->json(
            [
                'Status'    => $this->api_success,
                'Message'   => $msg,
                'Code'      => 200,
                'Data'      => (is_array($data) && count($data) == 0)?null:$data,
                'Errors'    => null
            ]
            , Response::HTTP_OK);
    }

    public function getJsonNotAuthorizedResponse($msg = "", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_FORBIDDEN);
    }

    public function postJsonSuccessResponse($msg = "", $data = []) {
        return response()->json(
            [
                'Status'    => $this->api_success,
                'Message'   => $msg,
                'Data'      => (is_array($data) && count($data) == 0)?null:$data,
                'Errors'    => null
            ]
            , Response::HTTP_CREATED);
    }

    public function getJsonLogicalErrorResponse($msg = "", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_CONFLICT);
    }

    public function getJsonBlackListedErrorResponse($msg = "", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_GONE);
    }

    public function getJsonNotFoundErrorResponse($msg = "", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_OK);
    }

    public function getJsonValidationErrorResponse($msg = "Validation Errors", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_BAD_REQUEST);
    }

    public function getJsonSessionTimOutResponse($msg = "Validation Errors", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_REQUEST_TIMEOUT);
    }

    public function getJsonSessionExpiredErrorResponse($msg = "", $data = []) {
        $response=$this->getErrorResponse($msg,$data);
        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }

    public function getStringLength($str) {
        return strlen($str);
    }




}
