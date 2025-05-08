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
		let gframe;

		$("#upload_images").on("click", function () {
			if (gframe) {
				gframe.open();
				return false;
			}

			gframe = wp.media({
				title: "Select Images",
				button: { text: "Insert Images" },
				multiple: true
			});

			gframe.on('select', function () {
				const attachments = gframe.state().get('selection').toJSON();
				const imageData = [];

				$("#images-container").html('');

				attachments.forEach(attachment => {
					const image = {
						url: attachment.sizes?.full?.url || attachment.url,
						alt: attachment.alt || '',
						caption: attachment.caption || ''
					};

					imageData.push(image);

					$("#images-container").append(`
						<div class="admin_image_single_wrapper" style="margin-right: 10px; display: inline-block;">
							<img class="admin_image_single" src="${image.url}" style="display:block; max-width:100px;" />
							<small><strong>Alt:</strong> ${image.alt}</small>
							<small><strong>Caption:</strong> ${image.caption}</small>
						</div>
					`);
				});

				// Save as JSON string in hidden field
				$("#omb_images_url").val(JSON.stringify(imageData));
			});

			gframe.open();
			return false;
		});
	});
})( jQuery );
