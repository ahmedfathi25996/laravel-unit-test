<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $addresses = Address::where("user_id",$user_id)->get();
        $result =AddressResource::collection($addresses);
        $msg = "";
        return $this->getJsonSuccessResponse($msg,$result);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        "lat" => "required",
        "lng" => "required",
    ]);
        $data = $request->all();
        $user = Auth::user();
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        $address = Address::create($data);
        if($address)
        {
            $data = new AddressResource($address);
            $msg = "Address Added Successfully";
            return $this->postJsonSuccessResponse($msg,$data);
        }else{
            $msg = "Error During Saving Address";
            return $this->getErrorResponse($msg);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $address = Address::where("user_id",$user_id)->where("id",$id)->first();
        if(!is_object($address))
        {
            $msg = "This Address Is Not Exist";
            return  $this->getJsonNotFoundErrorResponse($msg);
        }
        $result =new AddressResource($address);
        $msg = "";
        return $this->getJsonSuccessResponse($msg,$result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAdressRequest $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $data = $request->all();
        $address = Address::where("user_id",$user_id)->where("id",$id)->first();

        if(!is_object($address))
        {
            $msg = "This Address Is Not Exist";
            return  $this->getJsonNotFoundErrorResponse($msg);
        }
        $address = Address::where("id",$address->id)->update($data);
        if($address)
        {
            $msg = "Address Updated Successfully";
            return $this->postJsonSuccessResponse($msg);
        }else{
            $msg = "Error During Updating Address";
            return $this->getErrorResponse($msg);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $address = Address::where("user_id",$user_id)->where("id",$id)->first();

        if(!is_object($address))
        {
            $msg = "This Address Is Not Exist";
            return  $this->getJsonNotFoundErrorResponse($msg);
        }
        $address =  Address::where("id",$address->id)->delete();
        if($address)
        {
            $msg = "Address Deleted Successfully";
            return $this->postJsonSuccessResponse($msg);

        }else{
            $msg = "Error During Deleting Address";
            return $this->getErrorResponse($msg);
        }

    }
}
