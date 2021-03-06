$(document).ready(function () {
    window.onscroll = function () {
        scrollFunction()
    };
    $("#messageBox").hide();
});



function scrollFunction() {
    var mybutton = document.getElementById("backtotopButton");
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

document.querySelectorAll(".uploadpp-input").forEach(inputElem => {
    const dropZoneElem = inputElem.closest(".uploadpp");

    dropZoneElem.addEventListener("dragover", e => {
        e.preventDefault();
        dropZoneElem.classList.add("uploadpp--over");
    });

    ["dragleave", "dragend"].forEach(type => {
        dropZoneElem.addEventListener(type, e => {
            dropZoneElem.classList.remove("uploadpp--over");
        });
    });

    dropZoneElem.addEventListener("drop", e => {
        e.preventDefault();
        // console.log(e.dataTransfer.files);
        if (e.dataTransfer.files.length) {
            inputElem.files = e.dataTransfer.files;
        }
        console.log(inputElem.files[0]);
        var filenameText = inputElem.files[0].name;
        $("#filenamep").html(filenameText);
        $("#filenamep").removeClass("filenamep_text");
        $("#filenamep").addClass("filenamep_text_show");
        dropZoneElem.classList.remove("uploadpp--over");
    });

    dropZoneElem.addEventListener("click", e => {
        inputElem.click();
    });

    inputElem.addEventListener("change", e => {
        if (inputElem.files.length) {
            console.log(inputElem.files[0]);
        }
    });
});

function sendMessage(currentUserId) {
    userId = $("#friendmessagingto")[0].attributes[2].value;
    $.ajax({
        type: "POST",
        url: "../php/sendmessage.php",
        data: "cUser=" + currentUserId + "&toid=" + userId + "&messageText=" + $("#messageInput").val(),
        success: function (data) {
            phpResult = data;
            if (data == 200) {
                document.getElementById("messageHolder").innerHTML = document.getElementById("messageHolder").innerHTML + "<h3 id='showhidesentmsg'>Sent Message</h3>";
            }
        }
    });
}

function messageFriend(currentUserId, userId) {
    $("#friendmessagingto")[0].attributes[2].value = userId;
    $("#messageBox").show();
    $.ajax({
        type: "POST",
        url: "../php/getMessages.php",
        data: "cUser=" + currentUserId + "&toid=" + userId,
        success: function (data) {
            phpResult = data;
            document.getElementById("messageHolder").innerHTML = document.getElementById("messageHolder").innerHTML + phpResult;
        }
    });

    $.ajax({
        type: "POST",
        url: "../php/getUserName.php",
        data: "userId=" + userId,
        success: function (data) {
            phpResult = data;
            $("#chattingnameheading").text($("#chattingnameheading").text() + phpResult)
        }
    });
}

function closeChat() {
    $("#messageBox").hide();
}

function acceptFriendRequest(currentUserId, friendId, requestId) {
    $.ajax({
        type: "POST",
        url: "../php/addFriend.php",
        data: "uId=" + friendId + "&cUser=" + currentUserId + "&rid=" + requestId,
        success: function (data) {
            phpResult = data;
            if (data == 200) {
                console.log(phpResult);
                var sncakbar = document.getElementById("snackbar");
                var text = sncakbar.innerHTML;
                sncakbar.innerHTML = "Friend Added."
                sncakbar.className = "show";
                setTimeout(function () {
                    sncakbar.className = sncakbar.className.replace("show", "");
                }, 3000);
                sncakbar.innerHTML = text;
                location.reload();
            }
        }
    });
}

function followUser(currentUserId, otherUserId) {
    $.ajax({
        type: "POST",
        url: "../php/follower.php",
        data: "uId=" + otherUserId + "&cUser=" + currentUserId,
        success: function (data) {
            phpResult = data;
            if (data == 200) {
                location.reload();
            }
        }
    });
}

//<div class="uploadpp-imagethumb" data-label="mypic.png"></div>