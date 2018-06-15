<?php

	if( isset($_GET["api_fun"]) && strlen($_GET["api_fun"]) > 0 ) {
		if($_GET["api_fun"] == "insdb")
			insdb();
		else if($_GET["api_fun"] == "seldball")
				seldball();
			else if($_GET["api_fun"] == "seldbtask")
				seldbtask();
				else if($_GET["api_fun"] == "updatedbtask")
					updatedbtask();
					else
						echo "Error!";
	} else
		echo "Error!";
	
	
	function seldball() {
		$rec = array("ID" => 0, "task_name" => "", "description" => "", "stat" => 0, "comm_cnt" => 0 );
		$req = array();
		$db = mysqli_connect ("localhost", "root", "", "spurit_data_base");
		$sql = "SELECT task.ID as ID, Name, Description, Status, count(*) as Cnt
				FROM task, task_comments
				WHERE task_comments.Task_ID = task.ID
				GROUP BY task.ID, Name, Description, Status";	// SQL запрос
		$res = mysqli_query($db, $sql); // Получаем из БД
		if( $res  ) {									// Если данные из БД получены			
			while ( $row = mysqli_fetch_array($res) ) {
				$rec["ID"] = $row['ID'];
				$rec["task_name"] = $row['Name'];
				$rec["description"] = $row['Description'];
				$rec["stat"] = $row['Status'];
				$rec["comm_cnt"] = $row['Cnt'];
				$req[] = $rec;
			}
			echo json_encode($req);
		} else {
			$req[] = $rec;
			echo json_encode($req);
		}
	}
		
	function insdb() {
		$req = array("retcode" => 0, "msg"=> "");
		
		$task_name = $_GET["task_name"];
		$desc = $_GET["description"];
		$stat = $_GET["status"];

		if(isset($task_name) && isset($desc) && isset($stat)
			&& strlen($task_name)>0 && strlen($desc)>0 && strlen($stat)>0){
				
			$db = mysqli_connect ("localhost", "root", "", "spurit_data_base");
			$sql = "SELECT ID FROM task  WHERE Name='$task_name'";
			$res = mysqli_query($db, $sql);
			if( !($res) || !($row = mysqli_fetch_array($res)) ) {
				$sql = "INSERT INTO `task` (`Name` ,`Description`, `Status` ) VALUES ('$task_name','$desc','$stat')";
				$res = mysqli_query($db, $sql);
				if($res) {
					// Записать пустой коментарий
					$sql = "SELECT ID FROM task  WHERE Name='$task_name'";
					$res = mysqli_query($db, $sql);
					if( ($res) && ($row = mysqli_fetch_array($res)) ) {
						$Task_ID = $row['ID'];
						$sql = "INSERT INTO `task_comments` (`Task_ID` ,`Comments` ) VALUES ('$Task_ID','No Comments')";
						$res = mysqli_query($db, $sql);
					}
					
					$req["retcode"] = 1;
					$req["msg"] = "Task insert to the base";
					echo json_encode($req);
				   //echo "Task insert to the base";
				} else {
					$req["msg"] = "Task not insert to the base";
					echo json_encode($req);
				   //echo "Task not insert to the base";
				}
			} else {
				$req["msg"] = "This task already exists!";
				echo json_encode($req);
			}
		} 
		else {	 
			$req["msg"] = "One or more poles are not correct";
			echo json_encode($req);
			 //echo "One or more poles are not correct";
		}
	}
	
	function seldbtask() {
		$req = array("retcode" => 0, "task_name" => "", "description" => "", "stat" => 0, "comments" => "" );
		$task_id = $_GET["task_id"];
		if(isset($task_id) && strlen($task_id)>0) {
			$db = mysqli_connect ("localhost", "root", "", "spurit_data_base");
			$sql = "SELECT Name, Description, Status FROM task WHERE ID = '$task_id'";	// SQL запрос
			$res = mysqli_query($db, $sql); // Получаем из БД
			if( $res  ) {									// Если данные из БД получены			
				if ( $row = mysqli_fetch_array($res) ) {
					$req["retcode"] = 1;
					$req["task_name"] = $row['Name'];
					$req["description"] = $row['Description'];
					$req["stat"] = $row['Status'];
					
					$sql = "SELECT Comments FROM task_comments WHERE Task_ID = '$task_id'";
					$res = mysqli_query($db, $sql);
					if( $res  ) {
						$i=1;
						while ( $row = mysqli_fetch_array($res) ) {
							$req["comments"] .= "Comment('$i'):"."\n";
							$req["comments"] .= $row['Comments'];
							$i++;
						}
					}
				}
				echo json_encode($req);
			} else {
				$req[] = $rec;
				echo json_encode($req);
			}
		}
	}
	
	function updatedbtask() {
		$req = array("retcode" => 0, "msg"=> "");
		
		$task_id = $_GET["task_id"];
		$task_name = $_GET["task_name"];
		$desc = $_GET["description"];
		$stat = $_GET["status"];
		$comment = $_GET["comment"];

		if( isset($task_id) && isset($task_name) && isset($desc) && isset($stat) && isset($comment)
			&& strlen($task_id)>0 && strlen($task_name)>0 && strlen($desc)>0 && strlen($stat)>0 ){
			$db = mysqli_connect ("localhost", "root", "", "spurit_data_base");
			if(strlen($comment)>0)	{
				$sql = "INSERT INTO `task_comments` (`Task_ID` ,`Comments` ) VALUES ('$task_id','$comment')";
				$res = mysqli_query($db, $sql);
			}
			
			$sql = "UPDATE task SET Name='$task_name',Description='$desc',Status='$stat' WHERE ID = '$task_id'";
			$res = mysqli_query($db, $sql);
			if($res) {
				$req["retcode"] = 1;
				$req["msg"] = "Task update to the base";
				echo json_encode($req);
			} else {
				$req["msg"] = "Task not update to the base";
				echo json_encode($req);
			}
		} 
		else {	 
			$req["msg"] = "One or more poles are not correct";
			echo json_encode($req);
			 
		}
	}
	
	
	





?>