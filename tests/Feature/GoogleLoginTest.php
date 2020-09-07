<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\User;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        $this->user = Mockery::mock('Laravel\Socialite\One\User');
        $this->user
            ->shouldReceive('getId')
            ->andReturn(uniqid())
            ->shouldReceive('getName')
            ->andReturn('test')
            ->shouldReceive('getAvatar')
            ->andReturn('https://api.adorable.io/avatars/285/abott@adorable.png');

        $this->provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $this->provider->shouldReceive('user')->andReturn($this->user);
    }

    public static function tearDownAfterClass(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    /**
     * @test
     */
    public function Googleの認証画面を表示できる()
    {
        $response = $this->get(route('googleLogin'));
        $response->assertStatus(302);

        $domain = parse_url($response->headers->get('location'));
        $this->assertEquals('accounts.google.com', $domain['host']);
    }

    /**
     * @test
     */
    public function Googleアカウントでユーザー登録できる()
    {
        Socialite::shouldReceive('driver')->with('google')->andReturn($this->provider);

        $this->get(route('googleCallBack'))
            ->assertStatus(302)
            ->assertRedirect(route('home'));
        
        $this->assertDatabaseHas('users', [
            'uid' => $this->user->getId(),
            'name' => $this->user->getName(),
            'avatar' => $this->user->getAvatar()
        ]);

        $user = User::first();

        $this->assertDatabaseHas('performances', [
            'user_id' => $user->id,
        ]);

        $this->assertAuthenticated();
    }
}
