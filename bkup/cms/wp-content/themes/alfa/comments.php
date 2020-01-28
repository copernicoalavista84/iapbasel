<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) return;
?>
<div class="comments sixteen columns alpha omega">
	<?php if ( have_comments() ) { ?>
        <div class="line"></div>
        <h6>
			<?php
				printf( _nx( '1 Comment', '%1$s Comments', get_comments_number(), 'comments title', 'spyropress' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h6>
		<?php
			wp_list_comments( array(
				'format'      => 'html5',
                'style'         => 'div',
				'short_ping'  => true,
                'callback' => 'spyropress_comment'
			) );
		?>
		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'spyropress' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'spyropress' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'spyropress' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'spyropress' ); ?></p>
		<?php endif; ?>

	<?php
        } else {
            echo '<h4 class="comments-title">0 Comments</h4>';
        }
    ?>
</div><!-- #comments -->
<div class="line"></div>
<div id="comment-leave" class="reply clearfix">
<?php
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    
    $fields = array();
    $fields['author'] = '<div id="label-author" for="author" class="field user"><input id="author" name="author" type="text" class="text" placeholder="Name" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' /></div>';
    $fields['email'] = '<div id="label-email" for="email" class="field envelope"><input id="email" name="email" type="text" class="text" placeholder="Email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' /></div>';
    $fields['url'] = '<div id="label-url" for="url" class="field world"><input id="url" name="url" type="text" class="text" placeholder="Website" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div>';
    
    $args = array(
        'fields' => $fields,
        'comment_field' => '<div class="field pen"><textarea id="comment" name="comment" class="text textarea" placeholder="Message"></textarea></div>',
        'format' => 'html5',
        'label_submit' => 'Submit Comment',
        'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . '</p>',
        'comment_notes_after' => ''
    );
    
    ob_start();
    comment_form( $args );
    $comment_form = ob_get_clean();
    
    $comment_form = str_replace( '<p class="form-submit">', '<p class="form-submit field">', $comment_form );
    $comment_form = str_replace( '<input name="submit" type="submit" id="submit" value="Submit Comment" />', '<button name="submit" type="submit" id="submit" class="button send"><span aria-hidden="true" class="li_paperplane"></span>Submit</button>', $comment_form );
    
    echo $comment_form;
?>
</div>