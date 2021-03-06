<?php
// Detect the app root (taken from api/resources/index.php)
$appRoot = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
$appRoot = '/' . ltrim($appRoot . '/', '/');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
		<script type="text/javascript" src="<?php echo $appRoot; ?>jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {

				var APP_START_FAILED = "I'm sorry, the app can't start right now.";
				function startWithResources(resources, storeResources) {

					// Try to execute the Javascript
					try {
						eval(resources.js);
						APP.applicationController.start(resources, storeResources);

					// If the Javascript fails to launch, stop execution!
					} catch (e) {
						if (typeof console !== "undefined") {
							console.log(e);
						}
						alert(APP_START_FAILED);
					}
				}
				function startWithOnlineResources(resources) {
					startWithResources(resources, true);
				}

				function startWithOfflineResources(e) {
					var resources;

					// If we have resources saved from a previous visit, use them
					if (localStorage && localStorage.resources) {
						resources = JSON.parse(localStorage.resources);
						startWithResources(resources, false);

					// Otherwise, apologize and let the user know
					} else {
						alert(APP_START_FAILED);
					}
				}

				// If we know the device is offline, don't try to load new resources
				if (navigator && navigator.onLine === false) {
					startWithOfflineResources();

				// Otherwise, download resources, eval them, if successful push them into local storage.
				} else {
					$.ajax({
						url: '<?php echo $appRoot; ?>api/resources/',
						success: startWithOnlineResources,
						error: startWithOfflineResources,
						dataType: 'json'
					});
				}

			});
		</script>
		<title>News</title>
	</head>
<body>
	<div id="loading">Loading&hellip;</div>
</body>
</html>
