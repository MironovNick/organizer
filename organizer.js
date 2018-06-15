	
	
	var Task_ID = 0;
	
	window.addEventListener('load', function() {  seldball();	});
	
	function app(){
		insdb();
		seldball();
	}
	
	function updatetask(){
		updatedbtask();
		seldball();
	}
	


	function insdb(){
		var url = "organizer.php?api_fun=insdb&task_name="+document.getElementById("name").value+
		"&description="+document.getElementById("description").value+
		"&status="+document.getElementById("status1").value;
		var XMLHttp = new XMLHttpRequest();
		XMLHttp.open("GET", url, false);
		
		XMLHttp.onreadystatechange = function(){	
			if (XMLHttp.readyState == 4 && XMLHttp.status == 200){
				var resp = JSON.parse(XMLHttp.responseText); // получаемые данные в формате JSON, преобразуем в об'ект
/*				if(resp){
					if(resp.retcode == 1){	// приняли успешный код завершения
						document.getElementById("alert").innerHTML=resp.msg;
					} else
						document.getElementById("alert").innerHTML=resp.msg;	// сообщение об ошибке
				} else
					document.getElementById("alert").innerHTML= "Mesage not responced by JSON"; 	// сообщение об ошибке
*/
			}				
		}
		XMLHttp.send();
	}

	
	function seldball(){
		var url = "organizer.php?api_fun=seldball";
		var XMLHttp = new XMLHttpRequest();
		XMLHttp.open("GET", url, false);
		
		XMLHttp.onreadystatechange = function(){	
			if (XMLHttp.readyState == 4 && XMLHttp.status == 200){
				var resp = JSON.parse(XMLHttp.responseText); // получаемые данные в формате JSON, преобразуем в об'ект
				if(resp){
					//document.getElementById("alert").innerHTML="Select from DB";
					TaskListHTML(resp);
				}
			}
        }
		
		XMLHttp.send();
	}
	
	function TaskListHTML(resp)
	{
		var div_todo = document.getElementById("todo");
		var div_doing = document.getElementById("doing");
		var div_done = document.getElementById("done");
		div_todo.innerHTML = "";
		div_doing.innerHTML = "";
		div_done.innerHTML = "";
		
		
		
		var newtag = "<div class=\"day-set\"><p>TODO</p></div>";
		var newnode=document.createElement("span");	// Создать элемент
		newnode.innerHTML=newtag;					// Занести в него HTML содержимое
		div_todo.appendChild(newnode); // Добавить новый элемент 
		
		newtag = "<div class=\"day-set\"><p>DOING</p></div>";
		newnode=document.createElement("span");
		newnode.innerHTML=newtag;
		div_doing.appendChild(newnode);
		
		newtag = "<div class=\"day-set\"><p>DONE</p></div>";
		newnode=document.createElement("span");
		newnode.innerHTML=newtag;
		div_done.appendChild(newnode); 		
		
		for (var i = 0; i < resp.length; i++) {
			newtag = "<div class=\"ivent-info\" onclick = \"TaskClick("+resp[i]["ID"]+")\">"+
					"<p>"+resp[i]["task_name"]+": ("+resp[i]["comm_cnt"]+")</p>"+
					"<p>"+resp[i]["description"]+"</p>"+
					"</br>"+
					"<p><a href=\"#edit_modalform\"><img src=\"edit.png\" height=\"12\" width=\"12\"></a></p>"+
					"</div>";
			newnode=document.createElement("span");	// Создать элемент
			newnode.innerHTML=newtag;					// Занести в него HTML содержимое
			if(resp[i]["stat"] == 1)
				div_todo.appendChild(newnode); // Добавить новый элемент
			else if(resp[i]["stat"] == 2)
				div_doing.appendChild(newnode); // Добавить новый элемент
			else
				div_done.appendChild(newnode); // Добавить новый элемент
		}
	}
	
	
	function  TaskClick(e)	
	{
		Task_ID = e;
		seldbtask(e);
		
	}
	
	function seldbtask(taskid){
		var url = "organizer.php?api_fun=seldbtask&task_id="+taskid;
		var XMLHttp = new XMLHttpRequest();
		XMLHttp.open("GET", url, false);
		
		XMLHttp.onreadystatechange = function(){	
			if (XMLHttp.readyState == 4 && XMLHttp.status == 200){
				var resp = JSON.parse(XMLHttp.responseText); // получаемые данные в формате JSON, преобразуем в об'ект
				if(resp){
					document.getElementById("name2").value = resp["task_name"];
					document.getElementById("description2").value = resp["description"];;
					document.getElementById("status2").value = resp["stat"];;
					//document.getElementById("text_comment").value = resp["task_name"];;
					document.getElementById("comment").value = resp["comments"];;
				}
			}
        }
		
		XMLHttp.send();
	}
	
	function updatedbtask(){
		var url = "organizer.php?api_fun=updatedbtask&task_id="+Task_ID+
		"&task_name="+document.getElementById("name2").value+
		"&description="+document.getElementById("description2").value+
		"&status="+document.getElementById("status2").value+
		"&comment="+document.getElementById("text_comment").value;
		var XMLHttp = new XMLHttpRequest();
		XMLHttp.open("GET", url, false);
		
		XMLHttp.onreadystatechange = function(){	
			if (XMLHttp.readyState == 4 && XMLHttp.status == 200){
				var resp = JSON.parse(XMLHttp.responseText); // получаемые данные в формате JSON, преобразуем в об'ект
/*				if(resp){
					if(resp.retcode == 1){	// приняли успешный код завершения
						document.getElementById("alert").innerHTML=resp.msg;
					} else
						document.getElementById("alert").innerHTML=resp.msg;	// сообщение об ошибке
				} else
					document.getElementById("alert").innerHTML= "Mesage not responced by JSON"; 	// сообщение об ошибке
*/
			}				
		}
		XMLHttp.send();
	}
	
	
	
	
	
	
	
	
	
	
	