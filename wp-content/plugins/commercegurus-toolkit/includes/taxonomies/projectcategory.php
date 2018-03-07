<?php

    $labels = array(
        'name' => _x('Project Categories', 'taxonomy general name', 'commercegurus'),
        'singular_name' => _x('Project Category', 'taxonomy singular name', 'commercegurus'),
        'search_items' => __('Search Project Categories', 'commercegurus'),
        'popular_items' => __('Popular Project Categories', 'commercegurus'),
        'all_items' => __('All Project Categories', 'commercegurus'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Project Category', 'commercegurus'),
        'update_item' => __('Update Project Category', 'commercegurus'),
        'add_new_item' => __('Add New Project Category', 'commercegurus'),
        'new_item_name' => __('New Project Category Name', 'commercegurus'),
        'separate_items_with_commas' => __('Separate project categories with commas', 'commercegurus'),
        'add_or_remove_items' => __('Add or remove project categories', 'commercegurus'),
        'choose_from_most_used' => __('Choose from the most used project categories', 'commercegurus'),
    );

    register_taxonomy('project-categories', 'project', array(
        'label' => __('Project Category', 'commercegurus'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'project-category'),
    ));

?>