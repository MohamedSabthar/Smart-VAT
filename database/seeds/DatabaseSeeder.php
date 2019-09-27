<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Don't change the order
         */
        $this->call(UsersTableSeeder::class);
        $this->call(VatsTableSeeder::class);
        $this->call(VatPayersTableSeeder::class);
      
        $this->call(AssessmentRangesTableSeeder::class);
        $this->call(BusinessTypesTableSeeder::class);
        $this->call(BusinessTaxShopsTableSeeder::class);
    }
}
