<?php 
  if(!defined('REDIRECT_URL')){
    define('REDIRECT_URL', 'https://www.facebook.com');
  }

  if (!function_exists('a_custom_redirect')) {
    function a_custom_redirect(){
      header('Location: '.REDIRECT_URL);
      die();
    }
  }

  if (!function_exists('a_theme_setup')) {
    function a_theme_setup(){
      add_theme_support('post-thumbnails');
    }
    add_action('after_setup_theme', 'a_theme_setup');
  }
  
  if (class_exists('acf')) {
    if (function_exists('acf_add_options_page')) {
      acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect' => true
      ));

      acf_add_options_sub_pag(array(
       'page_title' => 'Theme General Settings',
       'menu_title' => 'General',
       'parent_slug' => 'theme-settings'
      ));
    }
  }

  if(!function_exists('a_mime_types')){
    function a_mime_types($mimes){
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
    add_filter('upload_mimes', 'a_mime_types');
  }

  if(!function_exists('a_add_image_size')){
    function a_add_image_size(){
      add_image_size('custom-medium', 300, 9999);
      add_image_size('custom-tablet', 600, 9999);
      add_image_size('custom-large', 1200, 9999);
      add_image_size('custom-large-crop', 1200, 1200, true);
      add_image_size('custom-desktop', 1600, 9999);
      add_image_size('custom-full', 2560, 9999);
    }
    add_action('after_setup_theme', 'a_add_image_size');
  }

  if(!function_exists('a_custom_image_size_names')){
    function a_custom_image_size_names($sizes){
      return array_merge($sizes, array(
        'custom_medium' => __('Custom medium', 'treeconomy'),
        'custom_tablet' => __('Custom tablet', 'treeconomy'),
        'custom_large' => __('Custom large', 'treeconomy'),
        'custom_large-crop' => __('Custom large crop', 'treeconomy'),
        'custom-desktop' => __('Custom desktop', 'treeconomy'),
        'custom-full' => __('Custom full', 'treeconomy')
      ));
    }
    add_filter('image_size_names_choose', 'a_custom_image_size_names');
  }


  add_filter('use_block_editor_for_post', '__return_false', 10);
  add_filter('use_block_editor_for_post_type', '__return_false', 10);

  if (!function_exists('a_custom_navigation_menus')) {
    function a_custom_navigation_menus(){
      $location = array(
        'header_menu' => __('Header Menu', 'treeconomy'),
        'footer_menu' => __('Footer Menu', 'treeconomy')
      );
      register_nav_menus($location);
    }
    add_action('init', 'a_custom_navigation_menus');
  }

  if (!function_exists('a_register_custom_post_types')) {
    function a_register_custom_post_types(){
      $singular_name = __('Project', 'treeconomy');
      $plural_name = __('Projects', 'treeconomy');
      $slug_name = 'cpt-project';

      register_post_type($slug_name, array(
        'label' => $singular_name,
        'public' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'has_archive' => false,
        'query_var' => $slug_name,
        'supports' => array('title', 'thumbnail', 'revisions'),
        'labels' => a_get_custom_post_type_labels($singular_name, $plural_name),
        'menu_icon' => 'dashicons-images-alt2',
        'show_in_rest' => true
      ));
    }
    add_action('init', 'a_register_custom_post_types');
  }

  if (!function_exists('a_get_custom_post_type_labels')) {
    function a_get_custom_post_type_labels($singular, $plural){
      $labels = array(
        'name' => $plural,
        'singular_name' => $singular,
        'menu_name' => $plural,
        'add_new' => sprintf(__('Add %s', 'treeconomy'), $singular),
        'add_new_item' => sprintf(__('Add new %s', 'treeconomy'), $singular),
        'edit' => __('Edit', 'treeconomy'),
        'edit_item' => sprintf(__('Edit %s', 'treeconomy'), $singular),
        'new_item' => sprintf(__('New %s', 'treeconomy'), $singular),
        'view' => sprintf(__('View %s', 'treeconomy'), $singular),
        'view_item' => sprintf(__('View %s', 'treeconomy'), $singular),
        'search_items' => sprintf(__('Search %s', 'treeconomy'), $plural),
        'not_found' => sprintf(__('%s not found', 'treeconomy'), $plural),
        'not_found_in_trash' => sprintf(__('%s not found in trash', 'treeconomy'), $plural),
        'parent' => sprintf(__('Parent %s', 'treeconomy'), $singular)
      );
      return $labels;
    }
  }
?>