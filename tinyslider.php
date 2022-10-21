<?php

/**
 * Plugin Name:       TinySlider
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Simple slider practice plugin from LWHH. [tslider][tslide caption="Beautiful One" id="112" size="large"][/tslider]
 * Version:           1.0.0
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ttinyslider
 * Domain Path:       /languages
 */


 function tinys_load_textdomain(){
    load_textdomain('ttinyslider', false, dirname(__FILE__).'/languages');
 }
 add_action('plugins_loaded', 'tinys_load_textdomain');

 function tinys_init(){
    add_image_size('tinys_slider', 800,600, true);
 }
 add_action('init', 'tinys_init');

 function tinys_assets(){
    wp_enqueue_style('tinyslider-style', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css', null, '1.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css', null, '1.0');
    wp_enqueue_style('tinyslider-main-style', plugin_dir_url(__FILE__).'assets/css/style.css', null, time());
    wp_enqueue_script('tinyslider-script', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', null, time(), true);
    wp_enqueue_script('tinyslider-main', plugin_dir_url(__FILE__).'assets/js/main.js', null, time(), true);
 }
 add_action('wp_enqueue_scripts', 'tinys_assets');

 function tinys_shortcode_tslider($arguments, $content){
    $defaults = array(
        'width'  => 800,
        'height' => 600,
        'id'     => '',
    );

    $attributes = shortcode_atts($defaults, $arguments);
    $content = do_shortcode($content);
    $shortcode_output = <<<EOD
<div class="container">
    <ul class="control" id="custom-control">
      <li class="prev">
        <i class="fas fa-angle-left fa-2x"></i>
      </li>
      <li class="next">
        <i class="fas fa-angle-right fa-2x"></i>
      </li>
    </ul>
    <div class="my-slider">
      {$content}
    </div>
</div>
EOD;
    return $shortcode_output;

 }
 add_shortcode('tslider', 'tinys_shortcode_tslider');

 function tinys_shortcode_tslide($arguments){
    $defaults = array(
        'caption'  => '',
        'id'       => '',
        'size'     => 'large'
    );
    $attributes = shortcode_atts($defaults, $arguments);

    $image_src = wp_get_attachment_image_src($attributes['id'], $attributes['size']);

    $shortcode_output = <<<EOD
<div class=slide>
    <img src="{$image_src[0]}" alt="{$attributes['caption']}">
</div>
EOD;

    return $shortcode_output;
 }
 add_shortcode('tslide', 'tinys_shortcode_tslide');