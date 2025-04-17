<?php
session_start();  // Începe sesiunea

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    // Dacă nu este logat, redirecționează la pagina de login
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Conectare la baza de date
    $conn = new mysqli('localhost', 'root', '', 'lista_sarcini'); 
    if ($conn->connect_error) { 
        die("Conexiune eșuată: " . $conn->connect_error); 
    }

    $titlu = $_POST['titlu']; 
    $descriere = $_POST['descriere']; 
    $deadline = $_POST['deadline']; 

    // Interogare pentru a adăuga sarcina
    $sql = "INSERT INTO sarcini (titlu, descriere, deadline) VALUES ('$titlu', '$descriere', '$deadline')"; 
    
    if ($conn->query($sql) === TRUE) { 
        echo "<div class='message success'>
                Sarcina a fost adăugată cu succes!
                <br><a href='admin.php' class='btn-back'>Înapoi la lista de sarcini</a>
              </div>"; 
    } else { 
        echo "<div class='message error'>
                Eroare: " . $conn->error . "
                <br><a href='admin.php' class='btn-back'>Înapoi la lista de sarcini</a>
              </div>"; 
    }

    $conn->close(); 
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Adaugă Sarcină</title> 
    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<header class="titlu">
    <h1>Adaugă o Sarcină Nouă</h1> 
</header>

<div class="buttons-container">
    <a href="admin.php"><button><i class="fas fa-home"></i> Acasă</button></a> 
    <a href="logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a> 
</div>

<div class="form-container">
    <form action="adauga.php" method="POST"> 
        <label for="titlu">Titlu Sarcină:</label>
        <input type="text" name="titlu" id="titlu" required><br><br> 

        <label for="descriere">Descriere:</label>
        <input type="text" name="descriere" id="descriere" required><br><br> 

        <label for="deadline">Deadline:</label>
        <input type="date" name="deadline" id="deadline" required><br><br>
        <input type="submit" value="Adaugă Sarcină"> 
    </form>
</div>

</body>
</html>
