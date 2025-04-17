<?php
session_start(); // Inițializează sesiunea pentru a păstra datele utilizatorului

// Conectare la baza de date
$conn = new mysqli('localhost', 'root', '', 'lista_sarcini');

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

// Verifică dacă datele au fost trimise prin POST
if (isset($_POST['username']) && isset($_POST['parola'])) {
    $username = $_POST['username'];
    $parola = $_POST['parola'];

    // Previne SQL Injection
    $username = $conn->real_escape_string($username);

    // Căutăm utilizatorul în baza de date
    $sql = "SELECT * FROM utilizatori WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificăm dacă parola este corectă
        if (password_verify($parola, $user['password'])) {
            // Salvează utilizatorul în sesiune
            $_SESSION['user_id'] = $user['id']; // Modificat la user_id

            // Verificăm rolul utilizatorului
            if ($user['role'] == 'admin') {
                // Redirecționăm către admin.php dacă utilizatorul este admin
                header("Location: admin.php");
                exit(); // Opriți execuția scriptului pentru a evita redirecționarea dublă
            } else {
                // Redirecționăm către index.php dacă utilizatorul este user
                header("Location: index.php");
                exit(); // Opriți execuția scriptului pentru a evita redirecționarea dublă
            }
        } else {
            echo "Parola incorectă!";
        }
    } else {
        echo "Utilizatorul nu există!";
    }
} else {
    echo "Completati toate câmpurile!";
}

$conn->close();
?>
