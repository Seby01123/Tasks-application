<?php
session_start();

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Opriți execuția scriptului pentru a preveni încărcarea paginii Admin
}

$conn = new mysqli('localhost', 'root', '', 'lista_sarcini');
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM sarcini WHERE id = '$id'");
}

if (isset($_POST['complete']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn->query("UPDATE sarcini SET completata = 1 WHERE id = '$id'");
}

$result = $conn->query("SELECT * FROM sarcini");
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sarcini</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<header class="titlu">
    <h1>Panou Administrativ</h1>
</header>

<div class="buttons-container">
    <a href="adauga.php"><button><i class="fas fa-plus-circle"></i> Adaugă Sarcină</button></a>
    <a href="logout.php"><button><i class="fas fa-sign-out-alt"></i> Logout</button></a>
</div>

<div class="container">
    <h1>Vizualizare Sarcini (Admin)</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Titlu</th>
            <th>Descriere</th>
            <th>Deadline</th>
            <th>Stare</th>
            <th>Acțiuni</th>
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
                                <input type="submit" name="complete" value="✔ Marchează ca completată" class="btn-complete"> <!-- Butonul de completare -->
                            </form>
                        <?php } else { ?>
                            <span>Completată</span> <!-- Dacă e deja completată -->
                        <?php } ?>

                        <!-- Butonul de modificare -->
                        <a href="editeaza.php?id=<?php echo $row['id']; ?>"><button class="btn-edit"><i class="fas fa-edit"></i> Modifică</button></a>

                        <!-- Formularul de ștergere -->
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete" value="❌ Șterge" class="btn-delete">
                        </form>
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