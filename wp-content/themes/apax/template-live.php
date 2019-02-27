<?php /* Template name: Live ! */ ?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<h1 class="post-title"><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<div class="wrap-block wrap-block-blog-interne">
		<h2><img src="<?= get_template_directory_uri() ?>/img/apax-blog-logo.svg" alt="Apax Blog"></h2>
		<div class="bandeau">
			<?php _e("Partners discuss the latest news","apax"); ?>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php
				$lst_art = new WP_Query([
					'post_type' => 'blog',
					'posts_per_page' => 3,
				]);

				if($lst_art->have_posts()) {
					foreach ($lst_art->posts as $post){
						$id_blog_interne = $post->ID;
						include 'pushs/blog-interne.php';
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 read-more-wrapper">
			<a href="<?= get_post_type_archive_link('blog') ?>" class="read-more read-more-blue">
				
				<?php if (ICL_LANGUAGE_CODE == "fr"): ?>
					Tout le <strong>blog</strong> 
				<?php else: ?>
					All the <strong>blog</strong> 
				<?php endif; ?>
				<br>
				<img src="<?= get_template_directory_uri() ?>/img/plus-blue.png" alt="">
			</a>
		</div>
	</div>

	<div class="wrap-block wrap-block-blog">
		<h2><img src="<?= get_template_directory_uri() ?>/img/apax-talks-logo.svg" alt="Apax Talk"></h2>
		<div class="bandeau">
			<?php if (ICL_LANGUAGE_CODE == "fr") {
				echo 'Les stratégies de croissance menées par nos entrepreneurs';
			} else {
				echo 'Growth strategies led by our entrepreneurs';
			} ?>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php 
					$list_id_blog = array();
					$lst_art = wp_query_link_api([
						"posts_per_page" => 3,
						"post_type" => "blog"
					]);
					
					foreach ($lst_art as $la)
						$list_id_blog[$la['id']] = $la;
					foreach ($list_id_blog as $id_blog=>$blog) 
						include 'pushs/blog.php';
				?>
			</div>
		</div>
	</div>
	
	
	<?php
		$list_page = get_pages([
			'meta_key' => '_wp_page_template',
			'meta_value' => 'template-list-talks.php'
		]);
		if(count($list_page)!=0) { 
			?>
				<div class="row">
					<div class="col-md-12 read-more-wrapper read-more-wrapper-magazine">
						<a href="<?php echo get_permalink($list_page[0]->ID); ?>"class="read-more">
							<?php if (ICL_LANGUAGE_CODE == "fr"): ?>
								Tout le <strong>magazine digital</strong> 
							<?php else: ?>
								All the <strong>Digital magazine</strong> 
							<?php endif; ?>
							<br><img src="<?= get_template_directory_uri() ?>/img/plus.png" alt="">
						</a>
					</div>
				</div>
			<?php
		}
	?>


	<?php
	/*
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<a href="http://apax-talks.fr/<?php echo ICL_LANGUAGE_CODE; ?>/inscription/" target="_blank" class="show_all_list show_all_list_inline">
				<?php _e("Register for","apax"); ?>
				<?php _e("the","apax"); ?>
				<span><?php _e("newsletter","apax"); ?> APAX TALKS</span>
				<img src="<?php bloginfo("template_url"); ?>/img/link-more-list.png" alt="" />
			</a>
		</div>
	</div>
	*/
	?>

	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<a class="twitter-timeline" href="https://twitter.com/ApaxPartners_FR" data-chrome="nofooter transparent" data-lang="<?php echo ICL_LANGUAGE_CODE; ?>" data-widget-id="727102341355327488"><?php _e("Tweets of @ApaxPartners_FR","apax"); ?></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
