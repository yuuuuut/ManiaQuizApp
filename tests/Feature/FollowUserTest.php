<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;
use Auth;

use App\Models\FollowUser;
use App\Models\User;

class FollowUserTest extends TestCase
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

        Socialite::shouldReceive('driver')->with('google')->andReturn($this->provider);

        $this->get(route('googleCallBack'))
            ->assertStatus(302)
            ->assertRedirect(route('quiz.index'));
    }

    public static function tearDownAfterClass(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    /**
     * @test
     */
    public function Userのフォローができる()
    {
        $user = factory(User::class)->create();

        $response = $this->post(route('user.follow', $user->id));
        $response->assertStatus(302)
                ->assertRedirect('/');

        $this->assertDatabaseHas('follow_users', [
            'user_id' => Auth::id(),
            'follow_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function Userのアンフォローができる()
    {
        $this->Userのフォローができる();

        $user = FollowUser::first();

        $response = $this->delete(route('user.unfollow', $user->follow_id));
        $response->assertStatus(302)
                ->assertRedirect('/');

        $this->assertEquals(0, FollowUser::count());
    }
}
