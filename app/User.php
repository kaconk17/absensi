<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'id',
        'nik',
        'alamat',
        'domisili',
        'kelamin',
        'no_telepon',
        'jabatan',
        'dept',
        'group',
        'section',
        'status_karyawan',
        'api_token',
    ];

    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rollApiKey(){
        do{
            $this->api_token =Str::random(60);
        }while(
            $this->where('api_token', $this->api_token)->exists()
        );
        $this->save();
    }
}
