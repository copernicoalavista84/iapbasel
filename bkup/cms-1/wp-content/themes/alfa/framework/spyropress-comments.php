<?php
/**
 * SpyroPress Comments
 *
 * @category    WordPress
 * @package     SpyroPress
 *
 */

/**
 * Comment Callback
 */
function spyropress_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<div class="post pingback">
		<p><?php _e( 'Pingback:', 'spyropress' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'spyropress' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
    <?php
        $gclass = 'two columns alpha';
            if( $depth == 2 ) $gclass .= ' offset-by-one';
            if( $depth == 3 ) $gclass .= ' offset-by-two';
            if( $depth == 4 ) $gclass .= ' offset-by-three';
            if( $depth == 5 ) $gclass .= ' offset-by-four';
        $tclass = 'columns coment omega';
            if( $depth == 1 ) $tclass .= ' fourteen';
            if( $depth == 2 ) $tclass .= ' thirteen';
            if( $depth == 3 ) $tclass .= ' twelve';
            if( $depth == 4 ) $tclass .= ' eleven';
            if( $depth == 5 ) $tclass .= ' ten';
    ?>
    <div <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="<?php echo $gclass; ?>">
			<?php echo get_avatar( $comment, 120 ); ?>
		</div>
		<div class="<?php echo $tclass; ?>">
			<div class="coment-text">
				<p><small><em><a href="<?php comment_author_url(); ?>"><?php comment_author(); ?></a></em></small></p>
				<?php if ( $comment->comment_approved == '0' ) { ?>
                    <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'spyropress' ); ?></em><br />
                <?php
                    }
                    comment_text();
                ?>
				<p><small><?php printf( __( '%1$s at %2$s', 'spyropress' ), get_comment_date(), get_comment_time() ) ?> - <?php
                comment_reply_link( array_merge( $args, array(
                    'depth' => $depth,
                    'reply_text' => 'Reply',
                    'max_depth' => $args['max_depth'],
                ) ) );
            ?></small></p>
			</div>
		</div>
	<?php
			break;
	endswitch;
}
?>