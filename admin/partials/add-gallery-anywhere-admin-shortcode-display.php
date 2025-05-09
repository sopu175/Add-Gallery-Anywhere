<?php

/**
 * Provide a admin area shortcode view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/admin/partials
 */

$image_id = get_post_meta(get_the_ID(), 'gallery_any_where', true);
$gallery_published = esc_attr('Published The Gallery First', 'gallery_any_where');
if (!empty($image_id)) {
    $short = esc_attr($image_id['shortcode'], 'gallery_any_where');
    $col = esc_attr($image_id['show_per_image'], 'gallery_any_where');
    if ($col == null) {
        $col = esc_attr("Default (4 image per col)", 'gallery_any_where');
    }
    $img_per_c = esc_attr('Image per column:', 'gallery_any_where');

    ?>

    <p><input type="text" readonly value="<?php echo  esc_html($short) ?>"/></p>
    <p><strong><?php echo  esc_html($img_per_c) . esc_html($col) ?> </strong></p>

    <?php
} else {
    ?>
    <p><strong><?php echo  esc_html($gallery_published) ?></strong></p>
    <?php
}


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
