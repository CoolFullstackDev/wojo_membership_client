<?php
// db conenction
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientarea";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// get data from request
$email = $_POST['email'];
$password = $_POST['password'];

// get userdata from db
$sql = "SELECT *  FROM users WHERE email = '$email'";

if ($result = $conn->query($sql)) {
    $user = $result->fetch_assoc();
    
    $salt = $user['salt'];
    $hashed_pass = $user['hash'];
    $active = $user['active'];

    $stretch_cost = 10;

    if (function_exists('crypt') && defined('CRYPT_BLOWFISH')) {
        $hash_new = crypt($password, '$2a$' . $stretch_cost . '$' . $salt . '$');
    } else {
        $hash = '';
        for ($i = 0; $i < 20000; $i++) {
            $hash = hash('sha512', $hash . $salt . $password);
        }
        $hash_new = $hash;
    }

    if($hashed_pass == $hash_new && $active == "y") {
        $data = [
            'status' => 'success',
            'email' => $email,
            'password' => $user['hash'],
            'user_id' => $user['id'],
            'username' => $user['username'],
            'firstname' => $user['fname'],
            'lastname' => $user['lname'],
            'image' => $user['avatar'],
            'country_id' => $user['country']
        ];
    } else {
        $data = [
            'status' => 'failure'
        ];
    }
} else {
    $data = [
        'status' => 'failure'
    ];
}

// send response to support site
echo json_encode($data);