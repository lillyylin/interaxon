/**
This function displays tab contents

@param {object} the current event 
@param {string} the name of the section to be opened
*/
function opentab(evt, section){
	let i, tabcontent, tablinks;

	let mission = document.getElementById("missionstatement");
	mission.style.display = "none";

	tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) { //go through all tabs to make sure the tab previously active does not display
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) { //go through all links to make sure tab previously active is not active
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(section).style.display = "block"; //set desired section to display and to be active
    evt.currentTarget.className += " active";
}
/**
This function displays the "home" screen, or the screen with the mission statement

@param {object} the current event 
@param {string} the name of the section to be opened
*/
function openhome(evt, section){

		let mission = document.getElementById("missionstatement");
		mission.style.display = "block";

		let tabcontent = document.getElementsByClassName("tabcontent");
   		for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
}

/**
This function displays the user's account screen

@param {object} the current event 
@param {string} the name of the section to be opened
*/
function openaccount(evt, section){
	let mission = document.getElementById("missionstatement");
	mission.style.display = "none";

	let tabcontent = document.getElementsByClassName("tabcontent");
   		for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    let accountinfo = document.getElementById("account");
    accountinfo.style.display = "block";
}

let login = document.getElementById('login');
//redirect to login.php if user chooses to login
if (login){
login.addEventListener('click', function() {
  document.location.href = 'login.php';
});
}
/**
This ajax call reads from a list of members (which changes ~once a quarter), and displays them under the "Membership" tab.
*/

$.ajax({
	url: "activemembers.txt",
	dataType: "text",
	success: function(data){
		$("#memberlist").html(data);
		
	}
});



let colors = ["#5DB0BE","#CDEBF4", "#EE7A43", "#D84727","#EE7A43","#CDEBF4"];

let id = setInterval(colorchange, 1000, colors);
/**
This function changes the color of the navigation bar buttons

@param {object} an array of color swatches
*/
function colorchange(color_arr){
	let tabs = document.getElementsByClassName("tablinks");
	for (let i=0; i < tabs.length; i++){ //assign a color from the array to a tab
		tabs[i].style.backgroundColor = color_arr[i];
	}
	let next = color_arr.shift(); //take the first element out of the color array
	color_arr.push(next); //push color element onto the end 

}

/**
This function retrieves subjects chosen by the user under 'Resources' and displays it on their 'Account' page.

*/
function getsubjects(){
	//console.log("hello");
	let subjects = document.getElementsByName("subjects");
	let newtext = "Your Subjects: <br>"; //for displaying on the webpage
	let record = ""; //for actually putting into a record
	for (let i = 0; i < subjects.length; i++){
		if (subjects[i].checked){
			let sub = subjects[i].id;
			console.log(sub);
			let text = sub + "<br>"
			newtext += text;
			let recordtext = sub+";";
			record += recordtext;
			
		}
	}
	document.getElementById("selected_subjects").innerHTML = newtext;

	makeRecord(record);
}

/**
This function makes an ajax call to 'user_save.php', which creates a record of the user's choices in a database.
It then informs the user that their curriculum has been saved and of what subjects they just saved.

@param {string} a string containing the user's subject choices
*/
function makeRecord(data){
	let userinfo = data;

		$.ajax({
   			 type: "POST",
    		 url: "user_save.php",
   			 data: {subjects: userinfo},
   			 success: function(data){

  			  console.log(data);
  			  userdata = data.split(";");
  			  console.log(userdata);
  			  document.getElementById("selected_subjects").innerHTML += "curriculum saved!<br>";
  			  for (let i=0; i<userdata.length; i++){
  			  	let text = "Topic " + (i+1) + ": ";
  			  	if (userdata[i]!==""){
  			   document.getElementById("selected_subjects").innerHTML += text + userdata[i] + "<br>";
  					}
  				}
  			  	let refreshbtn = document.createElement('button');
  				refreshbtn.setAttribute("id","refresh");
 			 	refreshbtn.setAttribute("onclick", "refresh()");
 			 	let text = document.createTextNode('Refresh Page');
 			 	refreshbtn.appendChild(text);
 			 	document.getElementById("account").appendChild(refreshbtn);
			}
			});


}

/**
This ajax call makes a get request to the user_save.php file, it looks for any previous records that the user has made, and if it exists it displays it in their "account" tab.
*/
$.ajax({
   	type: "GET",
   	data: {subjects: ""},
    url: "user_save.php",
   	success: function(data){

  	console.log(data);
  	if(data!==""){
  	userdata = data.split(";");
  	document.getElementById("selected_subjects").innerHTML = "Here is your existing curriculum schedule<br>";
  	for (let i=0; i<userdata.length; i++){
  		let text = "Topic " + (i+1) + ": ";
  		if (userdata[i]!==""){
  		document.getElementById("selected_subjects").innerHTML += text + userdata[i] + "<br>";
  			}
  		}
  	let deletebtn = document.createElement('button');
  	deletebtn.setAttribute("id","delete");
  	deletebtn.setAttribute("onclick", "deleteRecord()");
  	let text = document.createTextNode('Delete Schedule');
  	deletebtn.appendChild(text);
  	document.getElementById("account").appendChild(deletebtn);
	}
	}
});

/**
This function deletes the record of a user's subject list when the delete button is pressed.
*/
function deleteRecord(){
	$.ajax({
	url: 'user_save.php',
	type: "GET",
	data: {remove: "request"},
	success: function(data){
		console.log(data);
		document.getElementById("selected_subjects").innerHTML = "Schedule deleted.";
		let element = document.getElementById("delete");
		element.parentNode.removeChild(element);

		let refreshbtn = document.createElement('button');
  		refreshbtn.setAttribute("id","refresh");
 		refreshbtn.setAttribute("onclick", "refresh()");
 		let text = document.createTextNode('Refresh Page');
 		refreshbtn.appendChild(text);
 		document.getElementById("account").appendChild(refreshbtn);		
	}
});
}

/**
This function refreshes the page
*/
function refresh(){
	location.reload();
}


