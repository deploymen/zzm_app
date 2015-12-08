<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Apps
      |--------------------------------------------------------------------------
     */
    'app_store' => 'http://itunes.apple.com/app/id1003605763',
    'play_store' => 'https://play.google.com/store/apps/details?id=com.visualmathinteractive.zapzapmath',
    /*
      |--------------------------------------------------------------------------
      | Analytics
      |
      | Local, development and staging environments should use a test GA profile
      | Production environment should use the main GA profile
      |--------------------------------------------------------------------------
     */
    'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', false),
    /*
      |--------------------------------------------------------------------------
      | Social media
      |--------------------------------------------------------------------------
     */
    'facebook_url' => 'https://www.facebook.com/zapzapmath',
    'twitter_url' => 'https://twitter.com/vmathstudio',
    'twitter_username' => 'vmathstudio',
    'youtube_url' => 'https://www.youtube.com/channel/UCt_vlVsmfurGeunHTb1-HPQ',
    'pinterest_url' => 'https://www.pinterest.com/mathexpression/',
    'blog_url' => 'http://blog.zapzapmath.com',
    /*
      |--------------------------------------------------------------------------
      | Email addresses
      |--------------------------------------------------------------------------
     */
    'support_email' => 'hello@zapzapmath.com',
    /*
      |--------------------------------------------------------------------------
      | Typekit
      |--------------------------------------------------------------------------
     */
    'typekit_code' => 'jkr5dov',
    /*
      |--------------------------------------------------------------------------
      | CDN urls
      |--------------------------------------------------------------------------
     */
    'cdn_static' => 'https://d2te1y9qx21itc.cloudfront.net',
    /*
      |--------------------------------------------------------------------------
      | Default SEO
      |--------------------------------------------------------------------------
     */
    'default_page_description' => 'Zap Zap Math is a mobile platform for kids in grade 1 to 6. Be the first in line for our preview release and get tons of goodies for free!',
    /*
      |--------------------------------------------------------------------------
      | Feature flags
      |--------------------------------------------------------------------------
     */
    'flag_signin' => false,
];
