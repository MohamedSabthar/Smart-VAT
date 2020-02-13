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
            ['description' => 'Town Hall No 1  Weeding Function', 'parent_id' => 1],
            ['description' => 'Town Hall NO 1  Musical shows, Dramas, Circus and karata shows', 'parent_id' => 2],
            ['description' => 'Town Hall NO 1  If no entertainment tax is charged above shows', 'parent_id' => 3],
            ['description' => 'Town Hall NO 1  For any exhibition ,Public Dancing Show', 'parent_id' => 4],
            ['description' => 'Town Hall NO 1  Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing -non paying', 'parent_id' => 5],
            ['description' => 'Town Hall NO 1  Exhibitions, Displays, or Functions based on free charging, of books, Magazines  and Plastic Goods, Electrical Goods and Sale of Flowers and Furniture ', 'parent_id' => 6],
            ['description' => 'Town Hall NO 1  Paying Exhibition not Coming under 1.5', 'parent_id' => 7],
            ['description' => 'Town Hall NO 1  Day and Night Banquets not based on free charging', 'parent_id' => 8],
            ['description' => 'Town Hall NO 1  Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 9],
            ['description' => 'Town Hall NO 1  Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 10],
            ['description' => 'Town Hall NO 1  Religious Festivals, School Prize giving functions, religious interviews, School Children sport training and Variety entertainment', 'parent_id' => 11],
            ['description' => 'Town Hall NO 1  Any other free charging Services not herein mentioned', 'parent_id' => 12],
            ['description' => 'Town Hall NO 1  For preschool festival', 'parent_id' => 13],
            ['description' => 'Town Hall NO 1  For free charging Exhibition of Footwear and Apparels', 'parent_id' => 14],
            ['description' => 'Town Hall NO 1  For Literary Festivals', 'parent_id' => 15],
            ['description' => 'Town Hall NO 1  For International Pre School, International School', 'parent_id' => 16],
            ['description' => 'Town Hall NO 1  non- free charging which is not mentioned hereinbefore', 'parent_id' => 17],
            ['description' => 'Town Hall NO 1  For workshop on beauty culture and cookery', 'parent_id' => 18],
            ['description' => 'Town Hall NO 1  other event_description', 'parent_id' => 19],

        ]);
         //Town hall No 2
        DB::table('booking_tax_types')->insert([
            ['description' => 'Town Hall No 2  Weeding Function', 'parent_id' => 20],
            ['description' => 'Town Hall No 2  For meetings, Displays, Discussion, Exhibition, Seminars', 'parent_id' => 21],
            ['description' => 'Town Hall No 2  Display of sales and fairs (Finished Garments and Footwear Etc,)', 'parent_id' => 22],
            ['description' => 'Town Hall No 2  Any other function  performed for cash not mentioned hereinbefore', 'parent_id' => 23],
            ['description' => 'Town Hall No 2  Any other non chargeable function not mentioned hereinbefore', 'parent_id' => 24],
            ['description' => 'Town Hall No 2  Day and Night Banquets not based on free charging', 'parent_id' => 25],
            ['description' => 'Town Hall No 2  For workshop on beauty culture and cookery', 'parent_id' => 26],
            ['description' => 'Town Hall NO 2  other event_description', 'parent_id' => 27],

        ]);
          // stadium
        DB::table('booking_tax_types')->insert([
            ['description' => 'Stadium   Weeding Function', 'parent_id' => 28],
            ['description' => 'Stadium  Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing', 'parent_id' => 29],
            ['description' => 'Stadium  Exhibitions, Displays, or Functions based on cash transactions, of books, Magazines  and Plastic Goods, and Sale of Flowers and Furniture', 'parent_id' => 30],
            ['description' => 'Stadium  Exhibitions based on Cash transactions and Exhibitions not covered under 3.3 above', 'parent_id' => 31],
            ['description' => 'Stadium  Day and Night Banquets not based on free charging', 'parent_id' => 32],
            ['description' => 'Stadium  Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 33],
            ['description' => 'Stadium  Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 34],
            ['description' => 'Stadium  Any other paying Services not herein mentioned', 'parent_id' => 35],
            ['description' => 'Stadium  Any other non-charging Services not herein mentioned', 'parent_id' => 36],
            ['description' => 'Stadium  Display of sales and fairs (Apperals Electrical Appliances, Footwear etc)', 'parent_id' => 37],
            ['description' => 'Stadium  Literary festivals, Commemoration', 'parent_id' => 38],
            ['description' => 'Stadium  For night Lodging', 'parent_id' => 39],
            ['description' => 'Stadium  For watching international Cricket Tests', 'parent_id' => 40],
            ['description' => 'Stadium  International preschool, International School', 'parent_id' => 41],
            ['description' => 'Stadium  For watching other games which hold.', 'parent_id' => 42],
            ['description' => 'Stadium  for Workshops of Beauty Culture and Cookery', 'parent_id' => 43],
            ['description' => 'Stadium  other event_description', 'parent_id' => 44],
        ]);
         //samanala Ground
        DB::table('booking_tax_types')->insert([
            ['description' => 'Samanala Ground  For Meetings of political, Trade union and others', 'parent_id' => 45],
            ['description' => 'Samanala Ground  For Musical shows +', 'parent_id' => 46],
            ['description' => 'Samanala Ground  Non chargeable  Musical show ', 'parent_id' => 47],
            ['description' => 'Samanala Ground  For any Sport event_description-For School Children', 'parent_id' => 48],
            ['description' => 'Samanala Ground  For any Sport event_description - other', 'parent_id' => 49],
            ['description' => 'Samanala Ground  For any series of Sport event_descriptions-For School Children', 'parent_id' => 50],
            ['description' => 'Samanala Ground  For any series of Sportevent_description-other', 'parent_id' => 51],
            ['description' => 'Samanala Ground  For a circus', 'parent_id' => 52],
            ['description' => 'Samanala Ground  For any sports event_description held at National, Provincial, Divisional level by State or Any Sports activity concerned with preschools ', 'parent_id' => 53],
            ['description' => 'Samanala Ground  For any Sale or Fair', 'parent_id' => 54],
            ['description' => 'Samanala Ground  For other Sports Festival (including International School)', 'parent_id' => 55],
            ['description' => 'Samanala Ground  For Landing Air craft', 'parent_id' => 56],
            ['description' => 'Samanala Ground  For any other services not mentioned hereinbefore per day', 'parent_id' => 57],
            ['description' => 'Samanala Ground  For sport practices', 'parent_id' => 58],
            ['description' => 'Samanala Ground  other event_description', 'parent_id' => 59],

        ]);
          //Hiyare tank
        DB::table('booking_tax_types')->insert([
            ['description' => 'Hiyare Tank Ground  for the reservation of the ground', 'parent_id' => 60],
            ['description' => 'Hiyare Tank Ground  Other event_description', 'parent_id' => 61],
        ]);
         //dharmapala graden
        DB::table('booking_tax_types')->insert([
            ['description' => 'Dharmapala Garden  For a Festival day', 'parent_id' => 62],
            ['description' => 'Dharmapala Garden  charge for decorations and display of Notice of publicity ', 'parent_id' => 63],
            ['description' => 'Dharmapala Garden  For a Monthly Festival day', 'parent_id' => 64],
            ['description' => 'Dharmapala Garden  other event_description', 'parent_id' => 65],

        ]);

        DB::table('booking_tax_types')->insert([
            ['description' => 'Central Bus stand open air in uppermost Floor  for a single night Banquet', 'parent_id' => 66],
        ]);
        DB::table('booking_tax_types')->insert([
            ['description' => 'Other descriptions  Milidduwa Sports Ground', 'parent_id' => 67],
            ['description' => 'Other descriptions  For Festivals and Meetings on any road within Municipal Area  not obstructing free transport', 'parent_id' => 68],
            ['description' => 'Other descriptions  other event_description', 'parent_id' => 69],
        ]);
    }
}
