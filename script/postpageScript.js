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
            if (phpResult > 10) {
                deleteComment(commentId);
            }
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