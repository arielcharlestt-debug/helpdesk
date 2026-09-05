<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<section id="grid" class="x-container mt-16"> 
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-card', 'default', ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</section>
