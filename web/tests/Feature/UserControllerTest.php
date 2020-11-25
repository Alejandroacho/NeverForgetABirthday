<?php

namespace Tests\Feature;

use \App\Models\User as User;
use \App\Models\Contact as Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_anyone_can_acces_index_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_if_anyone_can_acces_register_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_if_anyone_can_acces_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_if_index_view_has_minimum_expected()
    {
        $response = $this->get('/');
        $response->assertSee('Never Forget A Birthday Anymore!');
        $response->assertSee('Login');
        $response->assertSee('Register');
        $response->assertSee('START NOW');
        $response->assertSee('We will send him the letter you wrote at his birthday!');
    }

    public function test_if_login_view_has_minimum_expected()
    {
        $response = $this->get('/login');
        $response->assertSee('Never Forget A Birthday');
        $response->assertSee('Login');
        $response->assertSee('E-Mail Address');
        $response->assertSee('Password');
    }

    public function test_if_register_view_has_minimum_expected()
    {
        $response = $this->get('/register');
        $response->assertSee('Never Forget A Birthday');
        $response->assertSee('Register');
        $response->assertSee('Name');
        $response->assertSee('Lastname');
        $response->assertSee('E-Mail Address');
        $response->assertSee('Password');
        $response->assertSee('Confirm Password');
    }

    public function test_if_contact_has_user_associated()
    {
        User::factory(10)->create();
        $contact = Contact::factory()->create();
        $user_id = $contact->user_id;
        $this->assertNotNull($user_id);
    }
}
