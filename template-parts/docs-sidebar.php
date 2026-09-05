<?php

if (!defined('ABSPATH')) {
    exit;
}

if ($args) {
    extract($args);
}

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}
$color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

$active_color = $color_style === 'neutral' ? 'frost' : 'primary';
$level = isset($level) ? $level : 1;
?>

<div data-simplebar class="docs-sidebar <?php echo !empty($class) ? $class : ''; ?>">
  <ul class="text-lg sm:text-base flex flex-col gap-4">
    <?php foreach ($documents as $index => $document): ?>
      <?php 
        $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID())));
      ?>

      <li 
        data-is-current="<?php echo esc_attr($is_current ? 'true' : 'false'); ?>"
        x-data="docsSidebarItem">
        <div class="flex justify-between items-center gap-2">
          <a class="font-bold grow hover:text-primary" href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
            <?php get_template_part('template-parts/docs-link-label', null, ['document' => $document]); ?>
          </a>

          <?php if (!empty($document['children'])): ?>
            <button 
              x-on:click="toggleExpanded" 
              class="inline-flex w-6 h-6 justify-center items-center shrink-0">
              <span x-show="isNotExpanded" x-cloak>
                <span class="sr-only">
                  <?php echo esc_html__('Expand', 'wp-documentation'); ?> <?php echo esc_html($document['title']); ?>
                </span>
                <?php echo wp_documentation_svg('chevron-right'); ?>
              </span>
              <span x-show="isExpanded" x-cloak>
                <span class="sr-only">
                  <?php echo esc_html__('Collapse', 'wp-documentation'); ?> <?php echo esc_html($document['title']); ?>
                </span>
                <?php echo wp_documentation_svg('chevron-down'); ?>
              </span>
            </button>
          <?php endif; ?>
        </div>

        <?php if (!empty($document['children'])): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 2]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>