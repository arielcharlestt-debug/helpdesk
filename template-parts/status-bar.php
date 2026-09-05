<?php

if (!defined('ABSPATH')) {
    exit;
}

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}

if (empty($theme_options['status_bar_enabled'])) {
    return;
}

$messages = !empty($theme_options['status_bar_messages']) ? $theme_options['status_bar_messages'] : [];

if (empty($messages)) {
    return;
}

$total = count($messages);
$duration = !empty($theme_options['status_bar_duration']) ? (int) $theme_options['status_bar_duration'] * 1000 : 5000;
$dismissible = !empty($theme_options['status_bar_dismissible']);

?>

<div
    x-data="statusBar"
    x-show="isNotDismissed"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 -translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-full"
    data-total="<?php echo esc_attr($total); ?>"
    data-duration="<?php echo esc_attr($duration); ?>"
    x-on:mouseenter="pause"
    x-on:mouseleave="resume"
    class="relative w-full bg-primary text-frost-0 text-sm z-[1002] print:hidden"
    role="status"
    aria-live="polite">

    <div class="x-container flex items-center justify-center py-2">

        <div class="grow flex items-center justify-center !text-xs font-semibold overflow-hidden">
            <?php foreach ($messages as $index => $message): ?>
                <?php $content = !empty($message['content']) ? $message['content'] : ''; ?>
                <?php $link = !empty($message['link']) ? $message['link'] : []; ?>

                <div
                    x-cloak
                    x-show="isActive"
                    data-index="<?php echo esc_attr($index); ?>"
                    class="flex items-center gap-2 px-4 text-center">

                    <?php if (!empty($link['url'])): ?>
                        <a
                            href="<?php echo esc_url($link['url']); ?>"
                            target="<?php echo esc_attr(!empty($link['target']) ? $link['target'] : '_self'); ?>"
                            class="text-primary-foreground no-underline">
                            <?php echo wp_kses_post($content); ?>
                        </a>
                    <?php else: ?>
                        <span><?php echo wp_kses_post($content); ?></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($dismissible): ?>
            <button
                x-on:click="dismiss"
                class="shrink-0 ml-2 inline-flex items-center justify-center w-6 h-6 rounded hover:bg-primary-100/20 transition-colors"
                aria-label="<?php esc_attr_e('Dismiss', 'wp-documentation'); ?>">
                <?php echo wp_documentation_svg('x'); ?>
            </button>
        <?php endif; ?>

    </div>
</div>
