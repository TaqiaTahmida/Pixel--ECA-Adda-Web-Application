<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Eca;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->first();

        if (! $author) {
            $author = User::query()->create([
                'name' => 'Seed Author',
                'email' => 'seed.author@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        $ecas = Eca::query()->orderBy('id')->get();

        if ($ecas->isEmpty()) {
            return;
        }

        $ecas = $ecas->values();
        $blogPasts = [
            'Rebellion Club' => [
                'title' => 'Beyond the Canvas: The Spirit of the Rebellion Club',
                'excerpt' => 'Discover how our members are redefining modern art through music and street murals.',
                'content' => "The Rebellion Club isn't just about making noise; it's about making a statement.\n\nFrom the high-energy pulse of electronic music production to the large-scale storytelling of street art, we provide a space for students to experiment without boundaries. This month, we've been working on a collaborative mural that combines digital projection with traditional spray painting.\n\nJoin us every Friday to share your vision and collaborate with like-minded rebels.",
            ],
            'Painting Club' => [
                'title' => 'Mastering the Light: A Guide for Young Painters',
                'excerpt' => 'Learn the secrets of color theory and light from our Painting Club sessions.',
                'content' => "Painting is more than just putting brush to canvas; it's about seeing the world in a different light.\n\nIn our latest workshop, Elena Rossi demonstrated how to capture the golden hour using oil glazes. Whether you're a complete beginner or an experienced artist, our club offers the tools and community you need to grow. We're currently preparing for the annual regional showcase, and we want your work to be there!\n\nStop by the art studio on Tuesdays and Thursdays.",
            ],
            'Creative Writing Club' => [
                'title' => 'Finding Your Voice: From Blank Page to Masterpiece',
                'excerpt' => 'How the Creative Writing Club helps students overcome writer\'s block and finish their novels.',
                'content' => "Every great story starts with a single word. At the Creative Writing Club, we help you find that word and the thousand that follow it.\n\nOur weekly workshops cover everything from the 'Hero's Journey' to experimental poetry. We also hold 'blind peer review' sessions which have become a favorite among our members. This semester, we are focusing on world-building in speculative fiction.\n\nIf you have a story to tell, we have the community to help you tell it better.",
            ],
            'Foreign Language Club' => [
                'title' => 'Language as a Bridge: Connecting Cultures through Speech',
                'excerpt' => 'Why learning a new language is the ultimate way to broaden your horizons.',
                'content' => "Learning a language is like gaining a second soul. The Foreign Language Club is your passport to new worlds.\n\nThis week, our Spanish students hosted a 'Tapas & Talk' night where we practiced conversational skills while sampling authentic cuisine. Next week, we transition to our French cinema series. Language is more than grammar; it's the music of culture.\n\nCome learn with us and prepare for a truly global future.",
            ],
            'Karate & Martial Arts' => [
                'title' => 'The Way of the Fist: More Than Just Self-Defense',
                'excerpt' => 'How Karate builds mental resilience and physical discipline.',
                'content' => "Karate is a journey of self-improvement. It begins and ends with courtesy.\n\nIn our sessions, Sensei Hiroshi emphasizes the 'Do' (the way) - focusing on character development as much as the physical techniques. Students learn that strength without control is nothing. This semester, we are working on basic katas and Kumite fundamentals. It's an incredible way to relieve stress and build confidence.\n\nJoin us at the Dojo every morning for a fresh start to your day.",
            ],
            'Artificial Intelligence & ML' => [
                'title' => 'Decoding Tomorrow: Our First Steps into AI',
                'excerpt' => 'Exploring the algorithms that power our modern world.',
                'content' => "AI isn't magic; it's math and logic working together. In the AI & Machine Learning Club, we demystify the tech that's changing the world.\n\nWe recently completed a project building a simple image classifier. Understanding how neural networks 'see' is a mind-bending experience. We don't just code; we also debate the ethics of automation and how to ensure AI remains a force for good. No heavy math background required—just a curious mind.\n\nSee you in the tech lab on Wednesdays!",
            ],
            'Hifzul Quran' => [
                'title' => 'The Art of Memorization: Journeying Through the Quran',
                'excerpt' => 'Finding peace and spiritual growth through Hifz.',
                'content' => "Memorizing the Holy Quran is a life-long privilege and a journey of the heart.\n\nOur Hifz sessions are a sanctuary of peace in a busy school week. Ustaz Mawlana guides each student with patience, focusing on the beauty of Tajweed and the deeper meaning of the ayats. It's not just about speed; it's about connection and reflection. Many of our students have found that the discipline of Hifz improves their focus in all other studies as well.\n\nAll are welcome to join our daily morning and evening circles.",
            ],
            'Singing & Vocal Mastery' => [
                'title' => 'Harmonizing Hearts: The Joy of Vocal Expression',
                'excerpt' => 'Unlocking your true vocal potential through proper technique.',
                'content' => "Your voice is the most personal instrument you own. At the Singing Club, we help you polish it.\n\nSarah Nightingale's masterclasses have transformed how our members approach performance. We've been practicing breath-support exercises that make even the highest notes feel effortless. This month, we're preparing a collaborative medley of modern hits for the upcoming community fair. Whether you're a shy shower-singer or a stage-vet, there's a voice for you here.\n\nRehearsals are every Monday in the music room.",
            ],
            'Poetry & Spoken Word' => [
                'title' => 'Rhythms of the Soul: A Night of Spoken Word',
                'excerpt' => 'Translating raw emotion into powerful verse.',
                'content' => "Poetry is the shortest distance between two hearts.\n\nIn our latest 'Open Mic' workshop, the room was filled with the raw energy of original student work. Robert Frost Jr. taught us about the power of silence between lines. We explore free verse, sonnets, and the rhythmic intensity of slam poetry. It's a space to be vulnerable, to be loud, and to be heard. You don't need to be a 'writer'—you just need to feel.\n\nJoin our circle every Thursday evening.",
            ],
            'Introduction to C++' => [
                'title' => 'Building the Backbone: Why C++ Still Rules',
                'excerpt' => 'Mastering the language that powers games and systems.',
                'content' => "If you want to understand how a computer really works, learn C++. It's the language of performance.\n\nAlan Turing II kicked off our new series on memory management this week. It sounds scary, but when you finally understand how to control every bit of your program, it feels like having a superpower. We're currently building a simple command-line game engine from scratch. It's challenging, frustrating, and incredibly rewarding when it finally compiles.\n\nBootcamp continues every Tuesday in the computer lab.",
            ],
        ];

        foreach ($blogPasts as $ecaTitle => $data) {
            $eca = Eca::where('title', $ecaTitle)->first();
            if (!$eca) continue;

            if (Blog::query()->where('title', $data['title'])->exists()) {
                continue;
            }

            $blog = new Blog();
            $blog->title = $data['title'];
            $blog->excerpt = $data['excerpt'];
            $blog->content = $data['content'];
            $blog->thumbnail = $eca->thumbnail; // Use the ECA's image for the blog too
            $blog->author_id = $author->id;
            $blog->save();
        }
    }
}
