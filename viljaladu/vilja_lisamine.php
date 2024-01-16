<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ühenduse ebaõnnestumine: " . $conn->connect_error);
}

$autoid = $kuupäev = $viljakogus = $asukoht = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $autoid = $_POST["autoid"];
    $kuupäev = $_POST["kuupäev"];
    $viljakogus = $_POST["viljakogus"];
    $asukoht = $_POST["asukoht"];

    $sql = "INSERT INTO Reisid (autoid, kuupäev, viljakogus, asukoht) VALUES ($autoid, '$kuupäev', $viljakogus, '$asukoht')";

    if ($conn->query($sql) === TRUE) {
        $message = "Vili edukalt lisatud!";
    } else {
        $message = "Viga: " . $sql . "<br>" . $conn->error;
    }
}

// Kuvab autode ripploendi
$sqlSelectAutod = "SELECT id, autonr FROM Autod";
$resultSelectAutod = $conn->query($sqlSelectAutod);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vilja lisamine</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php
    include("navigatsioon.php");
    ?>
    <style>
        /* Vilja lisamise leht */

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
        input[type="text"],
        input[type="date"],
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

        p.message {
            color: green;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Reisid</h1>

    <?php
    if (isset($message)) {
        echo "<p class='message'>$message</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="autoid">Vali auto:</label>
        <select name="autoid" required>
            <?php
            while ($row = $resultSelectAutod->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["autonr"] . "</option>";
            }
            ?>
        </select><br>

        <label for="kuupäev">Kuupäev:</label>
        <input type="date" name="kuupäev" required><br>

        <label for="viljakogus">Viljakogus:</label>
        <input type="number" name="viljakogus" required><br>

        <label for="asukoht">Asukoht:</label>
        <input type="text" name="asukoht" required><br>

        <input type="submit" value="Lisa vili">
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
