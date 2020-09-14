<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;

use App\Models\Category;

class CategoryTest extends TestCase
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
    public function Indexページにアクセスできる()
    {
        $response = $this->get(route('category.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Showページにアクセスできる()
    {
        $category = factory(Category::class)->create();

        $response = $this->get(route('category.show', $category->id));
        $response->assertStatus(200);
    }
}
