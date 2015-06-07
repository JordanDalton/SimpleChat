<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker   = Faker::create();

        foreach ( range( 0, 50 ) as $record )
        {
            $records[ ] = [
                'name'       => $faker->name,
                'email'      => "example{$record}@example.com",
                'password'   => bcrypt( 'password' ),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ];
        }

        DB::table('users')->insert( $records );
    }

}
