<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AbsenModel;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function create(Request $request){
        $token = $request['c_token'];
        $lat = $request['lat'];
        $long = $request['long'];
       $rad = DB::table('tb_conf')->where('name','radius')->first();

        $user = User::where('api_token',base64_decode($token))->first();

        if($user){

            if (empty($user->lat) || empty($user->long)) {
                return array(
                    'message'=>'Absen Gagal !',
                    'code'=>'latlong',
                    'success'=>false,
                );
            }
            $jarak = $this->distance($user->lat, $user->long, $lat, $long);
            if ($jarak > $rad->value) {
               $status = 'NG';
            }else{
                $status = 'OK';
            }

            $now = Carbon::now();
            $simpan = AbsenModel::create([
                'id_absensi'=>Str::uuid(),
                'id_user'=>$user->id,
                'tanggal'=>$now->toDateString(),
                'jam'=>$now->format('H:i:s'),
                'lat'=>$lat,
                'long'=>$long,
                'jarak'=>$jarak,
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

    public function getAbsen(Request $request, $id){

        $tanggal = Carbon::now()->toDateString();
        $user = User::find($id);
        $absen = AbsenModel::where('id_user',$id)
                            ->where('tanggal',$tanggal)
                            ->orderBy('tanggal','desc')
                            ->orderBy('jam','desc')
                            ->get();
        if (!$absen->isEmpty()) {
            return array(
                'message'=>'Berhasil ambil data',
                'code'=>'absen',
                'success'=>true,
                'homeLat'=> $user->lat,
                'homeLng'=> $user->long,
                'data'=> $absen,
            );
        }else{
            return array(
                'message'=>'Gagal mengambil data!',
                'code'=>'absen',
                'success'=>false,
            );
        }
    }

    public function history(Request $request, $id){
        $token = $request['c_token'];
        $user = User::where('api_token',base64_decode($token))->first();
        if ($user->id == $id) {
           $tgl_awal = $request['tgl_awal'];
           $tgl_akhir = $request['tgl_akhir'];

           $absen = AbsenModel::where('id_user',$id)
                                ->where('tanggal', '>=', $tgl_awal)
                                ->where('tanggal','<=', $tgl_akhir)
                                ->orderBy('tanggal','desc')
                                ->orderBy('jam','desc')
                                ->get();
            if (!$absen->isEmpty()) {
                return array(
                    'data' => $absen,
                    'message' => 'Ambil data berhasil',
                    'success'=>true,
                );
            }else{
                return array(
                    'message'=>'Gagal mengambil data!',
                    'code'=>'data',
                    'success'=>false,
                );
            }
        }else {
            return array(
                'message'=>'Gagal mengambil data!',
                'code'=>'token',
                'success'=>false,
            );
        }
    }
    

    //src : https://www.phpninja.info/en/other/calculating-distance-two-points-latitude-and-longitude/
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
