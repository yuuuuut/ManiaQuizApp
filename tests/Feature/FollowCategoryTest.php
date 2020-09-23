<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Socialite;
use Mockery;
use Auth;

use App\Models\FollowCategory;
use App\Models\Category;
use App\Models\User;

class FollowCategoryTest extends TestCase
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
    public function Categoryのフォローができる()
    {
        $category_id = factory(Category::class)->create()->id;

        $response = $this->post("/category/$category_id/follow");

        $this->assertEquals(1, FollowCategory::count());
        
        $this->assertDatabaseHas('follow_categories', [
            'user_id' => Auth::id(),
            'category_id' => $category_id,
        ]);
    }

    /**
     * @test
     */
    public function Categoryのアンフォローができる()
    {
        $this->Categoryのフォローができる();

        $category = Category::first();

        $response = $this->post("/category/$category->id/unfollow");

        $this->assertEquals(0, FollowCategory::count());
    }
}
