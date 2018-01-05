window.addEvent('domready', function() { // wait for the content

	// our uploader instance

	var up = new FancyUpload2($('demo-status'), $('demo-list'), { // options object
		// we console.log infos, remove that in production!!
		//verbose: true,

		// url is read from the form, so you just have to change one place
		url: $('form-demo').action,

		// path to the SWF file
		path: 'source/Swiff.Uploader.swf',

		// remove that line to select all files, or edit it, add more items
		typeFilter: {
			'Images (*.jpg, *.jpeg, *.gif, *.png, *.bmp)': '*.jpg; *.jpeg; *.gif; *.png'
		},

		// this is our browse button, *target* is overlayed with the Flash movie
		target: 'demo-browse',

		onSelect: function() {
			document.getElementById('browse').style.display = "none";
			document.getElementById('clear').style.display = "block";
			up.start();
		},

		// graceful degradation, onLoad is only called if all went well with Flash
		onLoad: function() {
			$('demo-status').removeClass('hide'); // we show the actual UI
			$('demo-fallback').destroy(); // ... and hide the plain form

			// We relay the interactions with the overlayed flash to the link
			this.target.addEvents({
				click: function() {
					return false;
				},
				mouseenter: function() {
					this.addClass('hover');
				},
				mouseleave: function() {
					this.removeClass('hover');
					this.blur();
				},
				mousedown: function() {
					this.focus();
				}
			});

			// Interactions for the 2 other buttons

			$('demo-clear').addEvent('click', function() {
				up.remove(); // remove all files
				document.getElementById('browse').style.display = "block";
				document.getElementById('clear').style.display = "none";
				document.getElementById("thumbnail").innerHTML = "";

				//Reset form elements
				up.overallProgress.set(0);
				up.currentProgress.set(0);
				document.getElementById("formbutton").style.display = "none";

				playSound('sounds/boing.mp3');

				return false;
			});

			$('demo-upload').addEvent('click', function() {
				//up.start(); // start upload
				return false;
			});
		},

		// Edit the following lines, it is your custom event handling

		/**
		 * Is called when files were not added, "files" is an array of invalid File classes.
		 *
		 * This example creates a list of error elements directly in the file list, which
		 * hide on click.
		 */
		onSelectFail: function(files) {
			files.each(function(file) {
				new Element('li', {
					'class': 'validation-error',
					html: file.validationErrorMessage || file.validationError,
					title: MooTools.lang.get('FancyUpload', 'removeTitle'),
					events: {
						click: function() {
							this.destroy();
						}
					}
				}).inject(this.list, 'top');
			}, this);
		},

		/**
		 * This one was directly in FancyUpload2 before, the event makes it
		 * easier for you, to add your own response handling (you probably want
		 * to send something else than JSON or different items).
		 */
		onFileSuccess: function(file, response) {
			var json = new Hash(JSON.decode(response, true) || {});

			if (json.get('status') == '1') {
				file.element.addClass('file-success');
				file.info.set('html', '<strong>Image was uploaded:</strong> ' + json.get('width') + ' x ' + json.get('height') + 'px, <em>' + json.get('mime') + '</em>)');

				//Spencer's code
				var familyName = document.getElementById("curdb").innerHTML;
				document.getElementById("filename").value = 'uploads/' + familyName + '/' + file.name;
				document.getElementById("formbutton").style.display = "block";
				document.getElementById("thumbnail").style.display = "block";
				//document.getElementById("browse").style.display = "none";
				//document.getElementById("clear").style.display = "block";

				var ext = file.name.split('.').pop();
				var tnName = file.name.substr(0, file.name.length - (ext.length + 1)) + "-tn." + ext;
				tnName = tnName.toLowerCase();
				//Create thumbnail after image has been uploaded (with clickable preview in popup window)
				document.getElementById("thumbnail").innerHTML = "";
				document.getElementById("thumbnail").innerHTML = "<a onclick=\"javascript:openPopup('uploads/" + familyName + "/" + file.name.toLowerCase() + "', " + json.get('width') + ", " + json.get('height') + ")\"><img id=\"tnpreview\" src=\"uploads/" + familyName +
				"/thumbnails/" + tnName + "\" /></a><br/><a href=\"uploads/" + familyName + "/" + file.name.toLowerCase() + "\" target=\"new\">Preview...</a>";

				playSound('sounds/fairybell.mp3');

			} else {
				file.element.addClass('file-failed');
				file.info.set('html', '<strong>An error occured:</strong> ' + (json.get('error') ? (json.get('error') + ' #' + json.get('code')) : response));
			}
		},

		/**
		 * onFail is called when the Flash movie got bashed by some browser plugin
		 * like Adblock or Flashblock.
		 */
		onFail: function(error) {
			switch (error) {
				case 'hidden': // works after enabling the movie and clicking refresh
					alert('To enable the embedded uploader, unblock it in your browser and refresh (see Adblock).');
					break;
				case 'blocked': // This no *full* fail, it works after the user clicks the button
					alert('To enable the embedded uploader, enable the blocked Flash movie (see Flashblock).');
					break;
				case 'empty': // Oh oh, wrong path
					alert('A required file was not found, please be patient and we fix this.');
					break;
				case 'flash': // no flash 9+ :(
					alert('To enable the embedded uploader, install the latest Adobe Flash plugin.')
			}
		}

	});

});

function openPopup(img, width, height)
{
	var myWnd = window.open("", "Image", "width=" + width + ", height=" + height + ", scrollbars=yes");
	myWnd.document.write("<img src=\"" + img + "\" />");
}

function deleteImg($imgName)
{

}

