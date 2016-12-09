<?php

namespace App\Helpers;


class Twitter
{

    /**
     * @param $count
     * @return mixed
     */
    public static function timeline($count) {
        try {
            $twitter = \Twitter::getUserTimeline(['screen_name' => env('TWITTER_SCREEN_NAME'), 'count' => $count, 'format' => 'array']);
            if (isset($twitter)) {
                return @$twitter;
            }
        } catch(\Exception $e) {
            return false;
        }
    }

}