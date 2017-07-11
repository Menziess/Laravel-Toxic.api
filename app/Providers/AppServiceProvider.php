<?php

namespace App\Providers;

use App\User;
use App\Post;
use App\Topic;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::creating(function ($user) {
            $user->makeSlug();
            $user->api_token = str_random(60);
        });

        User::deleting(function ($user) {
            $user->deletePersonalData();
        });
        
        Post::creating(function ($post) {
            
            // Create slug, then check if a topic exists with that slug
            $post->makeSlug();
            $topic = Topic::firstOrNew(['slug' => $post->slug]);
            $topic->subject = $post->subject;
            
            // If not persisted yet, assign user owner
            if ($topic->posts->count() < 1) {
                $topic->user()->associate($post->user)->save();
            }

            // Associate topic
            $post->topic()->associate($topic);
        });

        Post::deleting(function ($post) {
            $post->deletePersonalData();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
