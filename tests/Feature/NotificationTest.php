<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\Notification;
use App\Models\Quiz;
use App\Models\User;

class NotificationTest extends TestCase
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
    public function indexページにアクセスできる()
    {
        $response = $this->get("/notification");
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function 通知が10件超えた場合古い1件を削除する()
    {
        $user = factory(User::class)->create();
        $quiz = factory(Quiz::class)->create(['user_id' => $user->id]);
        $auth = User::first();

        factory(Notification::class, 10)->create([
                            'visiter_id' => $user->id,
                            'visited_id' => $auth->id,
                            'quiz_id' => $quiz->id
                        ]);

        $this->assertEquals(10, Notification::count());

        $response = $this->get(route('notifi.index'));
        $response->assertStatus(200);

        $this->assertEquals(9, Notification::count());
    }

    /**
     * @test
     */
    public function 通知が10件以下の場合何もしない()
    {
        $this->通知が10件超えた場合古い1件を削除する();

        $response = $this->get(route('notifi.index'));
        $response->assertStatus(200);

        $this->assertEquals(9, Notification::count());
    }
}
