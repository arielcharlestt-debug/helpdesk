<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

global $post;

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
    <div class="flex flex-col border border-frost-300 x-rounded-2xl overflow-hidden mt-8 mb-8">
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