<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Survey</title>

<meta name="viewport" content="width=device-width">

<link rel="stylesheet" href="./survey/bootstrap.min.css">

<link type="text/css" rel="stylesheet" href="./survey/style.css">
<link href="./survey/css" rel="stylesheet" type="text/css">

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body id="top">
<div id="cv">
	<div id="mainArea">

		<section>
			<div class="sectionTitle">
			<h1>작업 시작</h1> </div>
															

			<div class="sectionContent">
		<article>
		<p id="article_text">작업자의 이름을 입력하세요.
		자동이동을 선택하면 index를 입력하지 않아도 됩니다.
					수동이동을 하려면 이동하려는 index를 입력하세요
					</p>
					<div class="col-xs-4" >
					  <input type="text" class="form-control" placeholder="reporter name" id="reporter">
					  <input type="text" class="form-control" placeholder="index" id="index">
					  <button onclick="moveRecent()" class="btn-primary">자동이동</button>
					  <button onclick="moveTo()" class="btn-primary">수동이동</button>
					</div>					
				</article>
				
			</div>
			
			
			
			<div class="clear"></div>
		</section>
		
		<section>
			<div class="sectionTitle">
			<h1>현황</h1> 
			</div>
			
			<div class="sectionContent">
			<article>
			<p id="article_text">
			<p>Clover3 : <span id="clover3"></span> </p>
			<p>dongmin: <span id="dongmin"></span> </p>
			</p>
			</div>
			<div class="clear"></div>
		</section>
	</div>
</div>

<?php
function get_count($db, $name)
{
	  $sql= "select count(*) from reports where reporter=\"" . $name . "\";";
		$ret = $db->query($sql);
		if(!$ret){
			echo $db->lastErrorMsg();
			echo "Error";
		}
		else
		{
			$row = $ret->fetchArray(MYSQLI_ASSOC);
			$count= $row["count(*)"];
		}
		return $count;
}

function get_last_index($db)
{
	  $sql= "select id from corpus except select corpus_id from reports limit 1;";
		$ret = $db->query($sql);
		if(!$ret){
			echo $db->lastErrorMsg();
		}
		else
		{
			$row = $ret->fetchArray(MYSQLI_ASSOC);
			$lastIndex= $row['id'];
		}
		return $lastIndex;
}

  $db_path = "/home/clover/public_html/db/rp.db";
  $db = new SQLite3($db_path);
  if(!$db)
  	echo $db->lastErrorMsg();
	else
  {
		$cloverCount = get_count($db,"Clover3");
		$dongminCount= get_count($db,"dongmin");
		$lastIndex = get_last_index($db);

		$db->close();
	}
?>
<script>
var lastIndex= <?php echo $lastIndex; ?>;
var clover3_count = <?php echo $cloverCount; ?>;
var dongmin_count = <?php echo $dongminCount; ?>;

document.getElementById('clover3').innerHTML = clover3_count.toString();
document.getElementById('dongmin').innerHTML = dongmin_count.toString();

function moveTo()
{
	var reporter = document.getElementById('reporter').value;
	var index = document.getElementById('index').value;
	document.cookie = "name=" + reporter;
	window.location.href = 'load.php?corpus_id=' + index;
}
function moveRecent()
{
	var reporter = document.getElementById('reporter').value;
	var index = lastIndex;
	document.cookie = "name=" + reporter;
	window.location.href = 'load.php?corpus_id=' + index;
}

</script>

</body></html>
