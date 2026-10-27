<?php
/**
 * Generic interior page (Privacy Policy, Terms of Use, custom pages).
 *
 * @package Ibanint
 */

get_header();

set_query_var( 'ibanint_banner_title', get_the_title() );
set_query_var( 'ibanint_banner_image', '' );
set_query_var( 'ibanint_banner_sub', '' );
get_template_part( 'template-parts/page-banner' );
?>

<?php
while ( have_posts() ) :
	the_post();
	?>
	<section class="ib-page-body">
		<div class="ib-wrap">
			<div class="ib-prose">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
<?php endwhile; ?>

<?php
get_footer();
