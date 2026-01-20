<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Url>
 */
class UrlFactory extends Factory
{
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'long_url' => $this->faker->url(),
            'url_id' => Str::random(6),
            'uid' => (string) Str::ulid(),
            'description' => $this->faker->sentence(),
            'click_count' => $this->faker->numberBetween(0, 1000),
            'is_enabled' => $this->faker->boolean(90), // 90% chance of being enabled
            'expires_at' => $this->faker->optional(0.2)->dateTimeBetween('+1 month', '+1 year'), // 20% chance of having an expiry date
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
