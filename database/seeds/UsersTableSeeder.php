<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Wipe the table clean before populating
        DB::table('users')->delete();

        $users = array(
            [
                "name"  => "Auto Customs Inc.",
                "phone" => '877-204-7002',
                "email" => "name@autocustoms.com",
            ],
            [
                "name"  => "Philip Meckling",
                "phone" => '321-501-1234',
                "email" => "slydvox@aol.com",
            ],
            [
                "name"  => "Joe Blough",
                "phone" => '888-123-4567',
                "email" => "jb@mykumpnee.com",
            ],

        );

        // Run the seeder
        DB::table('users')->insert($users);
    }

}
