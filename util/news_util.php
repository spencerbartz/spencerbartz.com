<?php
	$postid = "";
	$posttext = "";

	function print_news_archive_links()
	{
    $json = get_json_config();
		$mysqli = get_mysqli_connection("newsdb");

		//Print links to news stories, counting down from last year
		for($i = intval(date("Y")) - 1; $i > 2013; $i--)
		{
			println($i, TRUE);
			println("<ul>");

			$sql = "SELECT id, dateposted FROM posts WHERE YEAR(dateposted) = " . $i . " ORDER BY dateposted DESC";
			$res = $mysqli->query($sql);

			if($res->num_rows > 0)
			{
				while($row = $res->fetch_assoc())
				{
					$path = basename(getcwd()) == "news" ? "" : "news" . DIRECTORY_SEPARATOR;
					println('<li><a href="' . $path . 'news_archive_view.php?id=' . $row["id"] . '">' . date("m/d/y", strtotime($row["dateposted"])) . "</a></li>");
				}
			}
			println("</ul>");
		}
	}

	function delete_post()
	{
		if(isset($_GET["deleteid"]))
		{
			$mysqli = get_mysqli_connection("newsdb");
			$sql = "delete from posts where id=" . $_GET["deleteid"];
			$res = $mysqli->query($sql);

			if($res)
				echo "<h3>Deleted post: " . $_GET["deleteid"] . "</h3>";
			else
				die("failed to delete post");
		}
	}

	function currently_editing()
	{
		if($GLOBALS["postid"] !== "")
			echo "<h3>Currently Editing Post id: " . $GLOBALS["postid"] . "</h3>";
		else if($GLOBALS["posttext"])
			echo "<h3>New Post Created!</h3>";
		else
			echo "<h3>New News Story</h3>";
	}

	function process_params()
	{
		$sql = "";
		$mysqli = get_mysqli_connection("newsdb");
		if(isset($_POST["posttext"]) )
		{
			if(isset($_POST["postid"]))
			{
				if(is_int($postid = filter_input(INPUT_POST, 'postid', FILTER_VALIDATE_INT)))
				{
					//update existing post
					$sql = "update posts set dateposted=dateposted, posttext='" . $_POST["posttext"] . "' where id=" . $_POST["postid"];
					$res = $mysqli->query($sql);

					if($res)
					{
						$GLOBALS["posttext"] = $_POST["posttext"];
						$GLOBALS["postid"] = $_POST["postid"];
					}
					else
					{
						die("failed to update post");
					}
				}
				else
				{
					//insert new post
					$sql = "insert into posts values(NULL, '" . $_POST["posttext"] . "', NOW(), '')";
					$res = $mysqli->query($sql );

					if($res)
					{
						$GLOBALS["posttext"] =  $_POST["posttext"];
						$sql = "select max(id) as postid from posts";
						$res = $mysqli->query($sql );
						$row = $res->fetch_assoc();
						$GLOBALS["postid"] = $row["postid"];
					}
					else
					{
						die("failed to insert post");
					}
				}
			}
		}
		else if(isset($_GET["postid"]))
		{
			//edit existing post
			$sql = "select id, posttext from posts where id=" . $_GET["postid"];
			$res = $mysqli->query($sql);

			if($res)
			{
				$row = $res->fetch_assoc();
				$GLOBALS["posttext"] =  $row["posttext"];
				$GLOBALS["postid"] = $row["id"];
			}
			else
			{
				die("failed to load text for editing");
			}
		}
	}

	function print_news()
	{
		$mysqli = get_mysqli_connection("newsdb");
		$sql = "SELECT posttext, hashtags, dateposted FROM newsdb.posts WHERE YEAR(dateposted) = YEAR(NOW()) ORDER BY dateposted DESC";

		if(!$res = $mysqli->query($sql))
			die("Failed to select post: (" . $mysqli->errno . ") " . $mysqli->error);

		if($res->num_rows > 0)
		{
			while($row = $res->fetch_assoc())
			{
				println('<div class="box">');
				println('<h1>Latest <span class="white">News:</span><span> ' . date('F jS, Y', strtotime($row['dateposted'])) . '</span></h1>');
				println('<p>' . $row['posttext'] . '</p>');
				println('<p class="post-footer align-right"> <span class="date">Date Posted: ' . $row['dateposted'] . '</span> </p>');
				println('</div>');
			}
		}
	}

	function news_post_text()
	{
		echo $GLOBALS["posttext"];
	}

	function news_post_Id()
	{
		echo $GLOBALS["postid"];
	}

	function print_archived_story($id)
	{
		if(!isset($id))
			return "News Story ID not provided";
		else
		{
			$mysqli = get_mysqli_connection("newsdb");
			$sql = "SELECT * FROM posts WHERE id = " . $id . " LIMIT 1";
			if(!$res = $mysqli->query($sql))
				die("Failed to select post: (" . $mysqli->errno . ") " . $mysqli->error);

			if($res->num_rows > 0)
			{
				$row = $res->fetch_assoc();
				println($row["posttext"]);
				println('<p class="post-footer align-right"> <span class="date">Date Posted: ' . $row['dateposted'] . '</span> </p>');
			}
		}
	}
?>
