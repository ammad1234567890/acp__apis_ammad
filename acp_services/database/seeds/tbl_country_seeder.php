<?php

use Illuminate\Database\Seeder;

class tbl_country_seeder extends Seeder
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
	            'name'=>'Pakistan',
	        ],
	        [
	            'id'=>2,
	            'name'=>'India',
	        ],
	        [
	            'id'=>3,
	            'name'=>'Bangladesh',
	        ],
	        [
	            'id'=>4,
	            'name'=>'China',
	        ],
	        [
	            'id'=>5,
	            'name'=>'Srilanka',
	        ],
	        [
	            'id'=>6,
	            'name'=>'Australia',
	        ]
    	);
        DB::table('tbl_country')->insert($data_arr);
    }
}
