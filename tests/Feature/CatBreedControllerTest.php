<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\CatBreed;
use App\Models\CatBreedsImage;

class CatBreedControllerTest extends TestCase
{
    use RefreshDatabase;
 

    public function setUp(): void
    {
        parent::setUp();

      
        $this->actingAs(User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'number'=>'12345678910',
            'role'=>'admin'
        ]));
    }
    /** @test */
    public function can_get_all_cat_breeds()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('api/cat-breeds');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'temperament',
                    'origin',
                    'life_span',
                    'adaptability',
                    'affection_level',
                    'child_friendly',
                    'grooming',
                    'intelligence',
                    'health_issues',
                    'social_needs',
                    'stranger_friendly',
                    'image',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    public function can_show_single_cat_breed()
    {
        $this->withoutExceptionHandling();

        $catBreed = CatBreed::factory()->create();

        $response = $this->get('api/cat-breeds/' . $catBreed->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $catBreed->id,
                'name' => $catBreed->name,
                // Add more assertions for other attributes as needed
            ]);
    }

    /** @test */
    public function can_update_cat_breed()
    {
        $this->withoutExceptionHandling();
    
        $catBreed = CatBreed::factory()->create();
    
        $updatedData = [
            'name' => 'Updated Cat Breed Name',
            'description' => 'Updated description',
            'temperament' => 'Updated temperament',
            'origin' => 'Updated origin',
            'life_span' => 'Updated life span',
            'adaptability' => 3,
            'affection_level' => 4,
            'child_friendly' => 3,
            'grooming' => 4,
            'intelligence' => 5,
            'health_issues' => 2,
            'social_needs' => 3,
            'stranger_friendly' => 2,
          
        ];
    
        $response = $this->put('/api/cat-breeds/' . $catBreed->id, $updatedData);
    
        $response->assertStatus(200)
            ->assertJson([
                'id' => $catBreed->id,
                'name' => 'Updated Cat Breed Name',
                'description' => 'Updated description',
                'temperament' => 'Updated temperament',
                'origin' => 'Updated origin',
                'life_span' => 'Updated life span',
                'adaptability' => 3,
                'affection_level' => 4,
                'child_friendly' => 3,
                'grooming' => 4,
                'intelligence' => 5,
                'health_issues' => 2,
                'social_needs' => 3,
                'stranger_friendly' => 2,
                // Add more assertions for other attributes as needed
            ]);
    
        $this->assertDatabaseHas('cat_breeds', $updatedData);
    }
    

    /** @test */
        public function can_delete_cat_breed()
        {
            $this->withoutExceptionHandling();

            $catBreed = CatBreed::factory()->create();

            $response = $this->delete('api/cat-breeds/' . $catBreed->id);

            $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Cat breed deleted',
                ]);

            
        }
    }
