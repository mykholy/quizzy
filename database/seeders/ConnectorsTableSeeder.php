<?php

namespace Database\Seeders;

use App\Models\Admin\Connector;
use Illuminate\Database\Seeder;

class ConnectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            ['plugshar_connector_id'=>1, 'name'=>'US Wall Outlet', 'description'=>'US Wall Outlet','power'=>null],
            ['plugshar_connector_id'=>2, 'name'=>'J-1772', 'description'=>'J-1772','power'=>null],
            ['plugshar_connector_id'=>3, 'name'=>'CHAdeMO', 'description'=>'CHAdeMO','power'=>null],
            ['plugshar_connector_id'=>4, 'name'=>'Tesla Roadster', 'description'=>'Tesla Roadster','power'=>null],
            ['plugshar_connector_id'=>5, 'name'=>'NEMA 14-50', 'description'=>'NEMA 14-50','power'=>null],
            ['plugshar_connector_id'=>6, 'name'=>'Tesla S HPWC', 'description'=>'Tesla S HPWC','power'=>0],
            ['plugshar_connector_id'=>7, 'name'=>'Type 2 (Mennekes)', 'description'=>'Type 2 (Mennekes)','power'=>null],
            ['plugshar_connector_id'=>8, 'name'=>'Type 3', 'description'=>'Type 3','power'=>null],
            ['plugshar_connector_id'=>9, 'name'=>'BS1363', 'description'=>'BS1363','power'=>null],
            ['plugshar_connector_id'=>10, 'name'=>'Europlug', 'description'=>'Europlug','power'=>null],
            ['plugshar_connector_id'=>11, 'name'=>'UK Commando', 'description'=>'UK Commando','power'=>null],
            ['plugshar_connector_id'=>12, 'name'=>'AS3112', 'description'=>'AS3112','power'=>null],
            ['plugshar_connector_id'=>13, 'name'=>'SAE Combo DC CCS', 'description'=>'SAE Combo DC CCS','power'=>null],
            ['plugshar_connector_id'=>14, 'name'=>'Three Phase (AU)', 'description'=>'Three Phase (AU)','power'=>null],
            ['plugshar_connector_id'=>15, 'name'=>'Caravan Mains Socket	', 'description'=>'Caravan Mains Socket	','power'=>null],
            ['plugshar_connector_id'=>16, 'name'=>'GB/T', 'description'=>'GB/T','power'=>null],
            ['plugshar_connector_id'=>17, 'name'=>'GB/T 2', 'description'=>'GB/T 2','power'=>null],
            ['plugshar_connector_id'=>25, 'name'=>'NEMA TT-30	', 'description'=>'NEMA TT-30	','power'=>null],

        ];
        foreach ($list as $item) {
            Connector::updateOrCreate([
                'plugshar_connector_id' => $item['plugshar_connector_id'],
            ], $item);
        }
    }
}
