<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\Category;
use App\Models\Answer;
use App\Models\User;
use App\Models\Quiz;

class QuizTest extends TestCase
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
    public function Indexページにアクセスできる()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Showページにアクセスできる()
    {
        $quiz = factory(Quiz::class)->create();

        $response = $this->get("/quiz/$quiz->id");
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function auth_answerアクセサが正しく機能する()
    {
        //Answerの作成
        $quiz = factory(Quiz::class)->create();

        $data = [
            'user_id' => \Auth::id(),
            'quiz_id' => $quiz->id,
            'content' => 'Test Content',
        ];

        $response = $this->post(route('answer.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect('/');
        
        $result = $quiz->auth_answer;
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function Createページにアクセスできる()
    {
        $response = $this->get("/quiz/create");
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Quizの作成ができる()
    {
        $category_id = factory(Category::class)->create()->id;
        $user = User::first();
        $data = [
            'user_id'     => $user->id,
            'category_id' => $category_id,
            'content'     => 'Test Content',
            'level'       => 3,
        ];

        $response = $this->post(route('quiz.store'), $data);
        $response->assertStatus(302)
            ->assertRedirect('/');
        
        $this->assertEquals(1, Quiz::count());
        $this->assertDatabaseHas('quizzes', [
            'user_id'     => $user->id,
            'category_id' => $category_id,
            'content'     => 'Test Content',
            'level'       => 3,
            'finish'      => '0',
        ]);

        $this->assertDatabaseHas('performances', [
            'user_id' => $user->id,
            'number_of_quizzes' => 1,
        ]);
    }
}
