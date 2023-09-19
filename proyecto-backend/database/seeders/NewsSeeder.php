<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::findOrFail(1);
        $categories = Category::all();

        foreach ($categories as $category) {
            if ($category->name == 'Actualidad') {
                $this->createCurrentNews($category, $user);
            } else {
                for ($i = 1; $i <= 5; $i ++) {
                    $article = Article::factory()->create(['user_id' => $user->id]);
                    $article->categories()->attach($category);
                }
            }
        }
    }

    private function createCurrentNews($category, $user) {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.xataka.com/categoria/seleccion');
        $crawler->filter('.recent-abstract.abstract-article')->each(function ($node) use ($user, $category) {

            $title = $node->filter('.abstract-title a')->text();
            $description = $node->filter('.abstract-excerpt p')->text();
            $imageName = $node->filter('.abstract-figure .base-asset-image img')->attr('src');
            $url = $node->filter('.abstract-title a')->attr('href');
            $date = $node->filter('.abstract-date')->attr('datetime');
            $carbonDate = Carbon::createFromFormat('Y-m-d\TH:i:s\Z', $date);
            $formattedDate = $carbonDate->format('Y-m-d H:i:s');
            $article = Article::create(['user_id' => $user->id, 'title' => $title, 'description' => $description,
                'url' => $url, 'imageName' => $imageName, 'date' => $formattedDate]);
            $article->categories()->attach($category);
        });
    }
}
