<?php
session_start(); // Pornim sesiunea pentru a putea folosi variabilele $_SESSION

$conn = new mysqli('localhost', 'root', '', 'lista_sarcini'); // Creăm conexiunea cu baza de date

if ($conn->connect_error) { // Verificăm dacă conexiunea a eșuat
    die("Conexiune eșuată: " . $conn->connect_error); // Oprim execuția și afișăm eroarea
}

if (isset($_POST['delete']) && isset($_POST['id'])) { // Verificăm dacă s-a trimis formularul de ștergere și există un ID
    $id = $_POST['id']; // Preluăm ID-ul sarcinii din formular
    $sql = "DELETE FROM sarcini WHERE id = '$id'"; // Pregătim query-ul SQL pentru ștergere

    if ($conn->query($sql) === TRUE) { // Executăm query-ul și verificăm dacă a fost cu succes
        $_SESSION['delete_success'] = true; // Setăm un mesaj de succes în sesiune
        header("Location: index.php"); // Redirecționăm către index.php
        exit(); // Oprim execuția scriptului
    } else {
        echo "Eroare: " . $conn->error; // Afișăm eroarea dacă ștergerea a eșuat
    }
}

if (isset($_POST['complete']) && isset($_POST['id'])) { // Verificăm dacă s-a trimis formularul de completare și există un ID
    $id = $_POST['id']; // Preluăm ID-ul sarcinii
    $sql = "UPDATE sarcini SET completata = 1 WHERE id = '$id'"; // Pregătim query-ul pentru a marca sarcina ca finalizată

    if ($conn->query($sql) === TRUE) { // Executăm query-ul
        $_SESSION['complete_success'] = true; // Setăm mesaj de succes
        header("Location: index.php"); // Redirecționăm către index.php
        exit(); // Oprim scriptul
    } else {
        echo "Eroare: " . $conn->error; // Afișăm eroarea dacă query-ul a eșuat
    }
}

$sql = "SELECT * FROM sarcini"; // Pregătim un query pentru a selecta toate sarcinile
$result = $conn->query($sql); // Executăm query-ul și salvăm rezultatul
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setăm codificarea caracterelor pentru suport RO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Optimizare pentru mobil -->
    <title>Gestionare Sarcini</title> <!-- Titlul paginii în browser -->
    <link rel="stylesheet" href="style.css"> <!-- Legăm fișierul CSS pentru stilizare -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<header class="titlu">
    <h1>Lista de Sarcini</h1> <!-- Titlul principal al paginii -->
</header>

<div class="buttons-container">
<a href="login.php"><button><i class="fas fa-sign-in-alt"></i> Login</button></a>  <!-- Buton pentru autentificare -->
    <!-- Butonul de editare general a fost eliminat -->
</div>

<div class="container">
    <h1>Vizualizare Sarcini</h1> <!-- Titlul secțiunii cu sarcinile existente -->

    <?php if (isset($_GET['edit']) && $_GET['edit'] === 'success') : ?> <!-- Mesaj de confirmare dacă s-a editat o sarcină -->
        <p style="color: green; text-align: center;">Sarcina a fost editată cu succes!</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th> <!-- Coloana ID -->
            <th>Titlu</th> <!-- Coloana Titlu -->
            <th>Descriere</th> <!-- Coloana Descriere -->
            <th>Deadline</th> <!-- Coloana Deadline -->
            <th>Stare</th> <!-- Coloana Stare (completată sau nu) -->
            <th>Acțiuni</th> <!-- Coloana cu butoane -->
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?> <!-- Iterăm prin fiecare sarcină -->
            <tr id="row-<?php echo $row['id']; ?>"> <!-- Identificator unic pentru fiecare rând -->
                <td><?php echo $row['id']; ?></td> <!-- Afișăm ID-ul -->
                <td><?php echo $row['titlu']; ?></td> <!-- Afișăm titlul -->
                <td><?php echo $row['descriere']; ?></td> <!-- Afișăm descrierea -->
                <td><?php echo $row['deadline']; ?></td> <!-- Afișăm deadline-ul -->
                <td><?php echo $row['completata'] ? 'Completată' : 'Necompletată'; ?></td> <!-- Afișăm starea sarcinii -->

                <td>
                    <div class="action-buttons">
                        <?php if ($row['completata'] == 0) { ?> <!-- Dacă nu e completată -->
                            <form action="" method="POST" style="display:inline;"> <!-- Formular pentru marcarea ca completată -->
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Ascundem ID-ul -->
                                <input type="submit" name="complete" value="✔ Marchează ca completată"> <!-- Butonul de completare -->
                            </form>
                        <?php } else { ?>
                            <span>Completată</span> <!-- Dacă e deja completată -->
                        <?php } ?>


                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close(); // Închidem conexiunea la baza de date
?>
