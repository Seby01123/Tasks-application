<?php
// Conectare la baza de date
$mysqli = new mysqli("localhost", "root", "", "lista_sarcini");

// Verificare conexiune
if ($mysqli->connect_error) {
    die("Conectare eșuată: " . $mysqli->connect_error);
}

// Verificăm dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preluăm datele din formular
    $task_id = $_POST['id'];
    $titlu = $_POST['titlu'];
    $descriere = $_POST['descriere'];
    $deadline = $_POST['deadline'];

    // Actualizăm sarcina în baza de date
    $sql = "UPDATE sarcini SET titlu = ?, descriere = ?, deadline = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssi", $titlu, $descriere, $deadline, $task_id);

    if ($stmt->execute()) {
        echo "Sarcina a fost actualizată cu succes!";
        header("Location: admin.php"); // Redirecționează către pagina principală
        exit();
    } else {
        echo "Eroare la actualizarea sarcinii: " . $stmt->error;
    }
}

// Închidem conexiunea la baza de date
$mysqli->close();
?>
