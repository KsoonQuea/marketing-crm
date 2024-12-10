<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cityWithStates = [
            1 => [
                'Johor Bahru',
                'Tebrau',
                'Pasir Gudang',
                'Bukit Indah',
                'Skudai',
                'Kluang',
                'Batu Pahat',
                'Muar',
                'Ulu Tiram',
                'Senai',
                'Segamat',
                'Kulai',
                'Kota Tinggi',
                'Pontian Kechil',
                'Tangkak',
                'Bukit Bakri',
                'Yong Peng',
                'Pekan Nenas',
                'Labis',
                'Mersing',
                'Simpang Renggam',
                'Parit Raja',
                'Kelapa Sawit',
                'Buloh Kasap',
                'Chaah',
            ],
            2 => [
                'Sungai Petani',
                'Alor Setar',
                'Kulim',
                'Jitra / Kubang Pasu',
                'Baling',
                'Pendang',
                'Langkawi',
                'Yan',
                'Sik',
                'Kuala Nerang',
                'Pokok Sena',
                'Bandar Baharu',
            ],
            3 => [
                'Kota Bharu',
                'Pangkal Kalong',
                'Tanah Merah',
                'Peringat',
                'Wakaf Baru',
                'Kadok',
                'Pasir Mas',
                'Gua Musang',
                'Kuala Krai',
                'Tumpat',
            ],
            4 => [
                'Bandaraya Melaka',
                'Bukit Baru',
                'Ayer Keroh',
                'Klebang',
                'Masjid Tanah',
                'Sungai Udang',
                'Batu Berendam',
                'Alor Gajah',
                'Bukit Rambai',
                'Ayer Molek',
                'Bemban',
                'Kuala Sungai Baru',
                'Pulau Sebang',
            ],
            5 => [
                'Seremban',
                'Port Dickson',
                'Nilai',
                'Bahau',
                'Tampin',
                'Kuala Pilah',
            ],
            6 => [
                'Kuantan',
                'Temerloh',
                'Bentong',
                'Mentakab',
                'Raub',
                'Jerantut',
                'Pekan',
                'Kuala Lipis',
                'Bandar Jengka',
                'Bukit Tinggi',
            ],
            7 => [
                'Ipoh',
                'Taiping',
                'Sitiawan',
                'Simpang Empat',
                'Teluk Intan',
                'Batu Gajah',
                'Lumut',
                'Kampung Koh',
                'Kuala Kangsar',
                'Sungai Siput Utara',
                'Tapah',
                'Bidor',
                'Parit Buntar',
                'Ayer Tawar',
                'Bagan Serai',
                'Tanjung Malim',
                'Lawan Kuda Baharu',
                'Pantai Remis',
                'Kampar',
            ],
            8 => [
                'Kangar',
                'Kuala Perlis',
            ],
            9 => [
                'Bukit Mertajam',
                'Georgetown',
                'Sungai Ara',
                'Gelugor',
                'Ayer Itam',
                'Butterworth',
                'Perai',
                'Nibong Tebal',
                'Permatang Kucing',
                'Tanjung Tokong',
                'Kepala Batas',
                'Tanjung Bungah',
                'Juru',
            ],
            15 => [
                'Kota Kinabalu',
                'Sandakan',
                'Tawau',
                'Lahad Datu',
                'Keningau',
                'Putatan',
                'Donggongon',
                'Semporna',
                'Kudat',
                'Kunak',
                'Papar',
                'Ranau',
                'Beaufort',
                'Kinarut',
                'Kota Belud',
            ],
            10 => [
                'Kuching',
                'Miri',
                'Sibu',
                'Bintulu',
                'Limbang',
                'Sarikei',
                'Sri Aman',
                'Kapit',
                'Batu Delapan Bazaar',
                'Kota Samarahan',
            ],
            11 => [
                'Subang Jaya',
                'Klang',
                'Ampang Jaya',
                'Shah Alam',
                'Petaling Jaya',
                'Cheras',
                'Kajang',
                'Selayang Baru',
                'Rawang',
                'Taman Greenwood',
                'Semenyih',
                'Banting',
                'Balakong',
                'Gombak Setia',
                'Kuala Selangor',
                'Serendah',
                'Bukit Beruntung',
                'Pengkalan Kundang',
                'Jenjarom',
                'Sungai Besar',
                'Batu Arang',
                'Tanjung Sepat',
                'Kuang',
                'Kuala Kubu Baharu',
                'Batang Berjuntai',
                'Bandar Baru Salak Tinggi',
                'Sekinchan',
                'Sabak',
                'Tanjung Karang',
                'Beranang',
                'Sungai Pelek',
            ],
            12 => [
                'Kuala Terengganu',
                'Chukai',
                'Dungun',
                'Kerteh',
                'Kuala Berang',
                'Marang',
                'Paka',
                'Jerteh',
            ],
            13 => [
                'Kuala Lumpur',
                'Setapak',
            ],
            14 => [
                'Labuan',
            ],
            16 => [
                'Putrajaya',
            ],
        ];

        foreach ($cityWithStates as $cityKey => $cities) {
            foreach ($cities as $city) {
                City::create([
                    'name' => $city,
                    'state_id' => $cityKey,
                ]);
            }
        }
    }
}
