<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$title = get_field('title');
$expanded = get_field('expanded');
$panel = get_field('panel');

$block_id = isset($block['id']) ? esc_attr($block['id']) : uniqid('collapse-');

?>
<div 
    class="wpd-collapse-block bg-frost-0 border border-frost-300 my-8" 
    x-data="collapse" 
    data-default-state="<?php echo esc_attr($expanded ? 'true' : 'false'); ?>"
    id="<?php echo esc_attr($block_id); ?>">
    <button 
        type="button" 
        class="w-full flex justify-between items-center px-4 py-3 font-semibold text-left hover:underline focus:outline-none" 
        x-on:click="toggle" 
        x-bind:aria-expanded="expanded" 
        aria-controls="panel-<?php echo esc_attr($block_id); ?>">
        <span><?php echo esc_html($title); ?></span>
        <span x-show="isNotExpanded" x-cloak>
            <?php echo wp_documentation_svg('chevron-down'); ?>
        </span>
        <span x-show="expanded" x-cloak>
            <?php echo wp_documentation_svg('chevron-up'); ?>
        </span>
    </button>

    <?php if(!empty($panel)): ?>
        <div x-show="expanded" x-collapse class="px-4 pb-4" id="panel-<?php echo esc_attr($block_id); ?>">
            <?php foreach ($panel as $key => $layout): ?>
                <?php if($layout['acf_fc_layout'] === 'content'): ?>
                    <?php echo wp_kses_post($layout['content']); ?>
                <?php elseif($layout['acf_fc_layout'] === 'code_snippet'): ?>
                    <?php get_template_part('template-parts/blocks/code-snippet', null, $layout); ?>
                <?php elseif($layout['acf_fc_layout'] === 'callout'): ?>
                    <?php get_template_part('template-parts/blocks/callout', null, $layout['callout']); ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
