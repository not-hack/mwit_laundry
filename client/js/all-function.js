
function showMessage(ID, message) {
    var showMessageID = "#time-remaining-ID" + ID;
    $(showMessageID).html(message);
}

function showTimeRemeaningMessage(ID, status) {
    var showTimeReID = "#messageShowTimeID" + ID;
    if(status == "working") {
        $(showTimeReID).show();
    } else {
        $(showTimeReID).hide();
    }
    
}

function changeStyleShowMessage(ID, colorCode) {
    var chageStyleShowMessageID = "#time-remaining-ID" + ID;
    $(chageStyleShowMessageID).css({ color: colorCode, fontWeight: "bold" });
}

function stopShakingIcon(ID, status) {
    var iconID = "#iconID" + ID;
    if(status == "working") {
        $(iconID).addClass("shaking");
    } else {
        $(iconID).removeClass("shaking");
    }
}

function showBtnViewUser(ID, status, UID, endtime) {
    if(status == "working") {
        var html_btn = '<button type="button" class="viewUserDetail btn btn-info btn-sm rounded-pill border border-dark shadow px-2 fw-bold" userid=' + UID + ' endtime=' + (endtime/1000) + '>detail User</button>';
        var showUserID = "#showUser-useID" + ID;
        $(showUserID).html(html_btn);
    }
}