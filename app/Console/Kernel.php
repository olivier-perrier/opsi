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
        $schedule->call(function () {

            echo 'starting ';

            // Sur quel Post Type creer les données
            $postTypeId = 2;

            // Sur quel user créer les données
            $userId = 1;

            // Sur quel Field créer les données
            $fieldId = 2;

            $urlLogin = "https://go.eu1.cloud.cobundu.com/rest/v2/login";
            $responseLogin = Http::post($urlLogin, [
                "password" => 'iconics2021',
                "username" => 'bouygues.microsoft.iconics'
            ]);

            $accessToken = $responseLogin->json()['accessToken'];
            // echo $responseLogin->json()['accessToken'] . "\n";


            $url = "https://go.eu1.cloud.cobundu.com/rest/v2/sensoring/devices";
            $response = Http::withToken($accessToken)->get($url);
            // echo 'starting\n';

            echo count($response->json()) . "\n";

            foreach ($response->json() as $key => $APIsensor) {

                $post = Post::where('name', $APIsensor['name'])->where('post_type_id', $postTypeId)->where('user_id', $userId)->firstOr(function () use ($APIsensor, $userId, $fieldId) {

                    echo 'firstOr ';

                    // $postCreated = Post::firstOrCreate(['name' => $APIsensor['name'], 'post_type_id' => 2, 'user_id' => 1]);
                    $postCreated = Post::create(['name' => $APIsensor['name'], 'post_type_id' => 2, 'user_id' => $userId]);

                    foreach ($postCreated->postType->fields as $key => $field) {
                        echo 'createData ';
                        Data::create(['field_id' => $field->id, 'post_id' => $postCreated->id]);
                    }

                    echo 'endFirstOr ';

                    return $postCreated;

                });

                /* upate some values */
                // Data::updateOrCreate(['field_id' => $fieldId, 'post_id' => $postCreated->id], ['value' => $APIsensor['locationId']]);

                echo $post->id . " ";

                /* update Occupancy value */
                $url = "https://go.eu1.cloud.cobundu.com/rest/v2/sensoring/sensorvalues?devices=" . $APIsensor['id'] . "&from=latest";
                $responseSensorValue = Http::withToken($accessToken)->get($url);

                if (count($responseSensorValue->json())) {

                    $sensorValue = $responseSensorValue->json()[0]['value'];

                    // echo $sensorValue;
                    Data::updateOrCreate(['field_id' => 1, 'post_id' => $post->id], ['value' => $sensorValue]);

                    echo "updated ";
                }

            }


            echo 'finished ';
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
