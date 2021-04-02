$(document).ready(function() {
    $('#userTable').DataTable({
        "order": [],
        "iDisplayLength": 15,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    });
    
    $.ajax({
        url: "https://cloud-save-function-app.azurewebsites.net/api/httpgetcosmosdbrcdstrigger",
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
                    // Azure Cosmos DB Unique Document Id
                    if (key == 'uid' || key == 'username' || key == 'telephoneNumber' || key == 'address' || key == 'city' || key == 'prov' || key == 'postal' || key == 'picture' || key == 'audio') {
                        all_items += `<td>${item[key]}</td>`;
                        rcd_id = key;
                    }
                }
                all_items += "</tr>\n";
            }
            $("#all_items_tbody").html(all_items);
        },
        error: function (xhr, status, errorThrown) {
            alert("There was an AJAX problem with /httpgetcosmosdbrcdstrigger");
            console.log("Error: " + errorThrown);
            console.log("Status: " + status);
            console.dir(xhr);
        }
    });
});