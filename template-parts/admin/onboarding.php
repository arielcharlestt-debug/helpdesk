<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
	extract($args);
}

?>


<section class="bg-white p-8 mb-8 border border-gray-300 border-solid">
    <h2 class="mb-6 mt-0"><?php esc_html_e('Setup Documentation', 'wp-documentation') ?></h2>

    <ul role="list" class="divide-y divide-gray-100 flex flex-col gap-4">
        <li>
            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=page&template=docs-home.php')); ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('1', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Create Docs Page with "Docs (Home)" page template', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url(admin_url('options-reading.php')) ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('2', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Set Docs Page as Homepage', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=title_tagline')) ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('3', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Add Your Logo', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url(admin_url('options-general.php?page=nested-pages-settings&tab=posttypes')) ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('4', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Setup nested pages for docs', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url(admin_url('post-new.php?post_type=docs')) ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('5', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Create your first doc page', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>

        <li>
            <a href="<?php echo esc_url(admin_url('admin.php?page=fast_fuzzy_search_options')) ?>" class="flex items-center justify-start gap-x-4 border text-lg font-semibold text-gray-900 border-gray-300 border-solid py-4 pl-4 pr-8">
                <span class="w-8 h-8 inline-flex justify-center items-center rounded-full bg-gray-900 text-white text-lg font-semibold">
                    <?php esc_html_e('6', 'wp-documentation') ?>   
                </span>
                <?php esc_html_e('Customize Search', 'wp-documentation') ?>
                <span class="w-6 h-6 inline-flex justify-center items-center p-1 ml-auto shrink-0">
                    <?php echo wp_documentation_svg('chevron-right'); ?>
                </span>
            </a>
        </li>
    </ul>
</section>