<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('docs' !== get_post_type()) {
    return;
}

$post_tags = get_the_terms(get_the_ID(), 'doc_tag');

if (!$post_tags) {
    return;
}

?>

<ul class="flex justify-start items-center flex-wrap gap-2 mt-8">

    <?php
        foreach ($post_tags as $index => $post_tag):

        if ($post_tag->slug === 'uncategorized' && $index > 0) {
            continue;
        }
    ?>

	    <li>
	        <a 
                class="inline-flex justify-center items-center bg-frost-0 px-4 py-2 border border-frost-300 border-solid text-sm font-semibold" 
                href="<?php echo esc_attr(get_term_link($post_tag)) ?>">
                #<?php echo esc_html($post_tag->name); ?>
            </a>
	    </li>

    <?php 
        endforeach;
    ?>
</ul>