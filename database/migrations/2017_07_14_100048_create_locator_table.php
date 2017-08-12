<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branchs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_name');
            $table->string('address');
            $table->decimal('lat', 11, 8);
            $table->decimal('longi', 11, 8);
            $table->integer('phone');
            $table->tinyInteger('type')->comment('1 Branch, 2 ATM');
        });


        $data_branch = array(
            // BRANCh
            array('address' => 'Manchester M25 1AX', 'branch_name' => '460 Bury New Road' , 'lat' => 53.533231, 'longi'=> -2.284868, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M2 3HQ', 'branch_name' => '51 Mosley Street' , 'lat' => 53.480186, 'longi'=> -2.240882, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M1 1PD', 'branch_name' => '86-88 Market Street' , 'lat' => 53.482326, 'longi'=> -2.240630, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M2 7PW', 'branch_name' => "17 St. Ann's Square" , 'lat' => 53.482109, 'longi'=> -2.245414, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M13 9NG', 'branch_name' => '320/322 Oxford Road' , 'lat' => 53.461754, 'longi'=> -2.229447, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M12 4JH', 'branch_name' => 'Longsight Shopping Centre' , 'lat' => 53.457270, 'longi'=> -2.200347, 'phone' => 03457345345, 'type' => 1),
            array('address' => 'Manchester M21 9AL', 'branch_name' => '587 Wilbraham Road' , 'lat' => 53.442459, 'longi'=> -2.277779, 'phone' => 03457345345, 'type' => 1),
            //ATM
            array('address' => 'Manchester M3 4EN 1AX', 'branch_name' => 'Deansgate' , 'lat' => 53.477528, 'longi'=> -2.249865, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Manchester M2 3HQ', 'branch_name' => '51 Mosley Street' , 'lat' => 53.480186, 'longi'=> -2.240882, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Manchester M1 1PD', 'branch_name' => '86-88 Market Street' , 'lat' => 53.482326, 'longi'=> -2.240630, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Manchester M2 7PW', 'branch_name' => "17 St. Ann's Square" , 'lat' => 53.482109, 'longi'=> -2.245414, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Manchester M15 6HD', 'branch_name' => 'Fallowfield Campus' , 'lat' => 53.463742, 'longi'=> -2.240831, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Hulme M15 5AS', 'branch_name' => 'Princess Road' , 'lat' => 53.461281, 'longi'=> -2.246906, 'phone' => 03457345345, 'type' => 2),
            array('address' => 'Manchester M11 3FF', 'branch_name' => 'Etihad Stadium' , 'lat' => 53.484910, 'longi'=> -2.202633, 'phone' => 03457345345, 'type' => 2),
        );

        // Insert some stuff
        DB::table('branchs')->insert($data_branch);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
