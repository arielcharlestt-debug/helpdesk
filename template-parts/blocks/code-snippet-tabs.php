<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$tabs = get_field('tabs'); // Expecting ACF repeater: tabs (title, language, code_snippet)

if (!$tabs || !is_array($tabs)) {
    return;
}

$id = !empty($block['id']) ? $block['id'] : 'code-snippet-tabs-' . uniqid();

?>

<div 
    x-data="tabs"
    id="<?php echo esc_attr($id); ?>"
    data-selected-tab="<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tabs[0]['title'])); ?>" 
    class="w-full border-frost-300 bg-frost-0 border border-solid my-7" x-data="tabs()">
    <div class="flex justify-start items-center w-full border-b border-frost-300 font-semibold">
        <div 
            <?php if(count($tabs) > 3): ?>
                data-simplebar 
            <?php endif; ?>
            class="grow self-stretch flex gap-1 text-xs whitespace-nowrap">
            <?php foreach ($tabs as $i => $tab): ?>
                <a
                    href="#<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                    data-tab-id="<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                    class="inline-flex h-10 justify-center items-center gap-1 px-3 py-1.5 text-xs font-semibold transition !text-frost-600 bg-transparent !no-underline aria-selected:border-b-2 aria-selected:border-primary aria-selected:font-bold !aria-selected:text-frost-1000 !hover:bg-frost-100"
                    x-bind:aria-selected="isActive"
                    x-on:click="selectTab"
                >
                    <?php echo wp_documentation_svg('brand-'.$tab['language'], 'w-4 h-4 inline-flex justify-center items-center'); ?>
                    <?php echo esc_html($tab['title']); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php foreach ($tabs as $i => $tab): ?>
            <button
                x-copy
                x-cloak
                x-show="isActive"
                data-tab-id="<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                data-copy="<?php echo esc_html($tab['code_snippet']); ?>"
                class="w-auto px-4 gap-1 h-full flex justify-center items-center text-xs font-semibold border-l border-frost-300 hover:bg-frost-100 active:bg-frost-200 focus:outline-none focus:ring-2 focus:ring-frost-500 focus:ring-opacity-50 transition duration-150 ease-in-out"
                type="button"
                aria-label="<?php esc_attr_e('Copy to clipboard', 'wp-documentation'); ?>">
                <span class="w-4 h-4 inline-flex justify-center items-center shrink-0">
                    <span x-show="isNotCopied" class="inline-flex"><?php echo wp_documentation_svg('copy'); ?></span>
                    <span x-show="isCopied" class="inline-flex" x-cloak> <?php echo wp_documentation_svg('check'); ?> </span>
                </span>
                <span x-show="isNotCopied" class="sr-only"> <?php esc_html_e('Copy to clipboard', 'wp-documentation') ?> </span>
                <span x-show="isCopied" class="sr-only" x-cloak> <?php esc_html_e('Copied!', 'wp-documentation') ?> </span>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="w-full">
        <?php foreach ($tabs as $i => $tab): ?>
            <div 
                id="<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                data-tab-panel
                data-tab-title="<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                data-tab-id="<?php echo esc_attr($id); ?>-<?php echo esc_attr(sanitize_title($tab['title'])); ?>"
                x-show="isActive" 
                x-cloak>
                <pre class="!m-0 !p-0 w-full h-auto !border-0"><code class="language-<?php echo esc_attr($tab['language']); ?> hljs"><?php echo esc_html($tab['code_snippet']); ?></code></pre>
            </div>
        <?php endforeach; ?>
    </div>
</div>