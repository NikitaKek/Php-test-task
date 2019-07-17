<!DOCTYPE HTML>
<html>
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<title>dddddddddd</title>
</head>
<body>
	<?php
		require_once('apiEngine.php');


		//$t = new restore();

		//$t->db_name = "kek_db";

		//$t->file = "sql/db_test.sql";		
		//$t->make_query($t->conn,$t->file);

		//$t->file = "sql/table_test.sql";	
		//$t->make_query($t->conn,$t->file);

		//$t->file = "sql/table_test_data.sql";
		//$t->add_elements($t->file);

		$Api = new ApiBase();



		$page = $_GET['page'];
		$limit = $_GET['limit'];


		//echo '<pre>';

		$Api->callApi($page,$limit);
		//echo '</pre>';

	
	?>
</body>
</html>