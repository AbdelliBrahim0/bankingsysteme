<?php
    session_start();
    include('../components/database.php');
    if(isset($_SESSION['IS_LOGGIN'])){
        echo "<script>window.location='Dashboard.php?type=n'</script>";
    }
    
    $username = "";
    $password = "";
    $msg = '';
    
    if(isset($_POST['submit'])){
        $username = mysqli_escape_string($con, $_POST['username']);
        $password = mysqli_escape_string($con, $_POST['password']);
        $sql = mysqli_query($con, "SELECT * FROM users WHERE usename = '$username' AND password = '$password'");
        
        if(mysqli_num_rows($sql) > 0){
            $res = mysqli_fetch_assoc($sql);
            $_SESSION['IS_LOGGIN'] = 'yes';
            $_SESSION['USER_ID'] = $res['id'];
            $_SESSION['USER_NAME'] = $res['usename'];
            $_SESSION['ROLE'] = $res['type'];
            
            if($_SESSION['ROLE'] == 0){
                echo "<script>window.location='Dashboard.php?type=n'</script>";
            } else {
                echo "<script>window.location='Customers.php?type=n'</script>";
            }
        } else {
           $msg = "<div class='alert alert-warning' role='alert'>
                    <i class='fas fa-exclamation-triangle me-2'></i>Nom d'utilisateur ou mot de passe incorrect.
                </div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Banque Zitouna</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../style/login.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-left">
            <div class="login-logo">
                <img src="../assets/logo.png" alt="Banque Zitouna Logo">
                <h1>Banque Zitouna</h1>
            </div>
            <div class="login-text">
                <div class="typewriter">
                    <h2>Bienvenue 🧑‍💻 Admin</h2>
                </div>
                <p>Accédez à tous nos services bancaires en toute sécurité</p>
            </div>
            <div class="login-features">
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <span>Sécurité renforcée</span>
                </div>
                <div class="feature">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Accès 24/7</span>
                </div>
                <div class="feature">
                    <i class="fas fa-lock"></i>
                    <span>Protection des données</span>
                </div>
            </div>
        </div>
        <div class="login-right">
            <div class="login-form-container">
                <div class="login-header">
                    <h2>Connexion</h2>
                    <p>Entrez vos identifiants pour accéder à votre compte</p>
                </div>
                <?php echo $msg ?>
                <form method="post" action="" class="login-form">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-icon"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                            <span class="toggle-password" onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-options">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        
                    </div>
                    <button type="submit" name="submit" class="login-button">
                        <span>Se connecter</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.toggle-password i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

<?php
    include '../components/Footer.php';
?>