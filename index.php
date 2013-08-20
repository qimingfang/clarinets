<?
	include "includes/functions.php";
	
	$title = "Home";
	$content = '
		<div id="page">
			<div id="content">
				<div class="post">
					<!-- <h2 class="title"><a href="#">Welcome to Breakeven </a></h2> -->
					<div class="entry">
						<p><a href="#"><img src="images/clarinets.png" width="1000" height="450" alt="" /></a></p>
						<p><strong>The 2012 Clarinet Section!</strong></p>
						<p><strong>Front:</strong> Eric, Ben, Ross, Jess, Mike, Evie, Jen<br />
						<strong>Back:</strong> Anita, Hallie, Rachel, Dhanya, Jen, Jason, Kim, Bri, Qiming, Julia, Julian, David, Nick, Michael Lee, Sam, Dan</p>
						
						<!-- <p class="links"><a href="#" class="more">Read More</a><a href="#" title="b0x" class="comments">Comments</a></p>
						-->
					</div>
				</div>
			</div>
			<!-- end #content -->
			<!-- end #sidebar -->
			<!-- <div style="clear: both;">&nbsp;</div> -->
		</div>
		<!-- end #page --> 
		<div id="featured-content">
			<div id="column1">
				<h2>Traditions</h2>
				<p><img src="images/img1.png" width="300" height="150" alt="" /></p>
				<p>Each section has its own traditions. Some have been going on for a while, some started yesterday (but you don\'t know it yet). Old traditions, however, provide a good segue into our first tradition: <strong>Clarinets are the coolest section in the band.</strong></p>
				<p class="button"><a href="#">Read More</a></p>
			</div>
			<div id="column2">
				<h2>Stories</h2>
				<p><img src="images/img2.png" width="300" height="150" alt="" /></p>
				<p>The clarinets have a countless number of stories that have accumulated over many many seasons. <a href="#">Join us</a> so that we can share your stories with the next generation of clarinets!</p>
				<p class="button"><a href="#">Read More</a></p>
			</div>
			<div id="column3">
				<h2>Parading</h2>
				<p><img src="images/img3.png" width="300" height="150" alt="" /></p>
				<p>Saturdays don\'t only consist of the football game. We spend a good portion of the day parading around campus at home and away. Some parade moves are executed across the band, but most are unique to a particular section. Ours are the best.</p>
				<p class="button"><a href="#">Read More</a></p>
			</div>
		</div>';
	
	include "template.php";
?>