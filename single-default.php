<section class="container post-wrapper">
	<div class="row">
		<article <?php post_class('col-md-8 entry'); ?>>
			<div class="entry post-inner">
				<ul class="post-social">
					<li><a class="tooltip-link" title="<?php _e('Post to Facebook' , 'offshore'); ?>" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink();?>&t=<?php echo get_the_title(); ?>" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
					<li><a class="tooltip-link" title="<?php _e('Post to Twitter' , 'offshore'); ?>" href="http://twitter.com/home?status=<?php echo get_the_title() .' => '.get_permalink(); ?>" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
					<li><a class="tooltip-link" title="<?php _e('Post to LinkenIn' , 'offshore'); ?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink() ?>&title=<?php echo get_the_title(); ?>&summary=&source=<?php echo get_bloginfo('name'); ?>" rel="nofollow"><i class="fa fa-linkedin"></i></a></li>
					<li><a class="tooltip-link" title="<?php _e('Pin at Pinterest' , 'offshore'); ?>" href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); echo $thumb['0']; ?>&description=<?php echo get_the_title(); ?>" rel="nofollow"><i class="fa fa-pinterest"></i></a></li>
					<li><a class="tooltip-link" title="<?php _e('Subscribe' , 'offshore'); ?>" href="<?php echo of_get_option('of_rssaddr'); ?>" rel="nofollow"><i class="fa fa-rss"></i></a></li>
				</ul>
				<?php $subtitle = get_post_meta($post->ID, 'subtitle', true);
				if ($subtitle != '') { ?>
					<p class="subtitle"><?php echo $subtitle; ?></p>
				<?php } ?>
				
				<?php
					offshore_innerslider();
				
					if (of_get_option('of_autoimage') == 1) { 
						$enableimage = 1;
					} else {
						$enableimage = 0;
					}								
				
					offshore_media(array(
					'name' => 'postfull', 
					'imgtag' => 1,
					'link' => 0,
					'enable_video' => 1, 
					'catch_image' => of_get_option('of_catch_img', 0),
					'video_id' => 'postfull',
					'enable_thumb' => $enableimage, 
					'resize_type' => 'c', 
					'media_width' => 702, 
					'media_height' => 500, 
					'thumb_align' => 'aligncenter',
					'enable_default' => 0
				)); 										

				the_content();
				
				// Display pagination
				$args = array(
					'before'           => '<p class="post-pagination">' . __('<strong>Pages:</strong>','offshore'),
					'after'            => '</p>',
					'link_before'      => '<span>',
					'link_after'       => '</span>',
					'next_or_number'   => 'number',
					'nextpagelink'     => __('Next page', 'offshore'),
					'previouspagelink' => __('Previous page', 'offshore'),
					'pagelink'         => '%',
					'echo'             => 1
				);
				wp_link_pages($args);
				
				// Display edit post link to site admin
				edit_post_link(__('Edit This Post','offshore'),'<p>','</p>'); 		
				
				// Post Widget
				offshore_dynamic_sidebar('PostWidget');
				?>
				
				<?php comments_template(); ?>
			</div>
			
		</article>
		
		<div class="col-md-4">
			<aside id="sidebar">
				<?php offshore_dynamic_sidebar('blog-sidebar'); ?>
			</aside>
		</div>
	</div>
</section><!-- Sitebody -->