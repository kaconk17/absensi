<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_conf')->insert([
            'name'=> 'radius',
            'value' => 5,
            
          ]);
    }
}
