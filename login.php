<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="titlu">
    <h1>LOGIN</h1> 
</header>

<div class="login">
    <form action="verifica_login.php" method="POST">
        <label for="username">Utilizator:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="parola">Parolă:</label><br>
        <input type="password" id="parola" name="parola" required><br><br>

        <input type="submit" value="Conectează-te">
        <br>
        <!-- Buton pentru a naviga la register.php -->
        <button type="button" onclick="window.location.href='register.php'" class="register-button">Înregistrează-te</button>
    </form>
</div>

</body>
</html>
