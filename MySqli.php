<?php
	
	class restore
		{
     		public $db_name = "test_db";
			public $file = "db_test.sql";			
     		public $conn;
     		public $qry;


			private $mysql_host = 'localhost';
     		private $mysql_username = 'root';
     		private $mysql_password = '';


			function make_query($link, $file)
			{
				$mysqli = new mysqli($this->mysql_host, $this->mysql_username, $this->mysql_password);
				$query = file_get_contents($file);

				if($mysqli->query($query)) {

					echo '<pre>Запрос '.$query.' успешно выполнен</pre>';

				} else {

					echo '<pre>Ошибка при создании базы данных: ' . $mysqli->error. '</pre>';

				}
				$mysqli->close();
			}
			function add_elements($file)
			{
				$result = exec('mysql -uroot test<'.$file);
			}

		}


?>