function handleData(imBlob) {
    const ajax_func_url = "";
    var button_html = "<center><form METHOD='GET' ACTION='/show-users.html'><p><button id='show_users'>Click Here To Show User Details</button></p></form></center>";
    $.ajax({
        url: ajax_func_url,
        type: 'PUT',
        contentType: 'image/png',
        data: imBlob,
        processData: false,
        success: function (data) {
            //$("#details_button").show();
            //$('#details_button').css({'display':'visible'});
            document.getElementById("details_button").style.visibility = "visible";
            //jq_ui_alert('dialog-message', "Successful write to Cosmos DB and/or upload to Azure Storage Blob Container.");
            $("#upload_result").html('<center><b>Cosmos DB Write and Image Upload Result:</b> Success</center>');
            console.log("Upload Result: Success");
        },
        error: function (xhr, status, errorThrown) {
            jq_ui_alert('dialog-message', "Unsuccessful write to Cosmos DB and/or upload to Azure Storage Blob Container.");
            $("#upload_result").html('<center><b>Cosmos DB Write and Image Upload Result:</b> Failed</center>');
            console.log("Cosmos DB Write and Image Upload Result: Failed");
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr);
        }
    });
}