<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ühenduse ebaõnnestumine: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $autoid = $_POST["autoid"];
    $lahkumismass = $_POST["lahkumismass"];

    $sql = "UPDATE Autod SET lahkumismass = $lahkumismass WHERE id = $autoid";

    if ($conn->query($sql) === TRUE) {
        echo "Väljumismass edukalt määratud!";
    } else {
        echo "Viga: " . $sql . "<br>" . $conn->error;
    }
}

// Saad valida auto väljumismassi määramiseks
$sqlSelectAutod = "SELECT id, autonr FROM Autod";
$resultSelectAutod = $conn->query($sqlSelectAutod);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Väljumismassi määramine</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php
    include("navigatsioon.php");
    ?>
    <style>
        /* Väljumismassi määramise leht */

        body {
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
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

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select,
        input[type="number"] {
            padding: 10px;
            margin: 8px 0;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Väljumismassi määramine</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="autoid">Vali auto:</label>
        <select name="autoid">
            <?php
            while ($row = $resultSelectAutod->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["autonr"] . "</option>";
            }
            ?>
        </select><br>

        <label for="lahkumismass">Väljumismass:</label>
        <input type="number" name="lahkumismass" required><br>

        <input type="submit" value="Määra väljumismass">
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
