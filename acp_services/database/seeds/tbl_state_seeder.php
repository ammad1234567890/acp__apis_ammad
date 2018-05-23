<?php

use Illuminate\Database\Seeder;

class tbl_state_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$data_arr=array(
    		[
	            'id'=>1,
	            'name'=>'Sindh',
	            'country_id'=>1
	        ],
	        [
	            'id'=>2,
	            'name'=>'Punjab',
	            'country_id'=>1
	        ],
	        [
	            'id'=>3,
	            'name'=>'Balochistan',
	            'country_id'=>1
	        ],
	        [
	            'id'=>4,
	            'name'=>'Khyber Pakhtunkhwa',
	            'country_id'=>1
	        ],
	        [
	            'id'=>5,
	            'name'=>'Gilgit-Baltistan',
	            'country_id'=>1
	        ]
    	);
        DB::table('tbl_state')->insert($data_arr);
    }
}
