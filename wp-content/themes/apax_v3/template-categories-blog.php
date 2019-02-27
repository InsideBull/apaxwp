<?php /* Template name: Liste categorie blog */ ?>
<?php get_header(); ?>

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
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="wrap-block wrap-block-blog">

			<?php $id_cat_blog = get_field("id_cat_blog");
			if ($id_cat_blog && $id_cat_blog != "") {
				$list_id_blog = array();
				$lst_art = json_decode(file_get_contents(URL_WP_API_BLOG_ARTICLE.'?categories-api='.$id_cat_blog.'&per_page=100&lang='.ICL_LANGUAGE_CODE),true);
				if ($lst_art) {
					foreach ($lst_art as $la) {
						$list_id_blog[$la["id"]] = $la;
					}
				}
				foreach ($list_id_blog as $id_blog=>$blog) include 'pushs/blog.php';
			} ?>

			</div>
		</div>
	</div>

</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
