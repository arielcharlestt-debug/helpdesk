<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (isset($args)) {
    extract($args);
}

?>

<section class="wp_documentation_empty-state">
  <div class="wp_documentation_empty-state__svg">
    <?php echo wp_documentation_svg('misc/empty-state'); ?>
  </div>

  <p class="wp_documentation_empty-state__title" role="status">
    <?php echo esc_attr($title) ?: __('Nothing found', 'wp-documentation'); ?>
  </p>
</section>