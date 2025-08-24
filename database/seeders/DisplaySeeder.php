<?php

namespace Database\Seeders;

use App\Models\Display;
use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisplaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a template to assign to displays
        $template = Template::first();

        $displays = [
            [
                'name' => 'Lobby TV 1',
                'make' => 'LG',
                'model' => '55UN7300PUF',
                'ip_address' => '192.168.1.100',
                'mac_address' => '00:1B:44:11:3A:B7',
                'os' => 'WebOS',
                'version' => '6.0',
                'firmware_version' => '03.21.16',
                'location' => 'Main Lobby',
                'floor' => 'Ground',
                'room' => 'Lobby',
                'status' => 'online',
                'online' => true,
                'template_id' => $template?->id,
            ],
            [
                'name' => 'Conference Room A',
                'make' => 'Samsung',
                'model' => 'QN65Q80TAFXZA',
                'ip_address' => '192.168.1.101',
                'mac_address' => '00:1B:44:11:3A:B8',
                'os' => 'Tizen',
                'version' => '6.5',
                'firmware_version' => '1500.0',
                'location' => 'Conference Room A',
                'floor' => 'First',
                'room' => 'Conference A',
                'status' => 'online',
                'online' => true,
                'template_id' => $template?->id,
            ],
            [
                'name' => 'Restaurant Display',
                'make' => 'Sony',
                'model' => 'XBR-65X950H',
                'ip_address' => '192.168.1.102',
                'mac_address' => '00:1B:44:11:3A:B9',
                'os' => 'Android TV',
                'version' => '10',
                'firmware_version' => 'PKG6.7140.0176NAA',
                'location' => 'Restaurant',
                'floor' => 'Ground',
                'room' => 'Restaurant',
                'status' => 'offline',
                'online' => false,
                'template_id' => $template?->id,
            ],
        ];

        foreach ($displays as $displayData) {
            Display::create($displayData);
        }
    }
}
