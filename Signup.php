<?php
session_start();
require "server/security/verify-input.php";
include("server/connection/connectionDB.php");

date_default_timezone_set("Asia/Bangkok");


if (isset($_POST['signup'])) {
    $userID = verify_input(strtolower($_POST['userID']));
    $email = verify_input(strtolower($_POST['email']));
    $firstname = verify_input($_POST['firstname']);
    $lastname = verify_input($_POST['lastname']);
    $dormitory = $_POST['dormitory'];
    $password = verify_input(sha1(md5($_POST['password'])));
    $confirm_password = verify_input(sha1(md5($_POST['confirm_password'])));

    $stmt = $conn->prepare("SELECT COUNT(`userID`) FROM `datauser` WHERE `userID` = ?");
    $stmt->bind_param('s', $userID);
    $stmt->execute();
    $stmt->bind_result($c_userID);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(`email`) FROM `datauser` WHERE `email` = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($c_email);
    $stmt->fetch();
    $stmt->close();

    if($password === $confirm_password) {
        if($c_userID == 0) {
            if($c_email == 0) {
                if($dormitory == 9) {
                    $gender = "male";
                } else if($dormitory == 7 || $dormitory == 8) {
                    $gender = "female";
                } else {
                    $gender = "(NULL)";
                }
                $created_at = date("Y-m-d H:i:s");
                $insert = "INSERT INTO `datauser` (`userID`, `password`, `firstname`, `lastname`, `email`,  `gender`, `DOM`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert);
                $rc = $stmt->bind_param('ssssssss', $userID, $password, $firstname, $lastname, $email, $gender, $dormitory, $created_at);-
                $stmt->execute();

                if($stmt) {
                    $success = "Sign up success.";
                } else {
                    $err = "Sign up fail.";
                }
            } else {
                $err = "Email have already.";
            }
        } else {
            $err = "User ID have already.";
        }
    } else {
        $err = "password doesn't match";
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="extension/plugins/Bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="extension/plugins/fontawesome-6.5.1/css/all.min.css">
    <link rel="stylesheet" href="extension/plugins/Sweetalert/sweetalert2.min.css">

    <link rel="icon" href="dist/img/icon.png">

    <script type="text/javascript" src="extension/plugins/swal.js"></script>

    <?php if (isset($err)) { ?>
        <script type="text/javascript">
            setTimeout(function () {
                swal("Failed", "<?php echo $err; ?>", "error");
            }, 100);
        </script>

    <?php } ?>
    <?php if (isset($success)) { ?>
        <script type="text/javascript">
            setTimeout(function () {
                swal("Success", "<?php echo $success; ?>", "success");
            }, 100);
        </script>

    <?php } ?>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signup {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .form-signup .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signup">
        <form method="post" id="signupForm" class="needs-validation" novalidate>
            <h1 class="h4 mb-3 fw-bold">Signup to <span class="text-info">MWIT Laundry</span></h1>
            <div class="form-floating mb-2 has-validation">
                <input type="text" name="userID" id="userID" class="form-control rounded-0" placeholder="User ID"
                    autocomplete="off" maxlength="8" required>
                <label for="userID">User ID</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your User ID.</span>
                </div>
            </div>
            <div class="form-floating mb-2 has-validation">
                <input type="email" name="email" id="Email" class="form-control rounded-0" placeholder="Email"
                    autocomplete="off" required>
                <label for="Email">Email</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your Email or Email doesn't formatted.</span>
                </div>
            </div>
            <div class="form-floating mb-2 has-validation">
                <input type="text" name="firstname" id="Firstname" class="form-control rounded-0"
                    placeholder="Firstname" autocomplete="off" required>
                <label for="Firstname">Firstname</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your Firstname.</span>
                </div>
            </div>
            <div class="form-floating mb-2 has-validation">
                <input type="text" name="lastname" id="Lastname" class="form-control rounded-0" placeholder="Lastname"
                    autocomplete="off" required>
                <label for="Lastname">Lastname</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your Lastname.</span>
                </div>
            </div>
            <div class="form-floating mb-2 has-validation">
                <input type="password" name="password" id="__password" class="form-control rounded-0"
                    placeholder="Password" required>
                <label for="__password">Password</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your Password.</span>
                </div>
            </div>
            <div class="form-floating mb-2 has-validation">
                <input type="password" name="confirm_password" id="confirm-password" class="form-control rounded-0"
                    placeholder="confirm password" autocomplete="off" required>
                <label for="confirm-password">Confirm Password</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your confirm password.</span>
                </div>
            </div>
            <div class="mb-2 has-validation">
                <select name="dormitory" id="Dormitory" class="form-select">
                    <option selected>Select your dormitory</option>
                    <option value="9">Dormitory 9 (Male)</option>
                    <option value="8">Dormitory 8 (Female)</option>
                    <option value="7">Dormitory 7 (Female)</option>
                </select>
            </div>
            <button type="submit" name="signup" id="signup" class="w-100 btn btn-lg btn-primary rounded-0">Sign up</button>
            <div class="row align-items-center">
                <span class="my-2">Don't you have account? <a href="Signin" class="text-decoration-none">Sign in</a></span>
            </div>
        </form>
    </main>

    <script type="text/javascript">
        (function () {
            'use strict'
            var forms = document.querySelectorAll(".needs-validation");
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>

</html>