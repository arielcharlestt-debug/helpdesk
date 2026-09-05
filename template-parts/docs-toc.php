
<?php

if (!defined('ABSPATH')) {
    exit;
}

if ($args) {
    extract($args);
}

if(!$toc) {
  return;
};

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}
$color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

$toc_class = $color_style === 'branded' ? 'wp_documentation_toc toc--branded' : 'wp_documentation_toc';

?>

<div 
  data-simplebar 
  class="<?php echo esc_attr($toc_class); ?> w-72 h-screen py-8 lg:pl-10 self-start text-left !sticky top-0 overflow-y-scroll hidden xl:block">
  
  
  <?php echo wp_kses_post($toc); ?>

  <a 
    class="inline-flex mt-8 text-sm font-semibold justify-center items-center whitespace-nowrap" href="#header">
    <?php esc_html_e('Back to top', 'wp-documentation'); ?>
    <span class="inline-block ml-2 w-4 h-4"><?php echo wp_documentation_svg('arrow-up'); ?></span>
  </a>
</div>