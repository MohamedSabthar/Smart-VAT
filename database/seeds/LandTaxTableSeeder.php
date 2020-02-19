<?php

use Illuminate\Database\Seeder;

class LandTaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('land_taxes')->insert([

            'land_name'=>'Samanala Ground',
            'worth'=> '12000',
            'phone' => '0912245878',
            'registration_no' => 'L1330',
            'door_no' => '00',
            'street' => 'sea road',
            'city' => 'Galle',
            'payer_id' => '2',
            'employee_id'=> '1',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'Samanala Ground',
            'worth'=> '15000',
            'phone' => '0772245878',
            'registration_no' => 'L1331',
            'door_no' => '00',
            'street' => 'maya road',
            'city' => 'Galle',
            'payer_id' => '2',
            'employee_id'=> '1',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'Childrens park',
            'worth'=> '5000',
            'phone' => '0912245878',
            'registration_no' => 'L1332',
            'door_no' => '00',
            'street' => 'park road',
            'city' => 'Ambalangoda',
            'payer_id' => '3',
            'employee_id'=> '1',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'presidents Ground',
            'worth'=> '12000',
            'phone' => '0912245878',
            'registration_no' => 'L1333',
            'door_no' => '00',
            'street' => 'sea road',
            'city' => 'Galle',
            'payer_id' => '3',
            'employee_id'=> '1',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'Karapitiya Ground',
            'worth'=> '5000',
            'phone' => '0775412548',
            'registration_no' => 'L1334',
            'door_no' => '02',
            'street' => 'ape para',
            'city' => 'Karapitiya',
            'payer_id' => '3',
            'employee_id'=> '2',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'fort',
            'worth'=> '65000',
            'phone' => '0784512563',
            'registration_no' => 'L1345',
            'door_no' => '00',
            'street' => 'fort street',
            'city' =>'Galle',
            'payer_id' => '4',
            'employee_id'=> '1',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'Cricket stadium',
            'worth'=> '75000',
            'phone' => '0754845485',
            'registration_no' => 'L1225',
            'door_no' => '00',
            'street' => 'mains street',
            'city' => 'Galle',
            'payer_id' => '5',
            'employee_id'=> '2',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'fruit market',
            'worth'=> '12000',
            'phone' => '0724545456',
            'registration_no' => 'L1445',
            'door_no' => '00',
            'street' => 'lowerDickson road',
            'city' => 'Galle',
            'payer_id' => '5',
            'employee_id'=> '3',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'Tennis ground',
            'worth'=> '7000',
            'phone' => '0754845485',
            'registration_no' => 'L1265',
            'door_no' => '00',
            'street' => 'gjhvjhj street',
            'city' => 'Galle',
            'payer_id' => '6',
            'employee_id'=> '3',
        ]);

        DB::table('land_taxes')->insert([

            'land_name'=>'hall de Galle',
            'worth'=> '10000',
            'phone' => '0751112485',
            'registration_no' => 'L1220',
            'door_no' => '00',
            'street' => 'asdas street',
            'city' => 'Galle',
            'payer_id' => '5',
            'employee_id'=> '2',
        ]);
    }
}