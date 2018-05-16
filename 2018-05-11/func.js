// this whole thing is to get the data
// from the SQL table
// that $ is a function already
/*global $*/
var thingData;

    $.ajax({
        type: "GET",
        url: "DBConnection.php",
        dataType: "json",
        success: function(data, status) {
          thingData = data;
          console.log("Got data", data);
          
        },
        error: function(err) {
          console.log("Didn't get data", err);
        }
    }); 
    
    
function display()
{
    $("body").append($.attr("<h3>").html("Final"));
}

function onSubmitClick(e) {
    window.location.href="addTimeSlot.php";
}