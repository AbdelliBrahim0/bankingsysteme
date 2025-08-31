<?php
    include '../components/Navigation__Bar.php';
    // ===========Condition==============
        if(!isset($_SESSION['IS_LOGGIN'])){
            echo "<script>window.location='Login.php?type=n'</script>";
        }
    // ========X===Condition===x=========

    //=========== Variable Declreation ==========
        $name = "";
        $gender = "";
        $birthday = "";
        $email = "";
        $phone_no = "";
        $state = "";
        $district = "";
        $city = "";
        $pin_code = "";
        $account_no = "";
        $acount_balance = 200;
        $card_number = "";

        $checked_ac = "";
        $ac_number = "";

        $msg = "";
        $msg_get ="";

        $id = "";
        $option = "";

        $disabled = "";
    //======X=== Variable Declreation ===X========

    //============For Other Functionality=========
        if(isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['option']) && $_GET['option']!=""){
            $id = mysqli_escape_string($con,$_GET['id']);
            $option = mysqli_escape_string($con,$_GET['option']);
        }
        //==========View Profile Functionality===============
            if($option == 'view'){
                $disabled = "disabled";
            }else{
                $disabled = "";
            }
            if($option == 'view' || $option == 'edit'){
                $res = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM customer WHERE account_no = '$id'"));
                $name = $res["name"];
                $gender = $res["gender"];
                $birthday = $res["birthday"];
                $email = $res["email"];
                $phone_no = $res["phone_no"];
                $state =  $res["state"];
                $district = $res["district"];
                $city = $res["city"];
                $pin_code = $res["pin_code"];
                $ac_number = $res["account_no"];
                $acount_balance = $res["acount_balance"];
                $card_number = $res["card_number"];
            }else{
                // ==========Génération du numéro de carte ===========
                    // Générer un numéro de carte unique à 12 chiffres
                    $is_unique = false;
                    $max_attempts = 10;
                    $attempts = 0;
                    
                    while (!$is_unique && $attempts < $max_attempts) {
                        // Générer 12 chiffres aléatoires
                        $card_number = '';
                        for ($i = 0; $i < 12; $i++) {
                            $card_number .= mt_rand(0, 9);
                        }
                        
                        // Vérifier si le numéro existe déjà
                        $check_sql = "SELECT COUNT(*) as count FROM customer WHERE card_number = '$card_number'";
                        $result = mysqli_query($con, $check_sql);
                        $row = mysqli_fetch_assoc($result);
                        
                        if ($row['count'] == 0) {
                            $is_unique = true;
                            $card_number = $card_number; // Définir le numéro de carte
                        }
                        
                        $attempts++;
                    }
                    
                    // Si tous les essais échouent, générer un numéro basé sur le timestamp
                    if (!$is_unique) {
                        $card_number = substr(time() . mt_rand(1000, 9999), -12);
                    }
                    
                    // Génération du numéro de compte
                    $sql_ac = mysqli_query($con,"SELECT account_no FROM customer ORDER BY id DESC LIMIT 1");
                    $checked_ac = mysqli_fetch_assoc($sql_ac);

                    if(mysqli_num_rows($sql_ac)>0){
                        $prives_ac = $checked_ac['account_no'];
                        $get_ac = str_replace("AC", "", $prives_ac);
                        $ac_incrase = $get_ac+1;
                        $get_ac_string = str_pad($ac_incrase, 12, 0, STR_PAD_LEFT);
                        $ac_number = "AC".$get_ac_string;
                    } else {
                        $ac_number = "AC".str_pad(1, 12, '0', STR_PAD_LEFT);
                    }
                // ======X===Genrate Account Number===X=======
            }
        //========X==View Profile Functionality==X=============
    //=========X===For Other Functionality===X======

    // ============Get Massege Here===========
        if(isset($_GET["msg"]) && $_GET["msg"] != ""){
            $msg_get = mysqli_escape_string($con,$_GET["msg"]);
            if($msg_get == "msg"){
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <h4 class='alert-heading'>Félicitations !</h4>
                    <strong>Détails du client ajoutés avec succès</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    // =========X===Get Massege Here===X=======

    // ========= Send Records Functionality ========
        if(isset($_POST['add_customer'])){
            $name = mysqli_escape_string($con,$_POST['name']);
            $gender = mysqli_escape_string($con,$_POST['gender']);
            $birthday = mysqli_escape_string($con,$_POST['birthday']);
            $email = mysqli_escape_string($con,$_POST['email']);
            $phone_no = mysqli_escape_string($con,$_POST['phone_no']);
            $state = mysqli_escape_string($con,$_POST['state']);
            $district = mysqli_escape_string($con,$_POST['district']);
            $city = mysqli_escape_string($con,$_POST['city']);
            $pin_code =mysqli_escape_string($con,$_POST['pin_code']);
            $account_no = $ac_number;
            $acount_balance = mysqli_escape_string($con,$_POST['account_balance']);
            $card_number = mysqli_escape_string($con,$_POST['card_number']);

            $sql_fetch = mysqli_query($con,"SELECT * FROM customer WHERE card_number = '$card_number'");
            if($option == ''){
                if(mysqli_num_rows($sql_fetch)>0){
                    $msg = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>Oups !</strong> Un compte client existe déjà avec ce numéro de carte.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Fermer'></button>
                    </div>";
                }else{
                    mysqli_query($con,"INSERT  INTO customer (name,gender,birthday,email,phone_no,state,district,city,pin_code,account_no,card_number,acount_balance) VALUES ('$name','$gender',' $birthday','$email','$phone_no','$state','$district','$city','$pin_code','$account_no','$card_number','$acount_balance')");

                    echo "<script>window.location='New__Customer.php?type=n&msg=msg'</script>";
                }
            }else{
                mysqli_query($con,"UPDATE customer SET name='$name',gender='$gender',birthday='$birthday',email='$email',phone_no='$phone_no',state='$state',district='$district',city='$city',pin_code='$pin_code',account_no='$account_no',card_number='$card_number',acount_balance='$acount_balance' WHERE account_no = '$id'");
           
                echo "<script>window.location='Customers.php?type=n&msg=msg'</script>";
            }
        
        }
    // ======X=== Send Records Functionality ===X===
?>
    <!-- ------------Customer Form---------------- -->
    <?php //include '../components/User_Name.php' ?>
    
    <div class="container customer-form-container" id="add_page">
        <?php echo $msg; ?>
        
        <div class="form-header">
            <?php 
                if($option == 'view'){
                    echo "
                        <h2><i class='fas fa-user-tie me-2'></i>Détails du client</h2>
                        <p>Consultation des détails pour <span class='text-primary fw-bold'>$name</span></p>
                    ";
                } else if ($option == 'edit'){
                    echo "
                        <h2><i class='fas fa-user-edit me-2'></i>Modifier les détails du client</h2>
                        <p>Modification du profil de <span class='text-primary fw-bold'>$name</span></p>
                    ";
                } else {
                    echo "
                        <h2><i class='fas fa-user-plus me-2'></i>Ajouter un nouveau client</h2>
                        <p>Veuillez remplir les détails du client ci-dessous</p>
                    ";
                }
            ?>
        </div>
        
        <form method="post" action="" class="needs-validation" novalidate>
            <!-- Informations du compte -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-id-card"></i> Informations du compte</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="accountNumber" class="form-label">Numéro de compte</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                            <input type="text" class="form-control bg-light" id="accountNumber" value="<?php echo $ac_number; ?>" disabled>
                            <input type="hidden" name="employe_id" value="<?php echo $ac_number; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="cardNumber" class="form-label">Numéro de carte</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="cardNumber" name="card_number" value="<?php echo $card_number; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez fournir un numéro de carte valide.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="accountBalance" class="form-label">Solde du compte (TND)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="accountBalance" name="account_balance" value="<?php echo $acount_balance; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations personnelles -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-user"></i> Informations personnelles</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="fullName" class="form-label">Nom complet</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="fullName" name="name" value="<?php echo $name; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez fournir un nom valide.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Adresse email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input <?php echo $disabled; ?> type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez fournir une adresse email valide.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Genre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            <select <?php echo $disabled; ?> class="form-select" id="gender" name="gender" required>
                                <?php 
                                    if($option == 'view'){
                                        echo "<option value='$gender' selected>$gender</option>";
                                    } else if($option == 'edit'){
                                        echo "<option value='$gender' selected>$gender</option>";
                                        echo "<option value='Masculin'>Masculin</option>";
                                        echo "<option value='Féminin'>Féminin</option>";
                                        echo "<option value='Autre'>Autre</option>";
                                    } else {
                                        echo "<option value='' selected disabled>Sélectionnez le genre</option>";
                                        echo "<option value='Masculin'>Masculin</option>";
                                        echo "<option value='Féminin'>Féminin</option>";
                                        echo "<option value='Autre'>Autre</option>";
                                    }   
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Numéro de téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input <?php echo $disabled; ?> type="tel" class="form-control" id="phone" name="phone_no" value="<?php echo $phone_no; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez fournir un numéro de téléphone valide.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="birthday" class="form-label">Date de naissance</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input <?php echo $disabled; ?> type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $birthday; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations d'adresse -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-map-marker-alt"></i> Informations d'adresse</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="state" class="form-label">Région</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="district" class="form-label">Département</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="district" name="district" value="<?php echo $district; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label">Ville</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="pinCode" class="form-label">Code postal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="pinCode" name="pin_code" value="<?php echo $pin_code; ?>" required>
                            <div class="invalid-feedback">
                                Veuillez fournir un code postal valide.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions du formulaire -->
            <div class="d-flex justify-content-between mt-4">
                <a href="Customers.php?type=n" class="btn btn-cancel">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
                <?php if($option != 'view'): ?>
                    <button type="submit" name="add_customer" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>
                        <?php echo ($option == 'edit') ? 'Mettre à jour' : 'Ajouter le client'; ?>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Include CSS -->
    <link rel="stylesheet" href="../style/customer-form.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Form Validation Script -->
    <script>
    // Form validation
    (function () {
        'use strict'
        
        // Fetch the form we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })()
    
    // Format phone number
    document.getElementById('phone').addEventListener('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
    
    // Format card number
    document.getElementById('cardNumber').addEventListener('input', function (e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + ' ' + x[2] + (x[3] ? ' ' + x[3] : '');
    });
    
    // Format PIN code
    document.getElementById('pinCode').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);
    });
    
    // Format account balance
    document.getElementById('accountBalance').addEventListener('input', function (e) {
        // Remove any non-digit and non-decimal point characters
        this.value = this.value.replace(/[^0-9.]/g, '');
        
        // Ensure only one decimal point
        if ((this.value.match(/\./g) || []).length > 1) {
            this.value = this.value.slice(0, -1);
        }
        
        // Limit to 2 decimal places
        if (this.value.indexOf('.') >= 0) {
            var parts = this.value.split('.');
            if (parts[1].length > 2) {
                parts[1] = parts[1].substring(0, 2);
                this.value = parts.join('.');
            }
        }
    });
    </script>
    <!-- ---------X---Customer Form---X------------- -->
<?php
    include '../components/Footer.php';
?>