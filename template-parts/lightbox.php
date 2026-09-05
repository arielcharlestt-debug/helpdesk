<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>

<div 
    x-cloak
    x-data="lightbox" 
    class="fixed z-[1010] w-full h-full left-0 right-0 top-0 bottom-0" 
    id="lightbox"
    x-show="isVisible">
    <div x-on:click="hide" class="absolute bg-black/50 w-full h-full"></div>
    <button x-on:click="hide" class="absolute z-30 top-0 right-0 inline-flex justify-center items-center bg-frost-0 border border-frost-300 w-12 h-12 p-3"><?php echo wp_documentation_svg('x'); ?></button>
    
    <div
        x-on:keydown.escape.window="hide"
        class="embla h-screen relative z-10"
        xyz="fade small-5 duration-2">

        <div
            class="flex w-full !h-full pointer-events-none">
            <template 
                x-for="(image, index) in images"
                x-bind:key="index">
                <div class="group basis-full shrink-0 grow-0 !h-full flex justify-center items-center">
                    <img
                        x-zoom
                        x-bind:data-index="index"
                        x-bind:src="src"
                        x-bind:alt="alt"
                        class="w-auto h-auto max-w-full max-h-full pointer-events-auto"
                    >
                </div>
            </template>
        </div>

        <div class="z-20 w-full h-auto flex justify-start items-center absolute bottom-0 left-0">
            <button x-on:click="prev" x-bind:disabled="isPrevDisabled" class="inline-flex justify-center items-center bg-frost-0 border border-frost-300 w-12 h-12 p-2 disabled:text-frost-400"><?php echo wp_documentation_svg('chevron-left') ?></button>
            <button x-on:click="next" x-bind:disabled="isNextDisabled" class="inline-flex justify-center items-center bg-frost-0 border border-frost-300 w-12 h-12 p-2 disabled:text-frost-400"><?php echo wp_documentation_svg('chevron-right') ?></button>
        </div>
    </div>

</div>