<?php 
	
	function wrw()
	{
		wp_enqueue_style('wrw-main-style', plugins_url(). '/wa-ruas-woo/css/style.css');
		wp_enqueue_script('wrw-main-script', plugins_url(). '/wa-ruas-woo/css/main.js');
	}
	
	add_action('wp_enqueue_scripts', 'wrw');
 ?>

