<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

require '../src/vendor/autoload.php';

$app = new \Slim\App;

// Enable CORS (Cross-Origin Resource Sharing)
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Endpoint to insert data into the database
$app->post('/postName', function (Request $request, Response $response, array $args) {
    try {
        $data = json_decode($request->getBody());

        if (!empty($data->fname) && !empty($data->lname)) {
            $fname = $data->fname;
            $lname = $data->lname;

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "demo";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO names (fname, lname) VALUES (:fname, :lname)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->execute();

            $conn = null;

            $responseArray = [
                "status" => "success",
                "data" => null,
            ];

            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        } else {

            $responseArray = [
                "status" => "error",
                "message" => "Invalid or missing data",
            ];
            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        }
    } catch (PDOException $e) {

        $errorMessage = [
            "status" => "error",
            "message" => $e->getMessage(),
        ];
        $response->getBody()->write(json_encode($errorMessage));
        return $response->withHeader('Content-Type', 'application/json');
    }
});

// Endpoint to extract data from the database
$app->get('/printName', function (Request $request, Response $response, array $args) {
    // Database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "demo";

    $data = [];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT fname, lname FROM names";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            $data[] = [
                "lname" => $row["lname"],
                "fname" => $row["fname"],
            ];
        }

        $responseArray = [
            "status" => "success",
            "data" => $data,
        ];

        $response->getBody()->write(json_encode($responseArray));
    } catch (PDOException $e) {
        $responseArray = [
            "status" => "error",
            "message" => $e->getMessage(),
        ];
        $response->getBody()->write(json_encode($responseArray));
    }
    $conn = null;

    return $response;
});

// Endpoint to update data in the database
$app->post('/updateName', function (Request $request, Response $response, array $args) {
    try {
        $data = json_decode($request->getBody());

        if (!empty($data->id) && !empty($data->fname) && !empty($data->lname)) {
            $id = $data->id;
            $fname = $data->fname;
            $lname = $data->lname;

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "demo";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE names SET fname = :fname, lname = :lname WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $conn = null;

            $responseArray = [
                "status" => "success",
                "data" => null,
            ];

            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $responseArray = [
                "status" => "error",
                "message" => "Invalid or missing data",
            ];
            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        }
    } catch (PDOException $e) {

        $errorMessage = [
            "status" => "error",
            "message" => $e->getMessage(),
        ];
        $response->getBody()->write(json_encode($errorMessage));
        return $response->withHeader('Content-Type', 'application/json');
    }
});

// Endpoint to delete data from the database
$app->delete('/deleteName', function (Request $request, Response $response, array $args) {
    try {
        $data = json_decode($request->getBody());

        if (!empty($data->id)) {
            $id = $data->id;

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "demo";

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DELETE FROM names WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $conn = null;

            $responseArray = [
                "status" => "success",
                "data" => null,
            ];

            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        } else {

            $responseArray = [
                "status" => "error",
                "message" => "Invalid or missing data",
            ];
            $response->getBody()->write(json_encode($responseArray));
            return $response->withHeader('Content-Type', 'application/json');
        }
    } catch (PDOException $e) {
        $errorMessage = [
            "status" => "error",
            "message" => $e->getMessage(),
        ];
        $response->getBody()->write(json_encode($errorMessage));
        return $response->withHeader('Content-Type', 'application/json');
    }
});

$app->run();
    