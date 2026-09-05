<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$panels = get_field('panels');

if (!$panels || !is_array($panels)) {
    return;
}

$id = !empty($block['id']) ? $block['id'] : 'code-snippet-tabs-' . uniqid();

?>

<section class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
    <?php foreach ($panels as $index => $panel): ?>
        <?php get_template_part('template-parts/blocks/code-snippet', null, $panel); ?>
    <?php endforeach; ?>
</section>