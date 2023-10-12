# API Name

API for Managing Names

## API Description

This setup focuses on a simple API using the Slim framework for CRUD operations.

## API Endpoints

- `POST /postName`: Insert a new name into the database.
- `GET /printName`: Retrieve a list of names from the database.
- `POST /updateName`: Update an existing name in the database.
- `DELETE /deleteName`: Delete a name from the database.

## Request Payload

### POST /postName

To insert a new name, send a POST request with a JSON request body containing the following fields:

- `fname` (string): The first name.
- `lname` (string): The last name.

Example Request Payload:

```json
{
    "fname": "manny",
    "lname": "hortizuela"
}

```
### POST /updateName
To update an existing name, send a POST request with a JSON request body containing the following fields:

- `id` (integer): The ID of the name to be updated.
- `fname` (string): The updated first name.
- `lname` (string): The updated last name.

Example Request Payload:

```json
{
    "id": 1,
    "fname": "manny",
    "lname": "hortizuela"
}
```
### DELETE /deleteName
To delete a name, send a DELETE request with a JSON request body containing the following field:

- `id` (integer): The ID of the name to be deleted.

Example Request Payload:

```json
{
    "id": 1
}
```

## Response
The API responds with JSON data, including a status field and, in the case of success, the data associated with the operation.

Example Response (Success):
```json
{
    "status": "success",
    "data": null
}
```

Example Response (Error):

```json
{
    "status": "error",
    "message": "Invalid or missing data"
}
```

## Usage
You can use the API by sending HTTP requests to the respective endpoints using your preferred HTTP client or programming language.

Insert Data using POST `/postName`:

```php
<?php
// API endpoint URL
$url = 'http://localhost:8080/postName';

// Data to send in the request payload
$data = [
    'fname' => 'manny',
    'lname' => 'hortizuela',
];

// Create HTTP request options
$options = [
    'http' => [
        'header' => 'Content-type: application/json',
        'method' => 'POST',
        'content' => json_encode($data),
    ],
];

// Create a stream context
$context = stream_context_create($options);

// Send the POST request
$result = file_get_contents($url, false, $context);

// Handle the response
if ($result !== false) {
    // API call was successful
    $response = json_decode($result, true);
    if ($response['status'] === 'success') {
        echo 'Data inserted successfully.';
    } else {
        echo 'Error: ' . $response['message'];
    }
} else {
    echo 'Error: Failed to make the API request.';
}
?>
```




Retrieve Data using GET `/printName`:


```php
<?php
// API endpoint URL
$url = 'http://localhost:8080/printName';

// Send a GET request
$response = file_get_contents($url);

// Handle the response
if ($response !== false) {
    // API call was successful
    $data = json_decode($response, true);
    if ($data['status'] === 'success') {
        foreach ($data['data'] as $item) {
            echo 'First Name: ' . $item['fname'] . '<br>';
            echo 'Last Name: ' . $item['lname'] . '<br>';
            echo '<br>';
        }
    } else {
        echo 'Error: ' . $data['message'];
    }
} else {
    echo 'Error: Failed to make the API request.';
}
?>
```





Update Data using POST `/updateName`:


```php
<?php
// API endpoint URL
$url = 'http://localhost:8080/updateName';

// Data to send in the request payload
$data = [
    'id' => 1,      // ID of the record to update
    'fname' => 'Jane', // Updated first name
    'lname' => 'Smith', // Updated last name
];

// Create HTTP request options
$options = [
    'http' => [
        'header' => 'Content-type: application/json',
        'method' => 'POST',
        'content' => json_encode($data),
    ],
];

// Create a stream context
$context = stream_context_create($options);

// Send the POST request
$result = file_get_contents($url, false, $context);

// Handle the response
if ($result !== false) {
    // API call was successful
    $response = json_decode($result, true);
    if ($response['status'] === 'success') {
        echo 'Data updated successfully.';
    } else {
        echo 'Error: ' . $response['message'];
    }
} else {
    echo 'Error: Failed to make the API request.';
}
?>
```


Delete Data using POST `/deleteName`:


```php
<?php
// API endpoint URL
$url = 'http://localhost:8080/deleteName';

// Data to send in the request payload
$data = [
    'id' => 1, // ID of the record to delete
];

// Create HTTP request options
$options = [
    'http' => [
        'header' => 'Content-type: application/json',
        'method' => 'DELETE',
        'content' => json_encode($data),
    ],
];

// Create a stream context
$context = stream_context_create($options);

// Send the DELETE request
$result = file_get_contents($url, false, $context);

// Handle the response
if ($result !== false) {
    // API call was successful
    $response = json_decode($result, true);
    if ($response['status'] === 'success') {
        echo 'Data deleted successfully.';
    } else {
        echo 'Error: ' . $response['message'];
    }
} else {
    echo 'Error: Failed to make the API request.';
}
?>

```

## License
This API is distributed under the MIT License.

## Contributors
Erven Poblete - API Developer

kingreuel33 - Contributer


## Contact
Information

ervenpoblete99@gmail.com
number Globe: 09458229663

















