<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!empty($args)) {
    extract($args);
}

$title = !empty($args['title']) ? $args['title'] : get_field('title');
$content = !empty($args['content']) ? $args['content'] : get_field('content');
$type_value = !empty($args['type']) ? $args['type'] : get_field('type');
$link = !empty($args['link']) ? $args['link'] : get_field('link');
$collapsed = !empty($args['collapsed']) ? $args['collapsed'] : get_field('collapsed');

$type_value = in_array($type_value, ['note', 'tip', 'info', 'warning', 'danger']) ? $type_value : 'note';

$link_url = !empty($link['url']) ? $link['url'] : '';
$link_title = !empty($link['title']) ? $link['title'] : '';
$link_target = !empty($link['target']) ? $link['target'] : '_self';

?>

<wp-callout
    type="<?php echo esc_attr($type_value); ?>"
    title="<?php echo esc_attr($title); ?>"
    <?php echo $collapsed ? 'collapsed' : ''; ?>
    <?php if ($link_url): ?>
    link-url="<?php echo esc_url($link_url); ?>"
    link-title="<?php echo esc_attr($link_title); ?>"
    link-target="<?php echo esc_attr($link_target); ?>"
    <?php endif; ?>
>
    <?php echo wp_kses_post($content); ?>
</wp-callout>
