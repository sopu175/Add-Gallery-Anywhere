<?php

/**
 * Provide a admin area image view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/admin/partials
 */
?>





<!--get post data -->
<?php
$image_id =get_post_meta($post->ID, 'gallery_any_where', true);

if(!empty($image_id)){

//    explode use for get individual link use ;
    $myArray = explode(';', $image_id['gallery_url']);

    if(!empty($image_id)){
    ?>
    <p style="margin-top: 30px; margin-bottom: 5px"><strong >Current Selected Images</strong></p>
    <div style="width:100%;height:auto;" id="images-container2">
        <?php
        foreach ($myArray as $index => $image){

            ?>

            <img  class="admin_image_single" data-sub-html="#caption2" src='<?=$myArray[$index]?>' />
            <?php
        }
        ?>
    </div>
    <?php
}

}



?>