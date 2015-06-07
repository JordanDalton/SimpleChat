<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MessagesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker    = Faker::create();
        $user_ids = User::lists('id');

        foreach ( range( 0, 50 ) as $record )
        {
            $records[ ] = [
                'user_id'    => $faker->randomElement($user_ids),
                'message'    => $faker->sentence,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ];
        }

        DB::table('messages')->insert( $records );
    }

}
