<?php

namespace WordPress\Themes\EveOnline\Helper;

\defined('ABSPATH') or die();

class PostHelper {
	public static function getPostMetaInformation() {
		$options = \get_option('eve_theme_options', ThemeHelper::getThemeDefaultOptions());

		if(!empty($options['show_post_meta']['yes'])) {
			\printf(\__('Posted on <time class="entry-date" datetime="%3$s">%4$s</time><span class="byline"> <span class="sep"> by </span> <span class="author vcard">%7$s</span></span>', 'eve-online'),
				\esc_url(\get_permalink()),
				\esc_attr(\get_the_time()),
				\esc_attr(\get_the_date('c')),
				\esc_html(\get_the_date()),
				\esc_url(\get_author_posts_url(\get_the_author_meta('ID'))),
				\esc_attr(\sprintf(\__('View all posts by %s', 'eve-online'),
					\get_the_author()
				)),
				\esc_html(get_the_author())
			);
		} // END if(!empty($options['show_post_meta']['yes']))
	} // END public static function getPostMetaInformation()

	public static function getComments($comment, $args, $depth) {
		switch($comment->comment_type) {
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="comment media" id="comment-<?php \comment_ID(); ?>">
					<div class="media-body">
						<p>
							<?php \_e('Pingback:', 'eve-online'); ?> <?php \comment_author_link(); ?>
						</p>
					</div><!--/.media-body -->
					<?php
					break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li class="comment media" id="comment-<?php \comment_ID(); ?>">
					<a href="<?php echo $comment->comment_author_url; ?>" class="pull-left">
						<?php echo \get_avatar($comment, 64); ?>
					</a>
					<div class="media-body">
						<h4 class="media-heading comment-author vcard">
							<?php
							\printf('<cite class="fn">%1$s %2$s</cite>',
								\get_comment_author_link(),
								// If current post author is also comment author, make it known visually.
								($comment->user_id === $post->post_author) ? '<span class="label"> ' . \__('Post author', 'eve-online') . '</span> ' : ''
							);
							?>
						</h4>
						<?php
						if('0' == $comment->comment_approved) {
							?>
							<p class="comment-awaiting-moderation">
								<?php \_e('Your comment is awaiting moderation.', 'eve-online'); ?>
							</p>
							<?php
						} // END if('0' == $comment->comment_approved)

						\comment_text();
						?>
						<p class="meta">
							<?php
							\printf('<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
								\esc_url(\get_comment_link($comment->comment_ID)),
								\get_comment_time('c'),
								\sprintf(\__('%1$s at %2$s', 'eve-online'), \get_comment_date(), \get_comment_time())
							);
							?>
						</p>
						<p class="reply">
							<?php
							\comment_reply_link(\array_merge($args, array(
								'reply_text' => __('Reply <span>&darr;</span>', 'eve-online'),
								'depth' => $depth,
								'max_depth' => $args['max_depth']
							)));
							?>
						</p>
					</div> <!--/.media-body -->
					<?php
				break;
		} // END switch ($comment->comment_type)
	} // END public static function getComments($comment, $args, $depth)

	public static function getPostCategoryAndTags() {
		$options = \get_option('eve_theme_options', ThemeHelper::getThemeDefaultOptions());

		if(!empty($options['show_post_meta']['yes'])) {
			\printf('<span class="cats_tags"><span class="glyphicon glyphicon-folder-open" title="My tip"></span><span class="cats">');
			\printf(\the_category(', '));
			\printf('</span>');

			if(\has_tag() === true) {
				\printf('<span class="glyphicon glyphicon-tags"></span><span class="tags">');
				\printf(\the_tags(' '));
				\printf('</span>');
			} // END if(has_tag() === true)

			\printf('</span>');
		} // END if(!empty($options['show_post_meta']['yes']))
	} // END public static function getPostCategoryAndTags()

	/**
	 * check if a post has content or not
	 *
	 * @param int $postID ID of the post
	 * @return boolean
	 */
	public static function hasContent($postID) {
		$content_post = \get_post($postID);
		$content = $content_post->post_content;

		return \trim(\str_replace('&nbsp;','',  \strip_tags($content))) !== '';
	} // END public static function hasContent($postID)

	public static function getHeaderColClasses($echo = false) {
		if(ThemeHelper::hasSidebar('header-widget-area')) {
			$contentColClass = 'col-xs-12 col-sm-9 col-md-6 col-lg-6';
		} else {
			$contentColClass = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
		} // END if(Helper\ThemeHelper::hasSidebar('header-widget-area'))

		if($echo === true) {
			echo $contentColClass;
		} else {
			return $contentColClass;
		} // END if($echo === true)
	} // END public static function getHeaderColClasses($echo = false)

	public static function getMainContentColClasses($echo = false) {
		if(ThemeHelper::hasSidebar('sidebar-page') || ThemeHelper::hasSidebar('sidebar-general') || ThemeHelper::hasSidebar('sidebar-post')) {
			$contentColClass = 'col-lg-9 col-md-9 col-sm-9 col-9';
		} else {
			$contentColClass = 'col-lg-12 col-md-12 col-sm-12 col-12';
		} // END if(ThemeHelper::hasSidebar('sidebar-page') || ThemeHelper::hasSidebar('sidebar-general') || ThemeHelper::hasSidebar('sidebar-post'))

		if($echo === true) {
			echo $contentColClass;
		} else {
			return $contentColClass;
		} // END if($echo === true)
	} // END public static function getMainContentColClasses($echo = false)

	public static function geLoopContentClasses($echo = false) {
		if(ThemeHelper::hasSidebar('sidebar-page') || ThemeHelper::hasSidebar('sidebar-general') || ThemeHelper::hasSidebar('sidebar-post')) {
			$contentColClass = 'col-lg-4 col-md-6 col-sm-12 col-xs-12';
		} else {
			$contentColClass = 'col-lg-3 col-md-4 col-sm-6 col-xs-12';
		} // END if(ThemeHelper::hasSidebar('sidebar-page') || ThemeHelper::hasSidebar('sidebar-general') || ThemeHelper::hasSidebar('sidebar-post'))

		if($echo === true) {
			echo $contentColClass;
		} else {
			return $contentColClass;
		} // END if($echo === true)
	} // END function public static function geLoopContentClasses($echo = false)
} // END class PostHelper

