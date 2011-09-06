	<div class="entry">
		<h2>Login</h2>
	<?php
		if(isset($_POST["user"])) {
			
			
			$user =  $_POST["user"];
			$pass =  md5($_POST["pass"]);
			
			$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
			mysql_select_db($dbname);
			
			$query = sprintf("SELECT nick FROM user WHERE nick='%s' AND pass='%s'", mysql_real_escape_string($user), $pass);
			$count=mysql_numrows(mysql_query($query));
			if($count>0) {
				echo "<p>Login successful! Please succeed!</p>";
				$_SESSION['user'] = "";
			}
			else { echo "<p>Login failed!</p>"; }
			mysql_close();
		}
		else { ?>
		<form name="loginform" id="loginform" action="index.php?page=login" method="post">
			<input type="text" name="user"><br/>
			<input type="password" name="pass"><br/>
			<input type="submit" value="Log In">
		</form>			
	<?php } ?>
	</div>