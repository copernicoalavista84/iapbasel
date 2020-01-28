<?php
/**
 * Upload OptionType
 *
 * @author 		SpyroSol
 * @category 	UI
 * @package 	Spyropress
 */

function spyropress_ui_upload( $item, $id, $value, $is_widget = false, $is_builder = false ) {

    ob_start();

    // collecting attributes
    $atts = array();
    $atts['class'] = 'field upload' . ( ( $value != '' ) ? ' has-file' : '' );
    $atts['type'] = 'text';
    $atts['id'] = esc_attr( $id );
    $atts['name'] = esc_attr( $item['name'] );
    $atts['value'] = esc_attr( $value );

    echo '<div ' . build_section_class( 'section-upload', $item ) . '>';
        build_heading( $item, $is_widget );
        build_description( $item );
        echo '<div class="controls">';
            echo '<div class="uploader clearfix">';
                printf( '<input%s />', spyropress_build_atts( $atts ) );
                printf( '<input class="upload_button button-secondary" type="button" value="Upload" id="upload_%s" />', $id );
                if ( is_array( @getimagesize( $value ) ) ) {
                    echo '<div class="screenshot" id="' . $id . '_image">';
                    if ( '' != $value ) {
                        $remove = '<a href="javascript:(void);" class="remove-media">Remove</a>';
                        $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
                        if ( $image ) {
                            echo '<img src="' . $value . '" alt="" />' . $remove;
                        }
                        else {
                            $parts = explode( '/', $value );
                            for( $i = 0; $i < sizeof($parts); ++$i ) {
                                $title = $parts[$i];
                            }
                            echo '<div class="no_image"><a href="' . $value . '">' . $title . '</a>' . $remove . '</div>';
                        }
                    }
                    echo '</div>';
                }
            echo '</div>';
        echo '</div>';
    echo '</div>';

    $ui_content = ob_get_clean();
    if ( $is_widget )
        return $ui_content;
    else
        echo $ui_content;
}

function spyropress_widget_upload( $item, $id, $value, $is_builder ) {
    return spyropress_ui_upload( $item, $id, $value, true, $is_builder );
}
?>