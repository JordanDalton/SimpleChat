<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * List of database tables.
     *
     * @var array
     */
    protected $tables = [
        'users',
        'password_resets',
        'messages',
    ];

    /**
     * List of table seeder classes.
     * @var array
     */
    protected $seeders = [
        'UsersTableSeeder',
        'MessagesTableSeeder'
    ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        // Truncate tables
        $this->truncateTables();

        // Seed tables.
        $this->seedTables();
	}

    /**
     * Truncate our list of database tables.
     *
     * @return void
     */
    private function truncateTables()
    {
        foreach( $this->tables as $table )
        {
            DB::table( $table )->truncate();
        }
    }

    /**
     * See our tables.
     *
     * @return void
     */
    private function seedTables()
    {
        foreach( $this->seeders as $seeder )
        {
            $this->call( $seeder );
        }
    }
}
