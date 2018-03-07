<?php

$labels = array(
    'name' => __( 'Projects', 'commercegurus' ),
    'singular_name' => __( 'Project', 'commercegurus' ),
    'add_new' => _x( 'Add New', 'project', 'commercegurus' ),
    'add_new_item' => __( 'Add New Project', 'commercegurus' ),
    'edit_item' => __( 'Edit Project', 'commercegurus' ),
    'new_item' => __( 'New Project', 'commercegurus' ),
    'view_item' => __( 'View Project', 'commercegurus' ),
    'search_items' => __( 'Search Projects', 'commercegurus' ),
    'not_found' => __( 'No projects found', 'commercegurus' ),
    'not_found_in_trash' => __( 'No projects found in Trash', 'commercegurus' ),
    'parent_item_colon' => ''
);

$args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'projects', 'with_front' => true),
    'capability_type' => 'post',
    'hierarchical' => false,
    'has_archive' => false,
    'menu_position' => 20,
    'menu_icon' => 'dashicons-screenoptions',
    'supports' => array('title','editor','page-attributes','thumbnail')
);

register_post_type( 'project', $args );

function cg_projects_edit_columns( $columns ) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __( 'Project Title', 'commercegurus' ),
        "date" => __( 'Date', 'commercegurus' )
    );
    return $columns;
}

add_filter( 'manage_edit-project_columns', 'cg_projects_edit_columns' );
