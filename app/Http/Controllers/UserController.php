<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        $email = $request['email'];
        $pass = $request['pass'];

        $data = User::where('email',$email)->first();
  
        if ($data) {
           if (Hash::check($pass,$data->password)) {
           
                $data->rollApiKey(); //Model Function
    
                return array(
                    'user' => $data,
                    'token'=>base64_encode($data->api_token),
                    'message' => 'Authorization Successful!',
                    'success'=>true
                );
    
           }else{
            
           
            return array(
                'message' => 'Login gagal!',
                'success'=>false
            );
           
           }
        }else{
           
           return array(
            'message' => 'Login gagal!',
            'success'=>false
        );
        }
    }
}
