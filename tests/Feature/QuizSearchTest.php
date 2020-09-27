<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\User;
use App\Models\Quiz;

class QuizSearchTest extends TestCase
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
    public function Quizのlevelで検索ができる()
    {
        $user = User::first();

        factory(Quiz::class)->create(['user_id' => $user->id ]);
        $quiz = Quiz::first();

        $response = $this->get("/quiz/search?level=1");
        $response->assertStatus(200)
                ->assertSee($user->name);
    }

    /**
     * @test
     */
    public function QuizのCategoryで検索ができる()
    {
        $user = User::first();

        factory(Quiz::class)->create(['user_id' => $user->id ]);
        $quiz = Quiz::first();

        $response = $this->get("/quiz/search?category_id=$quiz->category_id");
        $response->assertStatus(200)
                ->assertSee($user->name);
    }
}
