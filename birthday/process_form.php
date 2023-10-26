<?php
// Ensure that the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection
    include '_dbconnect.php';

    // Get and sanitize form inputs
    $name = $_POST["name"];
    $birthdate = $_POST["birthdate"];

    // Prepare and execute the SQL query to insert data into the database
    $stmt = $conn->prepare("INSERT INTO `day` (name, birthdate) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $birthdate);

    if ($stmt->execute()) {
        // Get the generated ID and print it
        $generatedId = $conn->insert_id;
        echo "Data inserted successfully. The generated ID is: " . $generatedId . " . Use this ID on the countdown page to know when your next birthday is.";
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Birthday Countdown</title>
</head>
<body>
    <h1>Birthday Countdown</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Database connection
    // include '_dbconnect.php';


// Function to get the next birthday for a given user ID
function getNextBirthday($userId, $conn) {
    // Retrieve user's birthdate from the database
    $sql = "SELECT birthdate FROM day WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $birthdate = new DateTime($row["birthdate"]);

            // Calculate the next birthday
            $today = new DateTime();
            $nextBirthday = new DateTime($today->format("Y") . "-" . $birthdate->format("m-d"));
            if ($nextBirthday < $today) {
                $nextBirthday->modify("+1 year");
            }

            // Calculate the number of days remaining until the next birthday
            $interval = $today->diff($nextBirthday);
            $daysLeft = $interval->days;

            $finalday = $daysLeft + 1;

            return $finalday;
        } else {
            return "User not found.";
        }
    } else {
        return "Error: " . $conn->error;
    }
}

// Check if the form was submitted
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $daysLeftUntilNextBirthday = getNextBirthday($userId, $conn);
    echo "Days left until your next birthday: " . $daysLeftUntilNextBirthday . "<br>";
} elseif (isset($_POST['userId']) && empty($_POST['userId'])) {
    echo "Please enter a valid user ID.";
}
?>