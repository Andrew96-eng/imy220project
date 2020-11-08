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

function unreport(commentId, userId) {
    $.ajax({
        type: "POST",
        url: "../php/unreportComment.php",
        data: "commentID=" + commentId,
        success: function (data) {
            if(data == 200)
            {
                window.location.href = '../frontend_php/reports.php?userID=' + userId;
            }
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
                    window.location.href = '../frontend_php/reports.php?userID=' + userId;
                }
            }
        });
    }  
}

function unreportPost(postId, userId)
{
    console.log("Here");
    $.ajax({
        type: "POST",
        url: "../php/unreportPost.php",
        data: "postID=" + postId,
        success: function (data) {
            phpResult = data;
            console.log(phpResult);
            if(phpResult == 200)
            {
                window.location.href = '../frontend_php/reports.php?userID=' + userId;
            }
        }
    });
}

function addnewReportReason(userId)
{
    let theReason = document.getElementById("addreportreason").value;
    $.ajax({
        type: "POST",
        url: "../php/addReportReason.php",
        data: "text=" + theReason,
        success: function (data) {
            phpResult = data;
            console.log(phpResult);
            if(phpResult == 200)
            {
                window.location.href = '../frontend_php/reports.php?userID=' + userId;
            }
        }
    });
}