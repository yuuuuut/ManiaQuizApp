<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Category;

class QuizServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'quiz.search', function($view) {
                $categorys = Category::all();
                $category_list = array(" " => "選択してください");
        
                foreach ($categorys as $category) {
                    $category_list += array($category->id => $category->name);
                }

                $view->with('category_list', $category_list);
            }
        );

        View::composer(
            'quiz.search', function($view) {
                $level_list = array(
                    ' ' => '選択してください',
                    '1' => '★',
                    '2' => '★★',
                    '3' => '★★★',
                    '4' => '★★★★',
                    '5' => '★★★★★',
                );

                $view->with('level_list', $level_list);
            }
        );
    }
}
