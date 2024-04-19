<?php

namespace Database\Factories;

use App\Models\CatBreed;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatBreed>
 */
class CatBreedFactory extends Factory
{
    protected $model = CatBreed::class;
    public function definition(): array
    {
        return [
            'id'=>'sed',
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'temperament' => $this->faker->words(3, true),
            'origin' => $this->faker->country,
            'life_span' => $this->faker->randomNumber(2) . ' years',
            'adaptability' => $this->faker->numberBetween(1, 5),
            'affection_level' => $this->faker->numberBetween(1, 5),
            'child_friendly' => $this->faker->numberBetween(1, 5),
            'grooming' => $this->faker->numberBetween(1, 5),
            'intelligence' => $this->faker->numberBetween(1, 5),
            'health_issues' => $this->faker->numberBetween(1, 5),
            'social_needs' => $this->faker->numberBetween(1, 5),
            'stranger_friendly' => $this->faker->numberBetween(1, 5),
            'search_count' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
