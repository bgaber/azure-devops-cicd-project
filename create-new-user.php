<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
	<title>BLOB Upload Test</title>
    
<?php
$theme_arr = array('black-tie','blitzer','cupertino','dot-luv','ui-lightness','sunny','start','redmond','pepper-grinder','le-frog','humanity','eggplant');
$theme = $theme_arr[date("n")-1];
echo "<link rel='stylesheet' type='text/css' href='//code.jquery.com/ui/1.11.4/themes/$theme/jquery-ui.css' />";
?>
    
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"
      integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"
      integrity="sha256-xNjb53/rY+WmG+4L6tTl9m6PpqknWZvRt0rO1SRnJzw=" crossorigin="anonymous"></script>
    <script src="/javascript/add_user.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/gdrm.css" type="text/css" media="all">
    
    <link rel="SHORTCUT ICON" href="/images/index.ico"/>

    <style type="text/css"><!--
    body {
       font-family:Verdana, Trebuchet MS;
       font-size:12px;
    }

    .ui-dialog .ui-dialog-titlebar, .ui-dialog .ui-dialog-buttonpane, .ui-dialog .ui-dialog-content {
        font-size: 12px;
    }

    .ui-widget button {
        font-size: 14px;
    }

    .expl {
	   color: #888;
	   font: 12px normal Tahoma, Arial, sans-serif;
	   font-style: italic;
	   vertical-align: 40%;
    }
 --></style>
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
	echo "<form method='post' enctype='multipart/form-data' name='add_user'>\n";
	echo "	<center>\n";
	echo "		<table width='95%'>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='userId_lbl'>User-Id:</th>\n";
	echo "				<td class='left'>\n";
	echo "				   <input type='text' name='uid' size='9' value='"; if(isset($_POST['uid'])) echo $_POST['uid']; echo "' class='required,alphanum' id='uid' /> <img alt='' height='16' name='uid' src='/images/blank.gif' width='16' /> <span class='expl'>mandatory</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='username_lbl'>Name:</th>\n";
	echo "				<td class='left'>\n";
	echo "				   <input type='text' name='username' size='25' value='"; if(isset($_POST['username'])) echo $_POST['username']; echo "' class='required,alphaSpc' id='username' /> <img alt='' height='16' name='username' src='/images/blank.gif' width='16' /> <span class='expl'>mandatory</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='telephoneNumber_lbl'>Telephone Number</th>\n";
	echo "				<td class='left'>\n";
	echo "				   <input type='text' name='telephoneNumber' size='15' value='"; if(isset($_POST['telephoneNumber'])) echo $_POST['telephoneNumber']; echo "' class='required,phone' id='telephoneNumber' /> <img alt='' height='16' name='telephoneNumber' src='/images/blank.gif' width='16' /> <span class='expl'>must be a phone number, e.g. 613-123-4567</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='address_lbl'>Address:</th>\n";
	echo "				<td class='left'>\n";
	echo "				   <input type='text' name='address'  size='50' value='"; if(isset($_POST['address'])) echo $_POST['address']; echo "' class='required,alphanumSpc' id='address' /> <img alt='' height='16' name='address' src='/images/blank.gif' width='16' /> <span class='expl'>mandatory</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='city_lbl'>City:</th>\n";
	echo "				<td class='left'>\n";
	echo "				   <input type='text' name='city'  size='15' value='"; if(isset($_POST['city'])) echo $_POST['city']; echo "' class='required,alphaSpc' id='city' /> <img alt='' height='16' name='city' src='/images/blank.gif' width='16' /> <span class='expl'>mandatory</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='prov_lbl'>Province:</th>\n";
	echo "				<td class='left'>\n";
	echo "					<select name='prov' id='prov'>\n";
	echo "						<option value=''></option>\n";
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "Alberta")) {
								echo "						<option value='Alberta' selected='selected'>Alberta</option>\n";
							} else {
								echo "						<option value='Alberta'>Alberta</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "BC")) {
								echo "						<option value='BC' selected='selected'>British Columbia</option>\n";
							} else {
								echo "						<option value='BC'>British Columbia</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "Manitoba")) {
								echo "						<option value='Manitoba' selected='selected'>Manitoba</option>\n";
							} else {
								echo "						<option value='Manitoba'>Manitoba</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "NB")) {
								echo "						<option value='NB' selected='selected'>New Brunswick</option>\n";
							} else {
								echo "						<option value='NB'>New Brunswick</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "NFLD")) {
								echo "						<option value='NFLD' selected='selected'>Newfoundland</option>\n";
							} else {
								echo "						<option value='NFLD'>Newfoundland</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "NS")) {
								echo "						<option value='NS' selected='selected'>Nova Scotia</option>\n";
							} else {
								echo "						<option value='NS'>Nova Scotia</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "Ontario")) {
								echo "						<option value='Ontario' selected='selected'>Ontario</option>\n";
							} else {
								echo "						<option value='Ontario'>Ontario</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "PEI")) {
								echo "						<option value='PEI' selected='selected'>Prince Edward Island</option>\n";
							} else {
								echo "						<option value='PEI'>Prince Edward Island</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "Quebec")) {
								echo "						<option value='Quebec' selected='selected'>Quebec</option>\n";
							} else {
								echo "						<option value='Quebec'>Quebec</option>\n";
							}
							if ((isset($_POST['prov'])) && ($_POST['prov'] == "Saskatchewan")) {
								echo "						<option value='Saskatchewan' selected='selected'>Saskatchewan</option>\n";
							} else {
								echo "						<option value='Saskatchewan'>Saskatchewan</option>\n";
							}
	echo "					</select>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "			<tr align='LEFT'>\n";
	echo "				<th class='right' id='postal_lbl'>Postal Code:</th>\n";
	echo "				<td class='left'>\n";
	echo "					<input type='text' name='postal' size='7' value='"; if(isset($_POST['postal'])) echo $_POST['postal']; echo "' class='postcode' id='postal' /> <img alt='' height='16' name='postal' src='/images/blank.gif' width='16' /> <span class='expl'>optional postal code, e.g. K0A 2T0</span>\n";
	echo "				</td>\n";
	echo "			</tr>\n";
	echo "		</table>\n";
	echo "		<input type='button'  value='Submit Information' id='validate' />\n";
	echo "	</center>\n";
	echo "</form>\n";
	echo "<div id='dialog-message' title='Invalid Data Warning'></div>\n";
}
    
function upload_using_azure_storage_sdk() {
    // https://github.com/Azure-Samples/storage-blobs-php-quickstart/blob/master/phpQS.php
    //
    // Instead of the code below do the following:
    // 1. compose a JSON document with all the user record values
    // 2. upload that JSON document to Azure Storage Blob Container
    // 3. create an Azure Function in Python that writes the JSON data composed in Step 1 into Cosmos DB
    // 4. configure Azure Storage Blob Container to trigger the Azure function whenever there is a JSON file uploaded

    // Compose JSON from $_POST associative array
	echo "Composed individual elements into JSON<br>\n";
    $id = rand(1000000, 9999999);
    $myObj->id              = "$id"; // needs to be enclosed in quotes or this JSON will not be accepted by CosmosDB
    $myObj->account_number  = $_POST['uid'];
	$myObj->uid             = $_POST['uid'];
	$myObj->username        = $_POST['username'];
	$myObj->telephoneNumber = $_POST['telephoneNumber'];
	$myObj->address         = $_POST['address'];
	$myObj->city            = $_POST['city'];
	$myObj->prov            = $_POST['prov'];
	$myObj->postal          = $_POST['postal'];
    $myObj->picture         = "{$id}.png";
    $myObj->audio           = "{$id}.wav";
	$jsonContent = json_encode($myObj);

	//echo "Composed \$_POST associative array into JSON<br>\n";
	//$jsonContent = json_encode($_POST);
    //echo $jsonContent; // output JSON to browser
    $blobFileName = "{$id}-user-rcd.json";
	    
    // Upload JSON to Azure
    //$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');
	$connectionString = "DefaultEndpointsProtocol=https;AccountName=cloudsavestorage;AccountKey=qjQo0fAdeD9ie34XJFUHeTlbp485eLQTVw4AZml223vJbKgmWELOWvqBeU/pj828BXNzHrgEZMTj8EMLcGiphg==;EndpointSuffix=core.windows.net"; //Enter deployment key

    // Create blob client.
    $blobClient = BlobRestProxy::createBlobService($connectionString);
    
    // Create container options object.
    $createContainerOptions = new CreateContainerOptions();

    // Set public access policy. Possible values are
    // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
    // CONTAINER_AND_BLOBS:
    // Specifies full public read access for container and blob data.
    // proxys can enumerate blobs within the container via anonymous
    // request, but cannot enumerate containers within the storage account.
    //
    // BLOBS_ONLY:
    // Specifies public read access for blobs. Blob data within this
    // container can be read via anonymous request, but container data is not
    // available. proxys cannot enumerate blobs within the container via
    // anonymous request.
    // If this value is not specified in the request, container data is
    // private to the account owner.
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

	$containerName = "cloud-save-blob-container";
	echo "Container Name: $containerName<br>\n";
    
    try {
        echo "Create BlockBlob from: ".PHP_EOL;
        echo $jsonContent;
        echo "<br />";

        //Create Block BLOB from the JSON Content
        $blobClient->createBlockBlob($containerName, $blobFileName, $jsonContent);
		echo "The JSON content has been uploaded with name of $blobFileName as a BLOB to the Azure Storage Container named $containerName<br>\n";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
?>

</body>
</html>