<?php

use Illuminate\Database\Seeder;

class tbl_city_seeder extends Seeder
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
	            'name'=>'Karachi',
	            'state_id'=>1
	        ],
	        [
	            'id'=>2,
	            'name'=>'Lahore',
	            'state_id'=>2
	        ],
	        [
	            'id'=>3,
	            'name'=>'Quetta',
	            'state_id'=>3
	        ],
	        [
	            'id'=>4,
	            'name'=>'Peshawar',
	            'state_id'=>4
	        ],
	        [
	            'id'=>5,
	            'name'=>'Gilgit',
	            'state_id'=>5
	        ]
    	);
    	DB::table('tbl_city')->insert($data_arr);
        
    }
}
