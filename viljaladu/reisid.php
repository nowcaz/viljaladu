<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ühenduse ebaõnnestumine: " . $conn->connect_error);
}

if (isset($_GET["autonr"])) {
    $autoid = $_GET["autonr"];

    // Kuvab valitud auto reisid
    $sqlSelectReisid = "SELECT * FROM Reisid WHERE autoid = $autoid";
    $resultSelectReisid = $conn->query($sqlSelectReisid);

    // Arvutab kokku toodud vilja koguse
    $kokkuToodudVili = 0;
    while ($rowReisid = $resultSelectReisid->fetch_assoc()) {
        $kokkuToodudVili += $rowReisid["viljakogus"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto reisid</title>
</head>
<body>
<h1>Auto reisid</h1>
<?php
include("navigatsioon.php");
?>

<?php
if (isset($resultSelectReisid) && $resultSelectReisid->num_rows > 0) {
    echo "<p>Kokku toodud vilja kogus: $kokkuToodudVili</p>";
    echo "<table border='1'><tr><th>ID</th><th>Kuupäev</th><th>Viljakogus</th></tr>";
    while ($rowReisid = $resultSelectReisid->fetch_assoc()) {
        echo "<tr><td>" . $rowReisid["id"] . "</td><td>" . $rowReisid["kuupäev"] . "</td><td>" . $rowReisid["viljakogus"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Reise ei leitud või andmed puuduvad.";
}
?>

</body>
</html>

<?php
$conn->close();
?>
