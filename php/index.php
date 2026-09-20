<?php
// Retrieve MySQL credentials from environment variables
$servername = getenv('MYSQL_HOST');  // This will be "mysql" based on the environment
$username = getenv('MYSQL_USER') ;
$password = getenv('MYSQL_PASSWORD') ;
$dbname = getenv('MYSQL_DB') ;

// echo $servername . "\n";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);

    // Check connection
    echo "Connected successfully to the database using PDO!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// Create table student 
$sql = "CREATE TABLE students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
$pdo->exec($sql);
echo "Table students created successfully";


$sql = "SELECT * FROM students";
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch()) {
    echo $row['name'] . "\n";
}

// Insert data into the table
$sql = "INSERT INTO students (name) VALUES ('John Doe')";
$pdo->exec($sql);
echo "New record created successfully";

?>