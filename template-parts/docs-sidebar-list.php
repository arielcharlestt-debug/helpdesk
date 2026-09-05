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

?>


<?php if(!empty($documents)): ?>
  <ul
    x-cloak
    x-collapse 
    x-show="expanded"
    class="mt-2 flex flex-col text-base sm:text-base <?php echo isset($level) && $level > 2 ? 'pl-4' : ''; ?>">
    <?php foreach ($documents as $index => $document): ?>
      <?php 
        $is_current = is_singular('docs') && (get_the_ID() === $document['ID'] || in_array($document['ID'], get_post_ancestors(get_the_ID()))); 
      ?>

      <li 
        class="w-full" 
        x-data="docsSidebarItem"
        data-is-current="<?php echo esc_attr($is_current ? 'true' : 'false'); ?>">
        <div class="w-full flex justify-start items-center gap-2">
          <a 
            class="grow block pl-4 py-2 border-solid text-base border-l-2 border-frost-300 x-rounded-lg rounded:border-none sm:text-base hover:bg-frost-100 <?php echo empty($document['children']) ? 'current:text-primary current:bg-primary-50 current:font-semibold current:border-primary current:border-l-2 current:neutral:border-frost-1000 current:neutral:text-frost-1000' : ''; ?>" 
            <?php if ($is_current): ?>
              aria-current="page"
            <?php endif; ?>
            href="<?php echo esc_attr($document['permalink']); ?>">
            <?php echo esc_html($document['title']); ?>
            <?php get_template_part('template-parts/docs-link-label', null, ['document' => $document]); ?>
          </a>

          <?php if (!empty($document['children'])): ?>
            <button 
              x-on:click="toggleExpanded" 
              class="inline-flex w-6 h-6 justify-center items-center shrink-0">
              <span x-show="isNotExpanded" x-cloak>
                <?php echo wp_documentation_svg('chevron-right'); ?>
              </span>
              <span x-show="isExpanded" x-cloak>
                <?php echo wp_documentation_svg('chevron-down'); ?>
              </span>
            </button>
          <?php endif; ?>
        </div>

        <?php if (!empty($document['children'])): ?>
          <?php get_template_part('template-parts/docs', 'sidebar-list', ['documents' => $document['children'], 'level' => isset($level) ? $level + 1 : 1]); ?>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>