	<div class="entry">
		<h2>Saving new comment ...</h2>
	<?php
		require_once('recaptchalib.php');
		$privatekey = "6LdxMcYSAAAAAIexPQM_nwdnhkbALtRDJZsG09Xm";
		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		$newentry = $_POST["newentry"];
		$newnick =  mysql_real_escape_string(htmlspecialchars($_POST["newnick"], ENT_QUOTES));
		$newtext =  mysql_real_escape_string(htmlspecialchars($_POST["newtext"]));
		
		if (!$resp->is_valid) {
			echo "<p>The reCAPTCHA wasn't entered correctly. Go back and try it again.<br/> Return to the article: <a href=\"index.php?page=blog&entry=$newentry\">click</a></p>";
		} else {
			if(isset($_POST["newnick"]) && strlen($newnick) > 2 && strlen($newtext) > 2 && strlen($newnick) < 13) {	
				$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
				mysql_select_db($dbname);
				
				$query = "INSERT INTO `zlog`.`comment`(`commentid`,`entryid`,`nick`,`text`,`time`)VALUES(NULL,'$newentry','$newnick','$newtext',CURRENT_TIMESTAMP)";
				mysql_query($query);
				mysql_close();
				echo "<p>Successful! Return to the article: <a href=\"index.php?page=blog&entry=".$newentry."\">click</a></p>";
			}
			else {
			 echo "<p>Failed! Your inputs should at least contain 2 characters. The nick is limited to 12. <br/> Return to the article: <a href=\"index.php?page=blog&entry=$newentry\">click</a></p>";	
			}
		}
		?>
	</div>
