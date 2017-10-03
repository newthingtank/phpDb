<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script type="text/javascript" src="jquery-1.12.0.js"></script>
        <script type="text/javascript" src="main.js"></script>
     </head>
  
    <body>
        <h1 >My task list</h1>
        <form id="showSort" >
        <table>
        </tr>
        <tr>
	 <td><input name="show" type="radio" value="incomplete" checked="checked">Show incomplete only</td>
	 <td></td>
	 <td><input name="sort" type="radio" value="date" checked="checked">Sort by date created</td>
		</tr>
		<tr>
		    <td><input name="show" type="radio"  value="all">Show All</td>
		    <td></td>
		    <td><input name="sort" type="radio" value="priority">Sort By Priority</td>
		</tr>
		<tr>
	 <td></td>
	 <td ><input type="submit" value="Submit"></td>
	 </tr>
       </table>
       </form>
       <br/>
       <form id="listTask">
       <table id="title" style="border:solid;" >
       <tr id="title"><td >Description</td><td >Priority</td><td >Date Created</td><td>Date Completed</td></tr>
       </table>
       <button type="button" id="complete" value="delete select" style="margin-top:2%;">Complete Selected</button>
       <button type="button" id="delete" style="margin-left: 11%; margin-top:2%;">Delete Selected</button>
       </form>

	 <h2 >Add a new task</h2>
	 <form id="newTask" >
	 <table style="border:solid;">
	 <tr> 
       <td>Task:</td>
       <td ><input type="text" name="description" style="size:50px;"></td> 	
	 </tr>
	
	 <tr>
		<td>Priority:</td>
		<td>
		<select name ="priority">
		<option value ="1">Very low</option>
		<option value ="2">Low</option>
		<option value ="3">Med</option>
		<option value ="4">Important</option>
		<option value ="5">Very Important</option>
		</select>
		</td>
		
	</tr>
	 </table>
	<!-- Submit-->
	<input type="submit" value="Submit" style="margin-top:2%">
</form>
</body>
</html>
