<?php

	require_once('MySQLi.php');

	class ApiBase
	{	
		private $mysql_host = 'localhost';
     	private $mysql_username = 'root';
		private $mysql_password = '';

		private $page;
		private $limit;

		private $Astatus = NULL;
		private $Aerror = '';
		private $Adata = NULL;
		private $Ahead = NULL;
		private $Abody = array(array());
		private $Aform = NULL;


	
		function callApi($pag,$limi)
		{
			$this->page = $pag;
			$this->limit = $limi;


			
			$this->createform();
		}


		function createData()
		{	
			try {
			if ($db = mysqli_connect($this->mysql_host, $this->mysql_username, $this->mysql_password) )
				{
					$mysqli = new mysqli($this->mysql_host, $this->mysql_username, $this->mysql_password);
					$query = "SELECT * FROM test.test";
					$result = $mysqli->query($query);					
					$rows = mysqli_num_rows($result);	
				}
				else
				{
					throw new Exception('Unable to connect');	
				}
			} catch (Exception $e) {
				$this->flag = 0;
				$this->Aerror = $e;
			}
			
			try {
			if ($page>0 || $limit>0 || $page*$limit<$rows)
				{
					$this->createHead();
					$this->createBody();
			
					$this->Adata = array('head' =>$this->Ahead,'body' =>$this->Abody);
				}
				else
				{
					throw new Exception('invalid entered data');
				}
			} catch (Exception $e) {
				$this->flag = 0;
				$this->Aerror = $this->Aerror . $e;
			}	

			
		}


		function createHead()
		{
			$mysqli = new mysqli($this->mysql_host, $this->mysql_username, $this->mysql_password);
			

			$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'test' AND TABLE_NAME = 'test';";
			$result = $mysqli->query($query);
			$row = $result->fetch_row();
			$rows = mysqli_num_rows($result);

			for ($i = 0 ; $i < $rows ; $i++)
			{
				$row = $result->fetch_row();
				
				$this->Ahead[$i] = $row[0];

			}			


			$mysqli->close();
			mysqli_free_result($result);
			
		}


		function createBody()
		{
			$mysqli = new mysqli($this->mysql_host, $this->mysql_username, $this->mysql_password);
			

			$off = $this->limit * $this->page-$this->limit;




			$query = "SELECT * FROM test.test LIMIT ".$this->limit." OFFSET ".$off;
			$result = $mysqli->query($query);
			$result->data_seek($off);
			$row = $result->fetch_row();
			$rows = mysqli_num_rows($result);
			$count = mysqli_num_fields($result);




			for ($j = 0 ; $j < $this->limit; $j++)
			{	
				
				for ($i = 0 ; $i < $count ; $i++)
				{
					
					$this->Abody[$j][$i] = $row[$i];
					
				}
				$row = $result->fetch_row();
			
			}

			$mysqli->close();
			mysqli_free_result($result);
   
		}


		function createform()
		{
	
			$this->createData();
		
			$this->Aform = ['status' => $this->Astatus, 'error' => $this->Aerror, 'data' => $this->Adata];
			echo json_encode($this->Aform);
	
	
		}
	}



?>