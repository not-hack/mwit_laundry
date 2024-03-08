<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require "server/security/verify-input.php";


if (isset($_SESSION['expired-OTP'])) {
    $process_otp = true;
    if (($_SERVER['REQUEST_TIME'] - $_SESSION['expired-OTP']) > 480) {
        header("Location: server/otp/cancle-otp.php");
        exit;
    }
} else {
    $process_otp = false;
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

    <script type="text/javascript" src="extension/plugins/swal.js"></script>

    <?php if (isset($_GET['err'])) {?>
        <script type="text/javascript">
            setTimeout(function () {
                swal("Failed", "<?php echo $_GET['err']; ?>", "error");
            }, 100);
        </script>
    <?php } ?>
    <?php if (isset($_GET['success'])) { ?>
        <script type="text/javascript">
            setTimeout(function () {
                swal("Success", "<?php echo $_GET['success']; ?>", "success");
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

        .form-forget-password {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .form-forget-password .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>

<body class="text-center">
    <main class="form-forget-password">
        <?php if (!$process_otp && !isset($_SESSION['_password_'])) { ?>
            <form action="server/otp/sendMailOTP.php" method="post" class="needs-validation" novalidate>
                <h1 class="h4 mb-3 fw-bold">Forget your password</h1>
                <div class="form-floating mb-2 has-validation">
                    <input type="email" name="email" id="Email" class="form-control rounded-0" placeholder="User ID"
                        autocomplete="off" required>
                    <label for="Email">Email</label>
                    <div class="invalid-feedback">
                        <span class="text-danger p-1">Please enter your Email.</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="Signin" class="btn btn-lg btn-secondary rounded-0" style="width: 48%;">Back</a>
                    <button type="submit" name="get-otp" class="btn btn-lg btn-primary rounded-0"
                        style="width: 48%;">Confirm</button>
                </div>
            </form>
        <?php } else if(!isset($_SESSION['_password_'])) { ?>
            <form action="server/otp/check-otp.php" method="post" class="col-sm-10 form-horizontal needs-validation" novalidate>
                <div class="form-group row">
                    <label for="inputOTP" class="col-sm-2 col-form-label fw-bold">OTP
                    </label>
                    <div class="col-sm-7 input-group has-validation">
                        <div class="inputfield" id="InputField">
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f1" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f2" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f3" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f4" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f5" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <input type="text" inputmode="numberic" id="inputOTP" maxlength="1" class="OTP-input"
                                name="OTP-f6" autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false"
                                required />
                            <style>
                                .inputfield {
                                    width: 100%;
                                    display: flex;
                                    justify-content: space-around;
                                }

                                .OTP-input {
                                    height: 2em;
                                    width: 2em;
                                    border: 2px solid #dad9df;
                                    outline: none;
                                    text-align: center;
                                    font-size: 1.5em;
                                    border-radius: 0.3em;
                                    background-color: #ffffff;
                                    outline: none;
                                    /*Hide number field arrows*/
                                    -moz-appearance: textfield;
                                }

                                input[type="number"]::-webkit-outer-spin-button,
                                input[type="number"]::-webkit-inner-spin-button {
                                    -webkit-appearance: none;
                                    margin: 0;
                                }
                            </style>
                        </div>
                        <div class="invalid-feedback">
                            <span class="text-dager fw-bold p-1">Please enter your OTP</span>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center col-6 justify-content-between">
                        <button type="submit" name="confirm-otp" class="btn btn-outline-success">Confirm</button>
                        <a href="server/otp/cancle-otp.php" class="btn btn-outline-danger ml-1">Cancle</a>
                    </div>
                    <div>
                        <i class="fa-solid fa-hourglass text-info spin" id="timer-icon"></i>
                        <span class="ml-3 font-weight-bold" id="expired-otp" style="font-size: 16px;">Loading..
                        </span>
                        <style>
                            .spin {
                                animation: spin infinite 2.5s;
                                animation-duration: 5s;
                            }

                            @keyframes spin {
                                0% {
                                    transform: rotate(0deg);
                                }

                                25% {
                                    transform: rotate(0deg);
                                }

                                50% {
                                    transform: rotate(180deg);
                                }

                                75% {
                                    transform: rotate(180deg);
                                }

                                100% {
                                    transform: rotate(360deg);
                                }
                            }
                        </style>
                    </div>
                </div>
            </form>
            <form action="server/otp/sendMailOTP.php" method="post" class="mt-1 start-12 position-absolute">
                <input type="hidden" name="ID" value="<?php echo $_SESSION['ID']; ?>">
                <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
                <button type="submit" class="btn btn-warning" name="Re-OTP" id="Re-OTP"><i
                        class="fas fa-sync-alt"></i> Send Again</button>
            </form>
            <script type="text/javascript">
                const InputField = document.getElementById("InputField");

                InputField.addEventListener("input", function (e) {
                    const target = e.target;
                    const val = target.value;

                    if (isNaN(val)) {
                        target.value = "";
                        return;
                    }

                    if (val != "") {
                        const next = target.nextElementSibling;
                        if (next) {
                            next.focus();
                        }
                    }
                });

                InputField.addEventListener("keyup", function (e) {
                    const target = e.target;
                    const key = e.key.toLowerCase();

                    if (key == "backspace" || key == "delete") {
                        target.value = "";
                        const prev = target.previousElementSibling;
                        if (prev) {
                            prev.focus();
                        }
                        return;
                    }
                });
            </script>
            <script type="text/javascript">
                var expired_otp = new Date("<?php echo date("M d, Y H:i:s", $_SESSION['expired-OTP']); ?>").getTime();
                function checkTime(i) {
                    return (i < 10) ? "0" + i : i;
                }

                var x = setInterval(function () {

                    let now = new Date().getTime();

                    var distance = expired_otp - now;

                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("expired-otp").innerHTML = checkTime(minutes) + "m " + checkTime(seconds) + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("expired-otp").innerHTML = 'EXPIRED';
                        document.getElementById("expired-otp").classList.add("text-danger");
                        document.getElementById("timer-icon").classList.replace("fa-hourglass", "fa-ban");
                        document.getElementById("timer-icon").classList.remove("spin");
                        document.getElementById("timer-icon").classList.replace("text-info", "text-danger");
                    }
                }, 1000);
            </script>
            <?php if (isset($_SESSION['OTP-cooldown'])) { ?>
                <script type="text/javascript">
                    var OTP_cooldown = new Date("<?php echo date("M d, Y G:i:s", $_SESSION['OTP-cooldown']); ?>").getTime();

                    function checkTime(i) {
                        return (i < 10) ? "0" + i : i;
                    }

                    var x = setInterval(function () {
                        let now = new Date().getTime();

                        var distance = OTP_cooldown - now;

                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.getElementById("Re-OTP").innerHTML = checkTime(minutes) + "m " + checkTime(seconds) + "s";
                        document.getElementById("Re-OTP").disabled = true;

                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("Re-OTP").innerHTML = '<i class="fas fa-sync-alt"></i> Send Again';
                            document.getElementById("Re-OTP").disabled = false;
                        }
                    }, 1000);
                </script>
            <?php } ?>
        <?php } else { ?>
            <form action="server/change-password.php" method="post" class="needs-validation" novalidate>
                <h1 class="h4 mb-3 fw-bold">Change your password</h1>
                <div class="form-floating mb-2 has-validation">
                    <input type="text" name="new-password" id="newPassword" class="form-control rounded-0" placeholder="New Password" autocomplete="off" required>
                    <label for="newPassword">New password</label>
                    <div class="invalid-feedback">
                        <span class="text-danger p-1">Please enter your New password.</span>
                    </div>
                </div>
                <div class="form-floating mb-2 has-validation">
                    <input type="text" name="confirm-new-password" id="confirmNewPassword" class="form-control rounded-0" placeholder="Confirm new password" autocomplete="off" required>
                    <label for="confirmNewPassword">Confirm new password</label>
                    <div class="invalid-feedback">
                        <span class="text-danger p-1">Please enter your confirm new password.</span>
                    </div>
                </div>
                <button type="submit" name="change-password" class="btn btn-lg btn-success rounded-0" style="width: 100%;">Change password</button>
            </form>
        <?php } ?>
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