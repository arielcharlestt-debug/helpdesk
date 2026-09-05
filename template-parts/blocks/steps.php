<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$steps = !empty($args['steps']) ? $args['steps'] : get_field('steps');
$block_id = isset($block['id']) ? esc_attr($block['id']) : uniqid('steps-');

?>

<div class="w-full flex flex-col gap-8 mt-8 mb-4" id="<?php echo esc_attr($block_id); ?>">
    <?php foreach ($steps as $index => $step): ?>
        <div class="w-full flex flex-col justify-start items-start sm:flex-row gap-8">
            <div class="shrink-0 flex justify-start items-start mt-0.5">
                <span class="shrink-0 inline-flex justify-center items-center w-8 h-8 rounded-full bg-primary text-white font-bold">
                    <?php echo esc_html($index + 1); ?>
                </span>
            </div>
            <div class="w-full grow">
                <div class="wpd-step-header">
                    <h3 class="!m-0"><?php echo esc_html($step['title']); ?></h3>
                    <?php if (!empty($step['icon'])): ?>
                        <span class="wpd-step-icon"><?php echo wp_documentation_svg($step['icon']); ?></span>
                    <?php endif; ?>
                </div>

                <?php if(!empty($step['panel'])): ?>
                    <div class="w-full" id="panel-<?php echo esc_attr($block_id); ?>">
                        <?php foreach ($step['panel'] as $key => $layout): ?>
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
        </div>
    <?php endforeach; ?>
</div>