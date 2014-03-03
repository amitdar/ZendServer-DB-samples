<html>
<head>

<script type="text/javascript">
/*
function updateMe(pageId) {
	console.log('update called with pageId ' + pageId);
}
*/
	
function loadJSON(url, callback) {
	   var data_file = url + '&random=' + Math.random();
	   var http_request = new XMLHttpRequest();
	   try {
	      // Opera 8.0+, Firefox, Chrome, Safari
	      http_request = new XMLHttpRequest();
	   } catch (e) {
	      // Internet Explorer Browsers
	      try {
	         http_request = new ActiveXObject("Msxml2.XMLHTTP");
	      } catch (e) {
	         try {
	            http_request = new ActiveXObject("Microsoft.XMLHTTP");
	         } catch (e){
	            // Something went wrong
	            return false;
	         }
	      }
	   }
	   
	   var orsc = this.onreadystatechange;
	   
	   this.onreadystatechange  = function() { if (this.readyState == 4) { console.log('done'); } };
	   
	   http_request.onreadystatechange  = function(){
	      if (http_request.readyState == 4  )
	      {
	        // Javascript function JSON.parse to parse JSON data
	        //var jsonObj = JSON.parse(http_request.responseText);
	        callback();
	      }
	   }
	   http_request.open("GET", data_file, true);
	   http_request.send();
}

function sendRequest() {
	loadJSON('db_ajax.php?inner=2', function() { 
		//console.log('done'); 
	});
}
</script>
</head>

<body>
INNER INNER PAGE

<button onclick="sendRequest()">Send AJAX</button>
<br/>

<a href="db_empty.php">move to another page</a>

<script type="text/javascript">
	sendRequest();
</script>
</body>

</html>