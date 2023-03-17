<?php

use OpenAI;

$accessToken = 'your_access_token';

// Get all followers
$followers = Twitter::getFollowers(['screen_name' => 'your_twitter_handle'])->ids;

// Loop through followers and retrieve their tweets
foreach ($followers as $follower) {
    $tweets = Twitter::getUserTimeline(['user_id' => $follower, 'count' => 200, 'exclude_replies' => true]);

    // Loop through tweets and analyze using OpenAI
    foreach ($tweets as $tweet) {
        $analysis = OpenAI::language()->analyze($tweet->text, ['model' => 'text-davinci-002']);

        // Check if tweet contains a buy signal
        if ($analysis->output->has_buy_signal) {
            // Extract token names
            preg_match_all('/\b[A-Z]{2,6}\b/', $tweet->text, $tokens);
            $token_names = $tokens[0];

            // Output token names
            foreach ($token_names as $token_name) {
                echo $token_name . "\n";
            }
        }
    }
}
