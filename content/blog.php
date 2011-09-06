        <?php
        if (!isset($entry)) {
			$site = $_GET['site'];
			if (!isset($site))
				$site = 1;
			$site=($site-1)*5;
            for ($i = $site; $i < sizeof($content) && $i < $site + 5; $i++) {
                echo "<div class=\"entry\">";
                    echo "<h2>" . $title[$i] . "</h2>";
                    echo $content[$i];
                    echo "<div class=\"meta\"><a href='index.php?page=blog&entry=" . $entryid[$i] . "'>Comments</a></div>";
                echo "</div>";
            }
            echo "<div id=\"sites\">";
            for($i = 1; $i <= ceil(sizeof($content) / 5); $i++)
            {
				echo "<a href=\"index.php?site=$i\">[$i]</a>";
			}
            echo "</div>";
        } else {
            echo "<div class=\"entry\">";
                echo "<h2>" . $title . "</h2>";
                echo $content;
                echo "<div class=\"meta\">asdf</div>";
            echo "</div>";
            echo "<div class=\"entry\">";
            	echo "<h3>Comments</h3> ";
            if(isset($cnick)) {
                    for($i = 0; $i < sizeof($cnick); $i++) {
								echo "<div class=\"comment\">";                        
                        	echo "<p class=\"chead\"><b>$cnick[$i]</b> ".date("F j, Y, G:i", strtotime($ctime[$i]))."</p>";
                        	echo "<p class=\"ctext\">$ctext[$i]</p>";   	
                        echo "</div>";
                    }
                }
            echo "</div>"; ?>
            <div class="entry">
                <h3>Leave A Comment</h3> 
                <!-- Theme for reCaptcha -->
                <script type="text/javascript">
					var RecaptchaOptions = {
						theme : 'clean'
					};
				</script>
                <!-- / Theme for reCaptcha -->
                <form id="newcomment" action="index.php?page=newcomment" method="POST">
                    <input type="hidden" name="newentry" value="<?php echo $entry; ?>"/>
                    Nick:</br><input type="text" name="newnick"/></br>
                    Comment:</br><TEXTAREA NAME="newtext" COLS=85 ROWS=6></TEXTAREA></br>
                    <?php 
						require_once("recaptchalib.php");
						$publickey = "6LdxMcYSAAAAAJv54leF3GX78AeOmM9itRgEykpf";
						echo recaptcha_get_html($publickey);
                    ?>
                    <input type="submit" value="Submit"/>
                </form>
            </div>
        <?php } ?>
