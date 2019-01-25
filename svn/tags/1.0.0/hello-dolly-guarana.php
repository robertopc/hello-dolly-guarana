<?php
/*
Plugin Name: Hello Dolly Guaraná
Plugin URI: https://wordpress.org/plugins/hello-dolly-guarana/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in three words sung most famously by Dollynho: Hello, Dolly Guaraná. When activated you will randomly see a phrase from <cite>Hello, Dolly Guaraná</cite> in the upper right of your admin screen on every page.
Author: Roberto Pereira da Costa
Author URI: https://robertopc.github.io/
Version: 1.0.0
Text Domain: hello-dolly-guarana
*/

function hello_dolly_guarana_get_lyric() {
	/** These are the lyrics to Hello Dolly */
	$phrases = file_get_contents('/phrases.txt');

	// Here we split it into lines
	$phrases = explode( "\n", $phrases );

	// And then randomly choose a line
	return wptexturize( $phrases[ mt_rand( 0, count( $phrases ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_dolly_guarana() {
	$chosen = hello_dolly_guarana_get_lyric();
	echo "<div id='dolly_guarana'>$chosen</div>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'hello_dolly_guarana' );

// We need some CSS to position the paragraph
function dolly_guarana_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';
	$y = is_rtl() ? 'right' : 'left';

	echo "
	<style type='text/css'>
	#dolly_guarana {
		float: $x;
		display:inline-block;
		padding-$x: 16px;
		padding-$y: 16px;
		text-align:
		margin: 0;
		margin-top: 6px;
		font-size: 11px;
		background-color:#9f0;
		background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAAQCAYAAADNo/U5AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAEKSURBVCiRhdK9SkNBEAXgby8pEm0Ufx4gWtjYi+ADiI2PYBmwtrISFGxstLewtTGo+Ah2gr1ah4B2IkJ0LLKRy801LgzLzszZc2b3iAjlwD6eMVWtjaIwvppoY6emNlwVlil0ERjgDDNjaiqgvQwox/l/8tZqxCxXE0VKqUgpjZofa0BLdWN1cYmErRp532hVxnCDL7zirQYUaOfm9PsQmMYmrvIFVdAtjnGNjQIi4j0i7iJiG6cV+Z/ooYEVdMZ+GycVll6pltCqc8Rs3l+y1IWUUiMrioj4qGN6wr2hnXYz2/okR6zmpk4+z2W2w0mgC0PPLZZyD+ij+ZeN5nEUEf1S7iD/32CU+AEfEPsJRF5QZQAAAABJRU5ErkJggg==');
		background-repeat: no-repeat;
		background-positon: $x center;
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_guarana_css' );


