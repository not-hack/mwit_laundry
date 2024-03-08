<?php
$query = "SELECT * FROM `washing-machine` WHERE `DOM` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $dormitory);
$stmt->execute();
$result = $stmt->get_result();

$cnt = 1;

while ($row = $result->fetch_object()) {
    ?>
    <div class="col-md-6 mt-2 mb-1 px-1">
        <div class="card h-md-100">
            <div class="card-header pb-0 mb-1 border-0">
                <h5 class="mb-0 mt-1 fw-bold text-center">
                    Washing machine
                    <span class="badge rounded-pill bg-primary text-dark">ID:
                        <?php echo $cnt; ?>
                    </span>
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="row align-items-center align-content-center">
                    <div class="col">
                        <p class="font-sans-serif lh-1 mb-1 fs-3 text-capitalize" id="time-remaining-ID<?php echo $cnt; ?>"
                            machine-id="<?php echo $cnt; ?>">Loading...
                        </p>
                        <span class="badge rounded-pill bg-success fs-13 text-blink" id="messageShowTimeID<?php echo $cnt; ?>">Time remaining</span>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="d-flex flex-nowrap align-items-center">
                            <div class="font-sans-serif text-wrap fw-bold mb-0 pr-2" id="showUser-useID<?php echo $cnt; ?>" machine-id="<?php echo $cnt; ?>">User: NULL
                            </div>
                            <div class="px-2 shaking" id="iconID<?php echo $cnt; ?>">
                                <svg fill="#000000" height="60px" width="60px" version="1.1" id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 463 463" xml:space="preserve">
                                    <g>
                                        <path d="M383.5,0h-304C66.542,0,56,10.542,56,23.5v416c0,12.958,10.542,23.5,23.5,23.5h304c12.958,0,23.5-10.542,23.5-23.5v-416
            C407,10.542,396.458,0,383.5,0z M71,95h321v321H71V95z M392,23.5V80H183V15h200.5C388.187,15,392,18.813,392,23.5z M79.5,15H168v65
            H71V23.5C71,18.813,74.813,15,79.5,15z M383.5,448h-304c-4.687,0-8.5-3.813-8.5-8.5V431h321v8.5C392,444.187,388.187,448,383.5,448
            z" />
                                        <path
                                            d="M231.5,128C170.019,128,120,178.019,120,239.5S170.019,351,231.5,351S343,300.981,343,239.5S292.981,128,231.5,128z
             M231.5,336c-53.21,0-96.5-43.29-96.5-96.5s43.29-96.5,96.5-96.5s96.5,43.29,96.5,96.5S284.71,336,231.5,336z" />
                                        <path d="M231.5,71c12.958,0,23.5-10.542,23.5-23.5S244.458,24,231.5,24S208,34.542,208,47.5S218.542,71,231.5,71z M231.5,39
            c4.687,0,8.5,3.813,8.5,8.5s-3.813,8.5-8.5,8.5s-8.5-3.813-8.5-8.5S226.813,39,231.5,39z" />
                                        <path
                                            d="M95.5,71h48c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-48c-4.142,0-7.5,3.358-7.5,7.5S91.358,71,95.5,71z" />
                                        <path
                                            d="M279.5,55h24c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-24c-4.142,0-7.5,3.358-7.5,7.5S275.358,55,279.5,55z" />
                                        <path
                                            d="M335.5,55h24c4.142,0,7.5-3.358,7.5-7.5s-3.358-7.5-7.5-7.5h-24c-4.142,0-7.5,3.358-7.5,7.5S331.358,55,335.5,55z" />
                                        <path
                                            d="M231.5,160c-43.836,0-79.5,35.664-79.5,79.5s35.664,79.5,79.5,79.5s79.5-35.664,79.5-79.5S275.336,160,231.5,160z
             M231.5,304c-35.565,0-64.5-28.935-64.5-64.5s28.935-64.5,64.5-64.5s64.5,28.935,64.5,64.5S267.065,304,231.5,304z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $cnt = $cnt + 1;
}
$stmt->close();
?>