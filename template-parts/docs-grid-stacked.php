<?php

if (!wp_documentation_is_pro()) {
    return;
}

if ($args) {
  extract($args);
}

?>

<section id="grid" class="x-container mt-8"> 
  <div class="grid grid-cols-1 gap-8">
    <?php foreach ($documents as $index => $document): $color = $colors[$index % count($colors)]; ?>
      <?php get_template_part('template-parts/docs-card', 'list', ['document' => $document, 'color' => $color]); ?>
    <?php endforeach; ?>
  </div>
</section>