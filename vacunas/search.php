<?php
error_reporting(0);
include("config.php");
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MySQL table search</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<style>
BODY, TD {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
</style>
</head>
<?php

if($json = json_decode(file_get_contents("http://requestbin.fullcontact.com/1bifcm71"), true)) {
      print_r($json);
      $datos = $json;
  } else {
      print_r($_POST);
      $datos = $_POST;
  }

 ?>
 </br>
 <?php
    $result = file_get_contents('http://requestbin.fullcontact.com/1bifcm71');
    echo $result;
   
?>

<body>
<h1> Inventario </h1> 
<form id="form1" name="form1" method="post" action="search.php">
	<label for="from">Fecha</label>
		<input name="from" type="text" id="from" size="10" value="<?php echo $_REQUEST["from"]; ?>" />
	<label>Empleado</label>
		<input type="text" name="string" id="string" value="<?php echo stripcslashes($_REQUEST["string"]); ?>" />
	<label>Peso</label>
		<select name="peso">
		<option value="">--</option>
		
<?php
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." GROUP BY peso ORDER BY peso";
	$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
	while ($row = mysql_fetch_assoc($sql_result)) {
		echo "<option value='".$row["peso"]."'".($row["peso"]==$_REQUEST["peso"] ? " selected" : "").">".$row["peso"]."</option>";
	}
?>
</select>
<input type="submit" name="button" id="button" value="Filter" />
  </label>
  <a href="search.php"> 
  reset</a>
</form>

<br />
<table width="700" border="1" cellspacing="0" cellpadding="4">
  <tr>
    <td width="95" bgcolor="#CCCCCC"><strong>Fecha</strong></td>
    <td width="159" bgcolor="#CCCCCC"><strong>Empleado</strong></td>
    <td width="75" bgcolor="#CCCCCC"><strong>Peso</strong></td>
  </tr>
<?php
if ($_REQUEST["string"]<>'') {
	$search_string = " AND (empleado LIKE '%".mysql_real_escape_string($_REQUEST["string"]);	
}
if ($_REQUEST["peso"]<>'') {
	$search_peso = " AND peso='".mysql_real_escape_string($_REQUEST["peso"])."'";	
}

if ($_REQUEST["from"]<>'') {
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE fecha >= '".mysql_real_escape_string($_REQUEST["from"])."'".$search_string.$search_peso;
} else {
	$sql = "SELECT * FROM ".$SETTINGS["data_table"]." WHERE id>0".$search_string.$search_peso;
}

$sql_result = mysql_query ($sql, $connection ) or die ('request "Could not execute SQL query" '.$sql);
if (mysql_num_rows($sql_result)>0) {
	while ($row = mysql_fetch_assoc($sql_result)) {
?>
  <tr>
    <td><?php echo $row["date"]; ?></td>
    <td><?php echo $row["employee"]; ?></td>
    <td><?php echo $row["peso"]; ?></td>
  </tr>
<?php
	}
} else {
?>
<tr><td colspan="5">No results found.</td>
<?php	
}
?>

<!-- tabla de ventas -->


	

<script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	</script>

</body>
</html>