<?php 
	require_once("dbcfg.php");
	$page = $_GET['page']; 
	date_default_timezone_set("Europe/Vienna");
	
	//connect to the db
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	mysql_select_db($dbname);
	//------------------
	
	$query = "SELECT page FROM page ORDER BY position";
	$results = mysql_query($query);
	
	if($page == "imprint" || $page == "login" || $page == "newcomment")
		$pageOK = true;
	else
		$pageOK = false;
	$i = 0;
	while ($row = mysql_fetch_assoc($results)) {
		$arr[$i++] = $row['page'];
		if($row['page'] == $page)
			$pageOK = true;
	}
	if(!isset($page))
		$page = "blog";
	else if(!$pageOK)
		$page = "404";
	$pagetitle = $page;
	//blog content / is there a requested entry?
	$entry = $_GET['entry'];
	if($page == "blog") {
		if(isset($entry) && is_numeric($entry)) {
			$query = "SELECT * FROM entry WHERE entryid = '$entry'";
			$results = mysql_query($query);
			if(mysql_num_rows($results) > 0)
			{
            //get data if the entry is declared
				while ($row = mysql_fetch_assoc($results)) {
					$title = $row['title'];
               $pagetitle = $title;
					$content = $row['content'];
					$time = $row['time'];
				}
                                //get the comments
                                $query = "SELECT nick, text, time FROM comment WHERE entryid = '$entry' ORDER BY time";
                                $results = mysql_query($query);
                                if(mysql_num_rows($results) > 0)
                                {
                                        $idx = 0;
                                        while ($row = mysql_fetch_assoc($results)) {
                                                $cnick[$idx] = $row['nick'];
                                                $ctext[$idx] = $row['text'];
                                                $ctime[$idx] = $row['time'];
                                                $idx++;
                                        }
                                }
			}
			else
			{
				$page = "404";
				$pagetitle = "404";
			}
		}
		else {
			$query = "SELECT * FROM entry";
			$results = mysql_query($query);
			if(mysql_num_rows($results) > 0)
			{
				$idx = 0;
				while ($row = mysql_fetch_assoc($results)) {
					$entryid[$idx] = $row['entryid'];
					$title[$idx] = $row['title'];
					$content[$idx] = $row['content'];
					$time[$idx] = $row['time'];
					$idx++;
				}
			}
		}
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" href="style/style.css" type="text/css">
		<title>zola :: <?php echo $pagetitle; ?></title>
	</head>
	<body>
		<div id="container">
			<div id="header">
			</div>
			<div class="bar" id="top">
				<div id="leftnav">
					<?php
						for ($i = 0; $i < sizeof($arr); $i++) {
							$element = $arr[$i];
							echo "<a";
							if($element == $page) {
								echo " id=\"active\"";
							}
							echo " href=\"index.php?page=".$element."\">".$element."</a>";
						}
					?>
				</div>
				<div id="rightnav">
                                    <!--search-->
				</div>
			</div>
			<div id="entries">
			<?php
				include("content/".$page.".php");
			?>
			</div>
			<div class="bar" id="bottom">
				<p>copyright 2011 zola-online.net. <a href="index.php?page=imprint">Imprint</a></p>
			</div>
		</div>
	</body>
</html>
<?php mysql_close($conn); ?>
