<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package TemplatePath
 */

global $tpath_options;
get_header();
 
$container_class = $scroll_type = '';	
if( $tpath_options['tpath_blog_type'] == 'grid' ) {
	if( $tpath_options['tpath_blog_grid_columns'] != '' ) {
		if( $tpath_options['tpath_blog_grid_columns'] == 'two' ) {
			$container_class = 'grid-layout grid-col-2';
		} elseif ( $tpath_options['tpath_blog_grid_columns'] == 'three' ) {
			$container_class = 'grid-layout grid-col-3';
		} elseif ( $tpath_options['tpath_blog_grid_columns'] == 'four' ) {
			$container_class = 'grid-layout grid-col-4';
		}
	}
	$post_class = 'grid-posts';
	$page_type_layout = 'grid';
	$image_size = 'theme-mid';
	$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_grid'];
		
} elseif( $tpath_options['tpath_blog_type'] == 'large' ) {
	$container_class = 'large-layout';
	$post_class = 'large-posts';
	$image_size = 'blog-large';
	$page_type_layout = 'large';
	$excerpt_limit = $tpath_options['tpath_blog_excerpt_length_large'];
		
} elseif( $tpath_options['tpath_blog_type'] == 'list' ) {
	$container_class = 'list-layout';
	$post_class = 'list-posts';
	$image_size = 'blog-list';
	$page_type_layout = 'list';
	$list_fullwidth = $tpath_options['tpath_blog_list_fullwidth'];
	if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
		$excerpt_limit = 20;
	} else {
		$excerpt_limit = 30;
	}
	$list_fullwidth = $tpath_options['tpath_blog_list_fullwidth'];
	if( isset( $list_fullwidth ) && $list_fullwidth == 'no' ) {
		$container_class .= ' list-columns';
	} else {
		$container_class .= ' list-fullwidth';
	}
}

if( $tpath_options['tpath_disable_blog_pagination'] ) {
	$scroll_type = "infinite";
	$scroll_type_class = " scroll-infinite";
} else {
	$scroll_type = "pagination";
	$scroll_type_class = " scroll-pagination";
}
?>
<div class="container">
	<div id="main-wrapper" class="tpath-row row">
		<div id="single-sidebar-container" class="single-sidebar-container main-col-full">
			<div class="tpath-row row">
				<div id="primary" class="content-area <?php justice_primary_content_classes(); ?>">
					<div id="content" class="site-content">
					
						<div id="archive-posts-container" class="tpath-posts-container <?php echo esc_attr( $container_class ); ?><?php echo esc_attr( $scroll_type_class ); ?> clearfix">
						
							<?php if ( have_posts() ):
								while ( have_posts() ): the_post();
								
									$post_id = get_the_ID();
									$post_format = get_post_format();
									
									$post_format_class = '';
									if( $post_format == 'image' ) {
										$post_format_class = ' image-format';
									} elseif( $post_format == 'quote' ) {
										$post_format_class = ' quote-image';
									} ?>
									
									<article id="post-<?php echo esc_attr( $post_id ); ?>" <?php post_class($post_class); ?>>
										<div class="posts-inner-container clearfix">
											<div class="posts-content-container">
												<?php if( $page_type_layout == 'list' || $page_type_layout == 'grid' ) {
													include( locate_template('partials/content-list.php') );
												} 
												elseif($page_type_layout == 'large') {
													include( locate_template('partials/content-large.php') );
												} ?>
											</div>
										</div>
									</article>
									
								<?php endwhile;
								
								else :
									get_template_part( 'content', 'none' );
							endif; ?>
							
						</div>
						<?php echo justice_pagination( $pages = '', $range = 2, $scroll_type ); ?>
						
					</div><!-- #content -->
				</div><!-- #primary -->
			
				<?php get_sidebar(); ?>
			</div>
		</div><!-- #single-sidebar-container -->
		
	</div><!-- #main-wrapper -->
</div><!-- .container -->
<?php get_footer(); ?>