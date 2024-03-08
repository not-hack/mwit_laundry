<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include("../server/security/checkLogin.php");
checkLogin();

$ID = $_SESSION['ID'];
$class = $_SESSION['class'];
$dormitory = $_SESSION['dormitory'];
$web_head = "Overview";

include("../server/connection/connectionDB.php");

// require "../googleSheets-API/vendor/autoload.php";
// require "../googleSheets-API/key.secret.php";

// $credentials_path = '../googleSheets-API/credentials.json';
// include("../googleSheets-API/service.php");

// require '../googleSheets-API/fetch-washing-all.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include("../extension/_partials/head.php"); ?>
<script type="text/javascript" src="js/all-function.js"></script>
<script type="text/javascript">
    'use strict';
    function checkTime(i) {
        return (i < 10) ? "0" + i : i;
    }
    function fetchWashing() {
        $.ajax({
            url: "../server/washing/fetch-sql.php",
            type: "GET",
            dataType: 'json',
            success: function (data) {
                data.forEach(function (element) {
                    showMessage(element.ID, element.status);
                    if (element.status == "ready") {
                        showTimeRemeaningMessage(element.ID);
                        changeStyleShowMessage(element.ID, '#198754');
                        stopShakingIcon(element.ID);
                        $("#showUser-useID" + element.ID).html("No user");
                    } else if (element.status == "repair") {
                        showTimeRemeaningMessage(element.ID);
                        changeStyleShowMessage(element.ID, '#ffc107');
                        stopShakingIcon(element.ID);
                        $("#showUser-useID" + element.ID).html("Please wait 4-7 days.");
                    } else if (element.status == "working") {
                        var distance = element.end_usetime - Date.now() + 1000;
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        var message = checkTime(minutes) + "m " + checkTime(seconds) + "s ";
                        showMessage(element.ID, message);
                        showTimeRemeaningMessage(element.ID, element.status);
                        showBtnViewUser(element.ID, element.status, element.current_user, element.end_usetime);
                        if(distance/1000 < 0) {
                            //clearInterval(x);
                            $.ajax({
                                url: "../server/washing/update.php",
                                type: "POST",
                                data: {
                                    ID: element.ID,
                                    status: "ready",
                                    end_usetime: "(NULL)",
                                    current_user: "(NULL)",
                                    lastuser: element.current_user
                                },
                                success: console.log(distance)
                            });
                        }
                    } else {
                        showMessage(element.ID, "Error")
                        showTimeRemeaningMessage(element.ID);
                        changeStyleShowMessage(element.ID, '#dc3545');
                        stopShakingIcon(element.ID);
                        $("#showUser-useID" + element.ID).html("Please contact admin.");
                    }
                });
            }
        });
    }
    fetchWashing();
    var x = setInterval(fetchWashing, 1000);
    console.log(new Date("<?php echo date("M d, Y H:i:s",strtotime("+52 minutes", $_SERVER['REQUEST_TIME'])) ?>").getTime());

</script>
<style>
    .text-blink {
        animation: textBlink 4s linear infinite;
    }

    .shaking {
        animation: machineShaking 0.7s infinite;
    }

    @keyframes machineShaking {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(8deg);
        }

        50% {
            transform: rotate(0deg);
        }

        75% {
            transform: rotate(-8deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    @keyframes textBlink {
        50% {
            opacity: .5;
        }
    }
</style>

<body>
    <main class="main" id="top">
        <div class="container-fluid px-0">
            <?php include("../extension/_partials/navbar.php"); ?>
            <div class="row row-col-2 mx-1">
                <?php include("../extension/_partials/showWashing-sql.php"); ?>
            </div>
            <div id="veiwDetailsUser" class="modal fade" tabindex="-1" aria-labelledby="veiwDetailsUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <div class="modal-title fw-bold"><i class="fas fa-user"></i> User Detail</div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <h5><i class="fa-solid fa-circle-user"></i> <span id="showUserID">s000000</span></h5>
                            <h5><i class="fa-solid fa-id-card"></i> <span id="showName">Pakornkaed Kuaisakun</span></h5>
                            <h5><i class="fa-solid fa-envelope"></i> <span id="showEmail">test</span></h5>
                            <h5><i class="fa-solid fa-clock"></i> <b>Finish in:</b>  <span id="showEndTime">(NULL)</span></h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script type="text/javascript">
        $(document).on('click', '.viewUserDetail', function () {
            var userID = $(this).attr('userid');
            var endTime = $(this).attr('endtime');
            $.ajax({
                url: "../server/washing/fetchuser.php",
                method: "POST",
                data: { UID: userID, endTime: endTime },
                dataType: "json",
                success: function(data) {
                    $('#veiwDetailsUser').modal('show');
                    $('#showUserID').text(data.userID);
                    $('#showName').text(data.name);
                    $('#showEmail').text(data.email);
                    $('#showEndTime').text(data.endTime);
                }
            });
        });
    </script>
    <script type="text/javascript" src="../extension/plugins/Bootstrap-5.3.2/js/bootstrap.min.js"></script>
</body>

</html>