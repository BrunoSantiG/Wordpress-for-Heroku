<?php
/**
 * Plugin Name: Smartt Deploy Hook
 * Description: Call webhook when WordPress a page or post is published/updated.
 * Version: 0.0.1
 * Author: Alexandre Anício <alexandre.anicio@smarttbotter.com>
 */  

  add_action('publish_future_post', 'nb_webhook_future_post', 10);
  add_action('publish_post', 'nb_webhook_post', 10, 2);
  add_action('publish_page', 'nb_webhook_post', 10, 2);
  add_action('post_updated', 'nb_webhook_update', 10, 3);

  function nb_webhook_future_post( $post_id ) {
    nb_webhook_post($post_id, get_post($post_id));
  }

  function nb_webhook_update($post_id, $post_after, $post_before) {
    nb_webhook_post($post_id, $post_after);
  }

  function nb_webhook_post($post_id, $post) {
    if ($post->post_status === 'publish') {
      $url = curl_init('https://api.netlify.com/build_hooks/601310e32013826813784fd8');
      curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
      curl_exec($url);
    }
  }
?>
