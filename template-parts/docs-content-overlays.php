<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_documentation
 */

if ($args) {
	extract($args);
}

$author_id = get_the_author_meta('ID');

?>


<div 
    x-show="showSidebar"
    x-trap="showSidebar" 
    x-cloak 
    x-on:click.away="hideSidebar"
    x-on:keydown.escape="hideSidebar"
    xyz="fade left-5 duration-2"
    x-transition:enter="xyz-in"
    x-transition:leave="xyz-out"
    data-simplebar
    class="!fixed z-[1500] bg-frost-50 px-6 py-8 top-0 left-0 w-96 bottom-0 h-screen admin-bar:top-[46px] border border-frost-300">
    <div class="w-full flex justify-end items-center mb-4">
        <button 
            x-on:click.prevent="hideSidebar"
            class="w-6 h-6 inline-flex justify-center items-center text-frost-600">
            <span x-cloak>
                <?php echo wp_documentation_svg('x'); ?>
            </span>
        </button>
    </div>
    <?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => 'w-full shrink-0 overflow-y-scroll lg:pr-10']); ?>
</div>