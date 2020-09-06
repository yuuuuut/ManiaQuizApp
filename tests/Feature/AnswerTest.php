<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Answer;

class AnswerTest extends TestCase
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
            ->assertRedirect(route('home'));

        $this->u = User::first();
    }

    public static function tearDownAfterClass(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    /**
     * @test
     */
    public function Answerの作成ができる()
    {
        $quiz = factory(Quiz::class)->create();

        $response = $this->get("/quiz/$quiz->id");
        $response->assertStatus(200);

        $data = [
            'user_id' => $this->u->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
        ];

        $response = $this->post(route('answer.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertEquals(1, Answer::count());
        $this->assertDatabaseHas('answers', [
            'user_id' => $this->u->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
            'hit'  => '0',
        ]);
    }
}
