<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$title = !empty($args['title']) ? $args['title'] : get_field('title');
$language = !empty($args['language']) ? $args['language'] : get_field('language');
$code_snippet = !empty($args['code_snippet']) ? $args['code_snippet'] : get_field('code_snippet');
$enable_preview = !empty($args['enable_preview']) ? $args['enable_preview'] : get_field('enable_preview');
$default_state = !empty($args['default_state']) ? $args['default_state'] : get_field('default_state');

?>

<div 
    x-data="codeSnippet" 
    <?php if(!empty($language) && $language === 'html' && !empty($enable_preview) && !empty($default_state)): ?>
        data-default-state="<?php echo esc_attr($default_state); ?>"
    <?php endif; ?>
    class="w-full border-frost-300 bg-frost-0 border border-solid my-7 x-rounded-lg overflow-hidden">
    <div class="flex justify-start items-center w-full h-10 border-b border-frost-300 font-semibold">
        <div class="grow px-4 text-xs flex justify-start items-center gap-1.5">
            <?php echo wp_documentation_svg('brand-'.esc_html($language), 'w-4 h-4 inline-flex justify-center items-center'); ?>
            <span><?php echo esc_html($title); ?></span>
        </div>

        <button 
            x-copy 
            data-copy="<?php echo esc_html($code_snippet); ?>"
            class="w-auto px-4 gap-1 h-full flex justify-center items-center text-xs font-semibold border-l border-frost-300 hover:bg-frost-100 active:bg-frost-200 focus:outline-none focus:ring-2 focus:ring-frost-500 focus:ring-opacity-50 transition duration-150 ease-in-out" 
            type="button" 
            aria-label="<?php esc_attr_e('Copy to clipboard', 'wp-documentation'); ?>">
            <span class="w-4 h-4 inline-flex justify-center items-center">
                <?php echo wp_documentation_svg('copy'); ?>
            </span>
            <span class="sr-only"><?php esc_html_e('Copy to clipboard', 'wp-documentation') ?></span>
        </button>

        <?php if(!empty($language) && $language === 'html' && !empty($enable_preview)): ?>
            <button
                x-cloak
                x-on:click="togglePreview"
                x-show="isPreviewing"
                class="w-auto px-4 gap-1 h-full flex justify-center items-center text-xs font-semibold border-l border-frost-300 hover:bg-frost-100 active:bg-frost-200 focus:outline-none focus:ring-2 focus:ring-frost-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                <span class="w-4 h-4 inline-flex justify-center items-center">
                    <?php echo wp_documentation_svg('pencil'); ?>
                </span>
                <span class="sr-only"><?php esc_html_e('Preview', 'wp-documentation') ?></span>
            </button>

            <button
                x-cloak
                x-on:click="togglePreview"
                x-show="isEditing"
                class="w-auto px-4 gap-1 h-full flex justify-center items-center text-xs font-semibold border-l border-frost-300 hover:bg-frost-100 active:bg-frost-200 focus:outline-none focus:ring-2 focus:ring-frost-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                <span class="w-4 h-4 inline-flex justify-center items-center">
                    <?php echo wp_documentation_svg('eye'); ?>
                </span>
                <span class="sr-only"><?php esc_html_e('Preview', 'wp-documentation') ?></span>
            </button>
        <?php endif; ?>
        
    </div>

    <pre 
        <?php if(!empty($language) && $language === 'html' && !empty($enable_preview)): ?>
            x-cloak 
            x-show="isEditing"
        <?php endif; ?>
        class="!m-0 !p-0 w-full h-auto !border-0 !bg-frost-0"><code class="language-<?php echo esc_attr($language); ?>"><?php echo esc_html($code_snippet); ?></code></pre>

    <?php if(!empty($language) && $language === 'html' && !empty($enable_preview)): ?>
        <div class="not-prose" x-cloak x-show="isPreviewing">
            <?php wp_documentation_render_html($code_snippet); ?>
        </div>
    <?php endif; ?>
    
</div>
