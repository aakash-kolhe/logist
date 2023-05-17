<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" src="dist/js/c.js"></script>
</head>
<body>
	<form>
		<h2>State</h2>
		<select type="text" onchange="print_city('state', this.selectedIndex);" id="s">State</select>
		<select id="state">State</select>
	</form>
</body>
<script type="text/javascript">
	print_state("s");
</script>
</html>