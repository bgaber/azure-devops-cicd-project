function handleData(json, imBlob) {
    // Output S3 Pre-Signed URL to webpage
    //$("#psurl_result").html('<b>PreSigned URL:</b> ' + json.fields);
    var button_html = "<center><form METHOD='GET' ACTION='/upload-history.html'><p><button id='upload_history'>Click Here To See Your Image Analysis</button></p></form></center>";
    console.log("Status Return: " + json.status);
    console.log("PreSign Return: " + json.fields);
    $.ajax({
        headers: { 'x-amz-acl': 'public-read' },
        url: json.fields,
        type: 'PUT',
        contentType: 'image/png',
        data: imBlob,
        processData: false,
        success: function (data) {
            //$("#analysis_button").show();
            //$('#analysis_button').css({'display':'visible'});
            document.getElementById("analysis_button").style.visibility = "visible";
            //jq_ui_alert('dialog-message', "Successful upload to S3 using pre-signed url.");
            $("#upload_result").html('<center><b>Upload Result:</b> Success</center>');
            console.log("Upload Result: Success");
        },
        error: function (xhr, status, errorThrown) {
            jq_ui_alert('dialog-message', "Unsuccessful upload to S3 using pre-signed url.");
            $("#upload_result").html('<center><b>Upload Result:</b> Failed</center>');
            console.log("Upload Result: Failed");
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr);
        }
    });
}