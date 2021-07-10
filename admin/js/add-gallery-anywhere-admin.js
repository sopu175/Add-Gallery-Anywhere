(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	var frame, gframe , i;
	$(document).ready(function () {


		// click upload button events
		$("#upload_images").on("click", function () {


			// wordpress javascript reference wp media
			if (gframe) {
				gframe.open();
				return false;
			}
			// set multiple image select feature
			gframe = wp.media({
				title: "Select Image",
				button: {
					text: "Insert Image"
				},

				multiple: true,

			});

			gframe.on('select', function () {
				var image_ids = [];
				var image_urls = [];
				var attachments = gframe.state().get('selection').toJSON();

				$("#images-container").html('');
				for (i in attachments) {
					var attachment = attachments[i];
					image_ids.push(attachment.id);

					image_urls.push(attachment.sizes.full.url);
					$("#images-container").append(`<img class="admin_image_single" style="margin-right: 10px;" src='${attachment.sizes.full.url}' />`);

				}

				$("#omb_images_url").val(image_urls.join(";"));


			});


			gframe.open();
			return false;
		});
	});
})( jQuery );
