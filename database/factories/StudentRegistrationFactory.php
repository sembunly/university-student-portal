<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\StudentRegistration;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentRegistration>
 */
class StudentRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => fake()->unique()->numerify('########'),
            'name_km' => fake()->name(),
            'name_en' => fake()->name(),
            'date_of_birth' => fake()->dateTimeBetween('-30 years', '-15 years'),
            'gender' => fake()->randomElement(['ប្រុស', 'ស្រី']),
            'nationality' => 'ខ្មែរ',
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'current_province_id' => Province::factory(),
            'current_district_id' => District::factory(),
            'current_commune_id' => Commune::factory(),
            'current_village_id' => Village::factory(),
            'current_house' => fake()->buildingNumber(),
            'current_street' => fake()->streetName(),
            'permanent_province_id' => Province::factory(),
            'permanent_district_id' => District::factory(),
            'permanent_commune_id' => Commune::factory(),
            'permanent_village_id' => Village::factory(),
            'permanent_house' => fake()->buildingNumber(),
            'permanent_street' => fake()->streetName(),
            'father_name' => fake()->name('male'),
            'father_occupation' => fake()->jobTitle(),
            'father_phone' => fake()->phoneNumber(),
            'mother_name' => fake()->name('female'),
            'mother_occupation' => fake()->jobTitle(),
            'mother_phone' => fake()->phoneNumber(),
            'emergency_name' => fake()->name(),
            'emergency_phone' => fake()->phoneNumber(),
            'high_school' => fake()->company().' High School',
            'graduation_year' => fake()->numberBetween(2015, (int) date('Y')),
            'education_province_id' => Province::factory(),
            'certificate_path' => null,
        ];
    }
}
