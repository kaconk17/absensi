<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AbsenModel;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AbsenController extends Controller
{
    public function create(Request $request){
        $token = $request['c_token'];
        $lat = $request['lat'];
        $long = $request['long'];
        $status= $request['status'];

        $user = User::where('api_token',base64_decode($token))->first();

        if($user){
            $now = Carbon::now();
            $simpan = AbsenModel::create([
                'id_absensi'=>Str::uuid(),
                'id_user'=>$user->id,
                'tanggal'=>$now->toDateString(),
                'jam'=>$now->format('H:i:s'),
                'lat'=>$lat,
                'long'=>$long,
                'status'=>$status,
            ]);
            if ($simpan) {
              
                return array(
                    'message'=>'Absen Berhasil !',
                    'code'=>'absen',
                    'success'=>true,
                );
            }else{
                return array(
                    'message'=>'Gagal menyimpan data!',
                    'code'=>'absen',
                    'success'=>false,
                );
            }
        }else{
            return array(
                'message'=>'Gagal menyimpan data!',
                'code'=>'user',
                'success'=>false,
            );
        }
       
    }
    

    public function test(Request $request){
        $token = $request['c_token'];
        $lat = $request['lat'];
        $long = $request['long'];
        $user = User::where('api_token',base64_decode($token))->first();

        $dist = $this->distance($user->lat, $user->long, $lat, $long);

        return array(

            'jarak'=>$dist,
        );
    }
    function distance($lat1, $lon1, $lat2, $lon2) { 
        $pi80 = M_PI / 180; 
        $lat1 *= $pi80; 
        $lon1 *= $pi80; 
        $lat2 *= $pi80; 
        $lon2 *= $pi80; 
        $r = 6372.797; // mean radius of Earth in km 
        $dlat = $lat2 - $lat1; 
        $dlon = $lon2 - $lon1; 
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2); 
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
        $km = $r * $c; 
        //echo ' '.$km; 
        return $km; 
        }
}
