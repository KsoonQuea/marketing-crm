<?php

namespace App\Notifications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscordLog
{
    public function __construct()
    {
        //
    }

    public static function returnLog($exception)
    {
        $webhook_url = config('logging.DISCORD_WEB_HOOK_URL','');
        if($webhook_url ){ // && config("app.env") !== "local"
            $content = date("d M Y h:i:s").' >>>>> line : '.$exception->getLine().' in file : '.$exception->getFile();
            return Http::post($webhook_url , [
                'content' => $content,
                'embeds' => [
                    [
                        'title' => "Error Code : ".$exception->getCode(),
                        'description' => $exception->getMessage(),
                        'color' => '7506394',
                    ]
                ],
            ]);
        }
    }
}
