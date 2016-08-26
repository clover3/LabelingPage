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
				<h1><p id="keyword">카</p></h1>
			</div>
			
			<div class="sectionContent">
				<article>
					<p id="article_text"></p>
					
					<div class="btn-group">
					  <button onclick="report(1)" class="btn-primary btn-lg">긍정</button>
					  <button onclick="report(2)" class="btn-info btn-lg">중립</button>
					  <button onclick="report(3)" class="btn-danger btn-lg">부정</button>
					  <button onclick="report(4)" class="btn-warning btn-lg">잘못된 Entity</button>
					</div>
					<div style="float: right;">
						<a id="weblink" href="about:blank" target="_blank"><h6><small>홈페이지에서 보기</small></h6></a>
					</div>

					
				</article>
				
			</div>
			
			
			
			<div class="clear"></div>
		</section>
	</div>
</div>

<script>
<?php
// get data form db
// 
  $corpus_id = $_GET['corpus_id'];
	if(empty($corpus_id)){
		echo "ERROR : corpus_id is empty\n";
	}
	else{
		$db_path = "/home/clover/public_html/db/rp.db";
		$db = new SQLite3($db_path);
		if(!$db)
			echo $db->lastErrorMsg();
		else
		{
			$sql = "SELECT * FROM corpus where id=" . $corpus_id. ";";
			$ret = $db->query($sql);
			if(!$ret){
			  echo $db->lastErrorMsg();
			}
			else
			{
				$row = $ret->fetchArray(MYSQLI_ASSOC);
				$article_id = $row['article_id'];
				$thread_id = $row['thread_id'];
				$content = json_encode($row['content']);
				$keyword = json_encode($row['keyword']);
			}
			$db->close();
		}
	}
?>

var corpus_id = <?php echo $corpus_id;?>;
var article_id = <?php echo $article_id;?>;
var thread_id = <?php echo $thread_id;?>; 
var content = <?php echo $content;?>;
var keyword = <?php echo $keyword;?>;

function report(label){
	reporter = "clover";
	url = "report.php?thread_id=" + thread_id + "&article_id=" + article_id
	+ "&reporter=" + reporter + "&label=" + label + "&corpus_id=" + corpus_id;
	window.location.href = url;
}

function get_highlight_text(text, keyword) {
	String.prototype.replaceAll = function(strReplace, strWith) {
		    var reg = new RegExp(strReplace, 'ig');
				    return this.replace(reg, strWith);
	};
	htext = text.replaceAll(keyword,"<span class='bg-primary'>" + keyword + "</span>");
	return htext;
}

function get_url(thread_id){
	url = "http://www.bobaedream.co.kr/view?code=national&No=" + thread_id;
	return url;
}

function init_page(content, keyword, thread_id){
	document.getElementById('article_text').innerHTML = get_highlight_text(content, keyword);
	document.getElementById("keyword").innerHTML = keyword;
	document.getElementById("weblink").href = get_url(thread_id);
}

init_page(content, keyword, thread_id);

</script>

</body></html>
