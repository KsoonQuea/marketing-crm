<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('states')->delete();

        DB::table('states')->insert([
            0 => [
                    'id' => 1,
                    'name' => 'Johor',
                    'postcode_format' => '79,80,81,82,83,84,85,86',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            1 => [
                    'id' => 2,
                    'name' => 'Kedah',
                    'postcode_format' => '5,6,7,8,9',
                    'other_postcode' => '14290,14390,34950',
                    'status' => 0,
                ],
            2 => [
                    'id' => 3,
                    'name' => 'Kelantan',
                    'postcode_format' => '15,16,17,18',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            3 => [
                    'id' => 4,
                    'name' => 'Melaka',
                    'postcode_format' => '75,76,77,78',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            4 => [
                    'id' => 5,
                    'name' => 'Negeri Sembilan',
                    'postcode_format' => '70,71,72,73',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            5 => [
                    'id' => 6,
                    'name' => 'Pahang',
                    'postcode_format' => '25,26,27,28,39,49,69',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            6 => [
                    'id' => 7,
                    'name' => 'Perak',
                    'postcode_format' => '30,31,32,33,34,35,36',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            7 => [
                    'id' => 8,
                    'name' => 'Perlis',
                    'postcode_format' => '1,2',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            8 => [
                    'id' => 9,
                    'name' => 'Pulau Pinang',
                    'postcode_format' => '10,11,12,13,14',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            9 => [
                    'id' => 10,
                    'name' => 'Sarawak',
                    'postcode_format' => '93,94,95,96,97,98',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            10 => [
                    'id' => 11,
                    'name' => 'Selangor',
                    'postcode_format' => '40,41,42,43,44,45,46,47,48,63,64,65,66,67,68',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            11 => [
                    'id' => 12,
                    'name' => 'Terengganu',
                    'postcode_format' => '20,21,22,23,24',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            12 => [
                    'id' => 13,
                    'name' => 'Kuala Lumpur',
                    'postcode_format' => '50,51,52,53,54,55,56,57,58,59,60',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            13 => [
                    'id' => 14,
                    'name' => 'Labuan',
                    'postcode_format' => '87',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            14 => [
                    'id' => 15,
                    'name' => 'Sabah',
                    'postcode_format' => '88,89,90,91',
                    'other_postcode' => null,
                    'status' => 0,
                ],
            15 => [
                    'id' => 16,
                    'name' => 'Putrajaya',
                    'postcode_format' => '62',
                    'other_postcode' => null,
                    'status' => 0,
                ],
        ]);
    }
}
