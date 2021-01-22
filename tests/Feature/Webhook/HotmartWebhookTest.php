<?php

namespace Tests\Feature\Webhook;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotmartWebhookTest extends TestCase
{
    protected $endpoint = '/webhook/hotmart';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_forbidden()
    {
        $response = $this->postJson($this->endpoint, [
            'hottok' => 'sdfdsfs'
        ]);

        $response->assertStatus(403);
    }

    public function test_request_subscription()
    {
        $response = $this->postJson($this->endpoint, [
            'name_subscription_plan' => 'value',
            'hottok' => config('hotmart.hottok')
        ]);

        $response->assertStatus(200);
    }

    public function test_course_not_found()
    {
        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            'prod' => 'sdfdsfsd'
        ]);

        $response->assertStatus(404);
    }

    public function test_enrollment_and_create_new_user()
    {
        $course = Course::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => "Carlos Teste",
            "email" => "email@teste.com",
            "payment_type" => "hotmart",
            "status" => "approved"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success',
                    ]);
    }

    public function test_enrollment_and__user_exists()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => $user->name,
            "email" => $user->email,
            "payment_type" => "hotmart",
            "status" => "approved"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success',
                    ]);
    }

    public function test_user_not_exists_and_status_chargeback()
    {
        $course = Course::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => "Carlos Teste",
            "email" => "carlos@teste.com",
            "payment_type" => "hotmart",
            "status" => "chargeback"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'User Not Exists And Status: chargeback',
                    ]);
    }

    public function test_user_not_exists_and_status_approved()
    {
        $course = Course::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => "Carlos Teste",
            "email" => "carlosnew@teste.com",
            "payment_type" => "hotmart",
            "status" => "approved"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success',
                    ]);
    }

    public function test_user_exists_and_status_aprroved()
    {
        $course = Course::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => "Carlos Teste",
            "email" => "carlos@teste.com",
            "payment_type" => "hotmart",
            "status" => "approved"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success',
                    ]);
    }

    public function test_user_exists_and_status_dispute()
    {
        $course = Course::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => "Carlos Teste",
            "email" => "carlos@teste.com",
            "payment_type" => "hotmart",
            "status" => "dispute"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success - User Removed',
                    ]);
    }

    public function test_user_exists_and_status_chargeback()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'hottok' => config('hotmart.hottok'),
            "prod" => $course->identificador_hotmart,
            "name" => $user->name,
            "email" => $user->email,
            "payment_type" => "hotmart",
            "status" => "chargeback"
        ]);

        $response->assertStatus(200)
                    ->assertJson([
                        'message' => 'Success - User Removed',
                    ]);
    }
}
