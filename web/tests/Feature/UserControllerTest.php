<?php

namespace Tests\Feature;

use \App\Models\User as User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_contact_has_name()
    {
        $user = User::factory()->create();
        $name = $user->name;
        $this->assertNotNull($name);
    }

    public function test_if_contact_has_lastname()
    {
        $user = User::factory()->create();
        $lastname = $user->lastname;
        $this->assertNotNull($lastname);
    }

    public function test_if_contact_has_email()
    {
        $user = User::factory()->create();
        $email = $user->email;
        $this->assertNotNull($email);
    }
}
