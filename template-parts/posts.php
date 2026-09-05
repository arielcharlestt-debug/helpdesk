<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


?>

<div class="x-container my-16">
    <div class="w-full grid 2xl:grid-cols-3 lg:grid-cols-2 gap-12 my-12">
        <?php foreach ($args['posts'] as $key => $post): ?>
            <?php setup_postdata($post); ?>
            <?php get_template_part('template-parts/post-card', 'default'); ?>
        <?php endforeach; ?>
    </div>
</div>