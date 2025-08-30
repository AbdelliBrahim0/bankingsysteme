<?php
    include '../components/Navigation__Bar.php';
     // ===========Condition==============
        if(!isset($_SESSION['IS_LOGGIN'])){
            echo "<script>window.location='Login.php?type=n'</script>";
        }
    // ========X===Condition===x=========
    $msg = '';
    // ============Get Massege Here===========
        if(isset($_GET["msg"])){
            $msg_get = mysqli_escape_string($con,$_GET["msg"]);
            if($msg_get == "msg"){
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <h4 class='alert-heading'>Well done!</h4>
                    <strong>Customer Detailes Edited Successfully</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    // =========X===Get Massege Here===X=======

    // ==========Delete Functionality=========
        if(isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['option']) && $_GET['option']!=""){
            $id = mysqli_escape_string($con,$_GET['id']);
            $option = mysqli_escape_string($con,$_GET['option']);

            if($option == 'delete'){
                mysqli_query($con,"DELETE FROM customer WHERE account_no = '$id'");
                mysqli_query($con,"DELETE FROM transaction WHERE customer_ac = '$id'");
                echo "<script>window.location='Customers.php?type=n'</script>";
            }
        }
    // =======X===Delete Functionality===X======

    // =============Get Record==============
        $sql = mysqli_query($con,"SELECT * FROM customer ORDER BY id DESC");
    // =============Get Record==============
?>
    <!-- Modern Customer Dashboard -->
    <div class="customer-dashboard">
        <?php include '../components/User_Name.php' ?>
        
        <!-- Header Section -->
        <div class="dashboard-header py-4 mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-5 fw-bold"><i class="fas fa-users me-2"></i>Gestion des Clients</h1>
                        <p class="lead text-muted">Gérez et surveillez tous les comptes clients</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="New__Customer.php?type=n" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Nouveau Client
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="container mb-5">
            <?php 
                $total_customers = mysqli_num_rows($sql);
                $total_balance = 0;
                $result = mysqli_query($con, "SELECT SUM(acount_balance) as total FROM customer");
                if($row = mysqli_fetch_assoc($result)) {
                    $total_balance = $row['total'];
                }
                mysqli_data_seek($sql, 0); // Reset result pointer
            ?>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card bg-primary bg-gradient text-white rounded-4 p-4 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <div class="stat-info">
                                <h2 class="mb-0 fw-bold"><?php echo $total_customers; ?></h2>
                                <p class="mb-0 text-white-50">Clients</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card bg-success bg-gradient text-white rounded-4 p-4 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <div class="stat-info">
                                <h2 class="mb-0 fw-bold"><?php echo number_format($total_balance, 2); ?> TND</h2>
                                <p class="mb-0 text-white-50">Solde Total</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card bg-info bg-gradient text-white rounded-4 p-4 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3">
                                <i class="fas fa-exchange-alt fa-2x"></i>
                            </div>
                            <div class="stat-info">
                                <h2 class="mb-0 fw-bold">24h</h2>
                                <p class="mb-0 text-white-50">Transactions Aujourd'hui</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card bg-warning bg-gradient text-white rounded-4 p-4 shadow-sm h-100">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon me-3">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                            <div class="stat-info">
                                <h2 class="mb-0 fw-bold">+12.5%</h2>
                                <p class="mb-0 text-white-50">Croissance Mensuelle</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer List Section -->
        <div class="container">
            <?php echo $msg; ?>
            
            <!-- Search and Filter -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="search-box position-relative">
                                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="searchInput" class="form-control form-control-lg ps-5" placeholder="Rechercher un client...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-lg" id="filterStatus">
                                <option value="">Tous les comptes</option>
                                <option value="active">Actifs</option>
                                <option value="inactive">Inactifs</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-lg" id="sortBy">
                                <option value="newest">Plus récent</option>
                                <option value="oldest">Plus ancien</option>
                                <option value="balance_high">Solde (élevé à faible)</option>
                                <option value="balance_low">Solde (faible à élevé)</option>
                                <option value="name_asc">Nom (A-Z)</option>
                                <option value="name_desc">Nom (Z-A)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Customer Cards Grid -->
            <link rel="stylesheet" href="../style/customers.css">
            <div class="row g-4" id="customerCards">
                <?php 
                $count = 0;
                while ($row = mysqli_fetch_assoc($sql)) {
                    $count++;
                    $balance_class = $row['acount_balance'] > 10000 ? 'text-success' : 'text-warning';
                    $gender_icon = $row['gender'] == 'Male' ? 'mars' : 'venus';
                    $created_date = date('d M Y', strtotime($row['created_date']));
                    $initials = '';
                    $name_parts = explode(' ', $row['name']);
                    foreach($name_parts as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                        if(strlen($initials) >= 2) break;
                    }
                ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="customer-card card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Active</span>
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['name']); ?></h5>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-<?php echo $gender_icon; ?> me-1"></i>
                                        <?php echo htmlspecialchars($row['gender']); ?>
                                    </p>
                                </div>
                                <div class="avatar" style="background-color: #<?php echo substr(md5($row['name']), 0, 6); ?>20; color: #<?php echo substr(md5($row['name']), 0, 6); ?>">
                                    <?php echo $initials; ?>
                                </div>
                            </div>
                            
                            <div class="customer-details mt-4">
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="text-muted small">Compte</div>
                                        <div class="fw-medium text-truncate"><?php echo $row['account_no']; ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small">Solde</div>
                                        <div class="fw-bold <?php echo $balance_class; ?>">
                                            <?php echo number_format($row['acount_balance'], 3); ?> TND
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="text-muted small">Inscrit le</div>
                                        <div class="fw-medium"><?php echo $created_date; ?></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted small">Ville</div>
                                        <div class="fw-medium text-truncate"><?php echo htmlspecialchars($row['city']); ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="customer-actions mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="All__Transction__History.php?type=n&id=<?php echo $row['account_no']; ?>" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Voir les transactions">
                                        <i class="fas fa-exchange-alt me-1"></i> Transactions
                                    </a>
                                    <div class="btn-group">
                                        <a href="New__Customer.php?type=n&id=<?php echo $row['account_no']; ?>&option=view" 
                                           class="btn btn-sm btn-outline-secondary"
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="New__Customer.php?type=n&id=<?php echo $row['account_no']; ?>&option=edit" 
                                           class="btn btn-sm btn-outline-secondary"
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="?type=n&id=<?php echo $row['account_no']; ?>&option=delete" 
                                           class="btn btn-sm btn-outline-danger"
                                           data-bs-toggle="tooltip" 
                                           title="Supprimer"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <!-- Empty State -->
                <?php if($count == 0) { ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">Aucun client trouvé</h4>
                        <p class="text-muted">Commencez par ajouter votre premier client</p>
                        <a href="New__Customer.php?type=n" class="btn btn-primary mt-2">
                            <i class="fas fa-user-plus me-2"></i>Ajouter un client
                        </a>
                    </div>
                </div>
                <?php } ?>
                
                <!-- Pagination -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de <span class="fw-bold">1-<?php echo min(10, $count); ?></span> sur 
                            <span class="fw-bold"><?php echo $count; ?></span> clients
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Précédent</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <?php if($count > 10) { ?>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <?php } ?>
                                <li class="page-item">
                                    <a class="page-link" href="#">Suivant</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript pour la recherche et le tri -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activer les tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Fonction de recherche
        const searchInput = document.getElementById('searchInput');
        const customerCards = document.querySelectorAll('.customer-card');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            customerCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                if (cardText.includes(searchTerm)) {
                    card.closest('.col-12').style.display = '';
                } else {
                    card.closest('.col-12').style.display = 'none';
                }
            });
        });
        
        // Fonction de tri
        const sortBy = document.getElementById('sortBy');
        const customerContainer = document.getElementById('customerCards');
        
        sortBy.addEventListener('change', function() {
            const sortValue = this.value;
            const customers = Array.from(customerContainer.querySelectorAll('.col-12'));
            
            customers.sort((a, b) => {
                const aCard = a.querySelector('.customer-card');
                const bCard = b.querySelector('.customer-card');
                
                switch(sortValue) {
                    case 'newest':
                        return 0; // Déjà trié par défaut
                    case 'oldest':
                        return 0; // À implémenter si nécessaire
                    case 'name_asc':
                        return aCard.querySelector('.card-title').textContent.localeCompare(bCard.querySelector('.card-title').textContent);
                    case 'name_desc':
                        return bCard.querySelector('.card-title').textContent.localeCompare(aCard.querySelector('.card-title').textContent);
                    case 'balance_high':
                        return parseFloat(bCard.querySelector('.fw-bold').textContent.replace(/[^0-9.]/g, '')) - 
                               parseFloat(aCard.querySelector('.fw-bold').textContent.replace(/[^0-9.]/g, ''));
                    case 'balance_low':
                        return parseFloat(aCard.querySelector('.fw-bold').textContent.replace(/[^0-9.]/g, '')) - 
                               parseFloat(bCard.querySelector('.fw-bold').textContent.replace(/[^0-9.]/g, ''));
                    default:
                        return 0;
                }
            });
            
            // Réorganiser les cartes dans le conteneur
            customers.forEach(customer => {
                customerContainer.appendChild(customer);
            });
        });
        
        // Animation au survol des cartes
        customerCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        });
    });
    </script>
    
    <!-- Ajout des icônes Font Awesome si elles ne sont pas déjà incluses -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Ajout de Bootstrap JS si ce n'est pas déjà fait -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
    include '../components/Footer.php';
?>