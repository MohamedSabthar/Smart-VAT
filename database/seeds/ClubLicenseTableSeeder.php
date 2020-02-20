<?php

use Illuminate\Database\Seeder;

class ClubLicenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('club_licence_tax_clubs')->insert([
            'club_name' => 'Saraz',
            'anual_worth' => '25000',
            'phone' => '0754869751',
            'registration_no'=> 'CL1440',
            'door_no' => '02',
            'street' => 'saarndibia',
            'city'=> 'Galle',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);

        DB::table('club_licence_tax_clubs')->insert([
            'club_name' => 'Saraz',
            'anual_worth' => '25000',
            'phone' => '0754869751',
            'registration_no'=> 'CL1441',
            'door_no' => '02',
            'street' => 'saarndibia',
            'city'=> 'Galle',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);

        DB::table('club_licence_tax_clubs')->insert([
            'club_name' => 'Saraz',
            'anual_worth' => '25000',
            'phone' => '0754869751',
            'registration_no'=> 'CL1442',
            'door_no' => '02',
            'street' => 'saarndibia',
            'city'=> 'Galle',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);

        DB::table('club_licence_tax_clubs')->insert([
            'club_name' => 'Saraz',
            'anual_worth' => '25000',
            'phone' => '0754869751',
            'registration_no'=> 'CL1443',
            'door_no' => '02',
            'street' => 'saarndibia',
            'city'=> 'Galle',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);

        DB::table('club_licence_tax_clubs')->insert([
            'club_name' => 'Saraz',
            'anual_worth' => '25000',
            'phone' => '0754869751',
            'registration_no'=> 'CL1444',
            'door_no' => '02',
            'street' => 'saarndibia',
            'city'=> 'Galle',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);
    }
}