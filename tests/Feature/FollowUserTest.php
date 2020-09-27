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

        $response = $this->post("/users/$user->id/follow");

        $this->assertEquals(1, FollowUser::count());

        $this->assertDatabaseHas('follow_users', [
            'user_id' => Auth::id(),
            'follow_id' => $user->id,
        ]);

        $this->assertDatabaseHas('notifications', [
            'visiter_id' => Auth::id(),
            'visited_id' => $user->id,
            'action' => 'FollowUser',
        ]);

        return $user;
    }

    /**
     * @test
     */
    public function Userのアンフォローができる()
    {
        $user = $this->Userのフォローができる();

        $response = $this->post("/users/$user->id/unfollow");

        $this->assertEquals(0, FollowUser::count());
    }
}
