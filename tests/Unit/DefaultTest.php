<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DefaultTest extends TestCase
{
    public function test_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_github_login_link()
    {
        $response = $this->get('/login');
        $response->assertSeeText('Login with GitHub');
        $response->assertStatus(200);
    }
}
