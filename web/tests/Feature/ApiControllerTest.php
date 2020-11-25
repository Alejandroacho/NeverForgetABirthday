<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use \App\Models\User as User;
use \App\Models\Contact as Contact;
use Tests\TestCase;
use App\Alarm;

class AlarmControllerTest extends TestCase
{
    use RefreshDatabase;

//+++++++++++++++++++++++++++++++++++++++++++ API | NOT LOGGED IN TEST++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function test_if_api_index_dont_returns_json_if_not_logged_in()
    {
        $response = $this->json('GET', '/api/contacts');

        $response->assertJsonMissing([
            '*' => ['id', 'name', 'email', 'message', 'birthday']
        ]);
        $response->assertStatus(401);
    }


    public function test_if_api_dont_stores_if_not_logged_in()
    {
        $response = $this->json('POST', '/api/contacts', [[
            'name'=>'Alejandra',
            'email'=>'a@a.com',
            'user_id'=>'1',
            'birthday'=>'1995/10/10',
            'message'=> 'Felicidades' ]]);

        $response->assertJsonMissing([
            '*' => ['id', 'name', 'email', 'message', 'birthday']
        ]);
        $this->assertDatabaseMissing('contacts',['tittle'=>'Alejandra']);
        $response->assertStatus(401);
    }

    public function test_if_api_dont_shows_if_not_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->json('GET', "/api/alarm/$contact->id");

        $response->assertJsonMissing([
            '*'=>['id', 'name', 'email', 'message', 'birthday']
        ]);
        $response->assertJsonMissing(['name'=>$contact->name]);
        $response->assertStatus(404);
    }

    public function test_if_api_doesnt_updates_if_not_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->json('PATCH', "/api/alarm/$contact->id", [
            'name'=>'Alejandra',
            'email'=>'a@a.com',
            'user_id'=>'1']);

        $this->assertDatabaseHas('contacts',['name'=>"$contact->name"]);
        $response->assertStatus(404);
    }

    public function test_if_api_doesnt_deletes_if_not_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->json('DELETE', "/api/contacts/$contact->id");

        $this->assertDatabaseHas('contacts',['name'=>"$contact->name"]);
        $response->assertStatus(401);
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++ API | LOGGED IN TEST++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function test_if_api_index_returns_json_if_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($user, 'api')->json('GET', '/api/contacts');

        $response->assertJsonStructure([
            'data' => [
                '*'=>['id', 'name', 'email', 'message', 'birthday']
            ]
        ]);
        $this->assertDatabaseHas('contacts',['name'=>"$contact->name"]);
        $response->assertStatus(200);
    }

    public function test_if_api_shows_if_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($user, 'api')->json('GET', "/api/contacts/$contact->id");
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'message', 'birthday']
        ]);
        $response->assertStatus(200);
    }

    public function test_if_api_create_contact_if_logged_in()
    {
        $user =User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/contacts', [
            'name'=>'Alejandra',
            'message'=>'Felicidades',
            'user_id'=>'1',
            'email'=>'a@a.com',
            'birthday'=>'2020-08-15',
            ]);

        $this->assertDatabaseHas('contacts',['name'=>"Alejandra"]);
        $response->assertStatus(200);
    }

    public function test_if_api_updates_if_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($user, 'api')->json('PUT', "/api/contacts/$contact->id", [
            'name'=>'Alejandra',
            'message'=>'Felicidades',
            'user_id'=>'1',
            'email'=>'a@a.com',
            'birthday'=>'2020-08-15'
        ]);
        $this->assertDatabaseHas('contacts',['name'=>'Alejandra']);
        $response->assertStatus(200);
    }

    public function test_if_api_deletes_if_logged_in()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($user, 'api')->json('DELETE', "/api/contacts/$contact->id");

        $this->assertDatabaseMissing('contacts',['tittle'=>"$contact->name"]);
        $response->assertStatus(200);
    }

    public function test_if_api_dont_stores_if_logged_in_and_form_not_correctly_filled()
    {
        $user =User::factory()->create();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/contacts', [
            'name'=>'Alejandra',
            'message'=> null,
            'user_id'=>'1',
            'email'=>'a@a.com',
            'birthday'=>'2020-08-15'
        ]);

        $this->assertDatabaseMissing('contacts',['name'=>'Alejandra']);
        $response->assertStatus(404);
    }

    public function test_if_api_doesnt_updates_if_logged_in_but_form_not_correctly_filled()
    {
        $user =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($user, 'api')->json('PATCH', "/api/contacts/$contact->id", [
            'name'=>'Alejandra',
            'message'=> null,
            'user_id'=>'1',
            'email'=>'a@a.com',
            'birthday'=>'2020-08-15'
        ]);

        $this->assertDatabaseMissing('contacts',['email'=>'a@a.com']);
        $response->assertStatus(404);
    }

    //+++++++++++++++++++++++++++++++++++++++++++++ API | OTHER USER ++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function test_if_api_doesnt_show_if_logged_in_with_other_user()
    {
        $user =User::factory()->create();
        $userTwo =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($userTwo, 'api')->json('GET', 'api/contacts/1');

        $response->assertStatus(404);
    }

    public function test_if_api_doesnt_deletes_if_logged_in_with_other_user()
    {
        $user =User::factory()->create();
        $userTwo =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($userTwo, 'api')->json('DELETE', 'api/contacts/1');

        $response->assertStatus(404);
        $this->assertDatabaseHas('contacts',['id'=>"$contact->id"]);
    }

    public function test_if_api_doesnt_updates_if_logged_in_with_other_user()
    {
        $user =User::factory()->create();
        $userTwo =User::factory()->create();
        $contact = Contact::factory()->create(['user_id'=>'1']);

        $response = $this->actingAs($userTwo, 'api')->json('PATCH', "/api/contacts/$contact->id", [
            'name'=>'Alejandra',
            'message'=>'Felicidades',
            'user_id'=>'1',
            'email'=>'a@a.com',
            'birthday'=>'2020-08-15'
        ]);

        $response->assertStatus(404);
        $this->assertDatabaseHas('contacts',['id'=>"$contact->id"]);
        $this->assertDatabaseMissing('contacts',['tittle'=>"Alejandra"]);
    }
}
