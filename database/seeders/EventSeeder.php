<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'image' => "assets/images/event-pic-1.png",
                'title' => "Buy your tickets for \nMiss Bohol 2024!",
                'description' => "Buy your tickets for Miss Bohol 2024! BUY YOUR TICKETS FOR MISS BOHOL 2024",
                'status' => "approved",
            ],
            // as we rally behind Miss Tubigon, Dianne Mariel Ybañez General Admission Ticket: Php 150.0 Get your tickets straight at the Municipal Tourism Office, Potohan, Tubigon, Bohol PAGEANT DATE: July 12, 2024 (7PM VENUE: Bohol Wisdom School Gy #MissBohol2024 #MissTubigon #AnyagSaTubigon #LGUTubigon #TourismTubigon #MarielYbañez",
            [
                'image' => "assets/images/event-pic-2.png",
                'title' => "TITLE 2",
                'description' => "description 2",
                'status' => "approved",
            ],
            [
                'image' => "assets/images/event-pic-3.png",
                'title' => "TITLE 3",
                'description' => "description 3",
                'status' => "pending",
            ],
        ];
        foreach($events as $event) {
            Event::create($event);
        }
    }
}
