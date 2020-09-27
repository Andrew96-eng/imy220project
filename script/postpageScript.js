
function likePost(postID)
{
    $.ajax({
        type: "POST",
        url: "../php/likescript.php",
        data: "postID="+postID,
        success: function(data){
        phpResult = data;
        console.log(phpResult);
        document.getElementById("commentHeading2").innerHTML = "Comments. Likes: " + phpResult + " <button class='ml-5 btn btn-outline-secondary' type='button' onclick='likePost("+ postID + ")'>Like</button>";
      }
      });
}