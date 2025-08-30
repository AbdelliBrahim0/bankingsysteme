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
        $designation = "";
        $salary = "";

        $checked_id = "";
        $employe_id	 = "";

        $msg = "";
        $msg_get ="";

        $option = "";
        $id = "";

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
                $res = mysqli_fetch_assoc(mysqli_query($con,"SELECT * FROM employe WHERE id = $id"));
                $employe_id	 = $res["employe_id"];
                $name = $res["name"];
                $gender = $res["gender"];
                $birthday = $res["birthday"];
                $email = $res["email_id"];
                $phone_no = $res["phone_no"];
                $state = $res["state"];
                $district = $res["district"];
                $city = $res["city"];
                $pin_code = $res["pin_code"];
                $designation = $res["designation"];
                $salary = $res["salary"];
            }else{
                // ==========Genrate Id Number===========
                    $sql_id = mysqli_query($con,"SELECT employe_id FROM employe ORDER BY id DESC LIMIT 1");
                    $checked_id = mysqli_fetch_assoc($sql_id);

                    if(mysqli_num_rows($sql_id)>0){
                        $prives_id = $checked_id['employe_id'];
                        $get_id = str_replace("EM", "", $prives_id);
                        $id_incrase = $get_id+1;
                        $get_id_string = str_pad($id_incrase, 5,0, STR_PAD_LEFT);

                        $employe_id = "EM".$get_id_string;
                    }else{
                        $employe_id = "EM00001";
                    }
                // ======X===Genrate Id Number===X=======
            }
        //========X==View Profile Functionality==X=============
    //=========X===For Other Functionality===X======

    // ============Get Massege Here===========
        if(isset($_GET["msg"]) && $_GET["msg"] != ""){
            $msg_get = mysqli_escape_string($con,$_GET["msg"]);
            if($msg_get == "msg"){
                $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <h4 class='alert-heading'>Well done!</h4>
                    <strong>Employe Detailes Added Successfully</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    // =========X===Get Massege Here===X=======

    // ========= Send Records Functionality ========
        if(isset($_POST['add_employe'])){
            $name = mysqli_escape_string($con,$_POST['name']);
            $gender = mysqli_escape_string($con,$_POST['gender']);
            $birthday = mysqli_escape_string($con,$_POST['birthday']);
            $email = mysqli_escape_string($con,$_POST['email']);
            $phone_no = mysqli_escape_string($con,$_POST['number']);
            $state = mysqli_escape_string($con,$_POST['state']);
            $district = mysqli_escape_string($con,$_POST['district']);
            $city = mysqli_escape_string($con,$_POST['city']);
            $pin_code =mysqli_escape_string($con,$_POST['pin_code']);
            $employe_id = $employe_id;
            $designation = mysqli_escape_string($con,$_POST['designation']);
            $salary = mysqli_escape_string($con,$_POST['salary']);

            if($option == ''){
                mysqli_query($con,"INSERT  INTO employe (employe_id,name,gender,email_id,birthday,phone_no,state,district,city,pin_code,designation,salary) VALUES ('$employe_id','$name','$gender','$email','$birthday','$phone_no','$state','$district','$city','$pin_code','$designation','$salary')");

                mysqli_query($con,"INSERT INTO users (usename,password,type) VALUES ('$employe_id','$phone_no',1)");
    
                echo "<script>window.location='New__Employe.php?type=n&msg=msg'</script>";
            }else{
                mysqli_query($con,"UPDATE employe SET employe_id='$employe_id',name='$name',gender='$gender',email_id='$email',birthday='$birthday',phone_no='$phone_no',state='$state',district='$district',city='$city',pin_code='$pin_code',designation='$designation',salary='$salary' WHERE id = $id");

                mysqli_query($con,"UPDATE users SET username='$employe_id',password='$phone_no',type='1' WHERE username = '$employe_id'");

                echo "<script>window.location='Employes_Detailes.php?type=n&msg=msg'</script>";
            }
        }
    // ======X=== Send Records Functionality ===X===
?>
    <!-- ------------Employee Form---------------- -->
    <?php include '../components/User_Name.php' ?>
    
    <div class="container employee-form-container" id="add_page">
        <?php echo $msg; ?>
        
        <div class="form-header">
            <?php 
                if($option == 'view'){
                    echo "
                        <h2><i class='fas fa-user-tie me-2'></i>View Employee Details</h2>
                        <p>Viewing details for <span class='text-primary fw-bold'>$name</span></p>
                    ";
                } else if ($option == 'edit'){
                    echo "
                        <h2><i class='fas fa-user-edit me-2'></i>Edit Employee Details</h2>
                        <p>Editing profile for <span class='text-primary fw-bold'>$name</span></p>
                    ";
                } else {
                    echo "
                        <h2><i class='fas fa-user-plus me-2'></i>Add New Employee</h2>
                        <p>Please fill in the employee details below</p>
                    ";
                }
            ?>
        </div>
        
        <form method="post" action="" class="needs-validation" novalidate>
            <!-- Employee Information Section -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-id-badge"></i> Employee Information</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="employeeId" class="form-label">Employee ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control bg-light" id="employeeId" value="<?php echo $employe_id; ?>" disabled>
                            <input type="hidden" name="employe_id" value="<?php echo $employe_id; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="designation" class="form-label">Designation</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                            <select <?php echo $disabled; ?> class="form-select" id="designation" name="designation" required>
                                <?php 
                                    $designations = [
                                        'Account Manager', 'Teller', 'Loan Officer', 'Customer Service', 
                                        'Branch Manager', 'Financial Advisor', 'Operations Manager', 'IT Support'
                                    ];
                                    
                                    if($option == 'view'){
                                        echo "<option value='$designation' selected>$designation</option>";
                                    } else {
                                        echo "<option value='' selected disabled>Select Designation</option>";
                                        foreach($designations as $desig) {
                                            $selected = ($desig == $designation) ? 'selected' : '';
                                            echo "<option value='$desig' $selected>$desig</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="salary" class="form-label">Monthly Salary (₹)</label>
                        <div class="input-group salary-input">
                            <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="salary" name="salary" value="<?php echo $salary; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="" class="row g-3 mt-2 mb-2">
            <!-- Personal Information Section -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-user"></i> Personal Information</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="fullName" class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="fullName" name="name" value="<?php echo $name; ?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input <?php echo $disabled; ?> type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            <select <?php echo $disabled; ?> class="form-select" id="gender" name="gender" required>
                                <?php 
                                    if($option == 'view'){
                                        echo "<option value='$gender' selected>$gender</option>";
                                    } else if($option == 'edit'){
                                        echo "<option value='$gender' selected>$gender</option>";
                                        echo "<option value='Male'>Male</option>";
                                        echo "<option value='Female'>Female</option>";
                                        echo "<option value='Other'>Other</option>";
                                    } else {
                                        echo "<option value='' selected disabled>Select Gender</option>";
                                        echo "<option value='Male'>Male</option>";
                                        echo "<option value='Female'>Female</option>";
                                        echo "<option value='Other'>Other</option>";
                                    }   
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input <?php echo $disabled; ?> type="tel" class="form-control" id="phone" name="number" value="<?php echo $phone_no; ?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid phone number.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="birthday" class="form-label">Date of Birth</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input <?php echo $disabled; ?> type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $birthday; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Address Information Section -->
            <div class="form-section">
                <h5 class="form-section-title"><i class="fas fa-map-marker-alt"></i> Address Information</h5>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="district" class="form-label">District</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="district" name="district" value="<?php echo $district; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label">City</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="pinCode" class="form-label">PIN Code</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            <input <?php echo $disabled; ?> type="text" class="form-control" id="pinCode" name="pin_code" value="<?php echo $pin_code; ?>" required>
                            <div class="invalid-feedback">
                                Please provide a valid PIN code.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="d-flex justify-content-between mt-4">
                <a href="Employes_Detailes.php?type=n" class="btn btn-cancel">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
                <?php if($option != 'view'): ?>
                    <button type="submit" name="add_employe" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>
                        <?php echo ($option == 'edit') ? 'Update Employee' : 'Add Employee'; ?>
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Include CSS -->
    <link rel="stylesheet" href="../style/employee-form.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JavaScript for form validation and formatting -->
    <script>
    // Enable form validation
    (function () {
        'use strict'
        
        // Fetch the form we want to apply custom Bootstrap validation styles to
        var form = document.querySelector('.needs-validation')
        
        // Add validation for phone number
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '');
            });
        }
        
        // Add validation for PIN code
        const pinInput = document.getElementById('pinCode');
        if (pinInput) {
            pinInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 6);
            });
        }
        
        // Add validation for salary
        const salaryInput = document.getElementById('salary');
        if (salaryInput) {
            salaryInput.addEventListener('input', function(e) {
                // Allow only numbers and one decimal point
                e.target.value = e.target.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
                
                // Format as currency
                let value = e.target.value.replace(/[^0-9.]/g, '');
                if (value) {
                    let parts = value.split('.');
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    e.target.value = parts.join('.');
                }
            });
        }
        
        // Form validation on submit
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false);
        }
    })()
    </script>
    
    <!-- Include Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ---------X---Employe Form---X------------- -->
<?php
    include '../components/Footer.php';
?>