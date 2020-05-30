<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function login(Request $request){
        $email = $request['email'];
        $pass = $request['pass'];

        $data = User::where('email',$email)->first();
        $rad = DB::table('tb_conf')->where('name','radius')->first();
        if ($data) {
           if (Hash::check($pass,$data->password)) {
           
                $data->rollApiKey(); //Model Function
    
                return array(
                    'user' => $data,
                    'radius'=> $rad->value,
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

    public function sethomelocation(Request $request){
        $setlat = $request['lat'];
        $setlong = $request['long'];
        $token = $request['c_token'];

        $user = User::where('api_token',base64_decode($token))->first();

        if ($user) {
          
      
        if (empty($user->lat) || empty($user->long)) {
           $user->lat = $setlat;
           $user->long = $setlong;
           $user->save();
           return array(
            'message' => 'Update user berhasil!',
            'code'=> 'latlong',
            'success'=>true,
        );
        }else{
            return array(
                'message' => 'Update user gagal!',
                'code'=> 'latlong',
                'success'=>false,
            );
        }
    }else{
        return array(
            'message' => 'Update user gagal!',
            'code'=> 'user',
            'success'=>false,
        );
    }

    }

    public function mylocation(Request $request, $id){
       
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
/*
    public function profile($id){
        $user = User::find($id);

        if ($user) {
            return array(
                'message'=>'Berhasil ambil data',
                'code'=>'user',
                'success'=>true,
                'data'=> $user,
            );
        }else{
            return array(
                'message'=>'Gagal mengambil data!',
                'code'=>'user',
                'success'=>false,
            );
        }
    }
*/
    public function profile(Request $request, $id){

        $token = $request['c_token'];
        //$user = User::find($id);
        //$user = DB::table('users')->where('id',$id)->first();
        $user = User::where('api_token',base64_decode($token))->first();
        if ($user) {
           
            if ($user->id == $id) {
                return array(
                    'user' => $user,
                    'message' => 'Ambil data berhasil',
                    'success'=>true,
                );
            }else{
                return array(
                    'message'=>'Gagal mengambil data!',
                    'code'=>'token',
                    'success'=>false,
                );
            }
        }else{
            return array(
                'message'=>'Gagal mengambil data!',
                'code'=>'token',
                'success'=>false,
            );
        }
        
    }

    public function create(Request $request){
        $token = $request['c_token'];
        $user = User::where('api_token',base64_decode($token))->first();

        if($user->dept == "Admin"){

            $create = User::create([
                'nama'=> $request['nama'],
                'email'=> $request['email'],
                'password' => Hash::make($request['password']),
                'id'=> Str::uuid(),
                'nik'=>$request['nik'],
                'alamat'=>$request['alamat'],
                'domisili'=>$request['domisili'],
                'kelamin'=>$request['jenis_kelamin'],
                'tgl_lahir'=> $request['tgl_lahir'],
                'no_telepon'=>$request['no_tlp'],
                'jabatan'=>$request['jabatan'],
                'dept'=>$request['dept'],
                'group'=>$request['group'],
                'section'=>$request['section'],
                'status_karyawan'=>$request['status'],
                
               ]);
            if ($create) {
               
                return array(
                'code'=>'user',
                 'message' => 'Ambil data berhasil',
                 'success'=>true,
             );
            }else{
                return array(
                    'message'=>'Gagal mengirim data!',
                    'code'=>'user',
                    'success'=>false,
                );
            }
        }else{
            return array(
                'message'=>'Gagal mengirim data!',
                'code'=>'token',
                'success'=>false,
            );
        }
    }
}
