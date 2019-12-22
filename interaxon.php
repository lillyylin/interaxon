#!/usr/local/bin/php
<?php
	session_start();
	$_SESSION['loggedin'] = false;
	if($_SESSION['usrconfirm'] === true){ //if the user has logged in, mark loggedin variable as 'true'
		$_SESSION['loggedin'] = true;
	}

	 if($_SERVER['REQUEST_METHOD'] === 'POST'){ //if the user logs out
		if (isset($_POST['logout'])){
		session_unset();
		session_destroy();
		$_SESSION['loggedin'] = false;
	}

		if(isset($_POST['submitemail'])){
			sendemail();
		}
	} 

/**
This function sends an email to me, and also a confirmation email to the sender.
*/
	function sendemail(){
		$subject = $_POST["subject"];
		$message = $_POST["message"];

		$email = $_POST['emailaddress'];
		$headers = "From: " . $email . "\r\n";
		$emailsend = mail('lilly.lin998@gmail.com', $subject, $message, $headers);

		//send confirmation email if successful
		if($emailsend){
		mail($email, "Email Confirmation", "Your email has been sent successfully! Here is a copy of your message: ".$message);
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="index.css" />	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" defer></script>
	<script src="index.js" defer></script>

	<title> InterAxon at UCLA </title>
</head>

<body>
	<button class="home" onclick="openhome(event,'home')" id="title"> Interaxon</button>
	<p id="subtitle"> Undergraduate Educational Neuroscience Outreach Group at UCLA <p>
	<p id="missionstatement"> Our mission is to create and foster interest, excitement, and curiosity about the brain. We travel to elementary schools, middle schools, and high schools in disadvantaged areas of Los Angeles to work with students at schools receiving poor funding in the sciences.
	</p> 
	<img src="ialogo.png" id="logo"/>
	<div class="navbar">
		<button id="abt_btn" class="tablinks" onclick="opentab(event,'About')"> About Us </button>
		<button class="tablinks" onclick="opentab(event,'Membership')"> Membership </button>
		<button class="tablinks" onclick="opentab(event,'Board')"> Meet The Board </button>
		<button class="tablinks" onclick="opentab(event,'Gallery')"> Gallery </button>
		<button class="tablinks" onclick="opentab(event,'Contact')"> Contact Us </button>
		<button class="tablinks" onclick="opentab(event,'Resources')"> Resources </button>
	</div>

	<?php //if the user is not logged in, make sure display has a login button
	if ($_SESSION['loggedin'] === false ): ?> 

	<button id="login"> Login </button>
	
		
	<?php else: //else if the user is logged in, make sure display has an account button and a logout button?>

		
	<button id="useraccount" class="btn" onclick="openaccount(event,'Account')"> My Account </button>
		<form method="post" action="ialogout.php">
	<button id="logout" class="btn" > Logout </button>
	    </form>
	
	<?php endif; ?>

	<div id="About" class="tabcontent">
		<h2> About Us </h2>
		<p> InterAxon was founded at UCLA in 2008 in affliation with the Brain Research Institute (BRI). Our club specifically targets Title I schools, which describe K-12 schools that are underfunded in the sciences. We aim to build the confidence of these students so that they are less intimidated by STEM fields in the future! <br> <br>

		InterAxon is able to organize events with K-12 schools. Our trained members present a multitude of poster boards covering various topics in Neuroscience, such as: Senses, Language Development, Neuromarketing, and so much more! Our members work hard to keep our posters up to date and full of engaging and educational activities. 
		<br><br>

		InterAxon offers different committees for members to participate in. Project Glia creates and refurbishes posters. Our Brochure committee designs fun and educational brochures that correspond to posters so that our students have something to bring home. This year, we are proud to announce the start of the Newsletter Committee: a way to keep in contact with schools we teach at. 
		</p>
	</div>

	<div id="Membership" class="tabcontent"> <!-- make a list -->
		<h2> Spring '18 Active Members </h2>
		<p id="memberlist">
​
		</p>
		<h2> Become A Member </h2>
		<h3> General Meetings </h3>
		<p> Fall Quarter - Wednesdays at 5:00PM <br>
		Gonda Neuroscience and Genetics Research Center - First Floor Conference Room (1357) 
		</p>
		<p> 1. Print and complete the Publicity Release form <br>
			2. Print and complete the Risk Agreement form <br>
			3. Turn in a one-time $20 membership fee used to cover t-shirts <br>

			These forms can be turned in during General Meetings. They do not have to be completed to attend General Meetings, just before site visits!
</p>

	</div>

	<div id="Board" class= "tabcontent">
		<img id="boardphoto" src="interaxonboard.png" class="boardphotos" width = "700"/>
		<img id="lilly" src="lilly.png" class = "officerpics" width="300"/>
		<img id="andre" src="Andre.png" class="officerpics" width="300" />
		<img id="sacci" src="Sacci.png" class = "officerpics" width="300"/>
		<img id="jasmine" src="Jasmine.png" class="officerpics" width="300" />

	</div>

	<div id="Gallery" class="tabcontent">
		<div id="pictures" class="pics">
	<img id="firstpic" src="interaxon-1.jpg" class="pics" width="300"/>
	<img id="secondpic" src="interaxon-2.jpg"class="pics"width="300"/>
	<img id="thirdpic" src="interaxon-3.jpg"class="pics"width="300"/>
	<img id="fourthpic" src="interaxon-4.jpg"class="pics"width="300"/>
	<img id="fifthpic" src="interaxon-5.jpg"class="pics"width="300"/>
		</div>

	</div>

	<div id="Contact" class= "tabcontent">
		<form method="post" >
			Name: <input type="text" id="name" name="name"><br>
			Email: <input type="email" id="email" name="emailaddress" pattern="[A-Za-z0-9._]+@[A-Za-z0-9.-]+\.[A-Za-z]{3}"><br>
			Subject Line: <input type="text" id="subject" name="subject"> <br>
			Message: <input type="text" id="message" name="message" width="500" height = "500"><br>	
		
			<input type="submit" name="submitemail">
		</form>
	</div>

	<div id="Resources" class="tabcontent">		
		<h3> Our posters cover a wide variety of cognitive science topics, and each presentation can be customized to cater to a specific grade level. Here are the subjects we currently offer presentations for: </h3>
	<?php	if ($_SESSION['loggedin'] === false ): //if the user is not logged in, only display a list of subjects?>
		<ul>
			<li> Senses </li>
			<li> Neuron </li>
			<li> Lobes </li>
			<li> Neurodegenerative Diseases </li>
			<li> Sports </li>
			<li> Neurosurgery </li>
			<li> Magic and the Brain </li>
			<li> Neuromarketing </li>
			<li> Sleep </li>
		</ul>
		
	

	<p> For more information and to customize your own curriculum, Login or Register! </p>
	<?php endif; ?>
	<?php
	if ($_SESSION['loggedin'] === true ): //if the user is logged in, display a form with checkboxes ?>
		<form id="curriculum">
	Senses <input type="checkbox" name='subjects' id='Senses'> <br>
	Neuron <input type='checkbox' name='subjects' id='Neuron'> <br>
	Lobes <input type='checkbox' name='subjects' id='Lobes'> <br>
	Neurodegenerative Diseases <input type='checkbox' name='subjects' id='Neurodegenerative Diseases'> <br>
	Sports <input type='checkbox' name='subjects' id='Sports'> <br>
	Neurosurgery <input type='checkbox' name='subjects' id='Neurosurgery'> <br>
	Magic and the Brain <input type='checkbox' name='subjects' id='Magic and the Brain'> <br>
	Neuromarketing <input type='checkbox' name='subjects' id='Neuromarketing'> <br>
	Sleep <input type='checkbox' name='subjects' id='Sleep'> <br>
		</form>
	<input type="submit" id="curriculum" value="Add to Curriculum" name="subjects" onclick="getsubjects()">
		
	<?php endif; ?>
	</div>

	<div id="account" class="tabcontent">
		<p id="selected_subjects">
			<!--default -->
			Nothing to see here yet: Select and add subjects from the Resources tab!
		</p>
	</div>


</body>
</html>