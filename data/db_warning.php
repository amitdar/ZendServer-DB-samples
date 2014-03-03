<html>
<head>
</head>

<body>

<?php 
for ($i = 0; $i < 10; $i++) {
	file_get_contents('aaaa' . $i . '.txt');
}
echo $i . ' warning created';
?>

</body>

</html>