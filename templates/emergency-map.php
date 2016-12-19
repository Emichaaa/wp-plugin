<?php
/**
 * Template Name: Map
 *
 * @package Total
 */

get_header(); ?>

<section id="ht-home-slider-section">
	<div id="ht-bx-slider">
	<?php 
	for ($i=1; $i < 4; $i++) {  
		$total_slider_page_id = get_theme_mod( 'total_slider_page'.$i );

		if($total_slider_page_id){
			$args = array( 
                        'page_id' => absint($total_slider_page_id) 
                        );
			$query = new WP_Query($args);
			if( $query->have_posts() ):
				while($query->have_posts()) : $query->the_post();
				?>
				<div class="ht-slide">
					<div class="ht-slide-overlay"></div>

					<?php 
					if(has_post_thumbnail()){
						$total_slider_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');	
						echo '<img src="'.esc_url($total_slider_image[0]).'">';
					} ?>
				
					<div class="ht-slide-caption">
						<div class="ht-slide-cap-title animated fadeInDown">
							<span><?php echo esc_html(get_the_title()); ?></span>
						</div>

						<div class="ht-slide-cap-desc animated fadeInDown">
							<?php echo esc_html(get_the_content()); ?>
						</div>
					</div>
				</div>
				<?php
				endwhile;
			endif;
		}
	} ?>
	</div>
</section>

<?php if(get_theme_mod('total_about_page_disable') != 'on' ){ ?>
<section id="ht-about-us-section" class="ht-section">
	<div class="ht-container ht-clearfix">
		<div class="ht-about-sec">
		<?php 
            $total_about_page_id = get_theme_mod('total_about_page');
			if($total_about_page_id){
                $args = array(
    				'page_id' => absint($total_about_page_id)
    				);
    			$query = new WP_Query($args);
    			if($query->have_posts()):
    				while($query->have_posts()) : $query->the_post();
    			?>
    			<h2 class="ht-section-title"><?php the_title(); ?></h2>
    			<div class="ht-content">
    				<?php 
					if(has_excerpt()){
						the_excerpt();
					}else{
						the_content(); 
					} ?>
    			</div>
    			<?php
    			endwhile;
    			endif;	
    			wp_reset_postdata();
            }
			?>

			<div class="ht-progress-bar-sec">
			<?php
			for ($i=1; $i < 6; $i++) { 
				$total_about_progressbar_title = get_theme_mod('total_about_progressbar_title'.$i);
				$total_about_progressbar_percentage = get_theme_mod('total_about_progressbar_percentage'.$i);
				$total_about_progressbar_disable = get_theme_mod('total_about_progressbar_disable'.$i);
				if(!$total_about_progressbar_disable){
				?>
				<div class="ht-progress">
					<h6><?php echo esc_html($total_about_progressbar_title); ?></h6>
					<div class="ht-progress-bar">
						<div class="ht-progress-bar-length" style="width:<?php echo absint($total_about_progressbar_percentage); ?>%">
							<span><?php echo absint($total_about_progressbar_percentage)."%"; ?></span>
						</div>
					</div>
				</div>
				<?php
				}
			}
			?>
			</div>
		</div>

		<div class="ht-about-image">
		<?php 
			$total_about_widget = get_theme_mod('total_about_widget');
			if($total_about_widget){
				dynamic_sidebar($total_about_widget);
			}else{
				$total_about_image = get_theme_mod('total_about_image');
				echo '<img src="'.esc_url($total_about_image).'"/>';
			}
		?>
		</div>
		
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_featured_section_disable') != 'on' ){ ?>
<section id="ht-featured-post-section" class="ht-section">
	<div class="ht-container">
		<?php
		$total_featured_title = get_theme_mod('total_featured_title');
		$total_featured_sub_title = get_theme_mod('total_featured_sub_title');
		?>
		<?php 
		if($total_featured_title || $total_featured_sub_title){
			?>
			<div class="ht-section-title-tagline">
			<?php
			if($total_featured_title){ ?>
			<h2 class="ht-section-title"><?php echo esc_html($total_featured_title); ?></h2>
			<?php } ?>

			<?php if($total_featured_sub_title){ ?>
			<div class="ht-section-tagline"><?php echo esc_html($total_featured_sub_title); ?></div>
			<?php } ?>
			</div>
		<?php } ?>

		<div class="ht-featured-post-wrap ht-clearfix">
			<?php 
			for( $i = 1; $i < 4; $i++ ){
				$total_featured_page_id = get_theme_mod('total_featured_page'.$i); 
				$total_featured_page_icon = get_theme_mod('total_featured_page_icon'.$i);
			
			if($total_featured_page_id){
				$args = array( 
                    'page_id' => absint($total_featured_page_id) 
                    );
				$query = new WP_Query($args);
				if( $query->have_posts() ):
					while($query->have_posts()) : $query->the_post();
				?>
					<div class="ht-featured-post">
						<div class="ht-featured-icon"><i class="<?php echo esc_attr($total_featured_page_icon); ?>"></i></div>
						<h5><?php the_title(); ?></h5>
						<div class="ht-featured-excerpt">
						<?php 
						if(has_excerpt()){
							echo get_the_excerpt();
						}else{
							echo total_excerpt( get_the_content(), 130); 
						}?>
						</div>
						<div class="ht-featured-link">
							<a href="<?php echo esc_url(get_permalink()); ?>"><?php _e( 'Read More', 'total' ); ?></a>
						</div>
					</div>
				<?php
				endwhile;
				endif;	
				wp_reset_postdata();
				}
			}
			?>
		</div>
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_portfolio_section_disable') != 'on' ){ ?>
<section id="ht-portfolio-section" class="ht-section">
	<div class="ht-container">
	<?php
	$total_portfolio_title = get_theme_mod('total_portfolio_title');
	$total_portfolio_sub_title = get_theme_mod('total_portfolio_sub_title');
	?>

	<?php 
	if( $total_portfolio_title || $total_portfolio_sub_title ){ ?>
	<div class="ht-section-title-tagline">
		<?php 
		if($total_portfolio_title){ ?>
		<h2 class="ht-section-title"><?php echo esc_html($total_portfolio_title); ?></h2>
		<?php } ?>

		<?php if($total_portfolio_sub_title){ ?>
		<div class="ht-section-tagline"><?php echo esc_html($total_portfolio_sub_title); ?></div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php 
	$total_portfolio_cat = get_theme_mod('total_portfolio_cat');
	
	if($total_portfolio_cat){
	$total_portfolio_cat_array = explode(',', $total_portfolio_cat) ;
	?>	
	<div class="ht-portfolio-cat-name-list">
		<i class="fa fa-th-large" aria-hidden="true"></i>
		<?php 
			foreach ($total_portfolio_cat_array as $total_portfolio_cat_single) {
				$category_slug = "";
				$category_slug = get_category($total_portfolio_cat_single);
				$category_slug = $category_slug->slug ;
				?>
				<div class="ht-portfolio-cat-name" data-filter=".<?php echo esc_attr($category_slug); ?>">
					<?php echo get_cat_name($total_portfolio_cat_single); ?>
				</div>
				<?php
			}
		?>
	</div>
	<?php } ?>

	<div class="ht-portfolio-post-wrap">
		<div class="ht-portfolio-posts ht-clearfix">
			<?php 
			if($total_portfolio_cat){
			$count = 1;
			$args = array( 'cat' => $total_portfolio_cat, 'posts_per_page' => -1 );
			$query = new WP_Query($args);
			if($query->have_posts()):
				while($query->have_posts()) : $query->the_post();	
				$categories = get_the_category();
		 		$category_slug = "";
		 		$cat_slug = array();

		 		foreach ($categories as $category) {
		 			$cat_slug[] = $category->slug;
		 		}

		 		$category_slug = implode(" ", $cat_slug);

		 		if(has_post_thumbnail()){
                	$image_url = get_template_directory_uri().'/images/portfolio-small-blank.png';
                	$total_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'total-portfolio-thumb');	
					$total_image_large = wp_get_attachment_image_src(get_post_thumbnail_id(),'large');
            	}else{
            		$image_url = get_template_directory_uri().'/images/portfolio-small.png';
            		$total_image = "";
            	}
			?>
				<div class="ht-portfolio <?php echo esc_attr($category_slug); ?>">
					<div class="ht-portfolio-outer-wrap">
					<div class="ht-portfolio-wrap" style="background-image: url(<?php echo esc_url($total_image[0]) ?>);">
					
					<img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr(get_the_title()); ?>">

					<div class="ht-portfolio-caption">
						<h5><?php the_title(); ?></h5>
						<a class="ht-portfolio-link" href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-link"></i></a>
						
						<?php if(has_post_thumbnail()){ ?>
							<a class="ht-portfolio-image" data-lightbox-gallery="gallery1" href="<?php echo esc_url($total_image_large[0]) ?>"><i class="fa fa-search"></i></a>
						<?php } ?>
					</div>
					</div>
					</div>
				</div>
			<?php
			endwhile;
			endif;	
			wp_reset_postdata();
			}
			?>
		</div>
		<?php
		?>
	</div>
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_service_section_disable') != 'on' ){ ?>
<section id="ht-service-post-section" class="ht-section">
	<div class="ht-service-left-bg"></div>
	<div class="ht-container">
		<div class="ht-service-posts ht-clearfix">
			<?php
			$total_service_title = get_theme_mod('total_service_title');
			$total_service_sub_title = get_theme_mod('total_service_sub_title');
			?>
			<?php 
			if($total_service_title || $total_service_sub_title){
			?>
				<div class="ht-section-title-tagline">
				<?php if($total_service_title){ ?>
				<h2 class="ht-section-title"><?php echo esc_html($total_service_title); ?></h2>
				<?php } ?>

				<?php if($total_service_sub_title){ ?>
				<div class="ht-section-tagline"><?php echo esc_html($total_service_sub_title); ?></div>
				<?php } ?>
				</div>
			<?php } ?>

			<div class="ht-service-post-wrap">
				<?php 
				for( $i = 1; $i < 7; $i++ ){
					$total_service_page_id = get_theme_mod('total_service_page'.$i); 
					$total_service_page_icon = get_theme_mod('total_service_page_icon'.$i);
				
					if($total_service_page_id){
						$args = array( 'page_id' => absint($total_service_page_id) );
						$query = new WP_Query($args);
						if($query->have_posts()):
							while($query->have_posts()) : $query->the_post();
						?>
							<div class="ht-service-post ht-clearfix">
								<div class="ht-service-icon"><i class="<?php echo esc_attr($total_service_page_icon); ?>"></i></div>
								<div class="ht-service-excerpt">
									<h5><?php the_title(); ?></h5>
									<div class="ht-service-text">
									<?php 
										if(has_excerpt()){
											echo get_the_excerpt();
										}else{
											echo total_excerpt( get_the_content(), 100);
										}
									 ?>
									 </div>
								</div>
							</div>
						<?php
						endwhile;
						endif;	
						wp_reset_postdata();
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_team_section_disable') != 'on' ){ ?>
<section id="ht-team-section" class="ht-section">
	<div class="ht-container">
		<?php
		$total_team_title = get_theme_mod('total_team_title');
		$total_team_sub_title = get_theme_mod('total_team_sub_title');
		?>
		<?php if( $total_team_title || $total_team_sub_title ){ ?>
			<div class="ht-section-title-tagline">
				<?php if($total_team_title){ ?>
				<h2 class="ht-section-title"><?php echo esc_html($total_team_title); ?></h2>
				<?php } ?>

				<?php if($total_team_sub_title){ ?>
				<div class="ht-section-tagline"><?php echo esc_html($total_team_sub_title); ?></div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="ht-team-member-wrap ht-clearfix">
			<?php 
			for( $i = 1; $i < 5; $i++ ){
				$total_team_page_id = get_theme_mod('total_team_page'.$i); 
				$total_team_page_icon = get_theme_mod('total_team_page_icon'.$i);
			
				if($total_team_page_id){
					$args = array( 'page_id' => absint($total_team_page_id) );
					$query = new WP_Query($args);
					if($query->have_posts()):
						while($query->have_posts()) : $query->the_post();
						$total_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'total-team-thumb');	
						$total_team_designation = get_theme_mod('total_team_designation'.$i);
						$total_team_facebook = get_theme_mod('total_team_facebook'.$i);
						$total_team_twitter = get_theme_mod('total_team_twitter'.$i);
						$total_team_google_plus = get_theme_mod('total_team_google_plus'.$i);
					?>
						<div class="ht-team-member">
							
							<div class="ht-team-member-image">
								<?php if( has_post_thumbnail() ){
									$image_url = $total_image[0];
								}else{
									$image_url = get_template_directory_uri().'/images/team-thumb.png';
								} ?>
								
								<img src="<?php echo esc_url($image_url);?>" alt="<?php the_title(); ?>" />
								<div class="ht-title-wrap">
								<h6><?php the_title(); ?></h6>
								</div>

								<a href="<?php the_permalink(); ?>" class="ht-team-member-excerpt">
									<div class="ht-team-member-excerpt-wrap">
									<span>
                                        <h6><?php the_title(); ?></h6>
								
        								<?php if($total_team_designation){ ?>
        									<div class="ht-team-designation"><?php echo esc_html($total_team_designation); ?></div>
        								<?php }
                                    
										if(has_excerpt()){
											echo get_the_excerpt();
										}else{
											echo total_excerpt( get_the_content() , 100 );
										}
									?>
									<div class="ht-team-detail"><?php _e('Detail', 'total') ?></div>
									</span>
									</div>
								</a>
							</div>	

							<?php if( $total_team_facebook || $total_team_twitter || $total_team_google_plus ){ ?>
								<div class="ht-team-social-id">
									<?php if($total_team_facebook){ ?>
									<a target="_blank" href="<?php echo esc_url($total_team_facebook) ?>"><i class="fa fa-facebook"></i></a>
									<?php } ?>

									<?php if($total_team_twitter){ ?>
									<a target="_blank" href="<?php echo esc_url($total_team_twitter) ?>"><i class="fa fa-twitter"></i></a>
									<?php } ?>

									<?php if($total_team_google_plus){ ?>
									<a target="_blank" href="<?php echo esc_url($total_team_google_plus) ?>"><i class="fa fa-google-plus"></i></a>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					
					<?php
					endwhile;
					endif;	
					wp_reset_postdata();
				}
			}
			?>
		</div>
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_counter_section_disable') != 'on' ){ ?>
<section id="ht-counter-section" data-stellar-background-ratio="0.5">
    <div class="ht-counter-section ht-section">
    <div class="ht-counter-overlay"></div>
    	<div class="ht-container">
    		<?php
    		$total_counter_title = get_theme_mod('total_counter_title');
    		$total_counter_sub_title = get_theme_mod('total_counter_sub_title');
    		?>
    		<?php 
    		if($total_counter_title || $total_counter_sub_title){
    		?>
    			<div class="ht-section-title-tagline">
    				<?php if($total_counter_title){ ?>
    				<h2 class="ht-section-title"><?php echo esc_html($total_counter_title); ?></h2>
    				<?php } ?>
    
    				<?php if($total_counter_sub_title){ ?>
    				<div class="ht-section-tagline"><?php echo esc_html($total_counter_sub_title); ?></div>
    				<?php } ?>
    			</div>
    		<?php } ?>
    
    		<div class="ht-team-counter-wrap ht-clearfix">
    			<?php 
    			for( $i = 1; $i < 5; $i++ ){
    				$total_counter_title = get_theme_mod('total_counter_title'.$i); 
    				$total_counter_count = get_theme_mod('total_counter_count'.$i);
    				$total_counter_icon = get_theme_mod('total_counter_icon'.$i);
    				if($total_counter_count){
    					?>
    					<div class="ht-counter">
    						<div class="ht-counter-icon">
    							<i class="<?php echo esc_attr($total_counter_icon); ?>"></i>
    						</div>
    
    						<div class="ht-counter-count odometer odometer<?php echo $i; ?>" data-count="<?php echo absint($total_counter_count); ?>">
    							99
    						</div>
    
    						<h6 class="ht-counter-title">
    							<?php echo esc_html($total_counter_title); ?>
    						</h6>
    					</div>
    					<?php
    				}
    			}
    			?>
    		</div>
    	</div>
    </div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_testimonial_section_disable') != 'on' ){ ?>
<section id="ht-testimonial-section" class="ht-section">
	<div class="ht-container">
		<?php
		$total_testimonial_title = get_theme_mod('total_testimonial_title');
		$total_testimonial_sub_title = get_theme_mod('total_testimonial_sub_title');
		?>
		<?php if($total_testimonial_title || $total_testimonial_sub_title){ ?>
		<div class="ht-section-title-tagline">
		<?php if($total_testimonial_title){ ?>
		<h2 class="ht-section-title"><?php echo esc_html($total_testimonial_title); ?></h2>
		<?php } ?>

		<?php if($total_testimonial_sub_title){ ?>
		<div class="ht-section-tagline"><?php echo esc_html($total_testimonial_sub_title); ?></div>
		<?php } ?>
		</div>
		<?php } ?>

		<div class="ht-testimonial-wrap">
			<div class="ht-testimonial-slider">
			<?php 
			$total_testimonial_page = get_theme_mod('total_testimonial_page');
				if(is_array($total_testimonial_page)){
					$args = array(
						'post_type' => 'page',
						'post__in' => $total_testimonial_page,
				 		);
					$query = new WP_Query($args);
					if($query->have_posts()):
						while($query->have_posts()) : $query->the_post();
						$total_image = wp_get_attachment_image_src(get_post_thumbnail_id(),'total-thumb');
					?>
						<div class="ht-testimonial">
							<div class="ht-testimonial-excerpt">
							<i class="fa fa-quote-left"></i>
							<?php 
							if(has_excerpt()){
								echo get_the_excerpt();
							}else{
								echo total_excerpt( get_the_content(), 300 );
							}
							?>
							</div>
							<?php
								if(has_post_thumbnail()){
									?>
									<img src="<?php echo esc_url($total_image[0]) ?>" alt="<?php the_title(); ?>">
									<?php
								}
							?>
							<h6><?php the_title(); ?></h6>
						</div>
					<?php
					endwhile;
					endif;	
					wp_reset_postdata();
				}
			?>
			</div>
		</div>
	</div>	
</section>
<?php } ?>

<?php if(get_theme_mod('total_blog_section_disable') != 'on' ){ ?>
<section id="ht-blog-section" class="ht-section">
	<div class="ht-container">
		<?php
		$total_blog_title = get_theme_mod('total_blog_title');
		$total_blog_sub_title = get_theme_mod('total_blog_sub_title');
		?>
		<?php if($total_blog_title || $total_blog_sub_title){ ?>
		<div class="ht-section-title-tagline">
		<?php if($total_blog_title){ ?>
		<h2 class="ht-section-title"><?php echo esc_html($total_blog_title); ?></h2>
		<?php } ?>

		<?php if($total_blog_sub_title){ ?>
		<div class="ht-section-tagline"><?php echo esc_html($total_blog_sub_title); ?></div>
		<?php } ?>
		</div>
		<?php } ?>

		<div class="ht-blog-wrap ht-clearfix">
		<?php 
			$total_blog_post_count = get_theme_mod('total_blog_post_count', 3 );
			$total_blog_cat_exclude = get_theme_mod('total_blog_cat_exclude');
            $total_blog_cat_exclude = explode(',', $total_blog_cat_exclude);

			$args = array(
				'posts_per_page' => absint($total_blog_post_count),
				'category__not_in' => $total_blog_cat_exclude
				);
			$query = new WP_Query($args);
			if($query -> have_posts()):
				while($query -> have_posts()) : $query -> the_post();
				$total_image = wp_get_attachment_image_src(get_post_thumbnail_id() , 'total-blog-thumb');
				?>
				<div class="ht-blog-post ht-clearfix">
					<?php 
					if(has_post_thumbnail()){
					?> 
						<div class="ht-blog-thumbnail">
							<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($total_image[0]) ?>" alt="<?php the_title(); ?>"></a>
						</div>
					<?php
					}
					?>
					<div class="ht-blog-excerpt">
					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<div class="ht-blog-date"><i class="fa fa-calendar-o" aria-hidden="true"></i><?php echo get_the_date(); ?></div>
						<?php 
						if(has_excerpt()){
							echo get_the_excerpt();
						}else{
							echo total_excerpt( get_the_content() , 190 );
						}
						?>
					</div>

					<div class="ht-blog-read-more">
						<a href="<?php the_permalink(); ?>"><?php _e('Read More', 'total'); ?></a>
					</div>
				</div>
				<?php
				endwhile;
			endif;
			wp_reset_postdata();
		?>
		</div>	
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_client_logo_section_disable') != 'on' ){ ?>
<section id="ht-logo-section" class="ht-section">
	<div class="ht-container">
		<?php
		$total_logo_title = get_theme_mod('total_logo_title');
		$total_logo_sub_title = get_theme_mod('total_logo_sub_title');
		?>
		<?php if($total_logo_title || $total_logo_sub_title){ ?>
		<div class="ht-section-title-tagline">
		<?php if($total_logo_title){ ?>
		<h2 class="ht-section-title"><?php echo esc_html($total_logo_title); ?></h2>
		<?php } ?>

		<?php if($total_logo_sub_title){ ?>
		<div class="ht-section-tagline"><?php echo esc_html($total_logo_sub_title); ?></div>
		<?php } ?>
		</div>
		<?php } ?>

		<?php 
		$total_client_logo_image = get_theme_mod('total_client_logo_image');
		$total_client_logo_image = explode(',', $total_client_logo_image);
		?>

		<div class="ht_client_logo_slider">
		<?php
		foreach ($total_client_logo_image as $total_client_logo_image_single) {
			$image = wp_get_attachment_image_src( $total_client_logo_image_single, 'full');
			?>
			<img src="<?php echo esc_url( $image[0] ); ?>">
			<?php
		}
		?>
		</div>
	</div>
</section>
<?php } ?>

<?php if(get_theme_mod('total_cta_section_disable') != 'on' ){ ?>
<section id="ht-cta-section" data-stellar-background-ratio="0.5">
    <div class="ht-cta-section ht-section">
    	<div class="ht-cta-overlay"></div>
    	<div class="ht-container">
    		<?php
    		$total_cta_title = get_theme_mod('total_cta_title');
    		$total_cta_sub_title = get_theme_mod('total_cta_sub_title');
    		$total_cta_button1_text = get_theme_mod('total_cta_button1_text');
    		$total_cta_button1_link = get_theme_mod('total_cta_button1_link');
    		$total_cta_button2_text = get_theme_mod('total_cta_button2_text');
    		$total_cta_button2_link = get_theme_mod('total_cta_button2_link');
    		?>
    		<?php if($total_cta_title || $total_cta_sub_title){ ?>
    		<div class="ht-section-title-tagline">
    		<?php if($total_cta_title){ ?>
    		<h2 class="ht-section-title"><?php echo esc_html($total_cta_title); ?></h2>
    		<?php } ?>
    
    		<?php if($total_cta_sub_title){ ?>
    		<div class="ht-section-tagline"><?php echo esc_html($total_cta_sub_title); ?></div>
    		<?php } ?>
    		</div>
    		<?php } ?>
    
    		<?php 
    		if($total_cta_button1_link || $total_cta_button2_link){
    		?>
    		<div class="ht-cta-buttons">
    
    		<?php if($total_cta_button1_link){ ?>
    		<a class="ht-cta-button1" href="<?php echo esc_url($total_cta_button1_link); ?>"><?php echo esc_html($total_cta_button1_text); ?></a>
    		<?php } ?>
    
    		<?php if($total_cta_button2_link){ ?>
    		<a class="ht-cta-button2" href="<?php echo esc_url($total_cta_button2_link); ?>"><?php echo esc_html($total_cta_button2_text); ?></a>
    		<?php } ?>
    
    		</div>
    		<?php
    		}
    		?>
    
    	</div>
    </div>
</section>
<?php } ?>

<?php get_footer(); 