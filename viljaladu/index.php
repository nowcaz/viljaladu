<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ühenduse ebaõnnestumine: " . $conn->connect_error);
}

$autonr = $sisenemismass = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $autonr = $_POST["autonr"];
    $sisenemismass = $_POST["sisenemismass"];

    $sql = "INSERT INTO Autod (autonr, sisenemismass) VALUES ('$autonr', $sisenemismass)";

    if ($conn->query($sql) === TRUE) {
        $message = "Auto edukalt lisatud!";
    } else {
        $message = "Viga: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autode haldus</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php
    include("navigatsioon.php");
    ?>
</head>
<body>
<div class="container">
    <h1>Auto sisestamine</h1>

    <?php
    if (isset($message)) {
        echo "<p class='message'>$message</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Autonumber: <input type="text" name="autonr" required><br>
        Sisenemismass: <input type="number" name="sisenemismass" required><br>
        <input type="submit" value="Lisa auto">
    </form>

</div>
</body>
</html>
