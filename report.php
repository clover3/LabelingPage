<html>
<body>
<?php
/*
	class MyDB extends SQLite3
	{
		function __construct()
		{
			$this->open('rp.db');
		}
	}
	*/

  $corpus_id= $_GET['corpus_id'];
  $article_id = $_GET['article_id'];
	$thread_id = $_GET['thread_id'];
	$reporter = $_GET['reporter'];
	$label = $_GET['label'];

	if(empty($article_id)){
		echo "ERROR : article id is empty\n";
	}
  elseif(empty($thread_id)){
		echo "ERROR : thread_id is empty\n";
	}
	elseif(empty($reporter)){
		echo "ERROR : reporter is empty\n";
	}
  elseif(empty($label)){
		echo "ERROR : label is empty\n";
	}
	else {
		$db_path = "/home/clover/public_html/db/rp.db";
		$db = new SQLite3($db_path);
		if(!$db)
			echo $db->lastErrorMsg();
		else
		{
			$sql = "INSERT INTO report (article_id, thread_id, reporter, label) VALUES (" . $article_id . "," . $thread_id . ",'" . $reporter . "'," . $label . ");";

//echo $sql;
			$ret = $db->exec($sql);
			if(!$ret){
			  echo $db->lastErrorMsg();
			}
			else
				echo "<script> window.location.href='load.php?corpus_id=" . ($corpus_id+1) . "'; </script>";
			$db->close();
		}
	}
?>
</body>

</html>
