<?php
session_start();
include("server/connection/connectionDB.php");
require "server/security/verify-input.php";

if(isset($_POST['signin'])) {
    $userID = verify_input($_POST['userID']);
    $password = verify_input(sha1(md5($_POST['password'])));

    $stmt = $conn->prepare("SELECT `ID`, `userID`, `password`, `gender`, `DOM`, `class` FROM `datauser` WHERE `userID` = ? AND `password` = ? LIMIT 1");
    $stmt->bind_param("ss", $userID, $password);
    $stmt->execute();
    $stmt->bind_result($ID, $userID, $password, $gender, $dormitory, $class);

    $result = $stmt->fetch();

    if($result) {
        if($class == "ADMIN") {
            header("Location: ");
        } else if($class == "USER") {
            $_SESSION['ID'] = $ID;
            $_SESSION['class'] = $class;
            $_SESSION['dormitory'] = $dormitory;
            header("Location: client/main.php");
        } else {
            $err = "Error";
        }
    } else {
        $err = "UserID or Password is wrong.";
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="extension/plugins/Bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="extension/plugins/fontawesome-6.5.1/css/all.min.css">
    <link rel="stylesheet" href="extension/plugins/Sweetalert/sweetalert2.min.css">

    <link rel="icon" href="dist/img/icon.png">

    <script type="text/javascript" src="extension/plugins/Sweetalert/sweetalert2.min.js"></script>
    <script type="text/javascript" src="extension/plugins/swal.js"></script>
    <script type="text/javascript" src="extension/plugins/Jquery/ajax.min.js"></script>

    <?php if (isset($err)) { ?>
        <script type="text/javascript">
            setTimeout(function () {
                swal("Failed", "<?php echo $err; ?>", "error");
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

        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="post" name="signInForm" id="signInForm" class="needs-validation" novalidate>
            <h1 class="h4 mb-3 fw-bold">Welcome to <span class="text-info">MWIT Laundry</span></h1>
            <div class="form-floating mb-2 has-validation">
                <input type="text" name="userID" id="userID" class="form-control rounded-0" placeholder="User ID"
                    autocomplete="off" maxlength="8" required>
                <label for="userID">User ID</label>
                <div class="invalid-feedback">
                    <span class="text-danger p-1">Please enter your User ID.</span>
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
            <button type="submit" name="signin" id="signin" class="w-100 btn btn-lg btn-primary rounded-0">Sign
                in</button>
            <div class="row align-items-center">
                <span class="my-2">Don't you have account? <a href="Signup" class="text-decoration-none">Sign
                        up</a></span>
                <a href="Forget-Password" class="text-decoration-none">Forget your password?</a>
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