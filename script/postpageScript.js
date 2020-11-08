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

function likePost(postID) {
    $.ajax({
        type: "POST",
        url: "../php/likescript.php",
        data: "postID=" + postID,
        success: function (data) {
            phpResult = data;
            console.log(phpResult);
            document.getElementById("commentHeading2").innerHTML = "Comments. Likes: " + phpResult + " <button class='ml-5 btn btn-outline-secondary' type='button' onclick='likePost(" + postID + ")'>Like</button>";
        }
    });
}

function reportComment(commentId) {
    $.ajax({
        type: "POST",
        url: "../php/reportComment.php",
        data: "commentID=" + commentId,
        success: function (data) {
            phpResult = data;
        }
    });
}

function deleteComment(commentId) {
    $.ajax({
        type: "POST",
        url: "../php/deleteComment.php",
        data: "commentID=" + commentId,
        success: function (data) {
            phpResult = data;
            console.log(phpResult);
            document.getElementById("comment" + commentId).outerHTML = "";
        }
    });
}

function deletePost(postId, userId)
{
    var r = confirm("Are you sure you want to Delete the post?");
    if (r == true) 
    {
        $.ajax({
            type: "POST",
            url: "../php/deletePost.php",
            data: "postID=" + postId + "&userID=" + userId,
            success: function (data) {
                phpResult = data;
                console.log(phpResult);
                if(phpResult == "Deleted")
                {
                    window.location.href = '../frontend_php/homepage.php?id=' + userId;
                }
            }
        });
    }  
}