<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eca;

class EcaSeeder extends Seeder
{
    public function run(): void
    {
        $ecas = [
            [
                'title' => 'Rebellion Club',
                'category' => 'Music & Arts',
                'level' => 'All Levels',
                'instructor' => 'Alex Turner',
                'short_description' => 'Express yourself through modern music and unconventional arts.',
                'full_description' => 'The Rebellion Club is for those who dare to be different. We focus on modern music production, street art, and alternative forms of expression. Members collaborate on unique projects that challenge traditional artistic boundaries.',
                'thumbnail' => '/landing/images/clubs/club1.png',
            ],
            [
                'title' => 'Painting Club',
                'category' => 'Visual Arts',
                'level' => 'Beginner to Intermediate',
                'instructor' => 'Elena Rossi',
                'short_description' => 'Master the strokes of classical and contemporary painting.',
                'full_description' => 'Unleash your inner artist in our Painting Club. We explore various mediums including oil, watercolor, and acrylics. Weekly sessions include guided tutorials, free-painting hours, and guest lectures from local artists.',
                'thumbnail' => '/landing/images/clubs/club2.png',
            ],
            [
                'title' => 'Creative Writing Club',
                'category' => 'Literature',
                'level' => 'All Levels',
                'instructor' => 'Julian Barnes',
                'short_description' => 'Craft compelling stories, poetry, and scripts.',
                'full_description' => 'The Creative Writing Club provides a supportive environment for writers of all genres. We host workshops on character development, plot structure, and world-building. Join us to turn your ideas into literary masterpieces.',
                'thumbnail' => '/landing/images/clubs/club3.png',
            ],
            [
                'title' => 'Foreign Language Club',
                'category' => 'Linguistics',
                'level' => 'Introductory',
                'instructor' => 'Maria Gonzalez',
                'short_description' => 'Broaden your horizons by learning new languages and cultures.',
                'full_description' => 'Dive into the world of linguistics and multiculturalism. Our Foreign Language Club offers introductory courses in Spanish, French, and Japanese. We combine language lessons with cultural activities like food tasting and film screenings.',
                'thumbnail' => '/landing/images/clubs/club4.png',
            ],
            [
                'title' => 'Karate & Martial Arts',
                'category' => 'Sports',
                'level' => 'Beginner to Advanced',
                'instructor' => 'Sensei Hiroshi',
                'short_description' => 'Build discipline, strength, and self-defense skills.',
                'full_description' => 'Our Karate ECA teaches traditional Shotokan Karate. Students develop physical fitness, coordination, and mental discipline while learning vital self-defense techniques in a safe environment.',
                'thumbnail' => '/eca-images/karate.png',
            ],
            [
                'title' => 'Artificial Intelligence & ML',
                'category' => 'Technology',
                'level' => 'Intermediate',
                'instructor' => 'Dr. Chen',
                'short_description' => 'Introduction to neural networks, automation, and AI ethics.',
                'full_description' => 'Explore the future of tech. This club covers Python basics for AI, building simple machine learning models, and discussing the ethical implications of artificial intelligence in modern society.',
                'thumbnail' => '/eca-images/ai.webp',
            ],
            [
                'title' => 'Hifzul Quran',
                'category' => 'Religious Studies',
                'level' => 'All Levels',
                'instructor' => 'Ustaz Mawlana',
                'short_description' => 'Memorize and perfect your recitation of the Holy Quran.',
                'full_description' => 'A serene environment for students to memorize the Quran with proper Tajweed. Our experienced instructors provide personalized guidance for students at every stage of their Hifz journey.',
                'thumbnail' => '/eca-images/publicSpeaking.jpg', // Fallback image
            ],
            [
                'title' => 'Singing & Vocal Mastery',
                'category' => 'Music',
                'level' => 'Beginner to Intermediate',
                'instructor' => 'Sarah Nightingale',
                'short_description' => 'Find your voice and master vocal techniques.',
                'full_description' => 'From solo performance to choral harmony, this club helps you develop pitch, breath control, and stage presence. We cover multiple genres from classical to contemporary pop.',
                'thumbnail' => '/eca-images/singing.png',
            ],
            [
                'title' => 'Poetry & Spoken Word',
                'category' => 'Literature',
                'level' => 'All Levels',
                'instructor' => 'Robert Frost Jr.',
                'short_description' => 'Explore the power of words and emotional expression.',
                'full_description' => 'A workshop for aspiring poets. We study various poetic forms, write original pieces, and practice the art of spoken word performance in a supportive and creative atmosphere.',
                'thumbnail' => '/landing/images/clubs/club3.png', // Fallback to writing/club image
            ],
            [
                'title' => 'Introduction to C++',
                'category' => 'Computer Science',
                'level' => 'Beginner',
                'instructor' => 'Alan Turing II',
                'short_description' => 'Learn the foundations of efficient systems programming.',
                'full_description' => 'C++ is the backbone of high-performance software. This ECA teaches students logic, data structures, and memory management through practical coding challenges and game development basics.',
                'thumbnail' => '/eca-images/robotics.webp', // Fallback to tech image
            ],
        ];

        foreach ($ecas as $eca) {
            Eca::updateOrCreate(
                ['title' => $eca['title']],
                $eca
            );
        }
    }
}
?>