<?php

/**
 * Module: Our Team
 *
 * @author 		SpyroSol
 * @category 	BuilderModules
 * @package 	Spyropress
 */

class Spyropress_Module_Our_Team extends SpyropressBuilderModule {

    /**
     * Constructor
     */
    public function __construct() {

        $this->path = dirname(__FILE__);
        // Widget variable settings
        $this->cssclass = 'module-our-team';
        $this->description = __( 'Display a list of team mates.', 'spyropress' );
        $this->id_base = 'spyropress_our_team';
        $this->name = __( 'Our Team', 'spyropress' );
        
        // Fields
        $this->fields = array (
            
            array(
                'label' => __( 'Mate', 'spyropress' ),
                'id' => 'mates',
                'type' => 'repeater',
                'item_title' => 'fname',
                'fields' => array(
                    array(
                        'label' => __( 'Full Name', 'spyropress' ),
                        'id' => 'fname',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Designation', 'spyropress' ),
                        'id' => 'designation',
                        'type' => 'text'
                    ),
                    
                    array(
                        'label' => __( 'Upload Picture', 'spyropress' ),
                        'id' => 'picture',
                        'type' => 'upload'
                    ),
        
                    array(
                        'label' => __( 'About', 'spyropress' ),
                        'id' => 'content',
                        'type' => 'textarea',
                        'rows' => 6
                    ),
                    
                    array(
                		'label' => __( 'Social', 'spyropress' ),
                		'type' => 'repeater',
                        'id' => 'socials',
                        'item_title' => 'network',
                        'fields' => array(
                            array(
                                'label' => __( 'Sociable Icon', 'spyropress' ),
                                'id' => 'network',
                                'type' => 'select',
                                'options' => array(
                                    'f17d' => __( 'Dribble', 'spyropress' ),
                                    'f09a' => __( 'Facebook', 'spyropress' ),
                                    'f16e' => __( 'Flickr', 'spyropress' ),
                                    'f180' => __( 'FourSquare', 'spyropress' ),
                                    'f0d5' => __( 'Google+', 'spyropress' ),
                                    'f16d' => __( 'Instagram', 'spyropress' ),
                                    'f0e1' => __( 'Linkedin', 'spyropress' ),
                                    'f0d2' => __( 'Pinterest', 'spyropress' ),
                                    'f17e' => __( 'Skype', 'spyropress' ),
                                    'f173' => __( 'Tumblr', 'spyropress' ),
                                    'f099' => __( 'Twitter', 'spyropress' ),
                                    'f167' => __( 'Youtube', 'spyropress' )
                                )
                            ),
                
                            array(
                                'label' => __( 'URL', 'spyropress' ),
                                'id' => 'link',
                                'type' => 'text',
                            )
                        )
                	),
                )
            ),
        );
        
        $this->create_widget();
    }

    function widget( $args, $instance ) {
        
        // extracting info
        extract( $args ); extract( $instance );
        include $this->get_view();
    }

}

spyropress_builder_register_module( 'Spyropress_Module_Our_Team' );

global $mate_count;
$mate_count = 1;
function generate_mate_item( $mate, $atts ) {
    global $mate_count;
    
    $socials = '';
    if( !empty( $mate['socials'] ) ) {
        $socials .= '<div class="left"><ul class="list-social-team">';
        foreach( $mate['socials'] as $item ) {
            $socials .= '<li class="icon-soc-team"><a href="' . $item['link'] . '">&#x' . $item['network'] . ';</a></li>';
        }
        $socials .= '</ul></div>';
    }
    
    $class = ( $mate_count++ % 2 == 0 ) ? 'portret1' : 'portret';
    
    echo '
    <div class="' . $atts['column_class'] . '">
        <div class="' . $class . '">
            <div class="tack"></div>
			<img src="' . $mate['picture'] . '" alt="">
			<div class="left1">
				<h6>' . $mate['fname'] . '</h6>
				' . wpautop( $mate['content'] ) . '
				<p><em><small>' . $mate['designation'] . '</small></em></p>	
			</div>
			' . $socials . '
		</div>
	</div>';
}
?>