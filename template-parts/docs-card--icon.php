<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

// Default values
$icon_size = isset($icon_size) ? $icon_size : 'medium';
$icon_variant = isset($icon_variant) ? $icon_variant : 'default';

// Size classes for images
$size_classes = [
    'x-small' => 'max-w-4 max-h-4',
    'small' => 'max-w-6 max-h-6',
    'medium' => 'max-w-10 max-h-10',
    'large' => 'max-w-12 max-h-12'
];

// Size classes for spans
$span_sizes = [
    'x-small' => 'w-4 h-4 text-sm',
    'small' => 'w-6 h-6 text-base',
    'medium' => 'w-10 h-10 text-lg',
    'large' => 'w-12 h-12 text-xl'
];

// Variant classes for spans
$variant_classes = [
    'default' => 'p-2 bg-' . esc_attr($color) . '-700 text-frost-0 dark:bg-' . esc_attr($color) . '-300 dark:text-' . esc_attr($color) . '-900',
    'light' => 'bg-white text-gray-900',
    'pastel' => 'p-2 bg-' . esc_attr($color) . '-50 border border-' . esc_attr($color) . '-100 text-' . esc_attr($color) . '-700 dark:bg-' . esc_attr($color) . '-200 dark:border-' . esc_attr($color) . '-300 dark:text-' . esc_attr($color) . '-1000',
    'mono' => 'text-inherit',
    'colored' => 'text-' . esc_attr($color) . '-700 dark:text-' . esc_attr($color) . '-300',
];

$image_size_class = isset($size_classes[$icon_size]) ? $size_classes[$icon_size] : $size_classes['medium'];
$span_size_class = isset($span_sizes[$icon_size]) ? $span_sizes[$icon_size] : $span_sizes['medium'];
$span_variant_class = isset($variant_classes[$icon_variant]) ? $variant_classes[$icon_variant] : $variant_classes['default'];

?>

<?php if (!empty($icon) && 'media_library' === $icon['type'] ):
    $attachment_id = $icon['value']['ID'];
    $size = 'full'; // (thumbnail, medium, large, full, or custom size)

    $image_html = wp_get_attachment_image($attachment_id, $size, false, array(
        'class' => 'w-auto h-auto ' . $image_size_class . ' shrink-0',
        'alt'   => esc_attr( $icon['value']['alt'] ),
    ));

    echo wp_kses_post($image_html);
?>

<?php elseif(!empty($icon) && 'url' === $icon['type']): ?>
    <img class="w-auto h-auto <?php echo $image_size_class; ?> shrink-0" src="<?php echo esc_attr( $icon['value'] ); ?>" alt="">
<?php else: ?>
    <span class="<?php echo $span_size_class; ?> inline-flex justify-center items-center x-rounded-xl overflow-hidden shrink-0 <?php echo $span_variant_class; ?>">
        <?php if (!empty($icon) && 'dashicons' === $icon['type']): ?>
            <span class="dashicons <?php echo esc_attr($icon['value']); ?>"></span>
        <?php else: ?>
            <?php echo wp_documentation_svg('file-text'); ?>
        <?php endif; ?>
    </span>
<?php endif; ?>