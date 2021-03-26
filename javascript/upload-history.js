$(document).ready(function() {
    $('#historyTable, #analysisTable').DataTable({
        "order": [],
        "iDisplayLength": 15,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    });

    const apigw_endpt_all = "https://3okf2i4b27.execute-api.ca-central-1.amazonaws.com/api";
    const apigw_endpt_one = "https://ign1au7nz2.execute-api.ca-central-1.amazonaws.com/api";
    
    $.ajax({
        url: apigw_endpt_all + "/return_all_cosmosdb_rcds",
        type: "GET",
        // The type of data expected back
        dataType: "json",
        success: function (jsonlist) {
            var all_items = "";
            for (var i = 0, size = jsonlist.length; i < size ; i++) {
                all_items += "<tr>";
                let item = jsonlist[i];
                for (const key in item) {
                    console.log(`${key}: ${item[key]}`);
                    if (key == 'id') {               // Asure Cosmos DB Unique Document Id
                        all_items += `<td>${item[key]}</td>`;
                        rcd_id = key;
                    }
                    else if (key == 'image_fname') { // Asure Cosmos DB Partition Key
                        all_items +=`<td><input id='id_${i}' type='hidden' value='${item[rcd_id]}'><input id='image_fname_${i}' type='hidden' value='${item[key]}'><img src="https://bg-ca-central-1-uploads.s3.ca-central-1.amazonaws.com/${item[key]}" width="50" id='img_${i}'></td>`;
                    } else if (key == '_ts') {      // Asure Cosmos DB _ts key
                        var imgDate = new Date(item[key]*1000);
                        all_items += `<td>${imgDate.toLocaleString()}</td>`;
                        //all_items += `<td>${item[key]}</td>`;
                    }
                }
                all_items += "</tr>\n";
            }
            $("#all_items_tbody").html(all_items);
        },
        error: function (xhr, status, errorThrown) {
            alert("There was an AJAX problem with the get_all_cosmosdb_rcds Lambda function.");
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr);
        }
    });
    
    $("#all_items_tbody").on("click", "img", function(event) {
        //alert(event.target.id + " triggered this event");
        //var triggerElementId = $(this).attr('id');
        //alert(triggerElementId);
        
        var element_num = $(event.target.id.split("_")).get(-1)
        
        //alert("The number of " + event.target.id + " is " + element_num);
        
        var rcdId = $( "#id_" + element_num ).val();
        var image_fname = $( "#image_fname_"  + element_num ).val();
        console.log("Parameters are id=" + rcdId + ", fname=" + image_fname)

        $.ajax({
            url: apigw_endpt_one + "/return_cosmosdb_record",
            data: {
                id: rcdId, fname: image_fname
            },
            type: "GET",
            // The type of data expected back
            dataType: "json",
            success: function (json) {
                jsonlist = json.scores;
                var analysis = "";
                for (var i = 0, size = jsonlist.length; i < size ; i++) {
                    let item = jsonlist[i];
                    analysis += `<tr><td>${i+1}</td>`;
                    for (const key in item) {
                        console.log(`${key}: ${item[key]}`);
                        analysis += `<td>${item[key]}</td>`;
                    }
                    analysis += `</tr>`;
                }
                $("#analyzed_image").html(`<img src="https://bg-ca-central-1-uploads.s3.ca-central-1.amazonaws.com/${image_fname}" width="400">`);
                $("#one_item_tbody").html(analysis);
                console.log(analysis);
            },
            error: function (xhr, status, errorThrown) {
                jq_ui_alert('dialog-message', "There was an AJAX problem with the get_cosmosdb_record Lambda function.");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            }
        });
    });
});