<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Redirect,Response;
use Event;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;

class UserController
{

    /**API to fetch all users */
    public function getAllUsers(){
        $response = User::where('role','User')->get();
        if(!empty($response)){
            $data['status'] = 1;
            $data['message'] = 'User fetched Successfully';    
            $data['data'] = $response;    
        }else{
            $data['status'] = 0;
            $data['status'] = 'User Not found';
        }
        return response()->json($data, 200);
    }

    /**API to fetch user details */
    public function getUserDetails($id){
        $response =  User::where('role','User')->find($id);
        if(!empty($response)){
            $data['status'] = 1;
            $data['message'] = 'User fetched Successfully';  
            $data['data'] = $response;      
        }else{
            $data['status'] = 0;
            $data['message'] = 'User Not found';
        }
        return response()->json($data, 200);
    }

    //****************************************************** */
}
