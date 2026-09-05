<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('wd_fs')) {
    return;
}

if (wp_documentation_is_pro()):
    $account_url = wd_fs()->get_account_url();
?>
    <section id="pricing" class="mt-16">
        <div class="mx-auto max-w-4xl text-center mb-16">
            <h2 class="mb-4 mt-0 text-5xl font-semibold text-center">
                <?php echo esc_html__('You\'re a Pro!', 'wp-documentation'); ?>
            </h2>
            <p class="text-base font-medium mt-4">
                <?php echo esc_html__('Thank you for supporting WP Documentation. Manage your license and account below.', 'wp-documentation'); ?>
            </p>
            <a href="<?php echo esc_url($account_url); ?>" class="button button-primary !px-8 !py-3 !mt-8 !text-base !inline-flex !items-center !gap-2">
                <?php echo wp_documentation_svg('settings', 'w-5 h-auto'); ?>
                <?php esc_html_e('Manage License', 'wp-documentation'); ?>
            </a>
        </div>
    </section>
<?php else: ?>
    <section id="pricing" class="mt-16">
        <div class="mx-auto max-w-4xl text-center mb-16 xl:mb-16">
            <h2 class="mb-4 mt-0 text-5xl font-semibold text-center">
                <?php echo esc_html__('WP Documentation Free vs Pro', 'wp-documentation'); ?>
            </h2>
            <p class="text-base font-medium mt-4">
                <?php echo esc_html__('Take your documentation to the next level. Get access to all the pro options and support you need.', 'wp-documentation'); ?>
            </p>
        </div>

        <div class="grid gap-8 justify-center md:grid-cols-2">
            <!-- Free -->
            <div class="bg-white border border-black p-7 xl:p-10">
                <div class="mb-[30px]">
                    <img src="<?php echo wp_documentation_assets('icons/bolt.svg') ?>" alt="" width="47" height="60" class="h-10 w-auto lg:h-[60px]" />
                </div>
                <div class="text-left">
                    <span class="text-xl font-semibold">Free</span>
                    <div class="month">
                        <span class="text-[48px] font-semibold leading-[1.3] xl:text-[72px]">$0</span>
                    </div>
                </div>

                <ul class="flex flex-col gap-y-3 font-semibold mt-8">
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Blazing Fast Performance
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Responsive Design
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Gutenberg Compatible
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Light & Dark Mode
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Instant Search
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-red-600"><?php echo wp_documentation_svg('square-rounded-x'); ?></span>
                        Custom Docs Page
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-red-600"><?php echo wp_documentation_svg('square-rounded-x'); ?></span>
                        Multiple Docs Layouts
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-red-600"><?php echo wp_documentation_svg('square-rounded-x'); ?></span>
                        Single Doc Page Variants
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-red-600"><?php echo wp_documentation_svg('square-rounded-x'); ?></span>
                        Priority Support
                    </li>
                </ul>

                <a href="#" disabled="disabled" class="button button-primary flex justify-center items-center !px-12 !py-4 text-center w-full font-medium !text-base !mt-8 cursor-not-allowed opacity-60"><span>Active</span></a>
            </div>

            <!-- Pro -->
            <div class="bg-white border border-black p-7 xl:p-10">
                <div class="mb-[30px]">
                    <img src="<?php echo wp_documentation_assets('icons/crown.svg') ?>" alt="" width="47" height="60" class="h-10 w-auto lg:h-[60px]" />
                </div>
                <div class="text-left">
                    <span class="text-xl font-semibold">Pro</span>
                    <div class="month">
                        <span class="text-[48px] font-semibold leading-[1.3] xl:text-[72px]">$29</span>
                    </div>
                </div>

                <ul class="flex flex-col gap-y-3 font-semibold mt-8">
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Blazing Fast Performance
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Responsive Design
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Gutenberg Compatible
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Light & Dark Mode
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Instant Search
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Custom Docs Page
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Multiple Docs Layouts
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Single Doc Page Variants
                    </li>
                    <li class="flex gap-x-3">
                        <span class="w-5 h-auto inline-flex items-center justify-center text-green-600"><?php echo wp_documentation_svg('rosette-discount-check-filled'); ?></span>
                        Priority Support
                    </li>
                </ul>

                <a target="_blank" href="<?php echo esc_url(wd_fs()->checkout_url()); ?>" class="button button-primary flex justify-center items-center !px-12 !py-4 text-center w-full font-medium !text-base !mt-8">
                    <span><?php esc_html_e('Upgrade to Pro', 'wp-documentation'); ?></span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>
