<?php
$image = get_post_meta($attributes['id'], 'gallery_any_where', true);
$col = $image['show_per_image'];


$myArray = explode(';', $image['gallery_url']);
$title = "Gallery";
if ($query->have_posts()) {
    while ($query->have_posts()) : $query->the_post();
        if (empty(get_the_title())) {
            $title = "Gallery";
        } else {
            $title = get_the_title();
        }
    endwhile;
}
?>
<section class="add_gallery_any_where_section">
    <div class="container">
        <div class="row lightgalleryinit">
            <h3 class="mainTitle text-center"><?= $title ?></h3>

            <div class="clearfix"></div>

            <?php
            if (!empty($image)) {
                foreach ($myArray as $index => $image) {
                    ?>

                    <div class="<?php if($col == null){ echo "col-lg-3 col-md-3";}elseif ($col=="6"){echo "col-lg-2 col-md-2";}elseif ($col=="Default"){echo "col-lg-3 col-md-3";}elseif ($col=="4"){echo "col-lg-3 col-md-3";}elseif ($col=="3"){echo "col-lg-4 col-md-4";}elseif ($col=="2"){echo "col-lg-6 col-md-6";} ?> col-xs-6 add_gallery_any_where_section_image_single">
                        <div class="image_wrapper">
                            <div class="hover_with_overflow">
                                <div class="image_bg " style="background-image: url('<?=$myArray[$index]?>');">
                                    <a class="" href="<?=$myArray[$index]?>" ></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>



