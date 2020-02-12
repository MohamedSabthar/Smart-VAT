<?php

use Illuminate\Database\Seeder;

class BookingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //town hall NO 1
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Town Hall No 1', 'event_description' => 'Weeding Function', 'parent_id' => 1],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Musical shows, Dramas, Circus and karata shows', 'parent_id' => 2],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'If no entertainment tax is charged above shows', 'parent_id' => 3],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For any exhibition ,Public Dancing Show', 'parent_id' => 4],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing -non paying', 'parent_id' => 5],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Exhibitions, Displays, or Functions based on free charging, of books, Magazines  and Plastic Goods, Electrical Goods and Sale of Flowers and Furniture ', 'parent_id' => 6],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Paying Exhibition not Coming under 1.5', 'parent_id' => 7],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Day and Night Banquets not based on free charging', 'parent_id' => 8],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 9],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 10],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Religious Festivals, School Prize giving functions, religious interviews, School Children sport training and Variety entertainment', 'parent_id' => 11],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'Any other free charging Services not herein mentioned', 'parent_id' => 12],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For preschool festival', 'parent_id' => 13],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For free charging Exhibition of Footwear and Apparels', 'parent_id' => 14],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For Literary Festivals', 'parent_id' => 15],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For International Pre School, International School', 'parent_id' => 16],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'non- free charging which is not mentioned hereinbefore', 'parent_id' => 17],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'For workshop on beauty culture and cookery', 'parent_id' => 18],
            ['place_description' => 'Town Hall NO 1', 'event_description' => 'other event_description', 'parent_id' => 19],

        ]);
         //Town hall No 2
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Town Hall No 2', 'event_description' => 'Weeding Function', 'parent_id' => 20],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'For meetings, Displays, Discussion, Exhibition, Seminars', 'parent_id' => 21],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'Display of sales and fairs (Finished Garments and Footwear Etc,)', 'parent_id' => 22],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'Any other function  performed for cash not mentioned hereinbefore', 'parent_id' => 23],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'Any other non chargeable function not mentioned hereinbefore', 'parent_id' => 24],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'Day and Night Banquets not based on free charging', 'parent_id' => 25],
            ['place_description' => 'Town Hall No 2', 'event_description' => 'For workshop on beauty culture and cookery', 'parent_id' => 26],
            ['place_description' => 'Town Hall NO 2', 'event_description' => 'other event_description', 'parent_id' => 27],

        ]);
          // stadium
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Stadium ', 'event_description' => 'Weeding Function', 'parent_id' => 28],
            ['place_description' => 'Stadium', 'event_description' => 'Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing', 'parent_id' => 29],
            ['place_description' => 'Stadium', 'event_description' => 'Exhibitions, Displays, or Functions based on cash transactions, of books, Magazines  and Plastic Goods, and Sale of Flowers and Furniture', 'parent_id' => 30],
            ['place_description' => 'Stadium', 'event_description' => 'Exhibitions based on Cash transactions and Exhibitions not covered under 3.3 above', 'parent_id' => 31],
            ['place_description' => 'Stadium', 'event_description' => 'Day and Night Banquets not based on free charging', 'parent_id' => 32],
            ['place_description' => 'Stadium', 'event_description' => 'Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 33],
            ['place_description' => 'Stadium', 'event_description' => 'Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 34],
            ['place_description' => 'Stadium', 'event_description' => 'Any other paying Services not herein mentioned', 'parent_id' => 35],
            ['place_description' => 'Stadium', 'event_description' => 'Any other non-charging Services not herein mentioned', 'parent_id' => 36],
            ['place_description' => 'Stadium', 'event_description' => 'Display of sales and fairs (Apperals Electrical Appliances, Footwear etc)', 'parent_id' => 37],
            ['place_description' => 'Stadium', 'event_description' => 'Literary festivals, Commemoration', 'parent_id' => 38],
            ['place_description' => 'Stadium', 'event_description' => 'For night Lodging', 'parent_id' => 39],
            ['place_description' => 'Stadium', 'event_description' => 'For watching international Cricket Tests', 'parent_id' => 40],
            ['place_description' => 'Stadium', 'event_description' => 'International preschool, International School', 'parent_id' => 41],
            ['place_description' => 'Stadium', 'event_description' => 'For watching other games which hold.', 'parent_id' => 42],
            ['place_description' => 'Stadium', 'event_description' => 'for Workshops of Beauty Culture and Cookery', 'parent_id' => 43],
            ['place_description' => 'Stadium', 'event_description' => 'other event_description', 'parent_id' => 44],
        ]);
         //samanala Ground
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Samanala Ground', 'event_description' => 'For Meetings of political, Trade union and others', 'parent_id' => 45],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For Musical shows +', 'parent_id' => 46],
            ['place_description' => 'Samanala Ground', 'event_description' => 'Non chargeable  Musical show ', 'parent_id' => 47],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any Sport event_description-For School Children', 'parent_id' => 48],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any Sport event_description - other', 'parent_id' => 49],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any series of Sport event_descriptions-For School Children', 'parent_id' => 50],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any series of Sportevent_description-other', 'parent_id' => 51],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For a circus', 'parent_id' => 52],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any sports event_description held at National, Provincial, Divisional level by State or Any Sports activity concerned with preschools ', 'parent_id' => 53],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any Sale or Fair', 'parent_id' => 54],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For other Sports Festival (including International School)', 'parent_id' => 55],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For Landing Air craft', 'parent_id' => 56],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For any other services not mentioned hereinbefore per day', 'parent_id' => 57],
            ['place_description' => 'Samanala Ground', 'event_description' => 'For sport practices', 'parent_id' => 58],
            ['place_description' => 'Samanala Ground', 'event_description' => 'other event_description', 'parent_id' => 59],

        ]);
          //Hiyare tank
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Hiyare Tank Ground', 'event_description' => 'for the reservation of the ground', 'parent_id' => 60],
            ['place_description' => 'Hiyare Tank Ground', 'event_description' => 'Other event_description', 'parent_id' => 61],
        ]);
         //dharmapala graden
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Dharmapala Garden', 'event_description' => 'For a Festival day', 'parent_id' => 62],
            ['place_description' => 'Dharmapala Garden', 'event_description' => 'charge for decorations and display of Notice of publicity ', 'parent_id' => 63],
            ['place_description' => 'Dharmapala Garden', 'event_description' => 'For a Monthly Festival day', 'parent_id' => 64],
            ['place_description' => 'Dharmapala Garden', 'event_description' => 'other event_description', 'parent_id' => 65],

        ]);

        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Central Bus stand open air in uppermost Floor', 'event_description' => 'for a single night Banquet', 'parent_id' => 66],
        ]);
        DB::table('booking_tax_types')->insert([
            ['place_description' => 'Other place_descriptions', 'event_description' => 'Milidduwa Sports Ground', 'parent_id' => 67],
            ['place_description' => 'Other place_descriptions', 'event_description' => 'For Festivals and Meetings on any road within Municipal Area  not obstructing free transport', 'parent_id' => 68],
            ['place_description' => 'Other place_descriptions', 'event_description' => 'other event_description', 'parent_id' => 69],
        ]);
    }
}
