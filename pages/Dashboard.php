<?php
    include '../components/Navigation__Bar.php';
    // ===========Condition==============
    if(!isset($_SESSION['IS_LOGGIN'])){
        header('Location:Login.php?type=n');
    }
    if($_SESSION['ROLE'] != 0){
        header('Location:Customers.php?type=n');
    }
    // ========X===Condition===x=========

    // ===========All Dashboard==========
    $sql = mysqli_query($con,"SELECT * FROM customer");
    $total_customers = mysqli_num_rows($sql);

    $sql_em = mysqli_query($con,"SELECT * FROM employe");
    $total_employes = mysqli_num_rows($sql_em);
    if($total_employes < 10){
        $total_employes = '0'.$total_employes;
    }
    
    $balance = mysqli_query($con,"SELECT SUM(acount_balance) AS value_sum FROM customer");
    $total = mysqli_fetch_assoc($balance);
    $formatted_balance = number_format($total['value_sum'], 2);
    // =========X==All Dashboard==X========
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Banking System</title>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Notre fichier CSS personnalisé -->
    <link rel="stylesheet" href="../style/dashboard.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4bb543;
            --text-color: #2b2d42;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f7ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-section {
            background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.2);
        }
        
        .welcome-section h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .welcome-section p {
            opacity: 0.9;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <?php include '../components/User_Name.php' ?>
    
    <div class="container dashboard-container">
        <!-- Section de bienvenue -->
        <div class="welcome-section">
            <h1>Tableau de Bord</h1>
            <p>Bienvenue sur votre espace d'administration</p>
        </div>
        
        <!-- Cartes de statistiques -->
        <div class="row">
            <!-- Carte Clients -->
            <div class="col-xl-4 col-md-6">
                <div class="dashboard-card">
                    <div class="card-body text-center p-4">
                        <div class="card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="card-title">Total Clients</h3>
                        <div class="card-value"><?php echo $total_customers; ?></div>
                        <div class="card-footer">
                            <i class="fas fa-chart-line me-2"></i> Gérer les clients
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Carte Employés -->
            <div class="col-xl-4 col-md-6">
                <div class="dashboard-card">
                    <div class="card-body text-center p-4">
                        <div class="card-icon" style="background: rgba(75, 181, 67, 0.1);">
                            <i class="fas fa-user-tie" style="color: #4bb543;"></i>
                        </div>
                        <h3 class="card-title">Total Employés</h3>
                        <div class="card-value"><?php echo $total_employes; ?></div>
                        <div class="card-footer">
                            <i class="fas fa-chart-pie me-2"></i> Voir les statistiques
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Carte Solde -->
            <div class="col-xl-4 col-md-6 mx-auto">
                <div class="dashboard-card">
                    <div class="card-body text-center p-4">
                        <div class="card-icon" style="background: rgba(255, 193, 7, 0.1);">
                            <i class="fas fa-wallet" style="color: #ffc107;"></i>
                        </div>
                        <h3 class="card-title">Solde Total</h3>
                        <div class="card-value"><?php echo $formatted_balance; ?> <small>₹</small></div>
                        <div class="card-footer">
                            <i class="fas fa-exchange-alt me-2"></i> Voir les transactions
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section d'activité récente -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Activité Récente</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-clock text-muted fa-3x mb-3"></i>
                            <p class="text-muted">Aucune activité récente pour le moment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/Footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s forwards`;
                card.style.opacity = '0';
            });
        });
    </script>
</body>
</html>