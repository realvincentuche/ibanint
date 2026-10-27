<?php
/**
 * Homepage.
 *
 * @package Ibanint
 */

get_header();
?>

<section class="section hero">
	<div class="wrap">
		<h1 class="hero-title"><?php bloginfo( 'name' ); ?></h1>
		<p class="hero-text"><?php bloginfo( 'description' ); ?></p>
	</div>
</section>

<?php get_template_part( 'template-parts/dynamic', 'content' ); ?>

<?php
get_footer();
