<?php
// Conectare la baza de date
$conn = new mysqli('localhost', 'root', '', 'lista_sarcini');

if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

// Verifică dacă datele au fost trimise prin POST
if (isset($_POST['username']) && isset($_POST['parola']) && isset($_POST['role'])) {
    $username = $_POST['username'];
    $parola = $_POST['parola'];
    $role = $_POST['role'];

    // Verifică dacă rolul este admin și parola admin este corectă
    if ($role == 'admin' && (!isset($_POST['admin-password']) || $_POST['admin-password'] != 'proiectfloreasebastian')) {
        echo "Parola admin incorectă!";
        exit();
    }

    // Previne SQL Injection
    $username = $conn->real_escape_string($username);
    $role = $conn->real_escape_string($role);

    // Criptare parolă
    $hashed_password = password_hash($parola, PASSWORD_DEFAULT);

    // Verifică dacă utilizatorul există deja
    $sql_check = "SELECT * FROM utilizatori WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        echo "Utilizatorul există deja!";
    } else {
        // Inserare utilizator în baza de date
        $sql = "INSERT INTO utilizatori (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

        if ($conn->query($sql) === TRUE) {
            // Redirecționează către pagina de login după înregistrare
            header("Location: login.php");
            exit(); // Opriți execuția scriptului pentru a preveni încărcarea unei pagini suplimentare
        } else {
            echo "Eroare la înregistrare: " . $conn->error;
        }
    }
} else {
    echo "Completati toate câmpurile!";
}

$conn->close();
?>
