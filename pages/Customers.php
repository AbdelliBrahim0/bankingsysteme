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
    <!-- Modern Dark Theme Customer Dashboard -->
    <style>
        :root {
            --primary: #00c853;
            --primary-dark: #009624;
            --primary-light: #5efc82;
            --secondary: #7c4dff;
            --dark: #121212;
            --darker: #0a0a0a;
            --light: #f5f5f5;
            --gray: #2d2d2d;
            --card-bg: #1e1e1e;
            --text: #e0e0e0;
            --text-secondary: #a0a0a0;
        }

        body {
            background-color: var(--dark);
            color: var(--text);
            font-family: 'Poppins', sans-serif;
        }

        .customer-dashboard {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 100%);
            padding-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 200, 83, 0.1) !important;
            border-color: var(--primary);
        }

        .customer-card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 200, 83, 0.15) !important;
            border-color: var(--primary);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 200, 83, 0.3);
        }

        .form-control, .form-select {
            background-color: var(--gray);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--gray);
            color: var(--text);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 200, 83, 0.25);
        }

        .card {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text);
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }
        
        /* Customer Cards Styling */
        .customer-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: linear-gradient(145deg, #1e1e1e, #252525);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        
        .customer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 200, 83, 0.15);
            border-color: var(--primary);
        }
        
        .customer-card:hover::before {
            opacity: 1;
        }
        
        .customer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(0, 200, 83, 0.1), rgba(124, 77, 255, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .customer-avatar::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.6s ease;
        }
        
        .customer-card:hover .customer-avatar::after {
            left: 100%;
        }
        
        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }
        
        .status-badge.online {
            background-color: #4caf50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.3);
        }
        
        .status-badge.offline {
            background-color: #f44336;
            box-shadow: 0 0 0 2px rgba(244, 67, 54, 0.3);
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 200, 83, 0.2);
        }
        
        .balance-amount {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(90deg, #fff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }
        
        .last-login {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .customer-email, .customer-phone {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .customer-email i, .customer-phone i {
            width: 20px;
            color: var(--primary);
        }
        
        .account-number {
            font-family: 'Roboto Mono', monospace;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
        
        .customer-name {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #fff;
        }
        
        .customer-card .dropdown-menu {
            background: #2d2d2d;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            padding: 0.5rem 0;
        }
        
        .customer-card .dropdown-item {
            color: var(--text);
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border-radius: 4px;
            margin: 0 0.5rem;
            width: auto;
        }
        
        .customer-card .dropdown-item:hover {
            background: rgba(0, 200, 83, 0.1);
            color: var(--primary);
        }
        
        .customer-card .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }
        
        .customer-card .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.05);
            margin: 0.5rem 0;
        }
        
        .empty-state {
            background: rgba(30, 30, 30, 0.5);
            border: 2px dashed rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 3rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .empty-state:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 200, 83, 0.1);
        }
        
        .empty-state i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
            opacity: 0.8;
        }
        
        .empty-state h5 {
            color: #fff;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }
        
        .pagination .page-link {
            background: #1e1e1e;
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--text);
            margin: 0 2px;
            border-radius: 8px !important;
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .pagination .page-link:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            transform: translateY(-2px);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 200, 83, 0.2);
        }
        
        .pagination .page-item.disabled .page-link {
            background: #1a1a1a;
            color: var(--text-secondary);
            border-color: rgba(255, 255, 255, 0.05);
        }
    </style>

    <div class="customer-dashboard">
        <?php include '../components/User_Name.php' ?>
        
        <!-- Enhanced Header Section with Glass Morphism -->
        <style>
            .dashboard-header {
                background: rgba(18, 18, 18, 0.8);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(0, 200, 83, 0.1);
                position: relative;
                overflow: hidden;
                padding: 2rem 0;
                margin-bottom: 2rem;
            }
            
            .dashboard-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(0, 200, 83, 0.05) 0%, rgba(0, 150, 36, 0.1) 100%);
                z-index: -1;
            }
            
            .header-content {
                position: relative;
                z-index: 2;
            }
            
            .header-title {
                font-size: 2.2rem;
                font-weight: 700;
                background: linear-gradient(90deg, var(--primary), var(--primary-light));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 0.5rem;
            }
            
            .header-subtitle {
                color: var(--text-secondary);
                font-size: 1.1rem;
                margin-bottom: 0;
            }
            
            .header-actions {
                display: flex;
                gap: 1rem;
                margin-top: 1.5rem;
            }
            
            .btn-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                transition: all 0.3s ease;
            }
            
            .btn-icon i {
                font-size: 1.1em;
            }
        </style>
        
        <div class="dashboard-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="header-content">
                            <h1 class="header-title">
                                <i class="fas fa-users me-2"></i>Gestion des Clients
                            </h1>
                            <p class="header-subtitle">
                                <i class="fas fa-chart-line me-2"></i>Surveillez et gérez tous les comptes en temps réel
                            </p>
                            <div class="header-actions">
                                <a href="New__Customer.php?type=n" class="btn btn-primary btn-icon">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Nouveau Client</span>
                                </a>
                                <button class="btn btn-outline-light btn-icon">
                                    <i class="fas fa-download"></i>
                                    <span>Exporter</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block">
                        <div class="text-end">
                            <div class="position-relative d-inline-block">
                                <div class="position-absolute top-0 end-0 bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                                <i class="fas fa-server fa-3x text-primary opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Stats Cards -->
        <div class="container mb-5">
            <?php 
                $total_customers = mysqli_num_rows($sql);
                $total_balance = 0;
                $avg_balance = 0;
                $active_customers = 0;
                
                $result = mysqli_query($con, "SELECT 
                    SUM(acount_balance) as total_balance,
                    AVG(acount_balance) as avg_balance,
                    COUNT(CASE WHEN acount_balance > 0 THEN 1 END) as active_customers
                    FROM customer");
                    
                if($row = mysqli_fetch_assoc($result)) {
                    $total_balance = $row['total_balance'] ?? 0;
                    $avg_balance = $row['avg_balance'] ?? 0;
                    $active_customers = $row['active_customers'] ?? 0;
                }
                
                $active_percentage = $total_customers > 0 ? ($active_customers / $total_customers) * 100 : 0;
                mysqli_data_seek($sql, 0); // Reset result pointer
            ?>
            
            <style>
                .stat-card {
                    border-radius: 12px;
                    padding: 1.5rem;
                    height: 100%;
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    position: relative;
                    overflow: hidden;
                    border: 1px solid rgba(255, 255, 255, 0.05);
                }
                
                .stat-card .stat-icon {
                    width: 60px;
                    height: 60px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-bottom: 1rem;
                    font-size: 1.5rem;
                    background: rgba(0, 200, 83, 0.1);
                    color: var(--primary);
                }
                
                .stat-card .stat-value {
                    font-size: 1.8rem;
                    font-weight: 700;
                    margin: 0.5rem 0;
                    background: linear-gradient(90deg, #fff, #e0e0e0);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
                
                .stat-card .stat-label {
                    color: var(--text-secondary);
                    font-size: 0.9rem;
                    margin-bottom: 0.5rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                
                .stat-card .stat-trend {
                    display: flex;
                    align-items: center;
                    font-size: 0.85rem;
                    margin-top: 0.5rem;
                }
                
                .stat-card .stat-trend.up {
                    color: #4caf50;
                }
                
                .stat-card .stat-trend.down {
                    color: #f44336;
                }
                
                .progress {
                    height: 4px;
                    background: rgba(255, 255, 255, 0.1);
                    border-radius: 2px;
                    margin-top: 1rem;
                    overflow: visible;
                }
                
                .progress-bar {
                    background: var(--primary);
                    position: relative;
                    overflow: visible;
                }
                
                .progress-bar::after {
                    content: '';
                    position: absolute;
                    right: 0;
                    top: -3px;
                    width: 10px;
                    height: 10px;
                    background: var(--primary);
                    border-radius: 50%;
                    box-shadow: 0 0 0 3px rgba(0, 200, 83, 0.3);
                }
                
                /* Animation for the progress bar */
                @keyframes progress-animation {
                    0% { width: 0; opacity: 0; }
                    100% { width: var(--progress-width); opacity: 1; }
                }
                
                .progress-bar.animate {
                    animation: progress-animation 1.5s ease-out forwards;
                }
            </style>
            
            <div class="row g-4">
                <!-- Total Customers Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value counter" data-target="<?php echo $total_customers; ?>">0</div>
                        <div class="stat-label">
                            <i class="fas fa-user-friends"></i>
                            <span>Total Clients</span>
                        </div>
                        <div class="stat-trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>12% vs last month</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="--progress-width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Balance Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(124, 77, 255, 0.1); color: #7c4dff;">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="stat-value">
                            <span class="counter" data-target="<?php echo str_replace([',', '.'], '', number_format($total_balance, 2)); ?>">0</span> TND
                        </div>
                        <div class="stat-label">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Solde Total</span>
                        </div>
                        <div class="stat-trend up">
                            <i class="fas fa-arrow-up"></i>
                            <span>8.5% vs last month</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="--progress-width: 65%; background: #7c4dff;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
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
                <!-- Active Customers Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(33, 150, 243, 0.1); color: #2196f3;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-value">
                            <span class="counter" data-target="<?php echo $active_customers; ?>">0</span>
                            <small class="text-muted">/ <?php echo $total_customers; ?></small>
                        </div>
                        <div class="stat-label">
                            <i class="fas fa-chart-pie"></i>
                            <span>Clients Actifs</span>
                        </div>
                        <div class="stat-trend up">
                            <i class="fas fa-chart-line"></i>
                            <span><?php echo number_format($active_percentage, 1); ?>% du total</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="--progress-width: <?php echo $active_percentage; ?>%; background: #2196f3;" 
                                 aria-valuenow="<?php echo $active_percentage; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Average Balance Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-value">
                            <span class="counter" data-target="<?php echo str_replace([',', '.'], '', number_format($avg_balance, 2)); ?>">0</span> TND
                        </div>
                        <div class="stat-label">
                            <i class="fas fa-calculator"></i>
                            <span>Moyenne des soldes</span>
                        </div>
                        <div class="stat-trend up">
                            <i class="fas fa-percentage"></i>
                            <span>5.2% vs last month</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="--progress-width: 85%; background: #ffc107;" 
                                 aria-valuenow="85" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
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
            <div class="row g-4" id="customerCards">
                <?php 
                $count = 0;
                mysqli_data_seek($sql, 0); // Reset result pointer
                while ($row = mysqli_fetch_assoc($sql)) {
                    $count++;
                    $account_no = $row['account_no'];
                    $name = htmlspecialchars($row['name']);
                    $email = htmlspecialchars($row['email']);
                    $balance = number_format($row['acount_balance'], 2, ',', ' ');
                    $phone_no = htmlspecialchars($row['phone_no']);
                    $status = $row['status'] ?? 'active';
                    $last_login = !empty($row['last_login']) ? date('d M Y', strtotime($row['last_login'])) : 'Jamais';
                    $initials = '';
                    $name_parts = explode(' ', $name);
                    foreach($name_parts as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                        if(strlen($initials) >= 2) break;
                    }
                    $is_vip = $row['acount_balance'] > 10000; // Example VIP condition
                    $is_online = rand(0, 1); // Simulate online status
                ?>
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-balance="<?php echo $row['acount_balance']; ?>" data-created="<?php echo strtotime($row['created_at'] ?? 'now'); ?>">
                    <div class="customer-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="customer-avatar me-3">
                                        <?php echo $initials; ?>
                                    </div>
                                    <div>
                                        <h5 class="customer-name mb-0"><?php echo $name; ?></h5>
                                        <span class="account-number">#<?php echo $account_no; ?></span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="action-btn" type="button" id="dropdownMenuButton<?php echo $count; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?php echo $count; ?>">
                                        <li><a class="dropdown-item" href="Edit__Customer.php?type=n&id=<?php echo $account_no; ?>"><i class="fas fa-edit me-2"></i>Modifier</a></li>
                                        <li><a class="dropdown-item" href="Transfer.php?type=n&id=<?php echo $account_no; ?>"><i class="fas fa-exchange-alt me-2"></i>Effectuer un virement</a></li>
                                        <li><a class="dropdown-item" href="All__Transction__History.php?type=n&id=<?php echo $account_no; ?>"><i class="fas fa-history me-2"></i>Historique</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="?type=n&id=<?php echo $account_no; ?>&option=delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')"><i class="fas fa-trash-alt me-2"></i>Supprimer</a></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="customer-email mb-2">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span><?php echo $email; ?></span>
                                </div>
                                <div class="customer-phone">
                                    <i class="fas fa-phone me-2"></i>
                                    <span><?php echo $phone_no; ?></span>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3">
                                <div>
                                    <div class="balance-amount"><?php echo $balance; ?> TND</div>
                                    <small class="text-muted">Solde actuel</small>
                                </div>
                                <div class="text-end">
                                    <div class="status-badge <?php echo $is_online ? 'online' : 'offline'; ?>"></div>
                                    <div class="last-login">
                                        <i class="far fa-clock me-1"></i> <?php echo $last_login; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($is_vip): ?>
                            <div class="position-absolute top-0 end-0 mt-2 me-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-crown me-1"></i> VIP
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="customer-actions mt-4 pt-3 border-top border-secondary">
                                <div class="d-flex justify-content-between">
                                    <a href="All__Transction__History.php?type=n&id=<?php echo $account_no; ?>" 
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip" 
                                       title="Voir les transactions">
                                        <i class="fas fa-exchange-alt me-1"></i> Transactions
                                    </a>
                                    <a href="Transfer.php?type=n&id=<?php echo $account_no; ?>" 
                                       class="btn btn-sm btn-outline-success"
                                       data-bs-toggle="tooltip"
                                       title="Effectuer un virement">
                                        <i class="fas fa-paper-plane me-1"></i> Virement
                                    </a>
                                    <a href="Edit__Customer.php?type=n&id=<?php echo $account_no; ?>" 
                                       class="btn btn-sm btn-outline-secondary"
                                       data-bs-toggle="tooltip"
                                       title="Modifier le profil">
                                        <i class="fas fa-pen"></i>
                                    </a>
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
    
    <!-- Modern JavaScript for Interactive Features -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS for animations and interactions -->
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations and interactions
            animateStats();
            setupSearchAndFilter();
            setupSorting();
            setupScrollToTop();
        });
        
        // Animate numbers in stats cards
        function animateStats() {
            document.querySelectorAll('.stat-number').forEach(el => {
                const target = parseInt(el.getAttribute('data-target')) || 0;
                animateValue(el, 0, target, 1500);
            });
            
            // Animate progress bars
            document.querySelectorAll('.progress-bar').forEach(bar => {
                const target = parseInt(bar.getAttribute('aria-valuenow')) || 0;
                let current = 0;
                const duration = 1000; // ms
                const increment = target / (duration / 16); // 60fps
                
                const animate = () => {
                    if (current < target) {
                        current = Math.min(current + increment, target);
                        bar.style.width = current + '%';
                        bar.textContent = Math.round(current) + '%';
                        requestAnimationFrame(animate);
                    }
                };
                
                // Only animate when in viewport
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animate();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                observer.observe(bar);
            });
        }
        
        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.textContent = Math.floor(progress * (end - start) + start).toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
        
        function setupSearchAndFilter() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            
            if (searchInput) {
                searchInput.addEventListener('input', filterCustomers);
            }
            
            if (statusFilter) {
                statusFilter.addEventListener('change', filterCustomers);
            }
        }
        
        function filterCustomers() {
            const searchTerm = (document.getElementById('searchInput')?.value || '').toLowerCase();
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';
            
            document.querySelectorAll('#customerCards > .col-12').forEach(card => {
                const name = card.querySelector('.customer-name')?.textContent?.toLowerCase() || '';
                const email = card.querySelector('.customer-email span')?.textContent?.toLowerCase() || '';
                const phone = card.querySelector('.customer-phone span')?.textContent?.toLowerCase() || '';
                const accountNo = card.querySelector('.account-number')?.textContent?.toLowerCase() || '';
                const isVip = card.querySelector('.badge.bg-warning') !== null;
                const isOnline = card.querySelector('.status-badge')?.classList.contains('online') || false;
                
                // Check search term
                const matchesSearch = searchTerm === '' || 
                                    name.includes(searchTerm) || 
                                    email.includes(searchTerm) || 
                                    phone.includes(searchTerm) ||
                                    accountNo.includes(searchTerm);
                
                // Check status filter
                let matchesStatus = true;
                if (statusFilter === 'vip') {
                    matchesStatus = isVip;
                } else if (statusFilter === 'active') {
                    matchesStatus = isOnline;
                } else if (statusFilter === 'inactive') {
                    matchesStatus = !isOnline;
                }
                
                // Show/hide based on filters
                if (matchesSearch && matchesStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
        
        function setupSorting() {
            const sortButtons = document.querySelectorAll('.sort-option');
            sortButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortBy = this.getAttribute('data-sort');
                    sortCustomers(sortBy);
                    
                    // Update active state
                    sortButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }
        
        function sortCustomers(sortBy) {
            const container = document.getElementById('customerCards');
            const cards = Array.from(container.children);
            
            cards.sort((a, b) => {
                const aName = a.querySelector('.customer-name')?.textContent?.toLowerCase() || '';
                const bName = b.querySelector('.customer-name')?.textContent?.toLowerCase() || '';
                const aBalance = parseFloat(a.getAttribute('data-balance') || 0);
                const bBalance = parseFloat(b.getAttribute('data-balance') || 0);
                const aDate = a.getAttribute('data-created') || 0;
                const bDate = b.getAttribute('data-created') || 0;
                
                switch(sortBy) {
                    case 'name_asc': return aName.localeCompare(bName);
                    case 'name_desc': return bName.localeCompare(aName);
                    case 'balance_high': return bBalance - aBalance;
                    case 'balance_low': return aBalance - bBalance;
                    case 'recent': return bDate - aDate;
                    case 'oldest': return aDate - bDate;
                    default: return 0;
                }
            });
            
            // Re-append sorted cards
            cards.forEach(card => container.appendChild(card));
        }
        
        function setupScrollToTop() {
            const scrollBtn = document.createElement('button');
            scrollBtn.className = 'btn btn-primary btn-scroll-top';
            scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            scrollBtn.title = 'Back to top';
            scrollBtn.onclick = () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            };
            
            document.body.appendChild(scrollBtn);
            
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    scrollBtn.classList.add('show');
                } else {
                    scrollBtn.classList.remove('show');
                }
            });
        }
    </script>
    
    <!-- Add some custom styles for the scroll-to-top button -->
    <style>
        .btn-scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .btn-scroll-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .btn-scroll-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        /* Ensure cards have proper spacing */
        #customerCards > .col-12 {
            margin-bottom: 1.5rem;
        }
    </style>
    
    <script>
        // Add hover effect to cards after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize cards hover effect
            const cards = document.querySelectorAll('.stat-card, .customer-card');
            
            cards.forEach(card => {
                card.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
                
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 15px 30px rgba(0, 200, 83, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                });
            });

            // Initialize refresh button if it exists
            const refreshBtn = document.getElementById('refreshStats');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const icon = this.querySelector('i');
                    icon.classList.add('fa-spin');
                    
                    // Simulate loading
                    setTimeout(() => {
                        icon.classList.remove('fa-spin');
                        
                        // Show success message
                        const toast = new bootstrap.Toast(document.getElementById('refreshToast'));
                        toast.show();
                        
                        // Reload the page after showing the toast
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }, 1000);
                });
            }
        });
    </script>
    
    <!-- Success Toast for Refresh -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="refreshToast" class="toast align-items-center text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i> Statistiques actualisées avec succès
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    </script>
    
    <script>
        // Initialize tooltips and other UI elements when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Initialize search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.customer-card');
                    
                    cards.forEach(card => {
                        const cardText = card.textContent.toLowerCase();
                        card.style.display = cardText.includes(searchTerm) ? 'block' : 'none';
                    });
                });
            }
            
            // Initialize sort buttons
            document.querySelectorAll('[data-sort]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const sortBy = this.getAttribute('data-sort');
                    sortCustomers(sortBy);
                });
            });
            
            // Initialize filter dropdowns
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                dropdown.addEventListener('change', function() {
                    applyFilters();
                });
            });
        });
        
        // Function to sort customers
        function sortCustomers(sortBy) {
            const container = document.getElementById('customerCards');
            const cards = Array.from(container.children);
            
            cards.sort((a, b) => {
                const aValue = a.querySelector('.customer-name').textContent.toLowerCase();
                const bValue = b.querySelector('.customer-name').textContent.toLowerCase();
                
                if (sortBy === 'name_asc') return aValue.localeCompare(bValue);
                if (sortBy === 'name_desc') return bValue.localeCompare(aValue);
                return 0;
            });
            
            // Re-append sorted cards
            cards.forEach(card => container.appendChild(card));
        }
        
        // Function to apply all active filters
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
            const statusFilter = document.getElementById('statusFilter')?.value || 'all';
            const cards = document.querySelectorAll('.customer-card');
            
            cards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                const cardStatus = card.getAttribute('data-status') || '';
                const isVip = card.classList.contains('vip-customer');
                
                // Check search term match
                const matchesSearch = searchTerm === '' || cardText.includes(searchTerm);
                
                // Check status filter
                let matchesStatus = true;
                if (statusFilter === 'vip') {
                    matchesStatus = isVip;
                } else if (statusFilter === 'active') {
                    matchesStatus = cardStatus === 'active';
                }
                
                // Show/hide based on filters
                card.style.display = (matchesSearch && matchesStatus) ? 'block' : 'none';
            });
        }

    // Function to handle sorting
    function setupSorting() {
        const sortBy = document.getElementById('sortBy');
        const customerContainer = document.getElementById('customerCards');
        
        if (sortBy && customerContainer) {
            sortBy.addEventListener('change', function() {
                const sortValue = this.value;
                const cards = Array.from(customerContainer.querySelectorAll('.col-12'));
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
        };
        
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
    };
    </script>
    
    <!-- Ajout des icônes Font Awesome si elles ne sont pas déjà incluses -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Ajout de Bootstrap JS si ce n'est pas déjà fait -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
    include '../components/Footer.php';
?>