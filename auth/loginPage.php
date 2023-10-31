<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="../styles/style.css">
    </head>

    <body>
        <h1>Login Page</h1>
        <form action="login.php" method="post">
            <div>
                <label for="userName">UserName</label>
                <input type="text" id="userName" name="userName" />
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" />
            </div>
            <button type="submit">Login</button>
        </form>
    </body>
</html>
