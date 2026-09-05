<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$faqs = function_exists('get_field') ? get_field('faqs') : [];

?>

<?php if(!empty($faqs)): ?>
    <h2 class="text-2xl mt-8 mb-4"><?php esc_html_e('Frequently asked questions', 'wp-documentation'); ?></h2>

    <dl 
        class="relative mt-8 flex flex-col gap-4"
        x-data="faq" 
        x-on:keydown.window="handleWindowEscape">

        <?php $activeIndex = 0; ?>

        <?php foreach ($faqs as $index => $faq): ?>             
            <div
                data-active-index="<?php echo esc_attr($activeIndex); ?>"
                class="py-4 px-4 bg-frost-0 border border-solid border-frost-300">
                <dt>
                    <button 
                        type="button" 
                        class="flex w-full items-start justify-between text-left text-frost-900 transition hover:underline" 
                        x-bind:aria-expanded="isActive" 
                        aria-controls="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                        id="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                        x-on:click="handleClick">
                        <span class="text-base/7 font-bold">
                            <?php echo esc_html($faq['title']); ?>
                        </span>

                        <span 
                            x-cloak
                            x-show="isNotActive" 
                            class="ml-6 flex h-7 items-center shrink-0">
                            <?php echo wp_documentation_svg('chevron-down'); ?>
                        </span>

                        <span 
                            x-cloak
                            x-show="isActive" 
                            class="ml-6 flex h-7 items-center shrink-0">
                            <?php echo wp_documentation_svg('chevron-up'); ?>
                        </span>

                    </button>
                </dt>

                <dd 
                    class="mt-2 pr-12 prose" 
                    x-show="isActive" 
                    role="region" 
                    id="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                    aria-labelledby="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                    style="display: none;"
                    x-collapse>
                    <?php echo wp_kses_post($faq['content']); ?>
                </dd>
            </div>

            <?php $activeIndex++; ?>
        <?php endforeach; ?>
    </dl>

<?php endif; ?>