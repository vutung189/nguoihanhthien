<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<section class="primary-slider" role="slider">
	<div class="owl-carousel owl-theme newsmag-slider">
		<?php

		$owl_nav_list = array();

		if ( $posts->have_posts() ):
		while ( $posts->have_posts() ): $posts->the_post();

			?>
			<div class="item">
				<div class="item-image">
					<a href="<?php the_permalink(); ?>">
						<?php

						if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'newsmag-slider-image' );
						} else {
							echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/banner-placeholder.jpg' ) . '"/>';
						}

						?>
					</a>
			
					<?php $owl_nav_list[] = get_the_title(); ?>
				
				</div> <!-- end image -->
			</div> <!-- end h-entry -->
		<?php endwhile; ?>
	</div> <!-- end slider swipe -->

	<!-- article navigation list -->
	<div class="owl-nav-list hidden-xs hidden-sm">
		<?php if ( empty( $instance['title'] ) ) { ?>
			<h4><?php esc_html_e( 'Tin nổi bật', 'newsmag' ); ?></h4>
		<?php } else { ?>
			<h4><?php echo esc_html( $instance['title'] ); ?></h4>
		<?php } ?>
		<ul>
			<?php

			foreach ( $owl_nav_list as $title_index => $title_value ) {
				$title_str = $title_index;

				if ( $title_index < 10 ) {
					$title_str = "0" . ( $title_index + 1 );
				}

				if ( $title_index == 0 ) {
					echo '<li class="active"><span>' . $title_str . '</span><a href="#">' . $title_value . '</a></li>';
				} else {
					echo '<li><span>' . $title_str . '</span><a href="#">' . $title_value . '</a></li>';
				}
			}

			?>
		</ul>
	</div>
	<!-- end article navigation list -->
	<?php endif; ?>
</section>