<?php

/**
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */


$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
};

$has_status_bar = !empty($theme_options['status_bar_enabled']) && !empty($theme_options['status_bar_messages']);
$main_padding = $has_status_bar ? 'pt-[6.5rem] sm:pt-[7.5rem]' : 'pt-14 sm:pt-[4.5rem]';

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
	<?php wp_head(); ?>
</head>

<body 
	<?php body_class("bg-frost-50 text-frost-1000"); ?> 
	x-cloak 
	x-data="page"
	data-color-scheme="<?php echo esc_attr(wp_documentation_get_color_scheme()); ?>"
	data-color-style="<?php echo esc_attr($theme_options['color_style']); ?>"
	data-roundedness="<?php echo esc_attr(!empty($theme_options['roundedness']) ? $theme_options['roundedness'] : 'none'); ?>"
	<?php if(!empty($theme_options['default_color_scheme']) && $theme_options['default_color_scheme'] === 'auto'): ?>
		x-bind:data-color-scheme="colorSchemeName"
	<?php endif; ?>
	>

<?php wp_body_open(); ?>

<div id="page" class="site" x-clock>

	<header 
		id="header"
		x-data="header" 
		x-on:keydown.window.ctrl.k.prevent="showSearch"
		role="banner" 
		class="absolute top-0 left-0 w-full min-h-[3.5rem] sm:min-h-[4.5rem] z-[1001] flex flex-col transition-all duration-500 ease-out-expo admin-bar:top-14 sm:admin-bar:top-8 print:hidden"
		x-bind:class="headerClass">
		
		<?php get_template_part('template-parts/skip-link'); ?>
		<?php get_template_part('template-parts/status-bar'); ?>

		<div class="w-full x-container flex justify-start items-center gap-x-8 gap-y-4 sm:gap-0 min-h-[3.5rem] sm:min-h-[4.5rem]">
			<a href="<?php echo esc_url(home_url()); ?>" class="w-40 sm:w-56 py-1 pr-8">
				<?php if(has_custom_logo()): ?>
					<span class="h-14 flex justify-start items-center">
						<?php get_template_part('template-parts/header-logo'); ?>
					</span>
				<?php else: ?>
					<span class="inline-flex items-center gap-3">
						<span class="inline-flex items-center font-secondary justify-center w-10 h-10 sm:w-12 sm:h-12 bg-primary text-primary-foreground neutral:bg-frost-1000 neutral:text-frost-0 x-rounded-xl text-lg sm:text-2xl shrink-0">
							<?php echo esc_html(mb_strtoupper(mb_substr(get_bloginfo('name'), 0, 1))); ?>
						</span>
						<span class="text-lg sm:text-xl text-frost-900 font-secondary">
							<?php echo esc_html(get_bloginfo('name')); ?>
						</span>
					</span>
				<?php endif; ?>
			</a>

			<?php if(defined('FAST_FUZZY_SEARCH_VERSION')): ?>
				<?php get_template_part('template-parts/header-search-button', null, ['classes' => 'hidden !sm:flex']); ?>
			<?php endif; ?>
			
			<div class="flex justify-end items-center w-auto shrink-0 ml-auto sm:pl-8 gap-6">
				<?php
					wp_nav_menu(array(
						'theme_location' => 'primary',
						'container' => 'nav',
						'container_class' => 'desktop ml-auto hidden lg:flex pl-8',
						'container_aria_label' => 'Primary',
						'menu_class' => '',
						'menu_id' => '',
						'fallback_cb' => false,
					));
				?>

				<?php
					if(function_exists('pll_the_languages')) {
						pll_the_languages( array( 'dropdown' => 1 ) );
					};
				?>

				<?php if(defined('FAST_FUZZY_SEARCH_VERSION')): ?>
					<?php get_template_part('template-parts/header-search-icon-button', null, ['classes' => '!sm:hidden']); ?>
				<?php endif; ?>

				<?php if(!empty($theme_options['default_color_scheme']) && $theme_options['default_color_scheme'] === 'auto'): ?>
					<button x-on:click="colorSchemeToggle" class="w-6 h-6 inline-flex justify-center items-center text-frost-600">
						<span x-show="isLight" class="inline-flex justify-center items-center">
							<?php echo wp_documentation_svg('moon'); ?>
						</span>

						<span x-cloak x-show="isDark" class="inline-flex justify-center items-center">
							<?php echo wp_documentation_svg('sun'); ?>
						</span>
					</button>
				<?php endif; ?>

				<button 
					x-on:click.prevent="handleMenuButtonClick"
					class="w-6 h-6 inline-flex justify-center items-center text-frost-600 !lg:hidden"
					>
					<span x-show="isSidebarHidden">
						<?php echo wp_documentation_svg('menu'); ?>
					</span>
					<span x-cloak x-show="isSidebarVisible">
						<?php echo wp_documentation_svg('x'); ?>
					</span>
				</button>
			</div>

		</div>

		<div 
			x-cloak
            class="fixed top-0 right-0 w-96 max-w-full bottom-0 lg:hidden admin-bar:top-[46px]" 
            style="z-index: 1000;"
            x-show="showSidebar"
            x-trap="showSidebar"
            xyz="fade right-5 duration-2"
			x-transition:enter="xyz-in"
			x-transition:leave="xyz-out"
            x-on:keydown.escape.window="handleSidebarWindowEscape">

            <div class="x-container h-full bg-frost-50 border border-frost-300 py-8">
				<div class="w-full flex justify-end items-center mb-4">
					<button 
						x-on:click.prevent="handleMenuButtonClick"
						class="w-6 h-6 inline-flex justify-center items-center text-frost-600 !lg:hidden">
						<span x-cloak x-show="isSidebarVisible">
							<?php echo wp_documentation_svg('x'); ?>
						</span>
					</button>
				</div>

                <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => '',
                        'container' => 'nav',
                        'container_aria_label' => 'Primary',
                        'container_class' => 'primary--mobile',
                    ]);
                ?>
            </div>
        </div>
	</header>

	
	<main class="site-content <?php echo esc_attr($main_padding); ?>" role="main">
		<?php if(has_nav_menu('secondary')): ?>
			<div class="x-container relative z-1000 mt-2 mb-4">
				<?php
					wp_nav_menu([
						'theme_location' => 'secondary',
						'menu_class' => 'flex justify-start items-center flex-wrap w-full gap-4 whitespace-nowrap bg-frost-0 border border-frost-200 p-2',
						'container' => 'nav',
						'container_aria_label' => 'Secondary',
						'container_class' => 'desktop--secondary',
					]);
				?>
			</div>
		<?php endif; ?>