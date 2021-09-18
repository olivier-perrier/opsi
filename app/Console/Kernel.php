<?php

namespace App\Console;

use App\Models\Data;
use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Carbon\Carbon;
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


            $url = "https://go.eu1.cloud.cobundu.com/rest/v2/locations?limit=1000";
            $response = Http::withToken($accessToken)->get($url);
            // echo 'starting\n';

            echo 'total location items ' . $response->json()['total'] . " \n";
            echo 'locations received (limit) ' . count($response->json()['items']) . "\n";

            $locationList = [];

            foreach ($response->json()['items'] as $location) {

                array_push($locationList, $location['id']);

                // $post = Post::where('name', $location['id'])->where('post_type_id', $postTypeId)->where('user_id', $userId)->firstOr(function () use ($location, $userId, $fieldId) {

                //     echo 'createPost ';
                //     $postCreated = Post::create(['name' => $location['id'], 'post_type_id' => 2, 'user_id' => $userId]);

                //     foreach ($postCreated->postType->fields as $field) {
                //         echo 'createData ';
                //         Data::create(['field_id' => $field->id, 'post_id' => $postCreated->id]);
                //     }

                //     return $postCreated;
                // });

                // echo $post->id . " ";

            }

            /* update Occupancy value */
            $url = "https://go.eu1.cloud.cobundu.com/rest/v2/sensoring/locationvalues/get";
            $responseLocationValue = Http::withToken($accessToken)->withBody(json_encode($locationList), 'application/json')->post($url);

            echo 'call ' . count($locationList) . ' ';

            if ($responseLocationValue->successful()) {

                echo 'successful ';

                echo 'location values received ' . count($responseLocationValue->json()) . "\n";

                foreach ($responseLocationValue->json() as $locationValue) {

                    // print_r( $locationValue['locationId']);

                    // $post = Post::where('name', $locationValue['locationId'])->first();
                    $post = Post::where('name', $locationValue['locationId'])->where('post_type_id', $postTypeId)->where('user_id', $userId)->firstOr(function () use ($locationValue, $userId, $fieldId) {

                        echo 'Post created ';
                        $postCreated = Post::create(['name' => $locationValue['locationId'], 'post_type_id' => 2, 'user_id' => $userId]);

                        foreach ($postCreated->postType->fields as $field) {
                            // echo 'createData ';
                            Data::create(['field_id' => $field->id, 'post_id' => $postCreated->id]);
                        }

                        return $postCreated;
                    });

                    echo $post->id . " ";


                    // Add the Data and Historicals
                    $data = Data::updateOrCreate(['field_id' => 1, 'post_id' => $post->id], ['value' => $locationValue['occupancy']]);

                    if($data){
                        $data->historicals()->create(['value' => $locationValue['occupancy'], 'timestamp' => Carbon::now()]);
                    }else{
                        echo 'no data found';
                    }


                    // echo "post " . $post->id . " updated ";
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
