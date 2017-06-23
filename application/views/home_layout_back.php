<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<title>jQuery Autocomplete Plugin</title>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/javascript/jquery-1.4.1.min.js"></script>
    
 	 
    <!-- Load auto complete -->
    <script type='text/javascript' src='<?php echo base_url() ?>assets/javascript/autocomplete/jquery.autocomplete.js'></script>
	<script type='text/javascript' src='<?php echo base_url() ?>assets/javascript/autocomplete/localdata.js'></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/javascript/autocomplete/jquery.autocomplete.css" /> 
	
<script type="text/javascript">
$(document).ready(function() {
	$("#keyWord").focus().autocomplete(cities);
});
</script>
	
</head>

<body>

<h1 id="banner"><a href="http://bassistance.de/jquery-plugins/jquery-plugin-autocomplete/">jQuery Autocomplete Plugin</a> Demo</h1>

<div id="content">
	
	<form autocomplete="off">
		<p>
			<label>Single City (local):</label>
			<input type="text" id="keyWord" />
			 
		</p>
		<p>
			<label>Mon </label></p>
		
		<input type="submit" value="Submit" />
	</form>
	
	<p>
		<a href="#TB_inline?height=155&width=400&inlineId=modalWindow" class="thickbox"> </a></p> <ol id="result"></ol>

</div>
 
</body>
</html>
