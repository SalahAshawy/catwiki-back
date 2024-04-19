<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class FetchCatBreeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-cat-breeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
  
    {
        
            $client = new Client();
            $response = $client->get('https://api.thecatapi.com/v1/breeds?limit=60');
            $breeds = json_decode($response->getBody(), true);
    
            foreach ($breeds as $breed) {
                DB::table('cat_breeds')->insert([
                    'id' => $breed['id'],
                    'name' => $breed['name'],
                    'description' => $breed['description'],
                    'temperament' => $breed['temperament'],
                    'origin' => $breed['origin'],
                    'life_span' => $breed['life_span'],
                    'adaptability' => $breed['adaptability'],
                    'affection_level' => $breed['affection_level'],
                    'child_friendly' => $breed['child_friendly'],
                    'grooming' => $breed['grooming'],
                    'intelligence' => $breed['intelligence'],
                    'health_issues' => $breed['health_issues'],
                    'social_needs' => $breed['social_needs'],
                    'stranger_friendly' => $breed['stranger_friendly'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
        }
    
} 
