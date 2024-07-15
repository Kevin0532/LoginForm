<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf(
        "SELECT * FROM user
            WHERE email = '%s' ",
        $mysqli->real_escape_string($_POST["email"])
    );

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styling.css">
</head>

<body>
    <div class="container">
        <h1 class="loginContainer">Login</h1>

        <?php if ($is_invalid) : ?>
            <em>Invalid Login</em>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?=htmlspecialchars($_POST["email"] ?? "") ?>">
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>

            <div id="button-container">
                <button type="submit">Login</button>
            </div>
        </form>

        <div class="registerLabel">
            <p>Nog geen account? <a style="text-decoration: none; color: #07f; font-weight: 500;" href="signup.html"> Aanmelden</a></p>
        </div>


    </div>
</body>

</html>