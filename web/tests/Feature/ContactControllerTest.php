<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_contact_has_user_associated()
    {
        $users = \App\Models\User::factory(10)->create();
        $contact = \App\Models\Contact::factory()->create();
        $user_id = $contact->user_id;
        $this->assertNotNull($user_id);
    }
}
