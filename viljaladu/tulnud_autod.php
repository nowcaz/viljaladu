<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ühenduse ebaõnnestumine: " . $conn->connect_error);
}

// Kuvab kõik autod koos andmetega
$sqlSelectAutod = "SELECT id, autonr, sisenemismass, lahkumismass FROM Autod";
$resultSelectAutod = $conn->query($sqlSelectAutod);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulnud autod</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php
    include("navigatsioon.php");
    ?>
    <style>
        /* Tulnud autode leht */

        body {
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        a {
            color: #0066cc;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tulnud autod</h1>

    <?php
    if ($resultSelectAutod->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Autonumber</th><th>Sisenemismass</th><th>Lahkumismass</th><th>Maha laetud koorma suurus</th></tr>";
        while($row = $resultSelectAutod->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td><a href='reisid.php?autoid=" . $row["id"] . "'>" . $row["autonr"]. "</a></td><td>" . $row["sisenemismass"]. "</td><td>" . $row["lahkumismass"]. "</td><td>" . ($row["lahkumismass"] - $row["sisenemismass"]) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Andmeid ei leitud.";
    }
    ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
