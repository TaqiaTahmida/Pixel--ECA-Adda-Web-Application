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
        $desiredCount = 5;
        $titleSuffixes = [
            'Spotlight',
            'Getting Started',
            'Skills You Build',
            'Instructor Insights',
            'Why Students Join',
        ];

        for ($i = 0; $i < $desiredCount; $i++) {
            $eca = $ecas[$i % $ecas->count()];
            $suffix = $titleSuffixes[$i % count($titleSuffixes)];
            $title = $eca->title.' - '.$suffix;

            if (Blog::query()->where('title', $title)->exists()) {
                continue;
            }

            $excerptSource = $eca->short_description
                ?? $eca->full_description
                ?? ('Discover the '.$eca->title.' extracurricular activity and what makes it special.');

            $contentParts = array_filter([
                'This post highlights the '.$eca->title.' extracurricular activity.',
                $eca->category ? 'Category: '.$eca->category.'.' : null,
                $eca->level ? 'Level: '.$eca->level.'.' : null,
                $eca->instructor ? 'Instructor: '.$eca->instructor.'.' : null,
                $eca->full_description ?: $eca->short_description,
                'Join the club to build skills, meet peers, and work on real projects.',
            ]);

            $blog = new Blog();
            $blog->title = $title;
            $blog->excerpt = Str::limit($excerptSource, 150);
            $blog->content = implode("\n\n", $contentParts);
            $blog->thumbnail = null;
            $blog->author_id = $author->id;
            $blog->save();
        }
    }
}
