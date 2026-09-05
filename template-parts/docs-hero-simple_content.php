<?php

if (!wp_documentation_is_pro()) {
    return;
}
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<section class="mt-16">
  <div class="x-container flex flex-col items-start justify-start gap-4">
    <h1 class="mb-6 font-secondary text-4xl md:text-5xl lg:text-6xl font-medium tracking-tight text-frost-1000 leading-[1.1]">
      <?php echo !empty($title) ? esc_html( $title ) : esc_html__('WP Documentation', 'wp-documentation'); ?>
    </h1>

    <div class="text-lg text-frost-700">
      <?php echo !empty($description) ? wp_kses_post( $description ) : esc_html__('Explore our documentation to find the information you need.', 'wp-documentation'); ?>
    </div>
  </div>
</section>
