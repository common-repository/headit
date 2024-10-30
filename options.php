<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Add the option names to be configurable through the options window
 */
function headit_register_settings() {
    register_setting(
         'headit_options',  // settings section
         'headit_headerlist', // setting name
         'headit_verify_headerlist'
    );
}
add_action('admin_init', 'headit_register_settings');


/**
 * validate the submitted headerlist - doesnt actally modify the headerlist given,
 * but if the list is valid a hidden (optimised) setting is updated with a ist of
 * headers to be used. This is shown in a read-only format in the settings page.
*/
function headit_verify_headerlist($oval) {

    $val = str_replace("\r", "\n", $oval);
    while(strpos($val, "\n\n") !== false)
        $val = str_replace("\n\n", "\n", $val);
    $val = str_replace("\n+","", $val);
    $val = explode("\n", $val);
    foreach($val as $line) {
        $line = trim($line);
        if(!$line || '#'===$line{0}) continue;
        $headers[] = $line;
    }

    update_option(
        'headit_headerlist_real',
        $headers
    );

    return apply_filters( 'headit_verify_headerlist', $oval, $oval);
}

/**
 * Add an admin submenu link under Settings
 */
function headit_add_options_submenu_page() {
     add_submenu_page(
          'options-general.php',          // admin page slug
          __( 'Headit', 'headit' ), // page title
          __( 'Headit', 'headit' ), // menu title
          'manage_options',               // capability required to see the page
          'headit_options',                // admin page slug, e.g. options-general.php?page=headit_options
          'headit_options_page'            // callback function to display the options page
     );
}
add_action( 'admin_menu', 'headit_add_options_submenu_page' );

// Add settings link on plugin page
function admin_plugin_settings_link( $links ) { 
    $settings_link = '<a href="options-general.php?page=headit_options">Settings</a>';
    array_unshift( $links, $settings_link ); 
    return $links; 
}
add_filter(
    'plugin_action_links_'.plugin_basename( plugin_dir_path( __FILE__ ) . 'headit.php'),
    'admin_plugin_settings_link'
);
 
/**
 * Build the options page
 */
function headit_options_page() {
$set = 0;
    if ( ! isset( $_REQUEST['settings-updated'] ) ) {
        $_REQUEST['settings-updated'] = false; 
    }
    $lst = esc_html(get_option( 'headit_headerlist' ));
    $lstr = headit_display_headerlist(get_option( 'headit_headerlist_real' ));
    ?>
 
    <style>
    .headit textarea { font-family: monospace; width: 100%; min-height:400px; }
    .headit table { max-width:900px; }
    .headit td { vertical-align:top;  padding: 0 10px; }
    .headit code { display:block; }
    .headit li { list-style-type: square; margin-left:20px; }
    </style>
    <div class="wrap headit">
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

        <p><b>Changing things here can break your site. You should only be using this plugin if you fully
understand the changes you are making.</b><br/>
        Headers set here are applied statically site-wide, and are not dynamic. Headers set here don't override any existing headers that may already be present in the response.</p>
        <table><tr><td>
        <b>Examples of headers <em>not</em> to use here:</b>
        <ul>
            <li>Location (this will redirect all page requests (!))</li>
            <li>Content-Length (this may break browser content rendering (!))</li>
            <li>Set-Cookie (should be set dynamically)</li>
            <li>Date (should be set dynamically)</li>
            <li>Connection (should be defined in your server config)</li>
        </ul>
        </td><td>
        <b>Examples of headers that are suitable to be used here:</b>
        <ul>
            <li>Public-Key-Pins</li>
            <li>Strict-Transport-Security</li>
            <li>X-Frame-Options</li>
            <li>X-XSS-Protection</li>
            <li>X-Content-Type-Options</li>
            <li>Content-Security-Policy</li>
            <li>Content-Security-Policy-Report-Only</li>
        </ul>
        </td></tr></table>
          
            <div id="post-body">
                <div id="post-body-content">
                    <form method="post" action="options.php">
                        <?php settings_fields( 'headit_options' ); ?>
                            <table class="form-table">
                                <tr><th scope="row"><?php _e( 'Header List' ); ?></th>
                                <td rowspan="2" style="text-align:top;">
                                    <textarea name='headit_headerlist'><?= $lst ?></textarea></td>
                                </tr><tr>
                                <td><label class="description" for="headit_headerlist"><?php _e( 'Add site-wide customised HTTP Response headers. Blank lines and lines beginning with \'#\' will be ignored, so you can disable a header line or add comments. If a line starts with a "+" character, it will be appended to the previous line. This enables complex headers to be spread over multiple lines.' ); ?></label>
                                    </td>
                                </tr><tr>
                                    <td></td><td><?php submit_button( 'Save Changes', 'primary') ?></td>
                                </tr>
                                <tr><th scope="row"><?php _e('Actual Headers' ); ?></th>
                                <td><code><?= $lstr ?></code></td>
                             </table>
                        </form>
                   </div> <!-- end post-body-content -->
              </div> <!-- end post-body -->
    </div>

<?php
}

function headit_display_headerlist($list=null) {
    if(!$list || !is_array($list)) return '';

    $out = '';
    foreach($list as $row) {
        list($name, $val) = explode(':', $row, 2);
        $out .= "<b>$name:</b>$val<br />";
    }
    return $out;
}

