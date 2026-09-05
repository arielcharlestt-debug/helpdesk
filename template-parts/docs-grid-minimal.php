<?php

if (!wp_documentation_is_pro()) {
    return;
}

if ($args) {
  extract($args);
}

?>


<section id="grid" class="x-container mt-8"> 
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-y-8 gap-x-16">
    <?php foreach ($documents as $index => $document): ?>
      <?php get_template_part('template-parts/docs-card', 'minimal', ['document' => $document]); ?>
    <?php endforeach; ?>
  </div>
</section>
