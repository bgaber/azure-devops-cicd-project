<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Image Upload</title>
    
<style> #content{ 
    width: 50%; 
    margin: 20px auto; 
    border: 1px solid #cbcbcb; 
} 
form{ 
    width: 50%; 
    margin: 20px auto; 
} 
form div{ 
    margin-top: 5px; 
} 
#img_div{ 
    width: 80%; 
    padding: 5px; 
    margin: 15px auto; 
    border: 1px solid #cbcbcb; 
} 
#img_div:after{ 
    content: ""; 
    display: block; 
    clear: both; 
} 
img{ 
    float: left; 
    margin: 5px; 
    width: 300px; 
    height: 140px; 
}
</style>
</head>
<body>
    
<?php
require_once 'vendor/autoload.php';
    
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

initial_html();

if (isset($_POST['uid']) and $_POST['uid'] != "") {
	upload_using_azure_storage_sdk();
}

function initial_html() {
    echo "<div id='content'>\n";
    echo "  <form method='POST' enctype='multipart/form-data'>\n";
    echo "      <input type='file' name='fileToUpload' id='fileToUpload'/>\n";
    echo "      <div>\n";
    echo "          <button type='submit' name='upload'>UPLOAD</button>\n";
    echo "        </div> \n";
    echo "  </form>\n";
    echo "</div>\n";
}
    
function upload_using_azure_storage_sdk() {
    // If upload button is clicked ... 
    if (isset($_POST['upload'])) {
        $connectionString = "DefaultEndpointsProtocol=https;AccountName=cloudsavestorage;AccountKey=qjQo0fAdeD9ie34XJFUHeTlbp485eLQTVw4AZml223vJbKgmWELOWvqBeU/pj828BXNzHrgEZMTj8EMLcGiphg==;EndpointSuffix=core.windows.net"; //Enter deployment key
        $containerName = 'cloud-save-blob-container';
        $blobClient = BlobRestProxy::createBlobService($connectionString);

        $file_name = $_FILES['fileToUpload']['name'];
        error_log($file_name);
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $content = fopen($_FILES['fileToUpload']["tmp_name"], "r");
        $blob_name = "myblob".'.'.$ext;

        try {
            //Upload blob
            $blobClient->createBlockBlob($containerName, $blob_name, $content);
            echo "successful";

        } catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message.PHP_EOL;
        }
    }
}
?>

</body>
</html>