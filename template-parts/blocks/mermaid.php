<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$title = get_field('title');
$diagram_code = get_field('diagram_code');

if (!$diagram_code) {
    return;
};

?>

<div 
    x-data="mermaid"
    data-id="<?php echo esc_attr(sanitize_title($title)); ?>" 
    class="w-full border-frost-300 bg-frost-0 text-frost-900 border border-solid my-8">
    <?php if ($title): ?>
        <div class="flex justify-start items-center gap-2 px-4 py-3 border-b border-frost-300 font-semibold text-xs">
            <span><?php echo esc_html($title); ?></span>
            <div class="ml-auto flex justify-end items-center gap-4">
                <button x-on:click="download" class="w-4 h-4 inline-flex justify-center items-center">
                    <?php echo wp_documentation_svg('download'); ?>
                </button>
                <button x-on:click="zoom" class="w-4 h-4 inline-flex justify-center items-center">
                    <?php echo wp_documentation_svg('zoom-in'); ?>
                </button>
            </div>
        </div>
    <?php endif; ?>
    <div class="p-4 overflow-hidden">
        <pre x-zoom x-ref="mermaid" xyz="fade small-5 duration-2" class="relative z-10 !bg-frost-0 !m-0 !p-0 w-full h-auto !border-0"><?php echo esc_html($diagram_code); ?></pre>
    </div>
</div>

<div 
    class="mermaidLightbox fixed z-[1010] w-full h-full left-0 right-0 top-0 bottom-0 flex justify-center items-center bg-frost-0 p-4"
    style="display: none;">
    <button class="close absolute z-30 top-0 right-0 inline-flex justify-center items-center bg-frost-0 border border-frost-300 w-12 h-12 p-3">
        <?php echo wp_documentation_svg('x'); ?>
    </button>
</div>
