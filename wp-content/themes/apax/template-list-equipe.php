<?php /* Template name: Liste équipe */ ?>
<?php
	wp_enqueue_script('list-filters', get_template_directory_uri() . '/js/list-filters.js', ["jquery", "adakaListMultiple"] );
	get_header();
?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php $sous_titre = get_field("sous-titre_page");
				if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>

				<?php
					echo '<div id="filter_wrap">';

					echo '<div id="filter_pole_wrap">';
					echo '<select id="filter_pole" data-placeholder="'.htmlentities(__("Activities", "apax")).'">';
					echo 	'<option value="">'.__("Activities", "apax").'</option>';
					foreach(get_field_object('field_5a3141f504b2c')['choices'] as $v) {
						echo 	'<option value="'.htmlentities($v).'">'.__($v, "apax").'</option>';
					}
					echo '</select>';
					echo '</div>';

					$current = isset($_GET['cat']) ?$_GET['cat'] :-1;
					$categories = get_terms('category','hide_empty=0&exclude=1,3');
					if ($categories && count($categories) > 0) {
						echo '<div id="filter_secteur_wrap">';
						echo '<select id="filter_secteur" data-placeholder="'.htmlentities(__("Sectors", "apax")).'">';
						echo 	'<option value="">'.__("Sectors", "apax").'</option>';
						foreach ($categories as $categorie){
							echo 	'<option value="cat-item-'.$categorie->term_id.'" '.($current==$categorie->term_id ?'selected' :'').'>'.$categorie->name.'</option>';
						}
						echo '</select>';
						echo '</div>';
					}

					$functions = get_field_object('field_5a3144b7507c5')['choices'];
					echo '<div id="filter_function_wrap">';
					echo '<select id="filter_function" data-placeholder="'.htmlentities(__("Functions", "apax")).'">';
					echo 	'<option value="">'.__("Functions", "apax").'</option>';
					foreach($functions as $k => $v) {
						echo 	'<option value="function-item-'.htmlentities($k).'">'.__($v, "apax").'</option>';
					}
					echo '</select>';
					echo '</div>';


					echo '</div>';
				?>
			</div>
		</div>
	</div>

	<?php $ele = get_posts("post_type=team&posts_per_page=-1&orderby=menu_order&order=ASC&suppress_filters=0");
	if (count($ele)): ?>

	<div class="grid row no-gutters list-no-gutters">

		<?php foreach ($ele as $e): ?>

		<?php
			$strCat = '';
			$cat = get_the_terms($e->ID, "category");
			if (is_array($cat)) {
				foreach ($cat as $c) {
					$strCat .= ($strCat==""?"":" ").'cat-item-'.$c->term_id;
				}
			}
		?>

		<div class="col-md-3 col-sm-6 col-xs-12 grid-item <?php echo $strCat; ?> function-item-<?php
			$function = get_field("function", $e->ID); // Return a keeeeyyyyyyy not the value label
			if(array_key_exists($function, $functions))
				echo $function;
		?>"
		data-poles="<?php implode(',', the_field("pole", $e->ID)); ?>">
			<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($e->ID), 'image-push' ); ?>
			<?php $poste_membre_equipe = get_field("poste_membre_equipe",$e->ID); ?>
			<a href="<?php echo get_permalink($e->ID); ?>" class="bloc-ele bloc-ele-equipe" style="<?php echo $thumb ? 'background-image: url('.$thumb[0].');' : ''; ?>">
				<?php echo $thumb ? '<img src="'.$thumb[0].'" alt="" />' : ''; ?>
				<span class="title">
				<?php if ($poste_membre_equipe != "" || $e->post_title != "") {
					// echo '<span class="name"><span>';
					echo $e->post_title != "" ? $e->post_title.'<br/>' : '';
					echo $poste_membre_equipe != "" ? $poste_membre_equipe : '';
					// echo '</span></span>';
				} ?>
				</span>
			</a>
		</div>
		<?php endforeach; ?>
	</div>

	<?php endif; ?>

	<div class="row">
		<div class="col-md-offset-3 col-md-3">
			<a href="<?php echo get_permalink(get_the_id_wpml(139)); ?>" class="show_all_list">
				<?php _e("All companies","apax"); ?>
				<?php _e("of our","apax"); ?>
				<span><?php _e("portfolio","apax"); ?></span><br/>
				<img src="<?php bloginfo("template_url"); ?>/img/link-more-list.png" alt="" />
			</a>
		</div>
		<div class="col-md-3">
			<a href="<?php echo get_permalink(get_the_id_wpml(5143)); ?>" class="show_all_list">
				<?php if (ICL_LANGUAGE_CODE != "it"): ?>
					<?php _e("See ","apax"); ?>
				<?php endif; ?>
				<span><?php _e("history","apax"); ?></span>
				<?php _e("of companies currently supported","apax"); ?><br/>
				<img src="<?php bloginfo("template_url"); ?>/img/link-more-list.png" alt="" />
			</a>
		</div>
	</div>

</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
