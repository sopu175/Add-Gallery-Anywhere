<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/admin/partials
 */

// Retrieve gallery data
$gallery_data = get_post_meta($post->ID, 'gallery_any_where', true);
$selected_column = isset($gallery_data['show_per_image']) ? esc_attr($gallery_data['show_per_image']) : 'Default';
$image_data = isset($gallery_data['gallery_url']) && is_array($gallery_data['gallery_url']) ? $gallery_data['gallery_url'] : [];

// Add a nonce field for security
wp_nonce_field('add_gallery_any_where', 'gallery_any_where_nonce');

// Column display options
$options = array(
    'Default' => __('Default', 'add-gallery-anywhere'),
    '6' => __('Six', 'add-gallery-anywhere'),
    '4' => __('Four', 'add-gallery-anywhere'),
    '3' => __('Three', 'add-gallery-anywhere'),
    '2' => __('Two', 'add-gallery-anywhere'),
);
?>
<div class="fields">
    <div class="field_c">
        <div class="input_c">
            <label for="upload_images"
                   class="mylabel"><strong><?php echo esc_html__('Add Gallery Images', 'add-gallery-anywhere') ?></strong>
                <button class="button"
                        id="upload_images"><?php echo esc_html__('Upload Images', 'add-gallery-anywhere') ?></button>
            </label>
            <hr>
            <label for="show_per_img" class="mylabel"
                   style="margin-top:15px"><strong><?php echo esc_html__('Show image per columns', 'add-gallery-anywhere') ?></strong>
                <select name="show_per_image" id="show_per_img">
                    <?php


                    foreach ($options as $value => $label) {
                        $selected = ($selected_column == $value) ? 'selected' : '';
                        echo '<option value="' . esc_attr($value) . '" ' . esc_attr($selected) . '>' . esc_html($label) . '</option>';
                    }
                    ?>
                </select></label>
            <hr>
            <input type="hidden" name="omb_images_url" id="omb_images_url"
                   value="<?php echo esc_attr(json_encode($image_data)) ?>"/>
            <div class="clearfix"></div>
            <div style="width:100%;height:auto;" id="images-container">
                <?php
                // Loop through each image and display it
                foreach ($image_data as $img) {
                    $url = esc_url($img['url'] ?? '');
                    $alt = esc_html($img['alt'] ?? '');
                    $caption = esc_html($img['caption'] ?? '');

                    ?>
                    <div class="admin_image_single_wrapper">
                        <img class="admin_image_single" style="margin-right: 10px; max-width: 100px;"
                             src="<?php echo esc_url($url) ?>"/>
                        <small><strong>Alt:</strong> <?php echo esc_html($alt) ?></small>
                        <small><strong>Caption:</strong><?php echo esc_html($caption) ?></small>
                    </div>
                    <?php

                }

                ?>
            </div>
            <div class="clearfix"></div>
            <hr>
        </div>
        <div class="float_c"></div>
    </div>
</div>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->

