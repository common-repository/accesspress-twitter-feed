<div class="aptf-tweets-wrapper aptf-template-2"><?php
    if (is_array($tweets)) {

// to use with intents
        //echo '<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>';

        foreach ($tweets as $tweet) {
            ?>

            <div class="aptf-single-tweet-wrapper">
                <div class="aptf-tweet-content">
                    <?php if ($aptf_settings['display_username'] == 1) { ?><a href="http://twitter.com/<?php echo esc_attr($username); ?>" class="aptf-tweet-name" target="_blank"><?php esc_attr_e($display_name); ?></a> <span class="aptf-tweet-username"><?php esc_attr_e($username); ?></span> <?php } ?>
                    <div class="clear"></div>
                   <?php
                        if ($tweet->full_text) {
                            //$the_tweet = ' '.$tweet->full_text . ' '; //adding an extra space to convert hast tag into links
                            
                            if (!empty($tweet->retweeted_status)) {
                            
                            $the_tweet =  '@' . $tweet->retweeted_status->user->screen_name . ': ' . $tweet->retweeted_status->full_text;
                            }
                            else{
                                $the_tweet = $tweet->full_text;
                            }
                            $the_tweet = $this->makeClickableLinks($the_tweet);
                            // i. User_mentions must link to the mentioned user's profile.
                            if (is_array($tweet->entities->user_mentions)) {
                                foreach ($tweet->entities->user_mentions as $key => $user_mention) {
                                    $the_tweet = preg_replace(
                                            '/@' . $user_mention->screen_name . '/i', '<a href="http://www.twitter.com/' . $user_mention->screen_name . '" target="_blank">@' . $user_mention->screen_name . '</a>', $the_tweet);
                                }
                            }

                            // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
                            if (is_array($tweet->entities->hashtags)) {
                                foreach ($tweet->entities->hashtags as $hashtag) {
                                    $the_tweet = str_replace(' #' . $hashtag->text . ' ', ' <a href="https://twitter.com/search?q=%23' . $hashtag->text . '&src=hash" target="_blank">#' . $hashtag->text . '</a> ', $the_tweet);
                                }
                            }

                            _e($the_tweet) . ' ';
                            ?>
                    </div><!--tweet content-->
                    <!--Tweet Image -->
                            <?php include(plugin_dir_path(__FILE__) . '../tweet-media.php'); ?>
                            <!--Tweet Image -->
                    <div class="aptf-tweet-date">
                        <p class="aptf-timestamp">
                            <a href="https://twitter.com/<?php echo esc_attr($username); ?>/status/<?php echo $tweet->id_str; ?>" target="_blank"> -
                                <?php echo $this->get_date_format($tweet->created_at, $aptf_settings['time_format']); ?>
                            </a>
                        </p>
                    </div><!--tweet_date-->
                        <?php
                    } else {
                        ?>

                        <p><a href="http://twitter.com/'<?php echo esc_attr($username); ?> " target="_blank"><?php _e('Click here to read ' . esc_attr($username) . '\'S Twitter feed', 'accesspress-twitter-feed'); ?></a></p>
                        <?php
                    }
                    ?>
                
                <?php if (isset($aptf_settings['display_twitter_actions']) && $aptf_settings['display_twitter_actions'] == 1) { ?>
                    <!--Tweet Action -->
                    <?php include(plugin_dir_path(__FILE__) . '../tweet-actions.php'); ?>
                    <!--Tweet Action -->
                <?php } ?>
            </div><!-- single_tweet_wrap-->
            <?php
        }
    }
    ?>
</div>
<?php if(isset($aptf_settings['display_follow_button']) && $aptf_settings['display_follow_button']==1){
    include(plugin_dir_path(__FILE__) . '../follow-btn.php');
}
?>