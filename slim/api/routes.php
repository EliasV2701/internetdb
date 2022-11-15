<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Helper as Helper;


/**
 *     ENDPOINT: GET "/doc"
 */
$app->get('/doc', function (Request $request, Response $response) {
	$res = [
		'statuscode' 	=> 200,
		'status' 		=> 'success',
		'message' 		=> "Welcome to the documentation of dev.wappprojects.de",
		'msgcode' 		=> 'msg0100',
		'data' 			=>  null,
	];
	return $response->withStatus(200)->withHeader('Content-Type', 'application/json')
					->write(Helper::jencode($res));
});


/**
 *     ENDPOINT: GET "/locations"
 */
// Get All Locations
$app->get('/locations', function(Request $request, Response $response){

	$sql = "SELECT uuid, major, minor, location FROM locations ORDER BY major ASC";

	try{
		// Get Database Object
		$db = new db();
		// Connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		
		$resp['statuscode'] = 200;
		$resp['status'] = 'success';
		$resp['message'] = 'Locations get successful!';
		$resp['msgcode'] = '1000';
		$resp['data'] = $result;
		return $response->withStatus(200)
						->withHeader('Content-Type', 'application/json')
						->write(Helper::jencode($resp));

	} catch(PDOEception $e){
		$resp['statuscode'] = 400;
		$resp['status'] = 'error';
		$resp['message'] = $e->getMessage();
		$resp['msgcode'] = 'E1000';
		$resp['data'] = null;
		return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
						->write(Helper::jencode($resp));
	}
});

/**
 *     ENDPOINT: GET "/location/{minor}"
 */

// Get Single Location
$app->get('/location/{major}/{minor}', function(Request $request, Response $response){

	$major = $request->getAttribute('major');
	$minor = $request->getAttribute('minor');

	$sql = "SELECT uuid, major, minor, location FROM locations WHERE major = $major AND minor = $minor";

	try{
		// Get Database Object
		$db = new db();
		// Connect
		$db = $db->connect();

		$stmt = $db->query($sql);
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;

		if ($result) {
			$resp['statuscode'] = 200;
			$resp['status'] = 'success';
			$resp['message'] = 'Location get successful!';
			$resp['msgcode'] = '1010';
			$resp['data'] = $result;
			return $response->withStatus(200)
							->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));
		} else {
			$resp['statuscode'] = 404;
			$resp['status'] = 'Not found';
			$resp['message'] = "Location with minor | minor values $major | $minor not found!";
			$resp['msgcode'] = 'E1020';
			$resp['data'] = $result;
			return $response->withStatus(404)
							->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));

		}

	} catch(PDOEception $e){
		$resp['statuscode'] = 403;
		$resp['status'] = 'error';
		$resp['message'] = $e->getMessage();
		$resp['msgcode'] = 'E1010';
		$resp['data'] = null;
		return $response->withStatus(403)->withHeader('Content-Type', 'application/json')
						->write(Helper::jencode($resp));
	}
});


/**
 *     ENDPOINT: POST "/location/add"
 */
// Get All Locations


// Add Location
$app->post('/location/add', function(Request $request, Response $response){

	try {
		$uuid = $request->getParam('uuid');
		$major = $request->getParam('major');
		$minor = $request->getParam('minor');
		$location = $request->getParam('location');

		$sql = "INSERT INTO locations_K999999 (uuid, major, minor, location) VALUES (:uuid, :major, :minor, :location)";

		try{
			// Get Database Object
			$db = new db();
			// Connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);

			$stmt->bindParam(':uuid', $uuid);
			$stmt->bindParam(':major', $major);
			$stmt->bindParam(':minor', $minor);
			$stmt->bindParam(':location', $location);

			$stmt->execute();

			$resp['statuscode'] = 200;
			$resp['status'] = 'success';
			$resp['message'] = 'Location added successfully!';
			$resp['msgcode'] = '1010';
			$resp['data'] = '';
			return $response->withStatus(200)
							->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));

		} catch(PDOExeption $e){
			echo $e->getMessage();
			$resp['statuscode'] = 520;
			$resp['status'] = 'error';
			$resp['message'] = 'Database error: ' .$e->getMessage();
			$resp['msgcode'] = 'E1020';
			$resp['data'] = null;
			return $response->withStatus(403)->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));
		}
	} catch (Exception $e) {
		$resp['statuscode'] = 530;
		$resp['status'] = 'error';
		$resp['message'] = 'Server or database error: ' .$e->getMessage();
		$resp['msgcode'] = 'E1030';
		$resp['data'] = null;
		return $response->withStatus(403)->withHeader('Content-Type', 'application/json')
						->write(Helper::jencode($resp));
	}
});


/**
 *     ENDPOINT: PUT "/location/update"
 */

// Add Location
$app->put('/location/update', function(Request $request, Response $response){

	try {
		$uuid = $request->getParam('uuid');
		$major = $request->getParam('major');
		$minor = $request->getParam('minor');
		$location = $request->getParam('location');

		#$sql = "INSERT INTO locations_K999999 (uuid, major, minor, location) VALUES (:uuid, :major, :minor, :location)";
		$sql = "UPDATE locations_K999999 SET location = :location
				WHERE uuid = '$uuid' AND major = $major AND minor = $minor";

		try{
			// Get Database Object
			$db = new db();
			// Connect
			$db = $db->connect();

			$stmt = $db->prepare($sql);

			$stmt->bindParam(':location', $location);

			$stmt->execute();

			$resp['statuscode'] = 200;
			$resp['status'] = 'success';
			$resp['message'] = 'Location updated successfully!';
			$resp['data'] = '';
			$resp['msgcode'] = '1010';
			return $response->withStatus(200)
							->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));

		} catch(PDOExeption $e){
			echo $e->getMessage();
			$resp['statuscode'] = 520;
			$resp['status'] = 'error';
			$resp['message'] = 'Database error: ' .$e->getMessage();
			$resp['msgcode'] = 'E1020';
			$resp['data'] = null;
			return $response->withStatus(403)->withHeader('Content-Type', 'application/json')
							->write(Helper::jencode($resp));
		}
	} catch (Exception $e) {
		$resp['statuscode'] = 530;
		$resp['status'] = 'error';
		$resp['message'] = 'Server or database error: ' .$e->getMessage();
		$resp['msgcode'] = 'E1030';
		$resp['data'] = null;
		return $response->withStatus(403)->withHeader('Content-Type', 'application/json')
						->write(Helper::jencode($resp));
	}
});


/**
 *     ENDPOINT: DELETE "/location/delete/{id}"
 */

// Delete Category
$app->delete('/locations/delete/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "DELETE FROM locations WHERE id = $id";

	try{
		// Get Database Object
		$db = new db();
		// Connect
		$db = $db->connect();

		$stmt = $db->prepare($sql);
		$stmt->execute();
		$db = null;
		echo '{"notice": {"text":"Category '.$id.' Deleted"}}';
	} catch(PDOException $e){
		echo '{"error": {"text":'.$e->getMessage().'}}';
	}
});



