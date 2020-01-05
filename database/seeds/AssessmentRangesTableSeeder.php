<?php

use Illuminate\Database\Seeder;
use App\Vat;

class AssessmentRangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Buisness tax ranges vat_id=1
        //ranges are rupees
        $businessTaxId = Vat::where('route', 'business')->first()->id;
        DB::table('assessment_ranges')->insert(
            [
            'start_value' => 0,
            'end_value' => 6000,
            'vat_id' => $businessTaxId ]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 6000,
            'end_value' => 12000,
            'vat_id' => $businessTaxId]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 12000,
            'end_value' => 18750,
            'vat_id' => 1]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 18750,
            'end_value' => 75000,
            'vat_id' => $businessTaxId]
        );

        DB::table('assessment_ranges')->insert(
            ['start_value' => 75000,
            'end_value' => 150000,
            'vat_id' => $businessTaxId]
        );

        DB::table('assessment_ranges')->insert(
            [ 'start_value' => 150000,
            'vat_id' => $businessTaxId]
        );

        //Industrial tax ranges vat_id=2
        //ranges are rupees
        $industrialTaxId = Vat::where('route', 'industrial')->first()->id;
        ;
        DB::table('assessment_ranges')->insert(
            ['start_value' => 0,
            'end_value' => 1500,
            'vat_id' => $industrialTaxId]
        );

        DB::table('assessment_ranges')->insert(
            ['start_value' => 1500,
            'end_value' => 2500,
            'vat_id' => $industrialTaxId]
        );

        DB::table('assessment_ranges')->insert(
            ['start_value' => 2500,
            'vat_id' => $industrialTaxId]
        );
    }
}