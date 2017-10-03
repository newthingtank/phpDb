<?php

header('Content-Type:application/json');

date_default_timezone_set('America/Toronto');
define('DB_HOST', 'localhost');
define('DB_USER', 'bbb');
define('DB_PASS', 'bbb');
define('DB_NAME', 'lamp2project1');

if (isset($_GET['action'])) 
{
    $connection=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if($connection->connect_error)
	{
		die("Connection failed ".$conn->connect_error);
	}
    
    if ($_GET['action'] == 'new'&& $_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		newTask($connection);
	}
	else if ($_GET['action'] == 'list' && $_SERVER['REQUEST_METHOD'] == 'GET')
	{
		listTask($connection);
	}
	else if ($_GET['action'] == 'showSort'&& $_SERVER['REQUEST_METHOD'] == 'GET') 
	{
		showSort($connection, $_GET['sortBy'], $_GET['includeCompleted']);
	}
	else if ($_GET['action'] == 'delete' && $_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		deleteTask($connection, $_GET['dropId']);
	}
	else if($_GET['action']=='complete' && $_SERVER['REQUEST_METHOD'] == 'POST')
	{
		completeTask($connection,$_GET['completeId']);
	}
$connection->close();
}

function newTask($connection)
{  
	$connection->select_db(DB_NAME);
      $timenow=date("Y-m-d H:i:s",mktime());
      $insertTask = "insert into task(id, description, priority, dateCreated, completed, dateComplete )
      values(null, '".$_POST['description']."','".$_POST['priority']."','".$timenow."',0, null)";
	$result=$connection->query($insertTask);
	
	// Return a single post object in JSON format.
	$queryId="SELECT max(id) FROM task";
	$idRs=$connection->query($queryId);
	$idrow=$idRs->fetch_assoc();
	$queryTask="SELECT * FROM task where id=".$idrow['max(id)'];
	$queryRs=$connection->query($queryTask);
	$row=$queryRs->fetch_assoc();
	echo json_encode($row);
}

    function listTask($connection)
     {
	$connection->select_db(DB_NAME);
	$listTask="SELECT * FROM task where completed='0' order by dateCreated;";
	$listRs=$connection->query($listTask);
	$taskArray=array();
	while($row=mysqli_fetch_assoc($listRs))
	{
		array_push($taskArray, $row);
	}
	echo json_encode($taskArray);
}

function showSort($connection, $sortBy, $includeCompleted)
{
	$connection->select_db(DB_NAME);
	if($sortBy=='dateCreated'&&$includeCompleted=='false')
	{
		$listTask="SELECT * FROM task where completed='0' order by dateCreated";
	}
	else if($sortBy=='dateCreated'&&$includeCompleted=='true')
	{
		$listTask="SELECT * FROM task order by dateCreated";
	}
	else if($sortBy=='priority'&&$includeCompleted=='false')
	{
		$listTask="SELECT * FROM task where completed='0' order by priority Desc";
	}
	else if($sortBy=='priority'&&$includeCompleted=='true')
	{
		$listTask="SELECT * FROM task order by priority Desc";
	}
	
	
	$listRs=$connection->query($listTask);
	$taskArray=array();
	while($row=mysqli_fetch_assoc($listRs))
	{
		array_push($taskArray, $row);
	}
	echo json_encode($taskArray);
}

function deleteTask($connection, $dropId)
{
	$connection->select_db(DB_NAME);
	$deleteTask="DELETE FROM task where id=".$dropId;
	$deleteRs=$connection->query($deleteTask);
	$result=array();
	if($deleteRs)
		$result['success']=true;
	else 
		$result['success']=false;
	echo json_encode($result);
}

function completeTask($connection, $completeId)
{
	$connection->select_db(DB_NAME);
	$timenow=date("Y-m-d H:i:s",mktime());
	$completeTask="UPDATE task SET completed='1', dateComplete='".$timenow."' where id='".$completeId."'";
	$completeRs=$connection->query($completeTask);
	$result=array();
	if($completeRs)
		$result['success']=true;
	 else
	 	$result['success']=false;
	 echo json_encode($result);
}
?>
