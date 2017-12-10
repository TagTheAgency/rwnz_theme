<?php get_header(); ?>
<?php 
$page_colour = get_post_meta(get_the_ID(), 'page-colour-theme', true);
$header_content = get_the_excerpt();
?>

<div class="clear">
<?php woocommerce_content(); ?>
</div>

<?php get_footer(); ?>
