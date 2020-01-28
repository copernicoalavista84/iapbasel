<?php

/**
 * Theme Vrifer
 *
 * This is theme verifeir admin page.
 *
 */

global $spyropress;

$values = wp_parse_args( $_REQUEST, array(
    'step' => '',
    'envato_username' => '',
    'envato_item_code' => ''
) );
extract( $values );
$step = ( $step ) ? $step : 1;

if ( $spyropress->admin->is_verified && $spyropress->admin->is_builder_installed )
    if ( !isset( $_GET['step'] ) )
        return;

if ( $spyropress->admin->is_verified && !$spyropress->admin->is_builder_installed ) $step = 2;
/** Step 1 **/
if ( 1 == $step ) {
?>
<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
		<h3>
			<?php _e( 'Welcome to SpyroPress!', 'spyropress' ); ?>
		</h3>
		<p class="about-description">
			<?php _e( 'In order to get better service and support you need you to verify your theme purchase by inserting the item purchase code below.', 'spyropress' ); ?><br />
		</p>
        <br />
        <div class="section">
            <form class="controls" method="post" enctype="multipart/form-data" id="spyropress_form">
                <h3 class="heading"><?php _e( 'Envato Username', 'spyropress' ); ?></h4>
                <input class="field" type="text" value="<?php echo $envato_username; ?>" name="envato_username" placeholder="<?php esc_attr_e( 'Enter your marketplace username here', 'spyropress' ); ?>" />
                <div class="clear"></div><br />
                <h3 class="heading"><?php _e( 'Item Purchase Code', 'spyropress' ); ?></h4>
                <input class="field" type="text" value="<?php echo $envato_item_code; ?>" name="envato_item_code" placeholder="<?php esc_attr_e( 'Enter your purchase code here', 'spyropress' ); ?>" />
                <div class="clear"></div>
                <div style="margin-top: 10px;">
                    <?php wp_nonce_field( 'spyropress-verification', 'security' ); ?>
                    <input class="button-xlarge button-green" value="<?php esc_attr_e('Verify', 'spyropress'); ?>" type="submit" />
                    <div class="description" style="line-height: 1.3;margin-top: 15px;width: 50%;">
                            <a target="_blank" href="http://cl.ly/JDD5"><?php _e('Where do I get my Item purchase Code?', 'spyropress') ?></a>
                    </div>
                </div>
            </form>
            <div class="clear"></div>
        </div>
	</div>
</div>
<?php
}
/** Step 2 **/
elseif ( 2 == $step ) {

// Getting Filesystem intact
$method = get_filesystem_method();

if ( isset( $_POST['password'] ) ) {
    $cred = $_POST;
    $filesystem = WP_Filesystem( $cred );
}
elseif ( isset( $_POST['spyropress_ftp_cred'] ) ) {
    $cred = spyropress_decode( $_POST['spyropress_ftp_cred'] );
    $filesystem = WP_Filesystem( $cred );
}
else
    $filesystem = WP_Filesystem();

$url = admin_url( 'admin.php?page=spyropress&step=2' );
?>
<h2 style="margin: 0;padding: 0;"></h2>
<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
		<?php
        if ( false == $filesystem ) {
		  request_filesystem_credentials( $url );
        }
        else {
        ?>
            <h3>
    			<?php _e( 'Ready to Install!', 'spyropress' ); ?>
    		</h3>
    		<p class="about-description">
    			<?php _e( 'You are successfully verified and ready to install the SpyroPress Builder, the next generation Wordpress Page and Template Builder.', 'spyropress' ); ?><br />
    		</p>
            <form method="post" enctype="multipart/form-data" id="spyropress_form" style="margin:20px 0 10px;">
                <?php wp_nonce_field( 'spyropress-verification', 'security' ); ?>
                <input type="hidden" name="spyropress_ftp_cred" value="<?php echo esc_attr( spyropress_encode( $_POST ) ); ?>" />
                <input type="hidden" name="spyropress_installer" value="builder" />
                <button type="submit" class="button-xlarge button-green" >
                    <?php _e( 'Install SpyroBuilder', 'spyropress' ); ?>
                </button>
            </form>
        <?php } ?>
	</div>
</div>
<?php
}
/** Step 3 **/
elseif ( 3 == $step ) {
?>
<h2 style="margin: 0;padding: 0;"></h2>
<div id="welcome-panel" class="welcome-panel">
	<div class="welcome-panel-content">
        <h3>
			<?php _e( 'Finally!', 'spyropress' ); ?>
		</h3>
		<p class="about-description">
			<?php _e( 'SpyroPress Builder successfully installed and ready to use. Just import the templates and you are all set.', 'spyropress' ); ?><br />
		</p>
        <form method="post" enctype="multipart/form-data" id="spyropress_form" style="margin:20px 0 10px;">
            <?php wp_nonce_field( 'spyropress-verification', 'security' ); ?>
            <input type="hidden" name="spyropress_installer" value="importer" />
            <button type="submit" class="button-xlarge button-green" >
                <?php _e( 'Install Templates', 'spyropress' ); ?>
            </button>
        </form>
	</div>
</div>
<?php
}
/** Step 4 **/
elseif ( 4 == $step ) {
    echo '<div class="updated"><p>'.__( 'You are all set to go !.', 'spyropress' ).'</p></div>';
}
?>