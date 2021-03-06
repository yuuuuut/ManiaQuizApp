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
use App\Models\Performance;

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
            ->assertRedirect(route('quiz.index'));
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
        $users = User::all();
        foreach($users as $user) {
            $users[] = $user;
        }
        $user  = $users[0];
        $user2 = $users[1];

        factory(Quiz::class)->create(['user_id' => $user->id ]);
        $quiz = Quiz::first();

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

        $this->assertDatabaseHas('notifications', [
            'visiter_id' => $user->id,
            'visited_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'action' => 'AnswerStore'
        ]);
    }

    /**
     * @test
     */
    public function Answerをupdateできる()
    {
        // User取得
        $users = User::all();
        foreach($users as $user) {
            $users[] = $user;
        }
        $user  = $users[0];
        $user2 = $users[1];
        // Quiz作成・取得
        factory(Quiz::class)->create(['user_id' => $user->id ]);
        $quiz = Quiz::first();
        // $user2のPerformance作成
        factory(Performance::class)->create(['user_id' => $user2->id ]);
        // BestAnswerの用意・作成
        $data = [
            'user_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
        ];
        $response = $this->post(route('answer.store'), $data);
        $response->assertStatus(302)
                ->assertRedirect('/');
        // NoneBestAnswerの用意・作成
        $data = [
            'user_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
        ];
        $response = $this->post(route('answer.store'), $data);
        $response->assertStatus(302)
                ->assertRedirect('/');
        // Answerの取得
        $answer = Answer::first();
        // Answerのupdate
        $response = $this->post(route('answer.update', $answer->id));
        $response->assertStatus(302)
            ->assertRedirect('/');
        // DB状態確認
        $this->assertDatabaseHas('answers', [
            'user_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
            'hit'  => '1',
        ]);

        $this->assertDatabaseHas('performances', [
            'user_id' => $user2->id,
            'number_of_correct_answers' => 1,
        ]);

        $this->assertDatabaseHas('notifications', [
            'visiter_id' => $user->id,
            'visited_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'action' => 'BestAnswer'
        ]);

        $this->assertDatabaseHas('notifications', [
            'visiter_id' => $user->id,
            'visited_id' => $user2->id,
            'quiz_id' => $quiz->id,
            'action' => 'NoneBestAnswer'
        ]);
    }
}
