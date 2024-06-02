<?php
// Get connection
include 'db.php';

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $action = $_POST['submit_action'];
  
    if ($action == 'register') {
        // Check if the user already exists
        $stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $result = $stmt->execute();

        if ($result) {
            // Fetch the first row
            $existingUser = $result->fetchArray(SQLITE3_ASSOC);
            
            if ($existingUser) {
                // User already exists
                echo "This email is already registered."; 
            } else {
                // Hash the password before storing it
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare the SQL statement for registration
                $stmt = $db->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
                
                // Bind the values to the placeholders
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $hashedPassword);

                // Execute the statement
                $result = $stmt->execute();

                // Check if the insert was successful
                if ($result) {
                    echo "Registration successful for email: " . htmlspecialchars($email);
                } else {
                    echo "Registration failed.";
                }
          }
    }
    } elseif ($action == 'login') {
      
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tournoi</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main>
    <div class="form-box">
      <form method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" require>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" require>
        <button type="submit" name="submit_action" value="register">register</button>
        <button type="submit" name="submit_action" value="login">login</button>
      </form>
    </div>
      <div class="intro bg-blur">
        <a href="http://localhost:1234/index.php"><h1 style="text-align:center;">[ Welcome to Tournoi ]</h1></a>
        <p style="text-align:center;">#️⃣ 🎠 🔃 🉐 👍 🎎 🐙 👐 🏥 🎋 🔗 ⚖ ❄️</p>
        <p>Cette application web sert a créer des tournois ou les participants on le droit de:</p>
        <ul>
          <li>S&#39;inscrire</li>
          <li>Se connecter</li>
          <li>Créer &amp; modifier des tournois.</li>
        </ul>
        <p>(Ceci est la liste complete des fonctionnalités du site.)</p>
        <p>
          C&#39;est un projet scolaire qui nous servira a apprendre les bases du développement web, sachant que nous n&#39;avons accès ni au libraries/framework ou Javascript!!!!!!
        </p>
        <p>Teste l'application maintenant en créent un compte ou en te connectant</p>
        <p>fuck school</p>
      </div>
  </main>
  <footer>
  <p>Une creation de <a href="https://github.com/pindjouf"><b>@pindjouf</b></a> & <a href="http://github.com/princeofthelord"><b>@princeofthelord</b></a>.</p>
  </footer>
</body>
</html>
