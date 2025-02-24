<?php

/**
 * @package SVG_TO_PNG_FEATURED_IMG
 * @version 0.2
 */
/*
        Plugin Name: SVG Featured Image
        Plugin URI: https://github.com/nirus/svg-featured-image
        Description: Automatic converter for featured images on wordpress that uses SVG image format. This plugin automatically creates an equivalent PNG format & adds to the meta tags in header.
        Author: Niranjan Kumar A.K.A NiRUS
        Version: 0.2
        Author URI: http://nirus.io
    */


include plugin_dir_path(__FILE__) . 'post-watch.php';


// create custom plugin settings menu
add_action('admin_menu', 'sfi_nirus_plug_menu');
register_uninstall_hook(__FILE__, 'sfi_nirus_uninstall_hook');

function sfi_nirus_plug_menu()
{
    add_menu_page(
        'SVG to PNG featured image',
        'SVG &#8594; PNG',
        'administrator',
        __FILE__,
        'sfi_nirus_plugged',
        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgd2lkdGg9IjU4NS45MThweCIgaGVpZ2h0PSI1ODUuOTE4cHgiIHZpZXdCb3g9IjAgMCA1ODUuOTE4IDU4NS45MTgiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU4NS45MTggNTg1LjkxODsiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZD0iTTM1Ny4zOTYsNTM1LjMzNWMwLjc3NiwwLjA0MiwxLjU0MiwwLjExNSwyLjMyOSwwLjExNWgxNzcuMzljMjAuNzUsMCwzNy42MjctMTYuODgzLDM3LjYyNy0zNy42MjhWODYuNjA0DQoJCWMwLTIwLjc0My0xNi44NzctMzcuNjI4LTM3LjYyNy0zNy42MjhoLTE3Ny4zOWMtMC43ODEsMC0xLjU1MywwLjA2OS0yLjMyOSwwLjExM1YwTDExLjE3Niw0Ni4yMDd2NDkyLjMxbDM0Ni4yMiw0Ny40MDFWNTM1LjMzNXoNCgkJIE0zNTcuMzk2LDI3Mi41NzV2LTE3LjY1MWgyLjU5MnYtOC4wOTdsMTEuMDE0LTkuOUwzNTcuMzk2LDI3Mi41NzV6IE0zNzkuODIsMjM1Ljg2OWg0Ljc1OHYtMi42ODhoMTIuMTA0djIuMjMxbC0zOS4yODYsMTAzLjI1OQ0KCQl2LTQ0LjA5NkwzNzkuODIsMjM1Ljg2OXogTTU1My4yNCwzNTIuNjI0aC0xLjEyMmwwLjE2Ny01My4zMjVoMC45NTVWMzUyLjYyNHogTTM1OS43MjYsNzAuNDc5aDE3Ny4zOQ0KCQljOC44OTMsMCwxNi4xMjUsNy4yMzMsMTYuMTI1LDE2LjEyNXYxOTkuOWgtMTEuNDExdjIuNjg4SDQ4Ny43OHYtMi42ODhoLTEyLjk3NnYxMi43OTRoMi4xNTF2MTIuMjk2aC0yLjE1MXYxMi45NzdoMTIuOTc2di0yLjMzNw0KCQloMTkuMDg3Yy01LjUzMiw1LjQyMy0xMS45NDYsOC43ODMtMTkuNDQzLDEwLjE5di0xLjgzOGgtMTIuNzk4djIuMDE1Yy04LjM0Ny0xLjExNy0xNS40NjUtNC42MDctMjEuNjgxLTEwLjYyNA0KCQljLTYuMTY4LTUuOTczLTkuODQ4LTEyLjg5NC0xMS4xNy0yMS4wNzFoMS41NjN2LTEyLjk3NGgtMS43OTVjMS4yMzMtOC4zMjUsNC45MDMtMTUuNDI1LDExLjE1OS0yMS42Mw0KCQljNi4yNjktNi4yMTMsMTMuNDYtOS44MTMsMjEuOTIzLTEwLjk0N3YyLjAxNWgxMi43OTh2LTEuNzE2YzUuODQ4LDEuMDM5LDExLjIyNCwzLjQwNCwxNi4wNDcsNy4wNjN2Ni42NTZoMTIuOTc3di0yLjMxMg0KCQlsMTguMDIyLDAuMTI5djIuMTc5aDEyLjk3N3YtMTIuODAxaC01LjY2NGMtNS45OS05LjgzOC0xMy45MTctMTcuODkzLTIzLjU5OC0yMy45NjljLTkuMzctNS44OS0xOS43LTkuMzcyLTMwLjc3MS0xMC4zOTN2LTMuMDg3DQoJCWgtMTIuNzk4djMuMDI3Yy0xNy40OTIsMS4yNTEtMzIuNzE1LDguMjIzLTQ1LjI5MiwyMC43NDNjLTEyLjU3NywxMi41MTUtMTkuNjMzLDI3LjY1Ni0yMC45OTksNDUuMDM1aC0zLjA0M3YxMi45NzRoMy4wNzYNCgkJYzEuNTk2LDE3LjI3MSw4Ljc1NSwzMi4yNjMsMjEuMzUsNDQuNjFjMTIuNTY2LDEyLjMzNiwyNy42NTgsMTkuMjAyLDQ0LjkwOCwyMC40NTF2Mi42ODhoMTIuNzk4di0yLjc2MQ0KCQljMTAuNzcyLTEuMTA0LDIwLjg0MS00LjUzNiwzMC4wMjYtMTAuMjA2djkuNzQ0aDEyLjh2LTIuNTA5aDExLjU3OXYyLjUwOWgxMS40MTJ2MTMyLjRjMCw4Ljg5My03LjIzMywxNi4xMjctMTYuMTI3LDE2LjEyNw0KCQlIMzU5LjcxNmMtMC43OTMsMC0xLjU2NC0wLjEyNy0yLjMzLTAuMjQzVjM2NS4yMzdoMi4yNzJ2LTkuNjIybC0wLjEtMC41NjZsNDUuNTE4LTExOS4xOGg0LjM5NHYtMTIuNzk1aC0xMi43OTh2Mi4xNDRoLTEyLjEwOQ0KCQl2LTAuNDc4bDIwLjY5Ny0xOC41OTloOC4zNzh2LTEyLjI5NGgtMTIuMjk0djkuNDI4bC0yMi4wMzcsMTkuNzk4aC03LjUzOXY2Ljc3OWwtMTQuMjI2LDEyLjc3N2gtMC4xNTFWNzAuNzA5DQoJCUMzNTguMTYyLDcwLjYwMiwzNTguOTI5LDcwLjQ3OSwzNTkuNzI2LDcwLjQ3OXogTTUxNy40NDksMzQwLjA3OHY2LjIyNWMtOS4wNzYsNi40NTEtMTkuMTU0LDEwLjM1Mi0zMC4wMjUsMTEuNTc1di0yLjAzNmgtMTIuNzk4DQoJCXYyLjEzN2MtMTUuMTYtMS4yMjMtMjguMzk5LTcuMzI4LTM5LjM5My0xOC4xNjNjLTEwLjk4MS0xMC44MTMtMTcuMzI5LTIzLjg5Ni0xOC44NzEtMzguOTA5aDEuNzA2di0xMi45NzloLTEuNzU5DQoJCWMxLjM0OS0xNS4xNDIsNy42MTItMjguMzgxLDE4LjY2Mi0zOS4zNzRjMTEuMDU1LTExLjAwMiwyNC4zNzItMTcuMjM4LDM5LjY1NC0xOC41NzJ2Mi4xMjhoMTIuNzk4di0xLjg5Mg0KCQljOS4yODEsMC45ODksMTguMDMxLDMuOTg5LDI2LjA2OCw4Ljk0NWM4LjMxNSw1LjExOCwxNS4xOTEsMTEuODc1LDIwLjQ4MywyMC4xMDNoLTE3LjUyM3YtMi42ODhoLTguMTU3DQoJCWMtNi4xLTQuNzQ2LTEzLjEwNi03Ljc0Ni0yMC44NzEtOC45NDJ2LTMuMjQyaC0xMi43OTh2Mi45NGMtMTAuNjEsMS4yMDUtMTkuODI3LDUuNjY0LTI3LjQ2NSwxMy4zMQ0KCQljLTcuNjQzLDcuNjM4LTEyLjE1OCwxNi44MDktMTMuNDYsMjcuMjg5aC0zLjE2djEyLjk3NGgzLjE5N2MxLjQxMiwxMC4zODMsNi4wMjEsMTkuMzgxLDEzLjcyNywyNi44MDMNCgkJYzcuNjg1LDcuMzkyLDE2LjgxLDExLjcxOCwyNy4xNjEsMTIuODk4djIuNzc3aDEyLjc5OHYtMy4wNDRjMTEuMzQ5LTEuNjI4LDIwLjg5Ny02LjkyNiwyOC40MzEtMTUuNzdoNi41MDl2LTEyLjk3N2gtMTIuNzk4djIuODYNCgkJSDQ4Ny43OHYtMi44NmgtMi44NjV2LTEyLjI5NmgyLjg2NXYtMi4xNDZoNTQuMDQ5djIuMTQ2aDIuNDc4Yy0wLjAyMSw0LjM3OS0wLjA3OCwxMy4yMzktMC4xNTMsMjYuNTc0djI2Ljc1MWgtMi4zMjR2Mi4zMzVoLTExLjU4DQoJCXYtMTQuODgxSDUxNy40NDlMNTE3LjQ0OSwzNDAuMDc4eiBNNjUuMjk3LDM0OS4xNzVjLTExLjUzLTAuMzExLTIyLjc4My0zLjgzOC0yOC4zNjgtNy4zNTRsNC41NDktMjAuMjA2DQoJCWM2LjA1NywzLjQ4MiwxNS40MjMsNy4wNCwyNS4xNjgsNy4xOThjMTAuNjE1LDAuMTg5LDE2LjIzOS00LjQ4NCwxNi4yMzktMTEuNzE3YzAtNi45MDgtNC44NzItMTAuODc2LTE3LjEzNy0xNS42OQ0KCQljLTE2LjczNS02LjM4OS0yNy40OTYtMTYuMzgtMjcuNDk2LTMyLjE1YzAtMTguNTA5LDE0LjE3NS0zMy4wNDgsMzguMDc5LTMzLjY4MmMxMS42MzMtMC4zMDgsMjAuMjcxLDIuMTE4LDI2LjQ4MSw0Ljk0NQ0KCQlsLTUuMjgxLDIwLjQ4NmMtNC4xNzYtMi4wOTItMTEuNTc3LTUuMTAzLTIxLjY0Ni00LjkzNWMtOS45ODEsMC4xNjUtMTQuNzkyLDUuMTMzLTE0Ljc5MiwxMC44MjcNCgkJYzAsNi45OTgsNS43MiwxMC4wNDUsMTguOTExLDE1LjM2OGMxOC4zMDcsNy4yMDIsMjcuMDMyLDE3LjQ5OSwyNy4wMzIsMzMuMjg1QzEwNy4wMywzMzQuMzI0LDkzLjUwNSwzNDkuOTI2LDY1LjI5NywzNDkuMTc1eg0KCQkgTTE3OC4xMTUsMzUwLjQ2MWwtMjkuMzAyLTAuNzU2bC0zNC41NDctMTEzLjI5NmwyNi42MjYtMC42ODJsMTMuMzEyLDQ4LjA2M2MzLjc1OSwxMy41ODMsNy4xOTUsMjYuNzExLDkuODI3LDQxLjA2M2wwLjUwNiwwLjAxMQ0KCQljMi44MDEtMTMuNzk3LDYuMjY4LTI3LjQ1NCwxMC4xMDEtNDAuNjQ2bDE0LjM5NC00OS43MjNsMjcuNjE0LTAuNzAzTDE3OC4xMTUsMzUwLjQ2MXogTTMzMC4yMzUsMzQ4LjcyOQ0KCQljLTguOTAyLDIuNzA5LTI1LjU3NSw2LjI4OS00Mi4wMjYsNS44NThjLTIyLjM2My0wLjYtMzguMjg5LTYuNTEtNDkuMjUtMTcuMzU0Yy0xMC44NTktMTAuMzgzLTE2Ljc2NC0yNS44NzktMTYuNTk4LTQzLjIwMw0KCQljMC4xNzgtMzkuMjAzLDI4Ljc5NS02Mi4zNTUsNjguNzc4LTYzLjM5MmMxNi4xMTUtMC40MjUsMjguNjgzLDIuMzU0LDM0LjkwOCw1LjEyNGwtNi4wNDgsMjIuNDA1DQoJCWMtNi45NDktMi44MTEtMTUuNTM3LTUuMDQyLTI5LjIzLTQuODEyYy0yMy4xNDIsMC4zNzYtNDAuMzI2LDEzLjQxOC00MC4zMjYsMzkuMjc4YzAsMjQuNjMxLDE1LjU2NywzOS40MjQsMzguMjk5LDM5LjgxMg0KCQljNi40NTQsMC4xMDQsMTEuNjI0LTAuNTMxLDEzLjg2Mi0xLjU3NXYtMjUuNTQ0bC0xOS4xNzQtMC4xMDl2LTIxLjM4NGw0Ni44MDYtMC4xNjRWMzQ4LjcyOXoiLz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjwvc3ZnPg0K'
    );

    //call register settings function
    add_action('admin_init', 'sfi_nirus_register_plugin');
    wp_register_style('sfi-nirus-prefix-style', plugins_url('style.css', __FILE__));
    wp_enqueue_style('sfi-nirus-prefix-style');
}

function sfi_nirus_register_plugin()
{
    //register our settings

    add_settings_field("SFI_NIRUS_FB_OPTION", "FB option", "sfi_nirus_plugged", "sfi-nirus-settings-group");
    add_settings_field("SFI_NIRUS_TWT_OPTION", "Twitter option", "sfi_nirus_plugged", "sfi-nirus-settings-group");

    register_setting("sfi-nirus-settings-group", "SFI_NIRUS_FB_OPTION");
    register_setting("sfi-nirus-settings-group", "SFI_NIRUS_TWT_OPTION");

    register_setting('sfi-nirus-settings-group', 'SFI_NIRUS_PNG_FOLDER_PATH', 'sfi_nirus_create_folder');
    register_setting("sfi-nirus-settings-group", "SFI_NIRUS_PNG_SITE_LOGO_PATH", 'sfi_nirus_create_logo');
}


function sfi_nirus_create_folder($option)
{
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $upload_dir = $upload_dir . '/' . $option;
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775);
    }

    return $option;
}

function sfi_nirus_create_logo($option)
{

    $file = new SplFileInfo($option);
    $ext  = $file->getExtension();

    if ($ext != 'svg') {
        return $option;
    }

    $upload = wp_upload_dir();

    $upload_dir = $upload['basedir'];

    if (!empty(get_option('SFI_NIRUS_PNG_FOLDER_PATH'))) {
        $fullpath = $upload_dir . '/' . get_option('SFI_NIRUS_PNG_FOLDER_PATH') . '/site_logo.png';
        $basepath = $upload['baseurl'] . '/' . get_option('SFI_NIRUS_PNG_FOLDER_PATH') . '/site_logo.png';
        $logo = ABSPATH . wp_make_link_relative($option);
        if(file_exists($logo)){
            sfi_nirus_png_create($logo, $fullpath, true);
        }else{
            $basepath = '';
        }
    }

    return $basepath;
}

function sfi_nirus_plugged()
{
    return load_template(dirname(__FILE__) . '/settings-view.php', true);
}


function sfi_nirus_uninstall_hook()
{
    resetAllPosts();
    
    $upload = wp_upload_dir();
    $upload_dir = $upload['basedir'];
    $fullpath = $upload_dir . '/' . get_option('SFI_NIRUS_PNG_FOLDER_PATH');

    if (is_dir($fullpath)) {
        $wp_filesystem_direct = new WP_Filesystem_Direct(false);
        $wp_filesystem_direct->rmdir(dirname($fullpath), true);        
    }

    delete_option('SFI_NIRUS_PNG_FOLDER_PATH');
    delete_option('SFI_NIRUS_FB_OPTION');
    delete_option('SFI_NIRUS_TWT_OPTION');
    delete_option('SFI_NIRUS_PNG_SITE_LOGO_PATH');
    remove_action( 'save_post', 'sfi_nirus_refresh_feature_image' );
    remove_action( 'wp_head', 'sfi_nirus_add_meta_tags' );
}

function resetAllPosts(){
    $query = new WP_Query( array( 
        'numberposts'	=> -1,
        'meta_key' => 'sfi-nirus-featured-png',
        'meta_compare' => 'EXISTS',
    ) );

    $allposts = get_posts( $query );

    foreach( $allposts  as $ai ) {
        delete_post_meta( $ai->ID, 'sfi-nirus-featured-png' );
        delete_post_meta( $ai->ID, 'sfi-nirus-image-hash' );
    }
    
    wp_reset_postdata();
}
