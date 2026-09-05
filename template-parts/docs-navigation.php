<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

global $post;

$current_menu_order = $post->menu_order;

$children = get_posts([
    'post_type'      => 'docs',
    'posts_per_page' => -1,
    'post_parent'    => $post->ID,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
  $theme_options = wp_documentation_get_default_options();
};

$colors = wp_documentation_get_palette_colors($theme_options);


?>

<?php if (!empty( $children)): ?>
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-8 mb-8">
        <?php foreach ( $children as $index => $child ): $color = $colors[$index % count($colors)]; ?>
            <?php 
                get_template_part( 'template-parts/docs-card', 'simple', [
                    'document' => [
                        'ID'        => $child->ID,
                        'title'     => $child->post_title,
                        'permalink' => get_permalink( $child ),
                    ],
                    'color'    => $color,
                ]); 
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php
// Get all siblings
$siblings = get_posts([
    'post_type'      => 'docs',
    'posts_per_page' => -1,
    'post_parent'    => empty($post->post_parent) ? 0 : $post->post_parent,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

// Build an array of "next" siblings (after current post)
$next_siblings = [];
$found_current = false;
foreach ($siblings as $sibling) {
    if ($found_current && $sibling->ID !== $post->ID) {
        $next_siblings[] = $sibling;
    }
    if ($sibling->ID === $post->ID) {
        $found_current = true;
    }
}
?>

<?php if (!empty($next_siblings)): ?>
    <h2 class="text-2xl mt-8 mb-4"><?php esc_html_e('Next', 'wp-documentation'); ?> </h2>
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 mb-8">
        <?php foreach ($next_siblings as $index => $sibling): $color = $colors[$index % count($colors)]; ?>
            <?php 
                get_template_part('template-parts/docs-card', 'simple', [
                    'document' => [
                        'ID'        => $sibling->ID,
                        'title'     => $sibling->post_title,
                        'permalink' => get_permalink($sibling),
                    ],
                    'color'    => $color,
                ]);
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>