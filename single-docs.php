<?php
/**
 * The template for displaying all single docs
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package wp_documentation
 */

get_header(); 

$documents = wp_documentation_get_document_hierarchy();
$toc = wp_documentation_get_toc(get_the_content());
$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
  $theme_options = wp_documentation_get_default_options();
};

?>

<?php if($theme_options['single_doc_layout'] == 'default') : ?>
  <div id="content" class="w-full flex justify-start x-container when-md:px-6">
    <?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => '!sticky top-0 sm:w-72 shrink-0 border-frost-300 text-frost-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start hidden lg:block']); ?>
    
    <div id="primary" class="pt-8 lg:px-8 !sm:w-7/12 w-full grow">
      <div class="wp_documentation_breadcrumb">
        <?php echo wp_documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->

    <?php get_template_part('template-parts/docs', 'toc', ['toc' => $toc]); ?>
  </div>

<?php elseif($theme_options['single_doc_layout'] == 'minimal') : ?>
  <div id="content" class="w-full flex justify-start max-w-5xl mx-auto when-md:px-6">
    <div id="primary" class="pt-8 w-full grow">
      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->
  </div>

<?php elseif($theme_options['single_doc_layout'] == 'hide_sidebar') : ?>
  <div id="content" class="w-full flex justify-start x-container">
    <div id="primary" class="pt-8 !sm:w-7/12 w-full grow">
      <div class="wp_documentation_breadcrumb">
        <?php echo wp_documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->

    <?php get_template_part('template-parts/docs', 'toc', ['toc' => $toc]); ?>
  </div>
  
<?php elseif($theme_options['single_doc_layout'] == 'hide_toc') : ?>
    
  <div id="content" class="w-full flex justify-start x-container">
    <?php get_template_part('template-parts/docs', 'sidebar', ['documents' => $documents, 'class' => '!sticky top-0 sm:w-72 shrink-0 border-frost-300 text-frost-1000 border-solid h-screen overflow-y-scroll py-8 lg:pr-10 self-start hidden lg:block']); ?>
    
    <div id="primary" class="pt-8 lg:pl-8 !sm:w-7/12 w-full grow">
      <div class="wp_documentation_breadcrumb">
        <?php echo wp_documentation_get_breadcrumb(); ?>
      </div>

      <?php
        /* Start the Loop */
        while (have_posts()):
          the_post();

          get_template_part('template-parts/docs-content', !empty($theme_options['single_doc_layout']) ? $theme_options['single_doc_layout'] : 'default', ['documents' => $documents, 'toc' => $toc]);

          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) :
            comments_template();
          endif;

        endwhile;
      ?>
    </div><!-- #primary -->
  </div>
<?php endif; ?>

<?php

get_footer();
