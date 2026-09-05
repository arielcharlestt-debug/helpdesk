<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<section class="mt-20">
  <div class="x-container flex flex-col items-start justify-start gap-4">
    <?php if (!empty($title)): ?>
        <h1 class="text-4xl font-medium text-frost-900">
            <?php echo esc_html($title); ?>
        </h1>
    <?php endif; ?>

    <?php if (!empty($description)): ?>
        <div class="text-base text-frost-700 mt-1">
            <?php echo wp_kses_post( $description ); ?>
        </div>
    <?php endif; ?>
  </div>
</section>
