<?php
wp_enqueue_script( 'page-home', get_template_directory_uri() . '/js/page-home.js', ["jquery"]);
get_header();
?>
<?php $video = get_field("video_home");
$image_video = get_field("image_attente_video");
if ($video): ?>
<video autoplay="true" class="bgvid" muted loop="true"<?php echo $image_video? ' poster="'.$image_video["url"].'"':''; ?>><source src="<?php echo $video["url"]; ?>" type="video/mp4" /></video>
<?php endif; ?>

<?php echo $image_video ? '<div class="bgvid" style="background-image: url('.$image_video["url"].');"></div>':''; ?>


<div id="home_slider_accroche">
	<img src="<?= get_template_directory_uri() ?>/img/logo-white.svg" alt="APAX Partner" id="logo-home-slider">
	<?php $fix = get_field("slider_txt_fixe"); ?>
	<?php if(!empty($fix)) { ?>
		<div class="fix"><?= $fix ?></div>
	<?php } ?>
	<?php $moved = get_field("slider_txt_move"); ?>
	<?php if(!empty($moved)) { ?>
		<div class="slider">
			<?php foreach($moved as $m) { ?>
				<div><?= $m['texte'] ?></div>
			<?php } ?>
		</div>
		<div class="pager"></div>
	<?php } ?>
	<?php
	$lien = get_field("lien");
	$texte_lien = get_field("texte_lien");
	if(!empty($lien) && !empty($texte_lien)) {
		echo '<a href="'.$lien.'"><span>'.$texte_lien.'<span></a>';
	}
	?>
</div>


<?php
$actus =  new WP_Query([
	'post_type' => 'post',
	'posts_per_page' => 3,
	'order' => "DESC",
	'orderby' => "date"
]);
$bloc_perso = get_field('list_bloc_slider_actu', 'apax_talks_home_'.ICL_LANGUAGE_CODE);
?>
<div class="wrap-container talks-list" id="apax-talks-home">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8" id="home_first_blocks_left">
				<div class="row">
					<?php 
                        foreach($bloc_perso as $k => $p) {
							$list_bloc = [$p];
							echo '<div class="col-xs-12 col-sm-12 col-md-6"><div class="item '.(($k==1) ?'active' :'').'">';
							ob_start();
							include "flex-content-bottom.php";
							$html = ob_get_clean();
							$html = str_replace('class="col-bloc_image_texte col-md-4 col-xs-12"', 'class="col-bloc_image_texte"', $html);
							echo $html;
							echo '</div></div>';
							
							if($k%2==1)
								echo '<div class="clear"></div>';
					    }
                    ?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4" id="home_first_blocks_right">
				<?php if($actus->have_posts()) { ?>
					<div id="actualites">
						<h3>
							<a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">
								<?php _e("News", "apax"); ?>
							</a>
						</h3>
						<div class="actualites-slider">
							<?php foreach($actus->posts as $p) { ?>
								<div class="item no-hover">
									<?php
									$img = get_the_post_thumbnail_url( $p, "talks_current" );
									if(!empty($img)) { ?>
										<div class="image" style="background-image: url('<?= $img ?>')"></div>
									<?php } ?>
									<div class="bg">
										<div class="wrap-content">
											<h3><a href="<?= get_permalink($p->ID) ?>"><?= $p->post_title ?></a></h3>
											<?php $lieu_date = get_field("lieu_date", $p->ID); ?>
											<?php if(!empty($lieu_date)) { ?>
												<p class="lieu"><?= $lieu_date; ?></p>
											<?php } ?>
											<p><?php the_field("extrait", $p->ID); ?></p>
										</div>
									</div>
									<a href="<?= get_permalink($p->ID) ?>" class="hover-link"></a>
								</div>
							<?php } ?>
						</div>
						<?php if(count($actus->posts) != 1) { ?>
							<div class="clear"></div>
							<div class="prev"></div>
							<div class="next"></div>
							<div class="pager"></div>
							<div class="clear"></div>
						<?php } ?>
					</div>
				<?php } ?>

				<div id="home-twitter">
					<h3><?php _e("Tweets", "apax"); ?></h3>
					<div class="overflow">
						<?php
							echo translate_tweeter_plugin(do_shortcode('[custom-twitter-feeds]'));
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="wrap-container" id="apax-pres">
	<div class="container">
		<div class="row">
			<?php $titre_sous_video = get_field("titre_sous_video");
			$sous_titre_sous_video = get_field("sous-titre_sous_video");
			if ($titre_sous_video != "" || $sous_titre_sous_video != ""): ?>

			<?php echo $titre_sous_video != "" ? '<h2>'.$titre_sous_video.'</h1>' : ''; ?>
				<?php echo $sous_titre_sous_video != "" ? '<div class="baseline">'.$sous_titre_sous_video.'</div>' : ''; ?>

			<?php endif; ?>

			<?php $list_bloc = get_field("list_bloc_sous_video");
			if ($list_bloc): ?>
			<div class="wrap-block">
				<?php include "flex-content-bottom.php"; ?>
				<div class="clear"></div>
			</div>
		<?php endif; ?>

		<?php $lien_sous_video = get_field("lien_sous_video");
		$titre_lien_sous_video = get_field("titre_lien_sous_video");
		if ($lien_sous_video != "" && $titre_lien_sous_video != ""): ?>
		<div class="center">
			<a href="<?php echo $lien_sous_video; ?>" class="link-arrow"><?php echo $titre_lien_sous_video; ?></a>
		</div>
	<?php endif; ?>
</div>
</div>
</div>

<div class="wrap-container wrap-container-grey">
	<div class="container">
		<h2 class="blue"><?php _e("ENTREPRENEURS CURRENTLY SUPPORTED","apax"); ?></h1>
			<div class="baseline baseline-short-margin"><?php _e("4 areas of specialisation","apax"); ?></div>
		</div>
	</div>

	<?php $args = array(
		"hide_empty" => 0,
		"title_li" => "",
		"exclude" => array(1)
	);
	$category = get_categories($args);
	if ($category && count($category)>0): ?>
	<div class="wrap-list-click">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<ul class="bt-click">
						<?php $randomEntr = array(); foreach ($category as $k=>$c){

							$tmpEntr = get_posts("post_type=societe&posts_per_page=1&orderby=rand&category=".$c->term_id);
							if (count($tmpEntr) > 0) {
								$randomEntr[$c->term_id] = $tmpEntr[0];
								echo '<li><a href="'.get_permalink(get_the_id_wpml(139)).'?cat='.$c->term_id.'"'.($k==0?' class="active"':'').' id="bt-click-entre'.$c->term_id.'">'.str_replace("&amp;","&amp;<br/>",$c->name).'</a></li>';
							}
						} ?>
					</ul>

					<div id="slide-entrepreneur">
						<?php foreach ($randomEntr as $idcat=>$r) {
							$thumb = get_the_post_thumbnail_url( $r->ID, 'bloc_image_full' );
							$nom_entrepreneur_societe = get_field("nom_entrepreneur_societe",$r->ID);
							$statut_entrepreneur_societe = get_field("statut_entrepreneur_societe",$r->ID);
							if ($thumb) {
								echo '<div class="block-entrepreneur" data-click="entre'.$idcat.'">
								<a href="'.get_permalink($r->ID).'" class="bloc-ele" style="background-image: url('.$thumb.');">
								<img src="'.$thumb.'" alt="'.$r->post_title.'" />
								<span class="title">'.$r->post_title.'</span>';
								if ($statut_entrepreneur_societe != "" || $nom_entrepreneur_societe != "") {
									echo '<span class="name"><span>';
									echo $nom_entrepreneur_societe != "" ? $nom_entrepreneur_societe.'<br/>' : '';
									echo $statut_entrepreneur_societe != "" ? $statut_entrepreneur_societe : '';
									echo '</span></span>';
								}
								echo '</a>
								</div>';
							}
						} ?>
						<?php /*<div class="block-entrepreneur">
						<a href="<?php echo get_permalink(get_the_id_wpml(139)); ?>" class="bloc-ele" style="background-image: url(<?php bloginfo("template_url"); ?>/img/Push-entrepreneurs-<?php echo ICL_LANGUAGE_CODE; ?>.gif);">
						<img src="<?php bloginfo("template_url"); ?>/img/Push-entrepreneurs-<?php echo ICL_LANGUAGE_CODE; ?>.gif" alt="" />
						</a>
						</div> */ ?>
						<a href="#" id="prev-slide-entrepreneur"><?php _e("Previous","apax"); ?></a>
						<a href="#" id="next-slide-entrepreneur"><?php _e("Next","apax"); ?></a>
						<!-- <div id="wrap-progress-slide-entrepreneur"><div id="progress-slide-entrepreneur"></div></div> -->
						<div id="pager-cycle-entrepreneur"></div>
					</div>

					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="wrap-container wrap-container-grey">
	<div class="container">
		<div class="center center-padding">
			<a href="<?php echo get_permalink(get_the_id_wpml(139)); ?>" class="link-arrow"><?php _e("All entrepreneurs","apax"); ?></a>
		</div>
	</div>
</div>


<?php $titre_val = get_field("titre_list_images_home");
$sous_titre_val = get_field("sous-titre_list_images_home");
if ($titre_val != "" || $sous_titre_val != ""): ?>
<div class="wrap-container">
	<div class="container">
		<?php echo $titre_val != "" ? '<h2 class="blue2 blue-text">'.$titre_val.'</h2>' : ''; ?>
		<?php echo $sous_titre_val != "" ? '<div class="baseline baseline-short-margin">'.$sous_titre_val.'</div>' : ''; ?>
	</div>
</div>
<?php endif; ?>

<?php $list_3images = get_field("list_images_home");
if ($list_3images): ?>
<div class="wrap-container wrap-container-grey wrap-container-nopadding">
	<div class="container">
		<div class="wrap-block wrap-block-little">
			<div class="row">
				<?php foreach ($list_3images as $l3i){
					$image = $l3i["image"];
					$link = $l3i["lien"];
					$blank = is_array($l3i["blank"]);
					if ($image) {

						echo '
						<div class="col-md-4 col-xs-12">
						<a'.($link != "" ? ' href="'.$link.'"'.($blank ? ' target="_blank"' : '') : '').' class="block-push">
						<span class="wrap-content-full-img" style="background-image: url('.$image["sizes"]["bloc-3-home"].');">
						<img src="'.$image["sizes"]["bloc-3-home"].'" alt="'.$image["alt"].'" />
						</span>
						</a>
						</div>';
					}
				} ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
