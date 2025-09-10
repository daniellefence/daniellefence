<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
   $questions = [
            [
                "question" => "What kind of maintenance does vinyl fencing require?",
                "answer" => "A vinyl / PVC fence and accessories requires virtually no maintenance. The high quality of Danielle Designer Series™, Country Estate™, Country Manor™, and G-Fence™ products are impervious to deterioration from moisture, temperature extremes, ultraviolet light exposure. and the wear and tear from time itself. You will never have to scrape or paint your vinyl fence, unlike wood, metal, aluminum, or imitation PVC fence. You will be able to enjoy your Danielle Fence vinyl fence from the very first day it is installed to years down the road. No traditional fence maintenance is required."
            ],
            [
                "question" => "How do I clean my vinyl/PVC fence?",
                "answer" => "In the event that your PVC fence grows mold, you can quickly and easily clean it off using a pressure washer. That is all that is needed to make your fence look new again!"
            ],
            [
                "question" => "Can my vinyl/PVC fence be recycled?",
                "answer" => "If the day comes when you no longer have a use for your  vinyl / PVC fence, then it can be dismantled and the materials can be safely recycled."
            ],
            [
                "question" => "Can more fence be added to my existing wood, vinyl, aluminum, or post & rail fence?",
                "answer" => "Every project is different but in most cases the answer is yes. It is common for fence and outdoor home improvement projects to be completed in phases, which means they are spread out over time. A new section of Danielle fence can be added to a previous project and when done, both the old and the new will blend perfectly."
            ],
            [
                "question" => "Will a quality wood, vinyl, aluminum, post & rail or EcoStone fence enhance my property value?",
                "answer" => "Yes, a beautiful fence around your property enhances its value in many ways. It may provide privacy to your backyard or prevent uninvited guests to your swimming pool. Maybe you simply want an attractive backdrop for your flower garden, or the ability to give your dog room to run and play without escaping. Adding a fence is a great way to get any of those tasks done, with flair. If you ever decide to sell your home, then your Danielle fence will add to the appeal of your listing because potential buyers will know that they won’t have to go through the time and expense of adding a fence themselves."
            ],
            [
                "question" => "Does Danielle Fence install vinyl or PVC fence in colors other than white, and can it be textured or have a wood-grain finish?",
                "answer" => "Danielle Fence styles are available in four colors: white, almond, adobe, and gray. These different color choices will make it easy to match a fence to your residence. All four colors can also be embossed or streaked, to add even more options for you."
            ],

            [
                "question" => "What is the required fence clearance for fire hydrants in Hillsborough, Pasco, Polk, and other counties in Florida?",
                "answer" => "All hydrants must have a 4′ rear clearance and a 7′ clearance on all other sides of the valve, including landscaping. Rear clearance means the side of the hydrant with no valve."
            ]
        ];

        foreach($questions as $q) {
            FAQ::create([
                'question'=>$q['question'],
                'answer'=>$q['answer'],
                'published'=>true
            ]);
        }
    }
}
