<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\User;
use App\Models\Quiz;

class QuizRequestTest extends TestCase
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
    public function contentが空の場合作成に失敗する()
    {
        $data = [
            'content' => ''
        ];
        $response = $this->post(route('quiz.store'), $data);
        $response->assertSessionHasErrors(['content' => '問題文 は必須です']);
        $this->assertEquals(0, Quiz::count());
    }

    /**
     * @test
     */
    public function contentが200文字以上の場合作成に失敗する()
    {
        $data = [
            'content' => Str::random(201)
        ];
        $response = $this->post(route('quiz.store'), $data);
        $response->assertSessionHasErrors(['content' => '問題文 は 200 文字以下のみ有効です']);
        $this->assertEquals(0, Quiz::count());
    }

    /**
     * @test
     */
    public function levelが0の場合作成に失敗する()
    {
        $data = [
            'level' => 0
        ];
        $response = $this->post(route('quiz.store'), $data);
        $response->assertSessionHasErrors(['level' => '難易度 は 1 ～ 5 までの数値まで有効です']);
        $this->assertEquals(0, Quiz::count());
    }

    /**
     * @test
     */
    public function levelが6の場合作成に失敗する()
    {
        $data = [
            'level' => 6
        ];
        $response = $this->post(route('quiz.store'), $data);
        $response->assertSessionHasErrors(['level' => '難易度 は 1 ～ 5 までの数値まで有効です']);
        $this->assertEquals(0, Quiz::count());
    }
}
