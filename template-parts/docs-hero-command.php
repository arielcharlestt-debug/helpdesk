<?php

if (!wp_documentation_is_pro()) {
    return;
}
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

?>

<section class="relative bg-frost-100 py-24 mt-0 border-y border-frost-300 overflow-hidden">
  <?php if(!empty($background_pattern) && $background_pattern === 'blob'): ?>
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 z-0 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div 
        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" 
        class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-primary to-primary opacity-10 dark:opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]">
      </div>
    </div>
  <?php endif; ?>

  <div class="relative z-10 x-container flex flex-col items-center justify-center gap-4">
    <h1 class="text-5xl font-medium text-frost-900 text-center">
      <?php echo !empty($title) ? esc_html( $title ) : esc_html__('wp-documentation', 'wp-documentation'); ?>
    </h1>

    <div class="text-base text-frost-700 mt-1 text-center">
      <?php echo !empty($description) ? wp_kses_post( $description ) : esc_html__('Explore our documentation to find the information you need.', 'wp-documentation'); ?>
    </div>

    <div class="w-full sm:w-1/2 border-frost-300 bg-frost-0 border border-solid mt-4">
        <div class="flex justify-start items-center w-full h-10 border-b border-frost-300 font-semibold">
          <div class="grow px-4 text-xs">
            <?php echo apply_filters('wp_documentation_label_command', esc_html__('Terminal', 'wp-documentation')); ?>
          </div>

          <button 
            x-copy 
            data-copy="<?php echo esc_html($command); ?>"
            class="w-auto px-4 gap-1 h-full flex justify-center items-center text-xs font-semibold border-l border-frost-300 hover:bg-frost-100 active:bg-frost-200 focus:outline-none focus:ring-2 focus:ring-frost-500 focus:ring-opacity-50 transition duration-150 ease-in-out" 
            type="button" 
            aria-label="<?php esc_attr_e('Copy to clipboard', 'wp-documentation'); ?>">
            <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo wp_documentation_svg('copy'); ?></span>
            <span class="sr-only"><?php esc_html_e('Copy to clipboard', 'wp-documentation') ?></span>
          </button>
        </div>

        <div class="flex justify-start items-center w-full h-12 px-4">
          <div class="w-full h-full flex justify-start items-center gap-2">
            <?php echo esc_html($command); ?>
          </div>
        </div>
    </div>
    
  </div>

  <?php if(!empty($background_pattern) && $background_pattern === 'blob'): ?>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] z-0 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div 
        style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" 
        class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-primary to-primary opacity-10 dark:opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]">
      </div>
    </div>
  <?php endif; ?>
</section>
