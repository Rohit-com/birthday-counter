<?php
// Database connection
    include '_dbconnect.php';

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

            $finalday = $daysLeft;

            return $daysLeft; 
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

<form method="post">
    <br>
  <label for="fname">Enter Your ID to know remaining days to your next birthday: </label><br>
  <input type="text" name="userId"> <br> <br>
  <input type="submit" value="Submit">
</form>
