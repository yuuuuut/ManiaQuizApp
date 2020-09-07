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
        factory(Quiz::class)->create();
        $quiz = Quiz::first();
        $user = User::first();

        $response = $this->get("/quiz/$quiz->id");
        $response->assertStatus(200);

        $data = [
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
        ];

        $response = $this->post(route('answer.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertEquals(1, Answer::count());
        $this->assertDatabaseHas('answers', [
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
            'hit'  => '0',
        ]);

        $this->assertDatabaseHas('performances', [
            'user_id' => $user->id,
            'number_of_answers' => 1,
        ]);
    }

    /**
     * @test
     */
    public function Answerをupdateできる()
    {
        $this->Answerの作成ができる();

        $answer = Answer::first();
        $quiz = Quiz::first();
        $user = User::first();

        $this->assertDatabaseHas('quizzes', [
            'user_id' => $quiz->user_id,
            'content' => $quiz->content,
            'level'   => $quiz->level,
            'finish'  => '0',
        ]);

        $response = $this->post(route('answer.update', $answer->id));
        $response->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertDatabaseHas('answers', [
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
            'hit'  => '1',
        ]);

        $this->assertDatabaseHas('quizzes', [
            'user_id' => $quiz->user_id,
            'content' => $quiz->content,
            'level'   => $quiz->level,
            'finish'  => '1',
        ]);

        $this->assertDatabaseHas('performances', [
            'user_id' => $user->id,
            'number_of_correct_answers' => 1,
        ]);
    }
}
