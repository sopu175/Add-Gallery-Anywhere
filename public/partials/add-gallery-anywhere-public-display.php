<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://sopu.me/
 * @since      1.0.0
 *
 * @package    Add_Gallery_Anywhere
 * @subpackage Add_Gallery_Anywhere/public/partials
 */
?>

<!-- This file primarily consists of HTML with PHP embedded for dynamic content rendering. -->

<?php
// Retrieve gallery information from post meta, sanitize data if necessary
$image = get_post_meta($attributes['id'], 'gallery_any_where', true);

// Set the number of images to show per row (column size)
$col = isset($image['show_per_image']) ? sanitize_text_field($image['show_per_image']) : 'Default';

// Split the gallery URLs into an array
$myArray = explode(';', $image['gallery_url']);

var_dump($image);


// Check if any posts are associated and set title accordingly
if ($query->have_posts()) {
    while ($query->have_posts()) : $query->the_post();
        $title = !empty(get_the_title()) ? get_the_title() : "Gallery";
    endwhile;
}

// Begin HTML structure for gallery
?>
<div class="add_gallery_any_where_section">
    <div class="add_gallery_any_where_section__row">
        <!-- Gallery container with animated thumbnails -->
        <div class="gallery-main-row" id="gallery-wrap" >
            <?php
            // Check if images are available
            if (!empty($image)) {
                foreach ($myArray as $index => $image_url) {

                    // Determine appropriate column size based on the value of $col
                    $col_class = 'col-lg-3 col-md-3'; // Default column size

                    if ($col == '6') {
                        $col_class = 'six';
                    } elseif ($col == 'Default') {
                        $col_class = 'four';
                    } elseif ($col == '4') {
                        $col_class = 'four';
                    } elseif ($col == '3') {
                        $col_class = 'three';
                    } elseif ($col == '2') {
                        $col_class = 'two';
                    }

                    // Ensure image URLs are sanitized for safety
                    $sanitized_image_url = esc_url($image_url);
                    ?>

                    <a data-fancybox data-caption="Single image" href="<?= $sanitized_image_url; ?>"
                       class="<?= esc_attr($col_class); ?> gallery-item add_gallery_any_where_section_image_single">
                        <img class="img-responsive" src="<?= $sanitized_image_url; ?>" alt="">
                    </a>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<script>

    jQuery(document).ready(function ($) {

        // Ensure the gallery container exists and is fully loaded before initializing LightGallery
        if ($('#gallery-wrap').length) {
            // First gallery
            Fancybox.bind(document.getElementById("gallery-wrap"), "[data-fancybox]", {
                // Your custom options
                wheel: "slide",
                hideScrollbar: false,
                Carousel: {
                    transition: "slide",
                },
                Thumbs: {
                    autoStart: true,
                    axis: "x",
                    position: "bottom",
                    spacing: 0,
                    showOnLoad: true,
                },
                Images: {
                    zoom: true,
                },
            });
        }
    });

</script>
