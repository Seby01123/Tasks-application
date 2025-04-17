<?php
session_start();

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "lista_sarcini");

if ($mysqli->connect_error) {
    die("Conectare eșuată: " . $mysqli->connect_error);
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $sql = "SELECT * FROM sarcini WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if (!$task) {
        echo "Sarcina nu a fost găsită.";
        exit();
    }
} else {
    echo "ID-ul sarcinii nu este setat.";
    exit();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editează Sarcină</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header class="titlu">
<h1>Editează o Sarcină</h1>
</header>

<div class="buttons-container">
    <a href="admin.php"><button><i class="fas fa-home"></i> Acasă</button></a>
    <a href="logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
</div>

<div class="editeaza">
    <form action="salveaza_modificari.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

        <label for="titlu">Titlu Sarcină:</label><br>
        <input type="text" id="titlu" name="titlu" value="<?php echo htmlspecialchars($task['titlu']); ?>"><br><br>

        <label for="descriere">Descriere Sarcină:</label><br>
        <input type="text" id="descriere" name="descriere" value="<?php echo htmlspecialchars($task['descriere']); ?>"><br><br>

        <label for="deadline">Deadline Sarcină:</label><br>
        <input type="date" id="deadline" name="deadline" value="<?php echo $task['deadline']; ?>"><br><br>

        <input type="submit" value="Salvează Modificările">
    </form>
</div>

</body>
</html>
