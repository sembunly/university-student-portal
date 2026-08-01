<?php

namespace Tests\Feature\Api\V1;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\StudentAccount;
use App\Models\StudentApiToken;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_register_and_use_bearer_token(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'phone' => '+855 12 345 678',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'device_name' => 'Flutter test',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.account.phone', '012345678')
            ->assertJsonPath('data.account.profile_completed', false);

        $token = $response->json('data.token');

        $this->withToken($token)
            ->getJson('/api/v1/auth/me')
            ->assertOk()
            ->assertJsonPath('data.phone', '012345678');
    }

    public function test_student_can_login_and_logout(): void
    {
        StudentAccount::query()->create([
            'student_id' => '0001',
            'phone' => '012345678',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'login' => '0001',
            'password' => 'password123',
        ])->assertOk();

        $token = $response->json('data.token');

        $this->withToken($token)->postJson('/api/v1/auth/logout')->assertOk();
        $this->withToken($token)->getJson('/api/v1/auth/me')->assertUnauthorized();
    }

    public function test_protected_routes_require_a_token(): void
    {
        $this->getJson('/api/v1/profile')->assertUnauthorized();
    }

    public function test_student_can_save_and_read_profile(): void
    {
        $account = StudentAccount::query()->create([
            'phone' => '012345678',
            'password' => 'password123',
        ]);
        $plainToken = 'test-token';
        StudentApiToken::query()->create([
            'student_account_id' => $account->getKey(),
            'name' => 'test',
            'token_hash' => hash('sha256', $plainToken),
        ]);

        $province = Province::factory()->create();
        $district = District::factory()->create(['province_id' => $province->getKey()]);
        $commune = Commune::factory()->create(['district_id' => $district->getKey()]);
        $village = Village::factory()->create(['commune_id' => $commune->getKey()]);

        $payload = [
            'name_km' => 'សុខ ដារ៉ា',
            'name_en' => 'Sok Dara',
            'gender' => 'ប្រុស',
            'emergency_name' => 'Sok Mom',
            'emergency_phone' => '098765432',
            'current_province_id' => $province->getKey(),
            'current_district_id' => $district->getKey(),
            'current_commune_id' => $commune->getKey(),
            'current_village_id' => $village->getKey(),
            'permanent_province_id' => $province->getKey(),
            'permanent_district_id' => $district->getKey(),
            'permanent_commune_id' => $commune->getKey(),
            'permanent_village_id' => $village->getKey(),
        ];

        $this->withToken($plainToken)
            ->postJson('/api/v1/profile', $payload)
            ->assertOk()
            ->assertJsonPath('data.account.student_id', '0001')
            ->assertJsonPath('data.profile.name_en', 'Sok Dara')
            ->assertJsonPath('data.profile.locations.current.province.id', $province->getKey());

        $this->withToken($plainToken)
            ->getJson('/api/v1/profile')
            ->assertOk()
            ->assertJsonPath('data.profile.student_id', '0001');

        $this->withToken($plainToken)
            ->getJson('/api/v1/addresses/provinces')
            ->assertOk()
            ->assertJsonPath('data.0.id', $province->getKey());
    }
}
