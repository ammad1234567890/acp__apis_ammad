<?php

use Illuminate\Database\Seeder;

class tbl_role_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data_arr=array(
            ['id'=>1,'role'=>'Student'],['id'=>2,'role'=>'Teacher'],['id'=>3,'role'=>'Institute']
        );
        DB::table('tbl_roles')->insert($data_arr);
    }
}
