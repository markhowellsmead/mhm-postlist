<?php

namespace MHM\Postlist;

class Plugin
{
    public function dump($var, $die = false)
    {
        echo '<pre>'.print_r($var, 1).'</pre>';
        if ($die) {
            die();
        }
    }

    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'loadTextDomain'));
        add_shortcode('mhm_postlist', array($this, 'handleShortcode'), 10, 1);
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain('mhm_postlist', false, dirname(plugin_basename(__FILE__)).'/../Resources/Private/Language');
    }

    public function handleShortcode($atts)
    {
        $this->atts = apply_filters('mhm_postlist/shortcode_atts_list', shortcode_atts(array(), $atts));

        $posts = get_posts();

        $html = '';

        foreach ($posts as $post) {
            setup_postdata($post);
            $html .= sprintf(
                '<article class="post">
                    <h4 class="post-title">%1$s</h4>
                    <time>%2$s</time>
                    %3$s
                </article>',
                $post->post_title,
                sprintf(
                    __('Published on %1$s', 'mhm_postlist'),
                    get_the_date(get_option('date_format'), $post->ID)
                ),
                apply_filters('the_content', $post->post_content)
            );
        }

        wp_reset_postdata();

        return $html;
    }
}

new Plugin();
