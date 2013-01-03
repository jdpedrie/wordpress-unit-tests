<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','whiteasmilk'); ?><p>
<?php
	return;
}


function whiteasmilk_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment-author vcard">
		<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
		<cite class="fn"><?php comment_author_link() ?></cite> <?php _e('Says:','whiteasmilk'); ?>
	</div>
	<?php if ($comment->comment_approved == '0') : ?>
		<em>Your comment is awaiting moderation.</em>
	<?php endif; ?>
	<br />
	<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date() ?> <?php _e('at','whiteasmilk'); ?> <?php comment_time() ?></a> <?php edit_comment_link(__('e','whiteasmilk'),'',''); ?></small>

	<?php comment_text() ?>
		
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}


if (have_comments()) : ?>
	<h3 id="comments"><?php comments_number(__('No Responses Yet','whiteasmilk'),__('One Response','whiteasmilk'),__('% Responses','whiteasmilk'));?> <?php _e('to','whiteasmilk'); ?> &#8220;<?php the_title(); ?>&#8221;</h3> 

	<ol class="commentlist">
	<?php wp_list_comments(array('callback'=>'whiteasmilk_comment')); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<br />
	
	<?php if (!comments_open()) : ?> 
		<p class="nocomments">Comments are closed.</p>
	<?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>
<div id="respond">
<h3><?php comment_form_title( __('Leave a Reply','whiteasmilk'), __('Leave a Reply to %s','whiteasmilk') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be','whiteasmilk'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in','whiteasmilk'); ?></a> <?php _e('to post a comment.','whiteasmilk'); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p><?php _e('Logged in as','whiteasmilk'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account','whiteasmilk') ?>"><?php _e('Logout','whiteasmilk'); ?> &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','whiteasmilk'); ?> <?php if ($req) _e('(required)','whiteasmilk'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','whiteasmilk'); ?> <?php if ($req) _e('(required)','whiteasmilk'); ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','whiteasmilk'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="90%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment','whiteasmilk'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>
<br style="clear:both;" />
</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
