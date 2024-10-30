<?php
/*
Plugin Name: Headit
Plugin URI:  https://stampy.me
Description: Allows adding arbitrary HTTP headers to all outbound responses
Version:     1.0.3
Author:      StampyCode
Author URI:  https://stampy.me
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: headit
*/

defined( 'ABSPATH' ) or die( 'No skiddies please!' );


// only render the options if the user is in the admin section
// (saves load time)
if( is_admin() ) {
    require_once( plugin_dir_path( __FILE__ ) . 'options.php' );
}

/**
 * append the headers to the outbound HTTP response
 */
add_action( 'send_headers', 'headit_add_header' );
function headit_add_header() {
    $heads = get_option('headit_headerlist_real');
    if(!$heads) {
        return;
    }
    foreach($heads as $header) {
        header($header, false);
    }
}





