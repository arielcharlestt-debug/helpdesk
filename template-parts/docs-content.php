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

$author_id = get_the_author_meta('ID');
$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
};

$isToc = true;
$isSidebar = true;

if(!empty($theme_options['single_doc_layout']) && $theme_options['single_doc_layout'] === 'minimal') {
	$isToc = false;
	$isSidebar = false;
};

if(!empty($theme_options['single_doc_layout']) && $theme_options['single_doc_layout'] === 'hide_sidebar') {
	$isToc = true;
	$isSidebar = false;
};

if(!empty($theme_options['single_doc_layout']) && $theme_options['single_doc_layout'] === 'hide_toc') {
	$isToc = false;
	$isSidebar = true;
};

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>

	<div x-data="docsOverlays" class="flex justify-between items-center">
		<button 
			class="origin-left flex justify-end items-center gap-2 text-sm font-semibold text-right transition-all mt-8 mr-auto <?php echo esc_attr($isSidebar ? '!lg:hidden' : ''); ?>"
			x-on:click="toggleSidebar">
			<span x-show="isNotSidebar" class="w-5 h-5 inline-flex justify-center items-center"><?php echo wp_documentation_svg('layout-sidebar-left-expand'); ?></span>
			<span><?php esc_html_e('All Pages', 'wp-documentation'); ?></span>
		</button>

		<style>
			@media (max-width: 1023px) {
				#docs-on-this-page-toggle {
					display: none !important;
				}
			}
		</style>
		<button
			id="docs-on-this-page-toggle"
			x-on:click="toggleToc"
			class="flex justify-end items-center gap-2 text-sm font-semibold text-right transition-all mt-8 ml-auto <?php echo esc_attr($isToc ? '!lg:hidden' : ''); ?>">
			<span x-show="isNotToc" class="w-5 h-5 inline-flex justify-center items-center"><?php echo wp_documentation_svg('list'); ?></span>
			<span><?php esc_html_e('On This Page', 'wp-documentation'); ?></span>
		</button>

		<?php get_template_part('template-parts/docs-content', 'overlays', ['documents' => $documents, 'toc' => $toc]); ?>
	</div>

	<div class="mt-8">
		<h1 class="entry-title text-5xl sm:text-6xl inline">
			<?php the_title(); ?>
		</h1>
	</div>

	<div class="text-sm text-frost-500 mt-4">
    	<?php echo sprintf(esc_html__('Published on %s', 'wp-documentation'), esc_html(get_the_date())); ?>
	</div>

	<?php $revised_date = function_exists('get_field') ? get_field('revised_date') : null; ?>
	<?php if (!empty($revised_date)): ?>
		<div class="text-sm text-frost-500 mt-2">
			<?php echo sprintf(esc_html__('Revised on %s', 'wp-documentation'), esc_html($revised_date)); ?>
		</div>
	<?php endif; ?>

	<?php if(get_post_thumbnail_id()): ?>
		<div class="relative h-96 flex flex-start items-stretch gap-4 mb-8 mt-8 overflow-hidden">
			<div class="h-full w-full rounded-2xl overflow-hidden">
				<?php get_template_part('template-parts/post-image'); ?>
			</div>
		</div>
	<?php endif; ?>
	
	<div class="entry-content prose">
		<?php
			the_content(
				sprintf(
					wp_kses(
						__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'wp-documentation'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-documentation'),
					'after'  => '</div>',
				)
			);
		?>
	</div><!-- .entry-content -->

	<?php get_template_part('template-parts/docs-content-tags'); ?>
	<?php get_template_part('template-parts/docs-navigation'); ?>
	<?php get_template_part('template-parts/docs-content-faq'); ?>

	
</article><!-- #post-## -->
