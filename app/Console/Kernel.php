<?php

namespace App\Console;

use App\Models\Data;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            // dd('starting...');

            // Todo create a specific WS user et find it here
            $wsUser = User::first();

            $webServices = PostType::where('name', 'Webservice')->first()->posts()->get();
            foreach ($webServices as $webService) {


                $url = $webService->getDataForFieldName('Url')->value;
                echo 'url = ' . $url . "\n";

                $fieldOrigin = $webService->getDataForFieldName('FieldOrigin')->value;
                echo  '$fieldOrigin = ' . $fieldOrigin . "\n";


                $FieldDestination = $webService->getDataForFieldName('FieldDestination')->relatedField;
                echo  '$FieldDestination = ' . $FieldDestination . "\n";

                $posttype = $FieldDestination->posttype;
                echo  '$posttype = ' . $posttype . "\n";


                $response = Http::get($url);

                echo '$response->json[\'' . $fieldOrigin . '\'] = ' . $response->json()[$fieldOrigin] . "\n";

                $postCreated = Post::create(['name' => 'callws', 'posttype_id' => $posttype->id, 'user_id' => $wsUser->id]);

                $dataCreated = Data::create(['field_id' => $FieldDestination->id, 'post_id' => $postCreated->id, 'value' => $response->json()['title']]);


                echo 'createdPost = ' . $postCreated;
                // dd($response->json());
                // echo 'ws - ' . $webService;
            }

            // echo 'all ws - ' . $webServices;
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
