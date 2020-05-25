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

    public function mylocation(Request $request, $id){
        //$token = $request['c_token'];
       // $user = User::where('api_token',base64_decode($token))->first();
       $user = User::find($id);
        if ($user) {

            return array(
                'id'=>$user->id,
                'lat'=>$user->lat,
                'long'=>$user->long,
                'success'=>true,

            );
          
        }else{
            return array(
                'message'=>'Gagal ambil data !',
                'code'=>'user',
                'success'=>false,
                
            );
        }
    }
}
