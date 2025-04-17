<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="titlu">
    <h1>Înregistrare</h1> 
</header>

<div class="register">
    <form action="process_register.php" method="POST">
        <label for="username">Utilizator:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="parola">Parolă:</label><br>
        <input type="password" id="parola" name="parola" required><br><br>

        <label for="role">Rol:</label><br>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <!-- Câmp pentru parola Admin -->
        <div id="admin-password-field" style="display: none;">
            <label for="admin-password">Parola Admin:</label><br>
            <input type="password" id="admin-password" name="admin-password"><br><br>
        </div>

        <input type="submit" value="Înregistrează-te">
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const adminPasswordField = document.getElementById('admin-password-field');
        if (this.value === 'admin') {
            adminPasswordField.style.display = 'block';  // Arată câmpul pentru parola admin
        } else {
            adminPasswordField.style.display = 'none';  // Ascunde câmpul pentru parola admin
        }
    });
</script>

</body>
</html>
