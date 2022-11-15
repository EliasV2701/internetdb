<?php
# header("Content-Type: text/html; charset=utf-8"); => in .htaccess 


# error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_WARNING);
ini_set('display_errors', TRUE);
ini_set('log_errors',TRUE);
ini_set('error_log','./errlog/err.log');
ini_set('display_startup_errors',FALSE);


require 'config/db.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/**
 * Step 1: Require the Slim Framework using Composer's autoloader
 *
 * If you are not using Composer, you need to load Slim Framework with your own
 * PSR-4 autoloader.
 */


require 'vendor/autoload.php';
require_once 'helper/helper.php';
require_once 'security/wf_jwt.php';

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];



$c = new \Slim\Container($configuration);

$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('<h1>404: Page not found</h1>');
    };
};

$app = new Slim\App($c);



//Enable debugging (on by default)

// Get Page Name
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

// Get All locations
$app->get('/api/', function(Request $request, Response $response){
	echo("<h2>Willkommen - Slim API Home!");
});

// var_dump($segments);

if(isset($segments[2])){

	// $endpoint = $segments[3];
	// echo "Angegebener Endpunkt: *".$endpoint."*";

	require_once('api/routes.php');

	$app->options('/{routes:.+}', function ($request, $response, $args) {
	    //wf_send_report_email("RESPONSE:  " . $response . "ARGS: " . json_encode($args));
	    return $response;
	});


	$app->add(function ($req, $res, $next) {
	    $response = $next($req, $res);
	    return $response
	            ->withHeader('Access-Control-Allow-Origin', '*')
	            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, api-token, email')
	            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
	});



	$app->add(function (Request $request, Response $response, callable $next) {

		// check email / token 
		// var_dump($request);
	    if ($request->hasHeader('api-token') AND $request->hasHeader('email')) {
	    	// Do something	
			$token = $request->getHeaderLine('api-token');    	
			$email = $request->getHeaderLine('email');

		    
		    //************************************
			// ATTENTION: SHORTCUT Token Check !!
		    //************************************

		    // $check_result = WF_JWT::wf_check_Token($email, $token);

            $check_result['status'] = "success";
            $check_result['message'] = "";

		    
			if ($check_result['status'] != 'success') {
				$resp['statuscode'] = 401;
				$resp['status'] = 'error';
				$resp['data'] = null;
				$resp['message'] = 'Unauthorized: '. $check_result['message'];
				$resp['msgcode'] = 'E0401';
				return $response->withStatus(401)->withHeader('Content-Type', 'application/json')
								->write(Helper::jencode($resp));			
			}
		} else {
			$resp['statuscode'] = 401;
			$resp['status'] = 'error';
			$resp['data'] = null;
			$resp['message'] = 'Unauthorized';
			$resp['msgcode'] = 'E0401';
			return $response->withStatus(401)->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));
		}	
	    return $next($request, $response);
	});
} else {
	// echo(Helper::jencode($segments));
	echo (json_encode($segments));
	echo("Check path structure!");
}


$app->run();