<?php
$featured_img = '';
$is_logo_there = !empty(get_option('SFI_NIRUS_PNG_SITE_LOGO_PATH'));
if (is_front_page() && is_home() && $is_logo_there) {

    $featured_img = get_option('SFI_NIRUS_PNG_SITE_LOGO_PATH');

} else {
    if (has_post_thumbnail($post->ID)) {
        sfi_nirus_refresh_feature_image($post->ID);
        $featured_img = get_post_meta($post->ID, 'sfi-nirus-featured-png', false);
        $featured_img = $featured_img[0];
    } else {
        $featured_img = $is_logo_there ? get_option('SFI_NIRUS_PNG_SITE_LOGO_PATH') : '';
    }

    $file = new SplFileInfo($featured_img);
    $file_info = $file->getFilename();

    $upl = wp_upload_dir();
    $upl_dir = $upl['basedir'];

    if (!file_exists($upl_dir . '/' . get_option('SFI_NIRUS_PNG_FOLDER_PATH') . '/' . $file_info)) {
        update_post_meta($post->ID, 'sfi-nirus-image-hash', '');
        return;
    }
}

?>
<!-- SVG Featured Image plugin : generated Meta tags-->
<?php if (!empty(get_option('SFI_NIRUS_TWT_OPTION'))) { ?>
    <meta name="twitter:image" content="<?php echo esc_attr($featured_img) ?>">
<?php } ?>
<?php if (!empty(get_option('SFI_NIRUS_FB_OPTION'))) { ?>
    <meta property="og:image" content="<?php echo esc_attr($featured_img) ?>">
<?php } ?>
<!-- SVG Featured Image plugin : generated Meta tags : http://nirus.io -->