<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SeedStores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Create a Faker instance with Indonesian locale
        $faker = Faker::create('id_ID');

        // Define region mapping for Bali (example)
        $regionMapping = [
            1 => 'MM',   // Region 1
            2 => 'JP3',  // Region 2
            3 => 'JP4',  // Region 3
            4 => 'JP5',  // Region 4
            5 => 'JP6',  // Region 5
            6 => 'JP7',  // Region 6
            7 => 'JP8',  // Region 7
            8 => 'JP9',  // Region 8
            9 => 'JP10', // Region 9
            10 => 'JP11' // Region 10
        ];

        // Insert first specific entry
        DB::table('store')->insert([
            'store' => 79,
            'store_name' => 'MM PRG',
            'store_add1' => 'JL. PURI GADING',
            'store_add2' => null,
            'store_city' => 'JIMBARAN',
            'region' => 1,
            'latitude' => -8.7737, // Latitude for Jimbaran, Bali
            'longitude' => 115.1668, // Longitude for Jimbaran, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert "DC Minimart" entry
        DB::table('store')->insert([
            'store' => 40,
            'store_name' => 'DC Minimart',
            'store_add1' => 'JL. NYANGNYANG SARI NO. 7A',
            'store_add2' => 'TUBAN',
            'store_city' => 'BADUNG',
            'region' => 1, // Region code for DC Minimart
            'latitude' => -8.7465, // Latitude for Tuban, Bali
            'longitude' => 115.1677, // Longitude for Tuban, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert additional specific entry
        DB::table('store')->insert([
            'store' => 41,
            'store_name' => 'MM RMY',
            'store_add1' => null, // No address provided
            'store_add2' => null,
            'store_city' => null, // No city provided
            'region' => 1, // Default region
            'latitude' => -8.7254882,
            'longitude' => 115.1709741,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert other specific entries
        DB::table('store')->insert([
            'store' => 89,
            'store_name' => 'MM LG5',
            'store_add1' => 'JL. RAYA LEGIAN',
            'store_add2' => null,
            'store_city' => 'BADUNG',
            'region' => 1,
            'latitude' => -8.7093, // Latitude for Legian, Bali
            'longitude' => 115.1710, // Longitude for Legian, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('store')->insert([
            'store' => 95,
            'store_name' => 'MM CG2',
            'store_add1' => 'JL. RAYA CANGGU, BR. ASEMAN KAWAN, KUTA UTARA',
            'store_add2' => null,
            'store_city' => 'BADUNG',
            'region' => 1,
            'latitude' => -8.6486, // Latitude for Canggu, Bali
            'longitude' => 115.1384, // Longitude for Canggu, Bali
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert additional specific entry
        DB::table('store')->insert([
            'store' => 42, // id
            'store_name' => 'MM RGH', // name
            'store_add1' => '', // Empty address field
            'store_add2' => null, // Null for optional address line 2
            'store_city' => null, // No city provided
            'region' => 1, // Default region
            'latitude' => -8.7060423, // latitude
            'longitude' => 115.1689762, // longitude
            'created_at' => '2023-04-06 15:02:05', // Custom creation time
            'updated_at' => now(), // Current timestamp for updated_at
        ]);

        $entries = [
            ['store' => 43, 'store_name' => 'MM KSV', 'latitude' => -8.7195791, 'longitude' => 115.1692239, 'created_at' => '2023-03-21 15:47:52'],
            ['store' => 45, 'store_name' => 'MM LG1', 'latitude' => -8.7159472, 'longitude' => 115.1738895, 'created_at' => '2023-04-06 15:08:23'],
            ['store' => 46, 'store_name' => 'MM BSR', 'latitude' => -8.7246813, 'longitude' => 115.1717575, 'created_at' => now()],
            ['store' => 47, 'store_name' => 'MM KSQ', 'latitude' => -8.723745, 'longitude' => 115.1714729, 'created_at' => '2024-01-17 09:19:26'],
            ['store' => 48, 'store_name' => 'MM LG2', 'latitude' => -8.7181072, 'longitude' => 115.1746157, 'created_at' => '2023-04-06 07:40:49'],
            ['store' => 49, 'store_name' => 'MM MLS', 'latitude' => -8.7087334, 'longitude' => 115.169469, 'created_at' => '2023-04-06 14:56:22'],
            ['store' => 54, 'store_name' => 'MM KPZ', 'latitude' => -8.7292241, 'longitude' => 115.1685357, 'created_at' => '2023-04-06 15:06:08'],
            ['store' => 55, 'store_name' => 'MM BPN', 'latitude' => -8.7856751, 'longitude' => 115.2023301, 'created_at' => '2023-04-06 15:00:45'],
            ['store' => 56, 'store_name' => 'MM BNS', 'latitude' => -8.7141258, 'longitude' => 115.1721569, 'created_at' => '2023-04-06 15:26:31'],
            ['store' => 57, 'store_name' => 'MM LG4', 'latitude' => -8.6971315, 'longitude' => 115.1687972, 'created_at' => '2023-04-05 16:09:00'],
            ['store' => 59, 'store_name' => 'MM HWR', 'latitude' => -8.6619527, 'longitude' => 115.2399464, 'created_at' => '2023-04-06 15:00:14'],
            ['store' => 60, 'store_name' => 'MM JP3', 'latitude' => -8.7130297, 'longitude' => 115.1676702, 'created_at' => '2023-04-06 15:05:10'],
            ['store' => 61, 'store_name' => 'MM KP2', 'latitude' => -8.7310792, 'longitude' => 115.16769, 'created_at' => now()],
            ['store' => 63, 'store_name' => 'MM KGL', 'latitude' => -8.7101574, 'longitude' => 115.1784266, 'created_at' => '2023-04-06 15:02:36'],
            ['store' => 65, 'store_name' => 'MM WTR', 'latitude' => -8.6785649, 'longitude' => 115.2256351, 'created_at' => '2023-04-06 15:04:42'],
            ['store' => 67, 'store_name' => 'MM SMY', 'latitude' => -8.6781636, 'longitude' => 115.1646362, 'created_at' => '2023-04-06 14:33:03'],
            ['store' => 68, 'store_name' => 'MM TRA', 'latitude' => -8.6613143, 'longitude' => 115.2188891, 'created_at' => '2023-04-06 15:05:02'],
            ['store' => 69, 'store_name' => 'MM DRC', 'latitude' => -8.7218022, 'longitude' => 115.1853069, 'created_at' => '2023-04-06 15:14:41'],
            ['store' => 71, 'store_name' => 'MM KDR', 'latitude' => -8.7373225, 'longitude' => 115.1679629, 'created_at' => '2023-04-06 15:01:49'],
            ['store' => 73, 'store_name' => 'MM BPJ', 'latitude' => -8.7557351, 'longitude' => 115.1797764, 'created_at' => '2023-04-05 15:57:51'],
            ['store' => 77, 'store_name' => 'MM SKJ', 'latitude' => -8.689489, 'longitude' => 115.1675632, 'created_at' => '2023-02-20 18:10:58'],
            ['store' => 78, 'store_name' => 'MM SNR', 'latitude' => -8.6841127, 'longitude' => 115.259102, 'created_at' => '2023-04-06 15:15:37'],
            ['store' => 79, 'store_name' => 'MM PRG', 'latitude' => -8.8048374, 'longitude' => 115.1593436, 'created_at' => '2023-04-06 15:20:02'],
            ['store' => 84, 'store_name' => 'MM KP3', 'latitude' => -8.7313733, 'longitude' => 115.1676277, 'created_at' => '2023-04-06 15:08:40'],
            ['store' => 85, 'store_name' => 'MM DWS', 'latitude' => -8.7000502, 'longitude' => 115.1775311, 'created_at' => '2023-04-06 15:01:53'],
            ['store' => 88, 'store_name' => 'MM TB2', 'latitude' => -8.7713906, 'longitude' => 115.2223231, 'created_at' => '2023-04-06 14:44:59'],
            ['store' => 89, 'store_name' => 'MM LG5', 'latitude' => -8.7212804, 'longitude' => 115.1753152, 'created_at' => '2023-04-06 15:04:20'],
        ];

        foreach ($entries as $entry) {
            DB::table('store')->insert(array_merge($entry, [
                'store_add1' => '',
                'store_add2' => null,
                'store_city' => null,
                'region' => 1,
                'updated_at' => now(),
            ]));
        }

        $entries = [
            ['store' => 90, 'store_name' => 'MM BN2', 'latitude' => -8.6837686, 'longitude' => 115.1535705],
            ['store' => 92, 'store_name' => 'MM OB2', 'latitude' => -8.6837686, 'longitude' => 115.1535705],
            ['store' => 93, 'store_name' => 'MM BUN', 'latitude' => -8.7259604, 'longitude' => 115.1749699],
            ['store' => 94, 'store_name' => 'MM PO2', 'latitude' => null, 'longitude' => null],
            ['store' => 95, 'store_name' => 'MM CG2', 'latitude' => -8.6415748, 'longitude' => 115.1547452],
            ['store' => 96, 'store_name' => 'MM MTR', 'latitude' => -8.7156327, 'longitude' => 115.1767907],
            ['store' => 98, 'store_name' => 'MM LG6', 'latitude' => null, 'longitude' => null],
            ['store' => 101, 'store_name' => 'MM LG8', 'latitude' => null, 'longitude' => null],
            ['store' => 102, 'store_name' => 'MM LG9', 'latitude' => -8.7133986, 'longitude' => 115.1733162],
            ['store' => 106, 'store_name' => 'MM BP2', 'latitude' => null, 'longitude' => null],
            ['store' => 109, 'store_name' => 'MM UB2', 'latitude' => -8.5043225, 'longitude' => 115.2536538],
            ['store' => 110, 'store_name' => 'MM SR2', 'latitude' => -8.7031033, 'longitude' => 115.180614],
            ['store' => 111, 'store_name' => 'MM UB3', 'latitude' => -8.5243656, 'longitude' => 115.2638871],
            ['store' => 113, 'store_name' => 'MM JP4', 'latitude' => -8.7224088, 'longitude' => 115.1748923],
            ['store' => 114, 'store_name' => 'MM UB4', 'latitude' => -8.512417, 'longitude' => 115.26096],
            ['store' => 116, 'store_name' => 'MM DBS', 'latitude' => -8.6969983, 'longitude' => 115.1662593],
            ['store' => 118, 'store_name' => 'MM OB3', 'latitude' => -8.6786135, 'longitude' => 115.1604458],
            ['store' => 119, 'store_name' => 'MM BP3', 'latitude' => null, 'longitude' => null],
            ['store' => 120, 'store_name' => 'MM ULW', 'latitude' => -8.81632295848123, 'longitude' => 115.155049826204],
            ['store' => 121, 'store_name' => 'MM BN4', 'latitude' => -8.7128244, 'longitude' => 115.168829],
            ['store' => 122, 'store_name' => 'MM SK2', 'latitude' => -8.6949252, 'longitude' => 115.1682632],
            ['store' => 123, 'store_name' => 'MM PT3', 'latitude' => -8.672886, 'longitude' => 115.158967],
            ['store' => 124, 'store_name' => 'MM NKL', 'latitude' => -8.6972526, 'longitude' => 115.1713014],
            ['store' => 125, 'store_name' => 'MM TN3', 'latitude' => null, 'longitude' => null],
            ['store' => 126, 'store_name' => 'MM UL2', 'latitude' => -8.812917, 'longitude' => 115.1572842],
            ['store' => 127, 'store_name' => 'MM KT3', 'latitude' => -8.6370402, 'longitude' => 115.2816553],
            ['store' => 128, 'store_name' => 'MM TN4', 'latitude' => -8.7291791, 'longitude' => 115.1771224],
            ['store' => 129, 'store_name' => 'MM LG10', 'latitude' => -8.7163915, 'longitude' => 115.1741563],
            ['store' => 132, 'store_name' => 'MM BT2', 'latitude' => -8.6729586, 'longitude' => 115.1523571],
            ['store' => 133, 'store_name' => 'MM RK2', 'latitude' => null, 'longitude' => null],
            ['store' => 134, 'store_name' => 'MM UDJ', 'latitude' => -8.79973673769927, 'longitude' => 115.171195812711],
            ['store' => 135, 'store_name' => 'MM DRP', 'latitude' => -8.6896223, 'longitude' => 115.1644502],
            ['store' => 136, 'store_name' => 'MM BSQ', 'latitude' => null, 'longitude' => null],
            ['store' => 137, 'store_name' => 'MM UML', 'latitude' => -8.6661215, 'longitude' => 115.1557542],
            ['store' => 138, 'store_name' => 'MM UM2', 'latitude' => -8.660626, 'longitude' => 115.1525581],
            ['store' => 139, 'store_name' => 'MM DW2', 'latitude' => null, 'longitude' => null],
            ['store' => 140, 'store_name' => 'MM DYP', 'latitude' => -8.6917701, 'longitude' => 115.1632959],
            ['store' => 141, 'store_name' => 'MM MLS2', 'latitude' => -8.7087901, 'longitude' => 115.169258],
            ['store' => 142, 'store_name' => 'MM OB4', 'latitude' => -8.6809196, 'longitude' => 115.1629117],
            ['store' => 143, 'store_name' => 'MM SR3', 'latitude' => -8.682472, 'longitude' => 115.1657541],
            ['store' => 144, 'store_name' => 'MM OB5', 'latitude' => -8.6828368, 'longitude' => 115.1599512],
            ['store' => 145, 'store_name' => 'MM DBS2', 'latitude' => -8.6971046, 'longitude' => 115.1671661],
            ['store' => 146, 'store_name' => 'MM BP4', 'latitude' => -8.78656105568626, 'longitude' => 115.204268726204],
            ['store' => 147, 'store_name' => 'MM PAD2', 'latitude' => -8.7016314, 'longitude' => 115.1664666],
            ['store' => 149, 'store_name' => 'MM PO4', 'latitude' => -8.7174395, 'longitude' => 115.1727677],
            ['store' => 150, 'store_name' => 'MM SM2', 'latitude' => -8.6761684, 'longitude' => 115.1647878],
            ['store' => 151, 'store_name' => 'MM OB6', 'latitude' => -8.6893154, 'longitude' => 115.1587126],
            ['store' => 152, 'store_name' => 'MM TNL', 'latitude' => -8.6093219, 'longitude' => 115.1117518],
            ['store' => 153, 'store_name' => 'MM SHU', 'latitude' => -8.8045116, 'longitude' => 115.217173],
            ['store' => 154, 'store_name' => 'MM BP5', 'latitude' => -8.7983825, 'longitude' => 115.2226263],
            ['store' => 155, 'store_name' => 'MM KPL', 'latitude' => -8.8010216, 'longitude' => 115.2137514],
            ['store' => 157, 'store_name' => 'MM CG4', 'latitude' => -8.62422772139348, 'longitude' => 115.123206017611],
            ['store' => 158, 'store_name' => 'MM UB5', 'latitude' => -8.5172309, 'longitude' => 115.2596473],
            ['store' => 159, 'store_name' => 'MM DP2', 'latitude' => -8.691041, 'longitude' => 115.1672794],
            ['store' => 160, 'store_name' => 'MM UB6', 'latitude' => -8.5060265, 'longitude' => 115.2626735],
            ['store' => 161, 'store_name' => 'MM UB7', 'latitude' => -8.5046754, 'longitude' => 115.255659],
            ['store' => 163, 'store_name' => 'MM CG5', 'latitude' => null, 'longitude' => null],
            ['store' => 165, 'store_name' => 'MM UB8', 'latitude' => -8.5160737, 'longitude' => 115.2600896],
            ['store' => 166, 'store_name' => 'MM TL2', 'latitude' => null, 'longitude' => null],
            ['store' => 167, 'store_name' => 'MM BP6', 'latitude' => -8.8053257, 'longitude' => 115.2228146],
            ['store' => 168, 'store_name' => 'MM OB8', 'latitude' => null, 'longitude' => null],
            ['store' => 169, 'store_name' => 'MM OB7', 'latitude' => -8.6768322, 'longitude' => 115.1593471],
            ['store' => 170, 'store_name' => 'MM KT4', 'latitude' => -8.6297305, 'longitude' => 115.2932494],
            ['store' => 171, 'store_name' => 'MM OB9', 'latitude' => -8.68416716751231, 'longitude' => 115.159295928656],
            ['store' => 172, 'store_name' => 'MM BN5', 'latitude' => -8.7113881, 'longitude' => 115.1711656],
            ['store' => 173, 'store_name' => 'MM BN6', 'latitude' => null, 'longitude' => null],
            ['store' => 174, 'store_name' => 'MM RK3', 'latitude' => -8.71108448723721, 'longitude' => 115.180762355039],
            ['store' => 175, 'store_name' => 'MM PT4', 'latitude' => -8.6764036, 'longitude' => 115.1575053],
            ['store' => 176, 'store_name' => 'MM LG11', 'latitude' => null, 'longitude' => null],
            ['store' => 177, 'store_name' => 'MM BN7', 'latitude' => -8.71418132343252, 'longitude' => 115.172163046447],
            ['store' => 178, 'store_name' => 'MM NK2', 'latitude' => null, 'longitude' => null],
            ['store' => 179, 'store_name' => 'MM SR4', 'latitude' => -8.70894520648253, 'longitude' => 115.185347855039],
            ['store' => 180, 'store_name' => 'MM SR5', 'latitude' => -8.6896305, 'longitude' => 115.1722912],
            ['store' => 181, 'store_name' => 'MM SK3', 'latitude' => -8.6963139, 'longitude' => 115.1685162],
            ['store' => 182, 'store_name' => 'MM PO6', 'latitude' => null, 'longitude' => null],
            ['store' => 183, 'store_name' => 'MM PO5', 'latitude' => -8.7197971, 'longitude' => 115.173771],
            ['store' => 184, 'store_name' => 'MM BT3', 'latitude' => -8.6733167, 'longitude' => 115.1466825],
            ['store' => 185, 'store_name' => 'MM OB10', 'latitude' => -8.68632722795294, 'longitude' => 115.15554836421],
            ['store' => 186, 'store_name' => 'MM PO7', 'latitude' => -8.717174, 'longitude' => 115.171557],
            ['store' => 187, 'store_name' => 'MM DW3', 'latitude' => -8.7067798, 'longitude' => 115.1779874],
            ['store' => 189, 'store_name' => 'MM NK3', 'latitude' => null, 'longitude' => null],
            ['store' => 191, 'store_name' => 'MM PR2', 'latitude' => null, 'longitude' => null],
            ['store' => 192, 'store_name' => 'MM UB9', 'latitude' => -8.5183002, 'longitude' => 115.262984],
            ['store' => 193, 'store_name' => 'MM BP7', 'latitude' => null, 'longitude' => null],
            ['store' => 194, 'store_name' => 'MM BT4', 'latitude' => null, 'longitude' => null],
            ['store' => 195, 'store_name' => 'MM UM3', 'latitude' => null, 'longitude' => null],
            ['store' => 196, 'store_name' => 'MM SR6', 'latitude' => -8.68217818031798, 'longitude' => 115.168400753528],
            ['store' => 197, 'store_name' => 'MM UB10', 'latitude' => -8.5068238, 'longitude' => 115.259103],
            ['store' => 198, 'store_name' => 'MM PT5', 'latitude' => -8.6788332, 'longitude' => 115.1535598],
            ['store' => 199, 'store_name' => 'MM UD3', 'latitude' => null, 'longitude' => null],
            ['store' => 201, 'store_name' => 'MM PT6', 'latitude' => null, 'longitude' => null],
            ['store' => 202, 'store_name' => 'MM UB11', 'latitude' => -8.49462247288208, 'longitude' => 115.253545728827],
            ['store' => 203, 'store_name' => 'MM OB11', 'latitude' => -8.685649, 'longitude' => 115.1566046],
            ['store' => 204, 'store_name' => 'MM UD4', 'latitude' => -8.79752980097937, 'longitude' => 115.171885462257],
            ['store' => 205, 'store_name' => 'MM UL3', 'latitude' => -8.82153, 'longitude' => 115.144796],
            ['store' => 206, 'store_name' => 'MM DRP2', 'latitude' => -8.6836939, 'longitude' => 115.1645246],
            ['store' => 207, 'store_name' => 'MM PT7', 'latitude' => null, 'longitude' => null],
            ['store' => 208, 'store_name' => 'MM PAD3', 'latitude' => -8.6997599, 'longitude' => 115.1657157],
            ['store' => 209, 'store_name' => 'MM UB12', 'latitude' => -8.50764076728676, 'longitude' => 115.262273228656],
            ['store' => 210, 'store_name' => 'MM DP3', 'latitude' => -8.6911751, 'longitude' => 115.1650326],
            ['store' => 211, 'store_name' => 'MM NK4', 'latitude' => -8.696681, 'longitude' => 115.172092],
            ['store' => 212, 'store_name' => 'MM SG2', 'latitude' => -8.7369123, 'longitude' => 115.1651577],
            ['store' => 213, 'store_name' => 'MM BN8', 'latitude' => -8.7167417, 'longitude' => 115.1724053],
            ['store' => 214, 'store_name' => 'MM UD5', 'latitude' => -8.7880378, 'longitude' => 115.1571858],
            ['store' => 215, 'store_name' => 'MM TAB', 'latitude' => -8.55172048513186, 'longitude' => 115.131800586428],
            ['store' => 216, 'store_name' => 'MM SR7', 'latitude' => -8.6836662, 'longitude' => 115.1710845],
            ['store' => 217, 'store_name' => 'MM BP8', 'latitude' => -8.7973127, 'longitude' => 115.2163968],
            ['store' => 218, 'store_name' => 'MM UL4', 'latitude' => null, 'longitude' => null],
            ['store' => 219, 'store_name' => 'MM UM4', 'latitude' => null, 'longitude' => null],
            ['store' => 220, 'store_name' => 'MM CG6', 'latitude' => null, 'longitude' => null],
            ['store' => 221, 'store_name' => 'MM OB12', 'latitude' => null, 'longitude' => null],
            ['store' => 222, 'store_name' => 'MM PNG2', 'latitude' => -8.6975683, 'longitude' => 115.1620351],
            ['store' => 223, 'store_name' => 'MM LG12', 'latitude' => -8.7171033, 'longitude' => 115.1746898],
            ['store' => 224, 'store_name' => 'MM TB5', 'latitude' => -8.77684300732962, 'longitude' => 115.223542155039],
            ['store' => 225, 'store_name' => 'MM TB6', 'latitude' => null, 'longitude' => null],
            ['store' => 226, 'store_name' => 'MM UB14', 'latitude' => -8.5062882452166, 'longitude' => 115.261560328051],
            ['store' => 227, 'store_name' => 'MM TB7', 'latitude' => -8.75785346664978, 'longitude' => 115.221469340911],
            ['store' => 228, 'store_name' => 'MM TAB2', 'latitude' => -8.5386262, 'longitude' => 115.1114915],
            ['store' => 229, 'store_name' => 'MM TAB3', 'latitude' => null, 'longitude' => null],
            ['store' => 230, 'store_name' => 'MM TN6', 'latitude' => -8.7421878, 'longitude' => 115.1788877],
            ['store' => 231, 'store_name' => 'MM GSU', 'latitude' => null, 'longitude' => null],
            ['store' => 233, 'store_name' => 'MM SK4', 'latitude' => -8.6884669, 'longitude' => 115.1688806],
            ['store' => 234, 'store_name' => 'MM DW4', 'latitude' => null, 'longitude' => null],
            ['store' => 235, 'store_name' => 'MM UD7', 'latitude' => null, 'longitude' => null],
            ['store' => 236, 'store_name' => 'MM TAB5', 'latitude' => null, 'longitude' => null],
            ['store' => 237, 'store_name' => 'MM SRJ', 'latitude' => -8.140469, 'longitude' => 115.0534825],
            ['store' => 238, 'store_name' => 'MM SRJ2', 'latitude' => -8.144489, 'longitude' => 115.0501519],
            ['store' => 239, 'store_name' => 'MM LG14', 'latitude' => null, 'longitude' => null],
            ['store' => 240, 'store_name' => 'MM SRJ3', 'latitude' => null, 'longitude' => null],
            ['store' => 241, 'store_name' => 'MM OB14', 'latitude' => -8.6789001, 'longitude' => 115.1604209],
            ['store' => 242, 'store_name' => 'MM SRJ4', 'latitude' => null, 'longitude' => null],
            ['store' => 243, 'store_name' => 'MM SRJ5', 'latitude' => -8.1520627, 'longitude' => 115.0362234],
            ['store' => 244, 'store_name' => 'MM SRJ6', 'latitude' => null, 'longitude' => null],
            ['store' => 246, 'store_name' => 'MM BP9', 'latitude' => -8.7818136, 'longitude' => 115.1795742],
            ['store' => 247, 'store_name' => 'MM SRJ7', 'latitude' => -8.1190951, 'longitude' => 115.0834719],
            ['store' => 248, 'store_name' => 'MM BP10', 'latitude' => null, 'longitude' => null],
            ['store' => 249, 'store_name' => 'MM DRP3', 'latitude' => -8.6866178, 'longitude' => 115.1649587],
            ['store' => 250, 'store_name' => 'MM SRJ9', 'latitude' => -8.1620183, 'longitude' => 115.0252326],
            ['store' => 251, 'store_name' => 'MM SRJ8', 'latitude' => -8.128498, 'longitude' => 115.0852899],
            ['store' => 252, 'store_name' => 'MM JP5', 'latitude' => -8.7225567, 'longitude' => 115.1716934],
            ['store' => 253, 'store_name' => 'MM SK5', 'latitude' => -8.6909415, 'longitude' => 115.1687022],
            ['store' => 254, 'store_name' => 'MM SMR2', 'latitude' => -8.6603172, 'longitude' => 115.1635933],
            ['store' => 255, 'store_name' => 'MM BN9', 'latitude' => null, 'longitude' => null],
            ['store' => 256, 'store_name' => 'MM SRJ10', 'latitude' => -8.1271543, 'longitude' => 115.0660932],
            ['store' => 257, 'store_name' => 'MM SRJ11', 'latitude' => -8.1166534, 'longitude' => 115.0868198],
            ['store' => 258, 'store_name' => 'MM OB15', 'latitude' => null, 'longitude' => null],
            ['store' => 259, 'store_name' => 'MM SRJ12', 'latitude' => -8.1169442, 'longitude' => 115.0918804],
            ['store' => 260, 'store_name' => 'MM SN2', 'latitude' => -8.7054827, 'longitude' => 115.2558278],
            ['store' => 261, 'store_name' => 'MM SK6', 'latitude' => -8.6905064, 'longitude' => 115.1677168],
            ['store' => 262, 'store_name' => 'MM PO8', 'latitude' => -8.720825, 'longitude' => 115.172532999999],
            ['store' => 263, 'store_name' => 'MM SRJ14', 'latitude' => null, 'longitude' => null],
            ['store' => 264, 'store_name' => 'MM BN10', 'latitude' => -8.7091276, 'longitude' => 115.1699832],
            ['store' => 265, 'store_name' => 'MM PO9', 'latitude' => -8.71753234344768, 'longitude' => 115.174122127991],
            ['store' => 266, 'store_name' => 'MM BT5', 'latitude' => -8.6730243, 'longitude' => 115.1476683],
            ['store' => 267, 'store_name' => 'MM TAB6', 'latitude' => -8.2766017, 'longitude' => 115.1647706],
            ['store' => 268, 'store_name' => 'MM KD3', 'latitude' => -8.7383033, 'longitude' => 115.1708673],
            ['store' => 269, 'store_name' => 'MM DRP4', 'latitude' => -8.6901648, 'longitude' => 115.1617299],
            ['store' => 270, 'store_name' => 'MM KPL2', 'latitude' => -8.8076388, 'longitude' => 115.197802],
            ['store' => 271, 'store_name' => 'MM SR8', 'latitude' => -8.67875396667103, 'longitude' => 115.160584364238],
            ['store' => 272, 'store_name' => 'MM CG8', 'latitude' => -8.6448305, 'longitude' => 115.1414491],
            ['store' => 273, 'store_name' => 'MM TAB7', 'latitude' => -8.35762299187423, 'longitude' => 115.190163683871],
            ['store' => 274, 'store_name' => 'MM TB8', 'latitude' => -8.7871793, 'longitude' => 115.2258858],
            ['store' => 275, 'store_name' => 'MM RK5', 'latitude' => -8.7145218, 'longitude' => 115.1835571],
            ['store' => 276, 'store_name' => 'MM CG9', 'latitude' => -8.6526913, 'longitude' => 115.1310102],
            ['store' => 277, 'store_name' => 'MM KP4', 'latitude' => -8.7362771, 'longitude' => 115.1672972],
            ['store' => 278, 'store_name' => 'MM CG10', 'latitude' => -8.6541267, 'longitude' => 115.1261891],
            ['store' => 279, 'store_name' => 'MM SRJ15', 'latitude' => -8.1035326046452, 'longitude' => 115.090929435591],
            ['store' => 280, 'store_name' => 'MM SR9', 'latitude' => -8.6798203302428, 'longitude' => 115.167397806567],
            ['store' => 281, 'store_name' => 'MM SK7', 'latitude' => -8.687088, 'longitude' => 115.1672422],
            ['store' => 282, 'store_name' => 'MM KD4', 'latitude' => -8.7386121, 'longitude' => 115.1719678],
            ['store' => 283, 'store_name' => 'MM UB15', 'latitude' => -8.5022795, 'longitude' => 115.2723201],
            ['store' => 284, 'store_name' => 'MM UB16', 'latitude' => -8.5307243, 'longitude' => 115.2717861],
            ['store' => 285, 'store_name' => 'MM GSU2', 'latitude' => -8.6356249, 'longitude' => 115.2265485],
            ['store' => 286, 'store_name' => 'MM CG11', 'latitude' => -8.6512072, 'longitude' => 115.1492276],
            ['store' => 287, 'store_name' => 'MM CG12', 'latitude' => -8.6450357, 'longitude' => 115.1526982],
            ['store' => 288, 'store_name' => 'MM BSQ2', 'latitude' => - 8.760979, 'longitude' => 115.1774586],
            ['store' => 289, 'store_name' => 'MM SRJ16', 'latitude' => -8.0939779, 'longitude' => 115.1149907],
            ['store' => 290, 'store_name' => 'MM UB17', 'latitude' => -8.4975095, 'longitude' => 115.2532626],
            ['store' => 291, 'store_name' => 'MM SRJ17', 'latitude' => null, 'longitude' => null],
            ['store' => 292, 'store_name' => 'MM CG14', 'latitude' => -8.654747, 'longitude' => 115.1418213],
            ['store' => 293, 'store_name' => 'MM CG7', 'latitude' => -8.6307122, 'longitude' => 115.1328099],
            ['store' => 294, 'store_name' => 'MM UB18', 'latitude' => -8.480596, 'longitude' => 115.2471791],
            ['store' => 295, 'store_name' => 'MM CG15', 'latitude' => -8.6546759, 'longitude' => 115.1353781],
            ['store' => 296, 'store_name' => 'MM CG16', 'latitude' => null, 'longitude' => null],
            ['store' => 297, 'store_name' => 'MM CG17', 'latitude' => -8.6402871, 'longitude' => 115.143664],
            ['store' => 298, 'store_name' => 'MM CG18', 'latitude' => -8.6522828, 'longitude' => 115.1434763],
            ['store' => 299, 'store_name' => 'MM CG19', 'latitude' => -8.643179, 'longitude' => 115.1395793],
            ['store' => 300, 'store_name' => 'MM CG20', 'latitude' => -8.6518231, 'longitude' => 115.1293127],
            ['store' => 301, 'store_name' => 'MM BP11', 'latitude' => -8.751963, 'longitude' => 115.181791],
            ['store' => 302, 'store_name' => 'MM TB9', 'latitude' => -8.7579565, 'longitude' => 115.2210106],
            ['store' => 303, 'store_name' => 'MM SK9', 'latitude' => -8.6841413, 'longitude' => 115.1666452],
            ['store' => 304, 'store_name' => 'MM CG21', 'latitude' => -8.64693881345852, 'longitude' => 115.132518253194],
            ['store' => 305, 'store_name' => 'MM CG22', 'latitude' => null, 'longitude' => null],
            ['store' => 306, 'store_name' => 'MM CG23', 'latitude' => -8.64180942324589, 'longitude' => 115.139185782029],
            ['store' => 307, 'store_name' => 'MM CG24', 'latitude' => -8.65758578513262, 'longitude' => 115.133569399111],
            ['store' => 308, 'store_name' => 'MM CG25', 'latitude' => null, 'longitude' => null],
            ['store' => 309, 'store_name' => 'MM JP6', 'latitude' => -8.72314992634197, 'longitude' => 115.173226988689],
            ['store' => 310, 'store_name' => 'MM TAB8', 'latitude' => null, 'longitude' => null],
            ['store' => 311, 'store_name' => 'MM DBS3', 'latitude' => -8.698111, 'longitude' => 115.1648508],
            ['store' => 312, 'store_name' => 'MM JP7', 'latitude' => null, 'longitude' => null],
            ['store' => 313, 'store_name' => 'MM CG26', 'latitude' => -8.64560198994481, 'longitude' => 115.135266482024],
            ['store' => 314, 'store_name' => 'MM UB19', 'latitude' => -8.5107346, 'longitude' => 115.2583249],
            ['store' => 315, 'store_name' => 'MM CG27', 'latitude' => -8.66469442966765, 'longitude' => 115.141834953952],
            ['store' => 316, 'store_name' => 'MM CG28', 'latitude' => -8.65320419936691, 'longitude' => 115.130875641454],
            ['store' => 317, 'store_name' => 'MM CG29', 'latitude' => -8.6502677, 'longitude' => 115.1295983],
            ['store' => 318, 'store_name' => 'MM CG30', 'latitude' => -8.6586078, 'longitude' => 115.1400445],
            ['store' => 319, 'store_name' => 'MM PT8', 'latitude' => -8.67428247087991, 'longitude' => 115.156457574828],
            ['store' => 320, 'store_name' => 'MM CG31', 'latitude' => -8.64398380256933, 'longitude' => 115.13745318876],
            ['store' => 321, 'store_name' => 'MM UB20', 'latitude' => -8.4302635, 'longitude' => 115.2763267],
            ['store' => 322, 'store_name' => 'MM CG34', 'latitude' => -8.63525837075161, 'longitude' => 115.133342746447],
            ['store' => 323, 'store_name' => 'BIG M KAPAL', 'latitude' => null, 'longitude' => null],
            ['store' => 324, 'store_name' => 'BIG M TABANAN', 'latitude' => null, 'longitude' => null],
            ['store' => 325, 'store_name' => 'MM CG32', 'latitude' => -8.509799, 'longitude' => 115.2603773],
            ['store' => 326, 'store_name' => 'MM PT9', 'latitude' => -8.676558, 'longitude' => 115.1538403],
            ['store' => 327, 'store_name' => 'MM PAD4', 'latitude' => -8.7056632, 'longitude' => 115.170932],
            ['store' => 328, 'store_name' => 'MM MLS3', 'latitude' => -8.7085043, 'longitude' => 115.1711127],
            ['store' => 329, 'store_name' => 'MM UB21', 'latitude' => -8.509799, 'longitude' => 115.2603773],
            ['store' => 330, 'store_name' => 'MM SN3', 'latitude' => -8.703527, 'longitude' => 115.2585031],
            ['store' => 331, 'store_name' => 'MM CG33', 'latitude' => -8.639648, 'longitude' => 115.136652],
            ['store' => 332, 'store_name' => 'MM CG35', 'latitude' => -8.644727, 'longitude' => 115.127782],
            ['store' => 333, 'store_name' => 'MM PAD5', 'latitude' => -8.7001518, 'longitude' => 115.1653071],
            ['store' => 334, 'store_name' => 'MM SN4', 'latitude' => -8.707449, 'longitude' => 115.2540598],
            ['store' => 335, 'store_name' => 'MM SN5', 'latitude' => -8.686754, 'longitude' => 115.262626],
            ['store' => 336, 'store_name' => 'MM CG36', 'latitude' => -8.631305, 'longitude' => 115.149854],
            ['store' => 337, 'store_name' => 'MM CG37', 'latitude' => -8.784511, 'longitude' => 115.171125],
            ['store' => 338, 'store_name' => 'MM UD8', 'latitude' => -8.78306, 'longitude' => 115.166843],
            ['store' => 339, 'store_name' => 'MM UD9', 'latitude' => -8.784511, 'longitude' => 115.171125],
            ['store' => 340, 'store_name' => 'MM CG38', 'latitude' => -8.6394949, 'longitude' => 115.1548548],
            ['store' => 341, 'store_name' => 'MM CG39', 'latitude' => null, 'longitude' => null],
            ['store' => 342, 'store_name' => 'MM CG40', 'latitude' => null, 'longitude' => null],
            ['store' => 343, 'store_name' => 'MM SG3', 'latitude' => -8.737186, 'longitude' => 115.16639],
            ['store' => 344, 'store_name' => 'MM SN6', 'latitude' => null, 'longitude' => null],
        ];

        foreach ($entries as $entry) {
            DB::table('store')->insert(array_merge($entry, [
                'store_add1' => '',
                'store_add2' => null,
                'store_city' => null,
                'region' => 1,
                'updated_at' => now(),
            ]));
        }

    }

}
