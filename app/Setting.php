<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';

    protected $fillable = [
        'site_name', 'title', 'url', 'logo', 'keywords', 'desc', 'code_google', 'code_yandex', 'facebook_url',
        'twitter_url', 'googleplus_url', 'youtube_url', 'linkedin_url', 'instagram_url', 'swarm_url',
        'foursquare_url', 'pinterest_url', 'mail_address', 'mail_host', 'mail_user', 'mail_password', 'slide_w',
        'slide_h', 'thumb_w', 'thumb_h', 'blog_w', 'blog_h', 'mail_to', 'mail_port', 'mail_driver'
    ];

}
