<?php

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

  <div class="relative x-container flex flex-col items-center justify-center gap-4 z-10">
    <h1 class="text-5xl font-medium text-frost-900 text-center">
      <?php echo !empty($title) ? esc_html( $title ) : esc_html__('wp-documentation', 'wp-documentation'); ?>
    </h1>

    <div class="text-base text-frost-700 mt-1 text-center">
      <?php echo !empty($description) ? wp_kses_post( $description ) : esc_html__('Explore our documentation to find the information you need.', 'wp-documentation'); ?>
    </div>

    <button
      x-data="fastFuzzySearchTrigger"
      x-on:click="showSearch" 
      x-bind:disabled="isDisabled" 
      data-context="<?php esc_attr_e('Docs', 'wp-documentation'); ?>"
      class="inline-flex items-center justify-between gap-2 px-4 py-2 text-sm font-semibold text-frost-900 bg-frost-0 border border-frost-300 mt-4 w-full !lg:w-1/2 max-w-full h-12 disabled:opacity-50">
      <p class="text-frost-700"><?php esc_html_e('Search for docs...', 'wp-documentation'); ?></p>
      
      <span x-cloak x-show="isNotLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo wp_documentation_svg('search'); ?>
      </span>

      <span x-show="isLoading" class="w-4 h-4 inline-flex justify-center items-center">
        <?php echo wp_documentation_svg('spinner'); ?>
      </span>
    </button>
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
