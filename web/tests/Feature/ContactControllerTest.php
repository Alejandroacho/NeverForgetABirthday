<?php

namespace Tests\Feature;

use \App\Models\User as User;
use \App\Models\Contact as Contact;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
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
//+++++++++++++++++++++++++++++++++++++++++++ LOGGED IN WITH TEST++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function test_user_logged_can_access_home()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/home');
        $this->assertEquals(200, $response->status());
    }

    public function test_user_logged_can_access_create_contact_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/contact/create');
        $this->assertEquals(200, $response->status());
    }

    public function test_user_logged_can_add_a_new_contact()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "1995/09/10",
            "user_id" => $user->id,
        ]);

        $this->assertDatabaseHas('contacts',[
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "1995/09/10",
            "user_id" => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }

    public function test_user_logged_can_access_edit_contact_page()
    {
        $user = User::factory()->create();
        $contact = new Contact;
            $contact->name = "Testing Contact";
            $contact->email = "testing@contact.com";
            $contact->message = "Testing text";
            $contact->birthday = "1995/10/09";
            $contact->user_id = $user->id;
            $contact->save();
        $response = $this->actingAs($user)->get("/contact/".$contact->id."/edit");
        $this->assertEquals(200, $response->status());
    }

    public function test_if_user_logged_can_update_a_contact()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "1995/09/10",
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($user)->patch('/contact/1', [
            "name" => "Testing Contact 2",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "1995/09/10",
            "user_id" => $user->id,
        ]);

        $this->assertDatabaseHas('contacts',[
            "name" => "Testing Contact 2",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "1995/09/10",
            "user_id" => $user->id,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');
    }

    public function test_user_logged_can_see_its_contact()
    {
        $user = User::factory()->create();
        $contact = new Contact;
            $contact->name = "Testing Contact";
            $contact->email = "testing@contact.com";
            $contact->message = "Testing text";
            $contact->birthday = "1995/09/10";
            $contact->user_id = $user->id;
            $contact->save();
        $response = $this->actingAs($user)->get("/contact/".$contact->id);
        $this->assertEquals(200, $response->status());
    }

    public function test_user_logged_can_delete_a_contact()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);
        $response = $this->actingAs($user)->delete("/contact/1");
        $this->assertDatabaseMissing('contacts',[
            "name" => "Testing Contact"
        ]);
        $this->assertEquals(302, $response->status());
    }
//+++++++++++++++++++++++++++++++++++++++++++ LOGGED IN WITH OTHER USER TEST++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function test_id_user_cannot_see_contact_from_other_user()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);
        $response = $this->actingAs($userTwo)->get("/contact/1");
        $response->assertViewIs('nopermission');
    }

    public function test_id_user_cannot_edit_contact_from_other_user()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);
        $response = $this->actingAs($userTwo)->get("/contact/1/edit");
        $response->assertViewIs('nopermission');
    }

    public function test_if_other_user_cannot_update_a_contact_from_other_user()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);

        $response = $this->actingAs($userTwo)->patch('/contact/1', [
            "name" => "Testing Contact 2",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);
        $response->assertViewIs('nopermission');
    }

    public function test_id_user_cannot_delete_contact_from_other_user()
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $this->actingAs($user)->post('/contact', [
            "name" => "Testing Contact",
            "email" => "testing@contact.com",
            "message" => "Testing text",
            "birthday" => "10/09/1995",
            "user_id" => $user->id,
        ]);
        $response = $this->actingAs($userTwo)->delete("/contact/1");
        $response->assertViewIs('nopermission');
    }

}
