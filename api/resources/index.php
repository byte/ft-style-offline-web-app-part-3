<?php
// Concatenate the files in the /source/ directory
// This would be a sensible point to compress your Javascript.
$js = '';
$js .= file_get_contents('../../libraries/client/fastclick.js');
$js = $js . 'window.APP={}; (function (APP) {';
$js = $js . file_get_contents('../../source/application/applicationcontroller.js');
$js = $js . file_get_contents('../../source/articles/articlescontroller.js');
$js = $js . file_get_contents('../../source/articles/article.js');
$js = $js . file_get_contents('../../source/datastores/network.js');
$js = $js . file_get_contents('../../source/datastores/indexeddb.js');
$js = $js . file_get_contents('../../source/datastores/websql.js');
$js = $js . file_get_contents('../../source/templates.js');
$js = $js . file_get_contents('../../source/appcache.js');
$js = $js . '}(APP)),';

// Detect and set the absolute path to the root of the web app
// First get a clean version of the current directory (will include api/resources)
$appRoot = trim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Strip of api/resources from the end of the path
$appRoot = trim(preg_replace('/api\/resources$/i', '', $appRoot), '/');

// Ensure the path starts and ends with a slash or just / if on the root of domain
$appRoot = '/' . ltrim($appRoot . '/', '/');

$js = $js . 'APP_ROOT = "' . $appRoot . '";';

$output['js'] = $js;

// Concatenate the files in the /css/ directory
// This would be a sensible point to compress your css
$css = '';
$css = $css . file_get_contents('../../css/global.css');
$output['css'] = $css;

// Encode with JSON (PHP 5.2.0+) & output the resources
echo json_encode($output);
