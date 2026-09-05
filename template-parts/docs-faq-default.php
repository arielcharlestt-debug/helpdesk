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


$faqs_query_args = [
    'post_type' => 'faq',
    'posts_per_page' => 10
];

if (!empty($category)) {
    $faqs_query_args['tax_query'] = [
        [
            'taxonomy' => 'faq_category',
            'field'    => 'term_id',
            'terms'    => (array) $category->term_id,
        ]
    ];
};

$faqs_query = new WP_Query($faqs_query_args);

?>

<div class="x-container">
  <div class="my-16 sm:my-24">
    <div class="">
        <h2 class="text-4xl tracking-tight text-frost-900 sm:text-5xl">
            <?php echo !empty($title) ? esc_html($title) : esc_html('Frequently asked questions', 'wp-documentation'); ?>
        </h2>

        <?php if (!empty($description)): ?>
            <div class="text-base text-frost-700 mt-3">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>

        <?php if ($faqs_query->have_posts()): ?>
            <dl 
                class="relative mt-12 flex flex-col border border-frost-300 x-rounded-2xl overflow-hidden"
                x-data="faq" 
                x-on:keydown.window="handleWindowEscape">

                <?php $activeIndex = 0; ?>

                <?php while ($faqs_query->have_posts()): $faqs_query->the_post(); ?>                
                    <div
                        data-active-index="<?php echo esc_attr($activeIndex); ?>"
                        class="bg-frost-0 border-b last:border-b-none border-solid border-frost-300">
                        <dt>
                            <button 
                                type="button" 
                                class="flex px-8 py-6 w-full items-start justify-between text-left text-frost-900 transition hover:underline" 
                                x-bind:aria-expanded="isActive" 
                                aria-controls="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                                id="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                                x-on:click="handleClick">
                                <span class="text-lg font-bold">
                                    <?php echo get_the_title(); ?>
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
                            class="mt-2 px-8 pb-8 prose" 
                            x-show="isActive" 
                            role="region" 
                            id="faq-content-<?php echo esc_attr($activeIndex); ?>" 
                            aria-labelledby="faq-header-<?php echo esc_attr($activeIndex); ?>" 
                            style="display: none;"
                            x-collapse>
                            <?php echo get_the_content(); ?>
                        </dd>
                    </div>

                    <?php $activeIndex++; ?>
                <?php endwhile; ?>
            </dl>
        <?php else: ?>
        
        <?php 
            get_template_part('template-parts/empty-state', null, [
                'title' => __('No FAQs', 'wp-documentation'),
                'description' => __('It seems that no FAQs have been created yet.', 'wp-documentation'),
                'icon' => 'notes-off',
            ]);
        ?>
      <?php endif; ?>
    </div>
  </div>
</div>
