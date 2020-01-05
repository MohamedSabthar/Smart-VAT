<?php

use Illuminate\Database\Seeder;

class EntertainmentPerfomanceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entertainment_performance_types')->insert([
            [ 'description'=>'Performance payment',
            'amount'=>1500.00,
            'additional_amount'=>1500.00],
            [ 'description'=>'Display payment',
            'amount'=>1500.00,
            'additional_amount'=>1500.00],
            [ 'description'=>'Magic display payment',
            'amount'=>1500.00,
            'additional_amount'=>250.00],
            [ 'description'=>'Variety Entertainment payment',
            'amount'=>1500.00,
            'additional_amount'=>250.00],
            [ 'description'=>'Performanc license fee for musical Entertainment',
            'amount'=>3000.00,
            'additional_amount'=>500.00],
        ]);
    }
}
