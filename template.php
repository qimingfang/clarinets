<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js" type="text/javascript"><!--mce:0--></script>
		<!-- jQuery UI is Optional. Its only required if using easing functions. -->
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript"><!--mce:1--></script>
		
		<link rel="stylesheet" type="text/css" href="styles/jqueryFileTree.css" />
		<link rel="stylesheet" type="text/css" href="styles/nivo-slider.css" />
		<link rel="stylesheet" href="styles/default/default.css" type="text/css" />
		<link rel="stylesheet" href="styles/formee-structure.css" type="text/css" />
		<link rel="stylesheet" href="styles/formee-style.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="styles/style.css" />
		<link rel="stylesheet" type="text/css" href="codemirror/lib/codemirror.css">
		<!-- markItUp! -->
		<script type="text/javascript" src="scripts/markitup/jquery.markitup.js"></script>
		<!-- markItUp! toolbar settings -->
		<script type="text/javascript" src="scripts/markitup/sets/html/set.js"></script>
		<!-- markItUp! skin -->
		<link rel="stylesheet" type="text/css" href="scripts/markitup/skins/markitup/style.css" />
		<!--  markItUp! toolbar skin -->
		<link rel="stylesheet" type="text/css" href="scripts/markitup/sets/html/style.css" />
		
		<script type="text/javascript" src="scripts/script.js"></script>
		<script type="text/javascript" src="scripts/jqueryFileTree.js"></script>
		
		<script type="text/javascript" src="codemirror/lib/codemirror.js"></script>
		<link rel="stylesheet" href="codemirror/lib/codemirror.css">
		<script type="text/javascript" src="codemirror/mode/clike/clike.js"></script>
		<script type="text/javascript" src="codemirror/mode/xml/xml.js"></script>
		<script type="text/javascript" src="codemirror/mode/css/css.js"></script>
		<script type="text/javascript" src="codemirror/mode/php/php.js"></script>
		<script type="text/javascript" src="codemirror/mode/javascript/javascript.js"></script>
				
		<script type="text/javascript" src="scripts/jquery.nivo.slider.pack.js"></script>
		<script src="scripts/jquery.sliding-menu.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(window).load(function() {
				jQuery(function(){
					console.log("here");
				  	jQuery('#menu .SlidingMenu').slidingMenu();
				});

				$('#slider').nivoSlider({
					effect : 'sliceDown'
				});
			});
			
		</script>
		<title><?php echo identity::$site_name;?></title>
	</head>
	<body>
		<div id="wrapper">
			<div id="header-wrapper">
				<div id="header" class="container">
					<div id="logo">
						<h1><a href="index.php"><img src="images/Clarinet_Logo.png" alt="logo" />Big Red Clarinets</a></h1>
					</div>
					<div id="menu">
						<ul class="SlidingMenu Horizontal">
							<li class="current_page_item"><a href="index.php">Homepage</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="members.php">People</a></li>
							<li><a href="photos.php">Photos</a></li>
							<li><a href="join.php">Join Us!</a></li>
						</ul>
					</div>
				</div>
			</div>

			<?php 
				if (isset($content)){
					echo $content;
				}
			?>

		</div>

		<div id="footer">
			<div id="footer-inner">
				<div class="left">
					<p>Copyright &copy; 2013 BRMB Clarinets
					</p>
				</div>

				<div class="right">
					<p>
						<a href="contact.php">Contact Us</a> |
						<a href="http://mb.bigredbands.org/sections.php">Other Sections</a> |
						<a href="http://bigredbands.org">Big Red Bands</a> |
						<a href="http://www.cornell.edu">Cornell University</a><br />
						A modified <a href="http://www.freecsstemplates.org/" rel="nofollow">fct</a> design |
						<a href="mailto:qf26@cornell.edu">Website Problems?</a> |
						<?php if (!isset($_SESSION['uid'])){ ?>
							<a href="login.php">Member Login</a>
						<?php } else { ?>
							<a href="user.php">User Panel</a> | 
							<a href="logout.php">Logout</a>
						<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>
