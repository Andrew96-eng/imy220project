function searchUser(currentUser)
{
    var searchText = document.getElementById("searchUsersInput").value;
    if(searchText == "")
    {
        $("div.searchResult").html("");
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "../php/searchUser.php",
            data: "searchText=" + searchText + "&currentUser="+currentUser,
            success: function (data) {
                phpResult = data;
                console.log(phpResult);
                $("div.searchResult").html(phpResult);
            }
        });
    }
}

function addFriend(userId)
{
    var currentUserId = document.getElementById("hiddenUserId").value;
    $.ajax({
        type: "POST",
        url: "../php/addFriend.php",
        data: "userId=" + userId +"&currentUser=" + currentUserId,
        success: function (data) {
            phpResult = data;
            if(data == 200)
            {
                console.log(phpResult);
                var sncakbar = document.getElementById("snackbar");
                sncakbar.className = "show";
                setTimeout(function(){ sncakbar.className = sncakbar.className.replace("show", ""); }, 3000);
            }
        }
    });
}

function messageFriend(currentUserId, userId)
{

}