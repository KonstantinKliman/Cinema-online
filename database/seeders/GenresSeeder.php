<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenresSeeder extends Seeder
{

    private $genres = [
        ['action', 'Action-packed movies with dynamic and thrilling scenes where protagonists face dangers and fight for survival.'],
        ['adventure', 'Guiding stories of extraordinary adventures and discoveries, where characters explore new worlds and overcome challenges.'],
        ['animation', 'Captivating animated works that bring characters to life, creating amazing worlds full of fantasy and magic.'],
        ['comedy', 'Funny and entertaining films designed to evoke laughter and uplift the audience`s mood.'],
        ['crime', 'Mysterious tales of crimes, investigations, and suspenseful twists in the world of criminal activities.'],
        ['drama', 'Deep and touching films focusing on the emotional experiences of characters and complex moments in life.'],
        ['fantasy', 'Magical and wondrous realms filled with enchantment, fantastical creatures, and thrilling adventures.'],
        ['horror', 'Atmospheric and chilling films that build tension and terrify the audience.'],
        ['mystery', 'Intriguing and mysterious films where characters confront unsolved mysteries and puzzles.'],
        ['romance', 'Exciting stories of love and relationships, accentuated by emotions and passion.'],
        ['science fiction', 'Engaging films based on scientific ideas and technological fantasies, portraying the future and unexplored worlds.'],
        ['thriller', 'Tense and gripping films that create a sense of uncertainty and anticipation.'],
        ['war', 'Powerful stories of wartime actions, heroism, and the impact of war on the lives of characters.'],
        ['western', 'Cinematic works set in the Wild West, where heroes fight for justice and survival.'],
        ['musical', 'Lively and musical films where the plot unfolds through songs and musical numbers.'],
        ['biography', 'Stories about real people, depicting their lives, achievements, and impact on the world.'],
        ['documentary', 'Films based on real events and facts, providing viewers with information and knowledge.'],
        ['family', 'Family-friendly films suitable for all ages, fostering a friendly atmosphere.'],
        ['history', 'Films that explore and depict historical events, periods, and characters.'],
        ['sport', 'Energetic and inspiring films centered around sports, showcasing the dedication, competition, and triumphs of athletes. These movies often capture the essence of teamwork, determination, and the pursuit of excellence on the playing field.'],
    ];

    public function run(): void
    {
        foreach ($this->genres as $genre) {
            Genre::create(['name' => $genre[0], 'description' => $genre[1]]);
        };
    }
}
