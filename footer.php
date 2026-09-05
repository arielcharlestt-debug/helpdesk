<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_documentation
 *
 */

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
  $theme_options = wp_documentation_get_default_options();
};

$footer_logo = !empty($theme_options['footer_logo']['url']) ? $theme_options['footer_logo'] : null;

?>


</main><!-- #content -->

<div class="sr-only live-status-region" role="status"></div>

<footer class="mt-16 border-t-1 bg-frost-1000 text-frost-0 border-frost-300 border-dashed">
  <div class="x-container flex flex-col !md:justify-between !md:items-center !md:flex-row py-8 gap-8">
    <a href="<?php echo esc_url(home_url()); ?>" class="w-40 sm:w-80 py-2 pr-4">
      <?php if($footer_logo): ?>
        <span class="h-20 sm:h-14 flex justify-start items-center">
          <img
            src="<?php echo esc_url($footer_logo['url']); ?>"
            alt="<?php echo esc_attr(!empty($footer_logo['alt']) ? $footer_logo['alt'] : get_bloginfo('name')); ?>"
            class="h-auto w-auto max-w-full max-h-[90%]" />
        </span>
      <?php elseif(has_custom_logo()): ?>
        <span class="h-20 sm:h-14 flex justify-start items-center">
          <?php get_template_part('template-parts/header-logo'); ?>
        </span>
      <?php else: ?>
        <span class="flex justify-start items-start flex-col gap-2">
          <span class="text-lg sm:text-3xl text-frost-0 font-secondary"><?php echo get_bloginfo('name'); ?></span>
        </span>
      <?php endif; ?>
    </a>

    <?php
      wp_nav_menu(array(
        'theme_location' => 'footer',
        'container' => 'nav',
        'container_class' => 'footer',
        'menu_class' => 'w-full flex justify-end gap-8 font-medium ml-auto flex-col !sm:flex-row',
        'menu_id' => '',
        'fallback_cb' => false,
        'container_aria_label' => 'Footer',
      ));
    ?>
  </div>

  <div class="x-container">
    <div class="w-full py-8 border-t-1 border-frost-300 border-solid">
      <p class="text-sm text-frost-0">
        <?php echo wp_documentation_get_footer_notice(); ?>
      </p>
    </div>
  </div>

  <?php get_template_part('template-parts/toast'); ?>
  <?php get_template_part('template-parts/lightbox'); ?>

</footer>

</div><!-- #page -->


<?php

if(function_exists('fast_fuzzy_search_get_template_part')) {
  $options = get_option('fast_fuzzy_search_options');
  fast_fuzzy_search_get_template_part('template-parts/search-panel', null, ['is_inline' => true, 'options' => $options]);
};

?>

<?php wp_footer(); ?>

</body>

</html>