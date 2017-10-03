 $(document).ready(function()
  {
     listTasks();  //Call listTasks function when page start 
     $("#newTask").submit(function(e) {   //create new task in newTask form
     e.preventDefault();                 //Prevent default method
           //judge textbox
     if($(":text").val()=='')            
          	{
               alert("Please input the description!");
           	}
            else{
            	$.post("ajax.php?action=new", $(this).serialize(), addTask); 
            }
            });
           
       $("#showSort").submit(function(e) {//Sort content
            e.preventDefault();            
            var show=$("input:radio[name='show']:checked").val(); 
            var sort=$("input:radio[name='sort']:checked").val();  
            if(show=='incomplete'&&sort=='date')   
               {
               	 $.get("ajax.php?action=showSort&sortBy=dateCreated&includeCompleted=false", function(response) {
                     $(".myclass").remove()
               		 for (var i = 0; i < response.length; i++)
                         addTask(response[i]);
             		
                 });
               }
              else if(show=='all'&&sort=='priority')
                {
            	   $.get("ajax.php?action=showSort&sortBy=priority&includeCompleted=true", function(response) {
            		   $(".myclass").remove(); 
            		   for (var i = 0; i < response.length; i++)
            	            addTask(response[i]);
            			
            	    });
            	}
               else if(show=='incomplete'&&sort=='priority')
               {
            	 $.get("ajax.php?action=showSort&sortBy=priority&includeCompleted=false", function(response) {
            		 $(".myclass").remove();   
            		 for (var i = 0; i < response.length; i++)
            	            addTask(response[i]);
            			
            	    });
               }
               else if(show=='all'&&sort=='date')
               {
            	   $.get("ajax.php?action=showSort&sortBy=dateCreated&includeCompleted=true", 
           
       		function(response) {
						   $(".myclass").remove(); 
						   for (var i = 0; i < response.length; i++)
					            addTask(response[i]);
            			
            	  			  });
               }
             
               });
     		
		//delete situation
		$("#delete").click(function(e) {  
               e.preventDefault();
               var check_boxes = $(":checkbox:checked");
               if(check_boxes.length<=0)
        	   {
        	     alert("Please select task!");
        	   }
               else
        	   {
            	   check_boxes.each(function(){
				   $.post("ajax.php?action=delete&dropId="+$(this).val(), $(this).serialize(), taskDe);
					});
            	   if(taskDe!=false)
            	   {   
            		   alert("Delete successfully!");
            		   $(".myclass").remove(); 
            	         window.location.reload();}
		              else{alert("Fail to delete!");
            	   }
        	   }
               });
           
		//complete situation
           $("#complete").click(function(e) {  
               e.preventDefault();
               var check_boxes=$(":checkbox:checked");
               if(check_boxes.length<=0)
               {
            	     alert("Please select at least one task!");
               }
               else
               {
            	    check_boxes.each(function(){
            	    $.post("ajax.php?action=complete&completeId="+$(this).val(), $(this).serialize(), checkCom);
					});
            	     
            	   if(taskCom!=false)
              	   {   
            		 alert("Complete successfully!");
              		 $(".myclass").remove(); 
              	       window.location.reload();
			    }
			    else{alert("Fail to complete!");
              	   }
              }
            		   
            });
           
       });
 
function listTasks()  //List task
{
	$.get("ajax.php?action=list", function(response) {
		
      for (var i = 0; i < response.length; i++)
            addTask(response[i]);
		
    });
}
 
function addTask(response)  //choose priority
 { 
	var priority;
	if(response.priority=='1')
		priority='Very low';
	else if(response.priority=='2')
		priority='Low';
	else if(response.priority=='3')
		priority='Med';
	else if(response.priority=='4')
		priority='Important';
	else if(response.priority=='5')
		priority='Very important';
	
	var dateComplete;
	if(response.dateComplete==null)
		dateComplete='/';
	else
		dateComplete=response.dateComplete;	
		
	var added="<tr class=\"myclass\"><td align=\"center\"><input type=\"checkbox\" id="+response.id+" \" value=\""+response.id+"\">"+response.description+"</td><td align=\"center\">"+priority+"</td><td align=\"center\">"+response.dateCreated+"</td><td align=\"center\" class=\"cc\">"+dateComplete+"</td></tr>";
	
	$("#title").append(added);
 }

var taskDe;
function checkDe(response)
{
	if(!response.success)
		taskDe=false;
}
var taskCom;
function checkCom(response)
{
	if(!response.success)
		taskCom=false;
}

