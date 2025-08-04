<?php

namespace Database\Seeders;

use App\Models\IptvChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IptvChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = [
            [
                'channel_number' => 101,
                'channel_name' => 'CNN',
                'protocol' => 'http',
                'stream_address' => 'http://192.168.1.101:8080/cnn/stream',
                'head_end_assignment' => 'Head-End A',
                'status' => 'active',
            ],
            [
                'channel_number' => 102,
                'channel_name' => 'ESPN',
                'protocol' => 'http',
                'stream_address' => 'http://192.168.1.102:8080/espn/stream',
                'head_end_assignment' => 'Head-End B',
                'status' => 'active',
            ],
            [
                'channel_number' => 103,
                'channel_name' => 'BBC One',
                'protocol' => 'https',
                'stream_address' => 'https://192.168.1.103:8080/bbc/stream',
                'head_end_assignment' => null,
                'status' => 'inactive',
            ],
            [
                'channel_number' => 104,
                'channel_name' => 'Fox News',
                'protocol' => 'http',
                'stream_address' => 'http://192.168.1.104:8080/fox/stream',
                'head_end_assignment' => 'Head-End A',
                'status' => 'active',
            ],
            [
                'channel_number' => 105,
                'channel_name' => 'Discovery',
                'protocol' => 'hls',
                'stream_address' => 'http://192.168.1.105:8080/discovery/playlist.m3u8',
                'head_end_assignment' => 'Head-End C',
                'status' => 'active',
            ],
            [
                'channel_number' => 106,
                'channel_name' => 'National Geographic',
                'protocol' => 'http',
                'stream_address' => 'http://192.168.1.106:8080/natgeo/stream',
                'head_end_assignment' => 'Head-End B',
                'status' => 'active',
            ],
            [
                'channel_number' => 107,
                'channel_name' => 'MTV',
                'protocol' => 'rtmp',
                'stream_address' => 'rtmp://192.168.1.107:1935/live/mtv',
                'head_end_assignment' => null,
                'status' => 'inactive',
            ],
            [
                'channel_number' => 108,
                'channel_name' => 'Comedy Central',
                'protocol' => 'http',
                'stream_address' => 'http://192.168.1.108:8080/comedy/stream',
                'head_end_assignment' => 'Head-End A',
                'status' => 'active',
            ],
        ];

        foreach ($channels as $channel) {
            IptvChannel::create($channel);
        }
    }
}
