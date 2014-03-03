<!DOCTYPE html P    UBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<?php require_once 'LogEntriesTrigger.php';?>

<script>
function buildQuery(id){
	
	id = id.trim();
	var urlQuery= "Router.php?{";
	switch (id.trim()){
    	case "triggerUserError":
    		var errorType = getErrorType("userErrorTypeList_triggerUserError");
    		var errorText = getErrorText("txt_triggerUserError");
    		urlQuery = urlQuery.concat('"triggerUserError":"',errorText,',',errorType,'"}');
    		break;
    	case "customUserError":
    		var errorType = getErrorType("userErrorTypeList_customUserError");
    		var phpErrorHandler = getErrorType("execInternalPHPError");
    		var errorText = getErrorText("txt_customUserError");
    		urlQuery = urlQuery.concat('"customUserError":"',errorText,',',errorType,',',phpErrorHandler,'"}');
    		break;
    	case "arrayUserError":
    		var errorType = getErrorType("userErrorTypeList_arrayUserError");
    		var errorText = getErrorText("txt_arrayUserError");
    		urlQuery = urlQuery.concat('"arrayUserError":"',errorText,',',errorType,'"}');
        	break;
    	default:
    		urlQuery = urlQuery.concat('"',id,'":""}');
    		break;
	}
	executeRequest(urlQuery);
}

function getErrorType(selectID){
	var errorList = document.getElementById(selectID);
	return errorList.options[errorList.selectedIndex].value;
}

function getErrorText(inputID){
	return document.getElementById(inputID).value;
}

function executeRequest(urlQuery){
	req = new XMLHttpRequest();
	req.onreadystatechange=function(){
		if (req.readyState == 4){
			console.info(req.responseText);
			var resDiv = document.getElementById("resultDiv");
			resDiv.innerHTML = "<legend>Request reuslt</legend><hr>" + req.responseText;
			return;
		}
	}
	console.log("Request: "+urlQuery);
	req.open('GET', urlQuery, true);
	req.send(null);
}

</script>
</head>
<body>

<div>
<table border="10" style="border-color:#6699FF;">
<?php

$funcList = get_class_methods(new LogEntriesTrigger());

foreach ($funcList as $fooName) {
    $ref = new ReflectionMethod('LogEntriesTrigger', $fooName);
    $fooParamsArr = $ref->getParameters();
    echo "<tr>";
    echo "<td>" . $fooName . "</td>";
    foreach ($fooParamsArr as $fooParam => $pName) {
        echo "<td> $pName->name: ";
        switch ($pName->name) {
            case "userErrorType":
                echo "<select id='userErrorTypeList_{$fooName}'><option value='1024'>E_USER_NOTICE</option>
		                      <option value='512'>E_USER_WARNING</option> 	                          
                              <option value='256'>E_USER_ERROR</option>
                              <option value='16384'>E_USER_DEPRECATED</option></select>";
                break;
            case "execInternalPHPError":
                echo "<select id='execInternalPHPError'><option value='y'>YES</option><option value='n'>NO</option></select>";
                break;
            
            default:
                echo " <input id='txt_".$fooName."'>";
                break;
        }
        echo "</td>";
    }
    echo "<td><button style='width:100%' id='{$fooName} 'onclick='buildQuery(this.id)'> execute</button></td>";
    echo "</tr>";
}
?>
		</table>
	</div>
	
	<div id="resultDiv" style="border-style:solid; border-color:#6699FF; margin-top:5px;  border-width:5px; width: 953px; height: 100px ">
	<legend>Request reuslt</legend><hr>
	</div>
</body>
</html>