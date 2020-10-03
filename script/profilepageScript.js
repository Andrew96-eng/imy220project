$(document).ready(function(){
    window.onscroll = function() {scrollFunction()};
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

        ["dragleave","dragend"].forEach(type => {
            dropZoneElem.addEventListener(type, e => {
                dropZoneElem.classList.remove("uploadpp--over");
            });
        });

        dropZoneElem.addEventListener("drop", e => {
            e.preventDefault();
            // console.log(e.dataTransfer.files);
            if(e.dataTransfer.files.length){
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
            if(inputElem.files.length)
            {
                console.log(inputElem.files[0]);
            }
        });
    });

    function messageFriend(currentUserId, userId)
    {

    }

    function acceptFriendRequest(currentUserId, friendId)
    {

    }

    function followUser(currentUserId,otherUserId)
    {
        
    }

    //<div class="uploadpp-imagethumb" data-label="mypic.png"></div>