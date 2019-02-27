<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<div id="logo-talks"></div>
				<h1 class="post-title"><?php single_term_title(); ?></h1>
			</div>
		</div>
	</div>
</div>

<?php
	$talks = new WP_Query([
		'post_type' => 'blog',
		'posts_per_page' => -1,
		'tax_query' => [[
			'taxonomy' => 'issues',
			'field'    => 'term_id',
			'terms'    => get_queried_object()->term_id
		]],
		'order' => "DESC",
		'orderby' => "date"
	]);
?>

<?php if ($talks->have_posts()): ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-md-10 col-md-offset-1" id="talks-list-current">
			<div class="row">

				<?php foreach($talks->posts as $k => $p) { ?>
					<div class="item <?= ($k%2==0) ?"item-left" :"item-right" ?>">
						<div class="row">
							<?php
							// detect if the is a yt embed
							$content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $p->post_content));
							global $the_flex_content;
							$the_flex_content = get_field("flex-content", $p->ID);
							ob_start();
							get_template_part("flex","content");
							$post_content = ob_get_contents();
							ob_end_clean();
							$re = '/src="https:\/\/www\.youtube\.com\/embed\//';
							$is_video = (preg_match_all($re, $post_content, $matches, PREG_SET_ORDER, 0) != 0);

							$img = get_the_post_thumbnail_url( $p, "talks_current" );
							?>
							<div class="wrap-image col-xs-12 col-md-5">
								<a href="<?= get_permalink($p->ID) ?>" class="hover-link"></a>
								<?php if ($is_video): ?>
									<span class="play-button"></span>
								<?php endif; ?>
								<span class="img"><span style="background-image: url('<?= $img ?>')"></span></span>
							</div>

							<div class="col-xs-12 <?= !empty($img)?'col-md-7':'' ?> <?= ($k%2==0) ?"col-md-offset-5" :"" ?>">
								<a href="<?= get_permalink($p->ID) ?>" class="hover-link"></a>

								<div class="wrap-content">
									<h3><?= $p->post_title ?></h3>
									<p><?php the_field("extrait", $p->ID); ?></p>
								</div>
								<?php
									$time = get_field("temps_lecture_blog", $p->ID);
									if(!empty($time))
										echo '<span class="time">'.$time.'MN</span>';
								?>
								<span class="date">
									<?= DateTime::createFromFormat('Y-m-d H:i:s', $p->post_date)->format('d.m.Y') ?>
								</span>
								<a href="<?= get_permalink($p->ID) ?>" class="link">
									<?php
										$cats = wp_get_post_terms( $p->ID, "talks_cat");
										if(empty($cats))
											_e("Lire la suite", "apax");
										else
											echo $cats[0]->name;
									?>
								</a>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
