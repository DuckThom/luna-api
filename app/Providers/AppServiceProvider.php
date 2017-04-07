<?php

namespace App\Providers;

use GuzzleHttp\Client;
use App\Services\LastFm;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('lastfm', function () {
            $client = new Client([
                'base_uri' => 'https://ws.audioscrobbler.com/'
            ]);

            return new LastFm($client);
        });

        if (app()->environment('local')) {
            //
        }
    }
}
