<?php
if (! defined('ABSPATH')) {
	exit;
}

get_header();
?>
<main class="tt-main">
	<section class="tt-section">
		<div class="tt-container">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<article <?php post_class('tt-page-content'); ?>>
						<h1 class="tt-fallback-title"><?php the_title(); ?></h1>
						<div class="tt-fallback-content">
							<?php the_content(); ?>
						</div>
					</article>
				<?php endwhile; ?>
			<?php else : ?>
				<p class="tt-fallback-content"><?php esc_html_e('Không tìm thấy nội dung.', 'ttshopgear-landing'); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
