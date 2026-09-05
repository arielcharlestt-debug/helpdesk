<?php

if (!defined('ABSPATH')) {
    exit;
}

if (wp_documentation_is_pro()) {
    return;
}

if (!function_exists('wd_fs')) {
    return;
}

?>

<div class="mx-auto max-w-2xl border border-solid bg-white mt-4 mb-8 border-gray-300 sm:border-l-4 sm:border-l-[#2271b1] lg:mx-0 lg:flex lg:max-w-none">
    <div class="p-8 sm:p-10 lg:flex-auto">
        <h3 class="text-xl font-semibold tracking-tight m-0 text-gray-900 dark:text-white">
            <?php esc_html_e('Unlock the Full Power of WP Documentation', 'wp-documentation'); ?>
        </h3>
        <p class="mt-4 !mb-0 text-base text-gray-600">
            <?php esc_html_e('Congratulations! You Are Using WP Documentation. Free version gives you all the basics—but you are missing out on the real power. Upgrade now to unlock premium features and priority support.', 'wp-documentation'); ?>
        </p>

        <div class="mt-4 flex items-center gap-x-4">
          <h4 class="flex-none font-semibold text-[#2271b1]">
            <?php esc_html_e('What\'s included', 'wp-documentation'); ?>
          </h4>
          <div class="h-px flex-auto bg-gray-200"></div>
        </div>

        <ul role="list" class="mt-2 grid grid-cols-1 gap-4 text-gray-600 sm:grid-cols-2 dark:text-gray-300">
          <li class="flex gap-x-3">
            <?php echo wp_documentation_svg('check', 'h-6 w-auto flex-none text-[#2271b1]'); ?>
            <?php esc_html_e('Custom Docs Page', 'wp-documentation'); ?>
          </li>
          <li class="flex gap-x-3">
            <?php echo wp_documentation_svg('check', 'h-6 w-auto flex-none text-[#2271b1]'); ?>
            <?php esc_html_e('Unlock All Variations', 'wp-documentation'); ?>
          </li>
          <li class="flex gap-x-3">
            <?php echo wp_documentation_svg('check', 'h-6 w-auto flex-none text-[#2271b1]'); ?>
            <?php esc_html_e('Single Doc Page Variants', 'wp-documentation'); ?>
          </li>
          <li class="flex gap-x-3">
            <?php echo wp_documentation_svg('check', 'h-6 w-auto flex-none text-[#2271b1]'); ?>
            <?php esc_html_e('Priority Support', 'wp-documentation'); ?>
          </li>
        </ul>
    </div>

    <div class="-mt-2 p-2 lg:mt-0 lg:w-full lg:max-w-md lg:shrink-0">
        <div class="bg-gray-100 text-gray-900 py-10 text-center inset-ring inset-ring-gray-900/5 lg:flex lg:flex-col lg:justify-center lg:py-10">
            <div class="mx-auto max-w-xs px-8">
                <p class="text-base font-semibold"><?php esc_html_e('Lifetime Access', 'wp-documentation'); ?></p>
                <p class="mt-6 flex items-baseline justify-center gap-x-2">
                    <span class="text-5xl font-semibold tracking-tight">$30</span>
                    <span class="text-sm/6 font-semibold tracking-wide">USD</span>
                </p>
                <a target="_blank" href="<?php echo esc_url(wd_fs()->checkout_url()); ?>" class="!mt-4 !text-base !px-4 !py-2 block w-full button button-primary">
                    <?php esc_html_e('Upgrade Now', 'wp-documentation'); ?>
                </a>
                <p class="mt-6 text-xs/5"><?php esc_html_e('Buy once and use on unlimited sites', 'wp-documentation'); ?></p>
            </div>
        </div>
    </div>
</div>
