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
      <?php echo !empty($title) ? esc_html( $title ) : esc_html__('WP Documentation', 'wp-documentation'); ?>
    </h1>

    <div class="text-base text-frost-700 mt-1 text-center">
      <?php echo !empty($description) ? wp_kses_post( $description ) : esc_html__('Explore our documentation to find the information you need.', 'wp-documentation'); ?>
    </div>

    <?php if(!empty($link)): ?>
      <a 
        href="<?php echo esc_url($link['url']); ?>" 
        <?php if(!empty($link['target'])): ?>
          target="<?php echo esc_attr($link['target']); ?>"
        <?php endif; ?>
        class="inline-flex items-center justify-between mt-4 gap-2 px-8 py-3 text-center font-semibold text-white bg-primary">
        <?php echo esc_html(!empty($link['title']) ? $link['title'] : ''); ?>
        <?php echo wp_documentation_svg('arrow-right', 'w-4 h-4 text-white'); ?>
      </a>
    <?php endif; ?>
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
