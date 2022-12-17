<?php
	if(isset($_POST['logout'])){
		setcookie("TEST", "", time() - 3600);
		header("Location:pafevent2.php");
	}
	include('config2.php');
	$setting = parse_ini_file("log2/setting.ini", false);
	define("PASSWORD", "$password");
	if(isset($_COOKIE["TEST"]) && $_COOKIE["TEST"] != null && md5(PASSWORD) === $_COOKIE["TEST"]){//クッキーの値がパスワードと一致するか確認
	session_start();
	function error_message($error_head,$error_body){
		return("<table class='error'><tr><td class='error_header'>{$error_head}</td></tr><tr><td class='error_body'>{$error_body}<br><a href='javascript:history.back()'>戻る</a></td></tr></table></body></html>");
	}
	function thanks($thanks_body){
		return("<table class='thanks'><tr><td class='thanks_body'>{$thanks_body}<br><a href='./admin2.php'>管理者ページ</a></td></tr></table></body></html>");
	}
$sitename = $setting["sitename"];

echo"<html lang='ja'>
<head>
<title>{$sitename}：管理ページ</title>
<link rel='stylesheet' href='./default2.css' type='text/css' media='all'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<meta http-equiv='content-script-type' content='text/javascript'>
<script language='JavaScript'><!--
function setTextField(flag)
{
document.odaiform.LIMIT0Y.disabled = flag;
document.odaiform.LIMIT0M.disabled = flag;
document.odaiform.LIMIT0D.disabled = flag;
document.odaiform.LIMIT0H.disabled = flag;
document.odaiform.PRE_DISP.disabled = flag;
document.odaiform.ODAI_PRE_BODY.disabled = flag;
}
// --></script>
</head>
<body>";
	$odaiindexurl = "log2/odaidata.csv";
	$odaiindex = file("log2/odaidata.csv");
	$odainew = $_POST["INPUTNEW"];
	$odaikey = $_GET['odai'];
	$votekey = $_GET['vote'];
	$bokekey = $_GET['boke'];
	$filekey = $_GET['file'];
	$listkey = $_GET['l'];
	$pagekey = $_GET['p'];
	if ($_POST["ODAI_UP"]) {	// お題を上へ移動ここから
		$up = $_POST["ODAI_UP"];
		$up--;
		if($up!=0){
			$down = $up-1;
			$fp2 = fopen("$odaiindexurl", "w");
			flock($fp2, LOCK_SH);
			foreach($odaiindex as $i => $v){
				if($i==$down){
					$v = $odaiindex[$up];
				}elseif($i==$up){
					$v = $odaiindex[$down];
				}
				fwrite($fp2, "$v");
			}
			flock($fp2, LOCK_UN);
			fclose($fp2);
		}
	$odaiindex = file("log2/odaidata.csv");
	}
	if ($_POST["ODAI_DOWN"]) {	// お題を下へ移動ここから
		$down = $_POST["ODAI_DOWN"];
		$down--;
		$indexsize = sizeof($odaiindex);
		$indexsize = $indexsize - 1;
		if($down<$indexsize){
			$up = $down+1;
			$fp2 = fopen("$odaiindexurl", "w");
			flock($fp2, LOCK_SH);
			foreach($odaiindex as $i => $v){
				if($i==$up){
					$v = $odaiindex[$down];
				}elseif($i==$down){
					$v = $odaiindex[$up];
				}
				fwrite($fp2, "$v");
			}
			flock($fp2, LOCK_UN);
			fclose($fp2);
		}
	$odaiindex = file("log2/odaidata.csv");
	}
	if ($_POST["SUBMIT_ODAI"]) {	// お題更新・作成作業
		$inputid = $_POST["INPUTID"];
		$inputnew = $_POST["INPUTNEW"];
		if(isset($inputnew)){
			$lastno = 0;
			foreach($odaiindex as $value){
				$line = explode(",", $value);
				if($line[0]>$lastno){$lastno = $line[0];}
			}
			$inputid=$lastno+1;
		}
		$newodaititle = $_POST["TITLE"];
		$newodaibody = $_POST["BODY"];
		$newlimit0y = $_POST["LIMIT0Y"];
		$newlimit0m = $_POST["LIMIT0M"];
		$newlimit0d = $_POST["LIMIT0D"];
		$newlimit0H = $_POST["LIMIT0H"];
		$newlimit1y = $_POST["LIMIT1Y"];
		$newlimit1m = $_POST["LIMIT1M"];
		$newlimit1d = $_POST["LIMIT1D"];
		$newlimit1H = $_POST["LIMIT1H"];
		$newlimit2y = $_POST["LIMIT2Y"];
		$newlimit2m = $_POST["LIMIT2M"];
		$newlimit2d = $_POST["LIMIT2D"];
		$newlimit2H = $_POST["LIMIT2H"];
		$newpostlimit = $_POST["POSTLIMIT"];
		$newcmt_mode = $_POST["CMT_MODE"];
		$newodai_mode = $_POST["ODAI_MODE"];
		$newanaume1 = $_POST["ANAUME1"];
		$newanaume2 = $_POST["ANAUME2"];

		$newp4v = $_POST["P4V"];
		$newp3v = $_POST["P3V"];
		$newp2v = $_POST["P2V"];
		$newp4limit = $_POST["P4LIMIT"];
		$newp3limit = $_POST["P3LIMIT"];
		$newp2limit = $_POST["P2LIMIT"];
		$newodai_pre_disp = $_POST["PRE_DISP"];
		$newchk_count = $_POST["CHK_COUNT"];
		$newvoter_disp = $_POST["VOTER_DISP"];
		$image_position = $_POST["IMAGE_POSITION"];
		$newodai_pre_body = $_POST["ODAI_PRE_BODY"];
		$prepost = $_POST['PREPOST'];
		$newvote_self = $_POST['VOTE_SELF'];
		$newvote_bonus = $_POST['VOTE_BONUS'];
		$newodai_manual = $_POST['ODAI_MANUAL'];
		$newdeadline = $_POST['DEADLINE'];
		if($prepost=="1"){
			if($newlimit0y=="" or $newlimit0m=="" or $newlimit0d=="" or $newlimit0H==""){
			echo error_message("更新エラー","予約投稿日付欄が空欄です");
				exit;
			}
		}
		if($newodaititle=="" or $newodaibody=="" or $newlimit1y=="" or $newlimit1m=="" or $newlimit1d=="" or $newlimit1H=="" or $newlimit2y=="" or $newlimit2m=="" or $newlimit2d=="" or $newlimit2H=="" or $newpostlimit=="" or $newp4v=="" or $newp4v=="0"){
			echo error_message("更新エラー","空欄があります");
			exit;
		}

		if($prepost=="1"){
			if(!preg_match("/^[0-9]+$/",$newlimit0y) or !preg_match("/^[0-9]+$/",$newlimit0m) or !preg_match("/^[0-9]+$/",$newlimit0d) or !preg_match("/^[0-9]+$/",$newlimit0H)){
			echo error_message("更新エラー","数値の欄には半角数字のみを入力してください");
			exit;
			}
		}
		if(!preg_match("/^[0-9]+$/",$newp4v)){
			echo error_message("更新エラー","数値の欄には半角数字のみを入力してください");
			exit;
		}
		if(!empty($newvote_bonus)){if(!preg_match("/^[0-9]+$/",$newvote_bonus)){echo error_message("更新エラー","数値の欄には半角数字のみを入力してください");exit;}}
		$point_r=0;
		if(!empty($newp3v)){if(!preg_match("/^[0-9]+$/",$newp3v)){$point_r++;}}
		if(!empty($newp2v)){if(!preg_match("/^[0-9]+$/",$newp2v)){$point_r++;}}
		if(!empty($newp4limit)){if(!preg_match("/^[0-9]+$/",$newp4limit)){$point_r++;}}
		if(!empty($newp3limit)){if(!preg_match("/^[0-9]+$/",$newp3limit)){$point_r++;}}
		if(!empty($newp2limit)){if(!preg_match("/^[0-9]+$/",$newp2limit)){$point_r++;}}
		if(!$point_r==0){echo error_message("更新エラー","数値の欄には半角数字のみを入力してください");exit;}
		if(!preg_match("/^[0-9]+$/",$newlimit1y) or !preg_match("/^[0-9]+$/",$newlimit1m) or !preg_match("/^[0-9]+$/",$newlimit1d) or !preg_match("/^[0-9]+$/",$newlimit1H) or !preg_match("/^[0-9]+$/",$newlimit2y) or !preg_match("/^[0-9]+$/",$newlimit2m) or !preg_match("/^[0-9]+$/",$newlimit2d) or !preg_match("/^[0-9]+$/",$newlimit2H) or !preg_match("/^[0-9]+$/",$newpostlimit) or !preg_match("/^[0-9]+$/",$newcmt_mode) or !preg_match("/^[0-9]+$/",$newcmt_mode)){echo error_message("更新エラー","数値の欄には半角数字のみを入力してください");exit;
		}
		if($prepost=="1"){
			if(strlen($newlimit0y)>4 or strlen($newlimit0m)>2 or strlen($newlimit0d)>2 or strlen($newlimit0H)>2){
				echo error_message("更新エラー","ケタ数に誤りがあります");
				exit;
			}
		}

		if(strlen($newlimit1y)>4 or strlen($newlimit1m)>2 or strlen($newlimit1d)>2 or strlen($newlimit1H)>2 or strlen($newlimit2y)>4 or strlen($newlimit2m)>2 or strlen($newlimit2d)>2 or strlen($newlimit2H)>2){
			echo error_message("更新エラー","ケタ数に誤りがあります");
			exit;
		}
		if(!checkdate($newlimit1m , $newlimit1d , $newlimit1y) or !checkdate($newlimit2m , $newlimit2d , $newlimit2y)){
			echo error_message("更新エラー","無効な日付です");
			exit;
			}

		if($prepost=="1"){
			if(!checkdate($newlimit0m , $newlimit0d , $newlimit0y)){
				echo error_message("更新エラー","無効な日付です");
				exit;
			}
		}
		$limit1date=$newlimit1y . $newlimit1m . $newlimit1d . $newlimit1H . "0000";
		$limit2date=$newlimit2y . $newlimit2m . $newlimit2d . $newlimit2H . "0000";
		if($limit1date>$limit2date){
		echo error_message("更新エラー","投稿締め切り日は投票締め切り日より前に設定してください");
			exit;
		}
		if($prepost=="1"){
			$limit0date=$newlimit0y . $newlimit0m . $newlimit0d . $newlimit0H . "0000";
			if($limit0date>$limit1date){
				echo error_message("更新エラー","受付開始日は投稿締め切り日より前に設定してください");
				exit;
			}
		}else{$limit0date=0;}

		// 画像アップロードここから
		if($_FILES['IMG_1']['error'] == 2 or $_FILES['IMG_2']['error'] == 2 or $_FILES['IMG_3']['error'] == 2){
			echo error_message("アップロードエラー","ファイルサイズが大きすぎます");
			exit;
		}
		$width_max = 400;
		$img_array = "";
		if (is_uploaded_file($_FILES["IMG_1"]["tmp_name"])){	// 画像1
			$target1_a = $_FILES["IMG_1"]["name"];
			$target1_a = strtoupper($target1_a);
			$ext = array("JPG","JPEG","PNG","GIF");
			$type1_ok = false;
			foreach($ext as $key1 => $Value) {
				$target1_b = basename($target1_a, $Value);
				if (strlen($target1_b . $Value) == strlen($target1_a)) {
					$type1_ok = true;
					$type1 = $key1;
					break;
				}
			}
			if (!$type1_ok){
				echo error_message("アップロードエラー","認められていない拡張子です");
				exit;
			}else{
			$upfile1 = $_FILES['IMG_1']['tmp_name'];
			list($width1,$height1) = getimagesize($upfile1);
			if($width1 > $width_max){
				$height1 = round($height1 * $width_max / $width1);
				$width1 = $width_max;
			}
			if($type1 == 0){$uploadfile1 = "image/" . date("YmdHis") . "_1.jpg";}
			if($type1 == 1){$uploadfile1 = "image/" . date("YmdHis") . "_1.jpeg";}
			if($type1 == 2){$uploadfile1 = "image/" . date("YmdHis") . "_1.png";}
			if($type1 == 3){$uploadfile1 = "image/" . date("YmdHis") . "_1.gif";}
			$image1_tag = "<img src='" . $uploadfile1 . "' width='" . $width1 . "' height='" . $height1 . "'>";
			if(!empty($img_array)){$img_array = $img_array. "<br>" . $image1_tag;}
			else{$img_array = $image1_tag;}
			$image1upload = true;
			}
		}	// 画像1ここまで
		if (is_uploaded_file($_FILES["IMG_2"]["tmp_name"])){	// 画像2
			$target2_a = $_FILES["IMG_2"]["name"];
			$target2_a = strtoupper($target2_a);
			$ext = array("JPG","JPEG","PNG","GIF");
			$type2_ok = false;
			foreach($ext as $key2 => $Value) {
				$target2_b = basename($target2_a, $Value);
				if (strlen($target2_b . $Value) == strlen($target2_a)) {
					$type2_ok = true;
					$type2 = $key2;
					break;
				}
			}
			if (!$type2_ok){
				echo error_message("アップロードエラー","認められていない拡張子です");
				exit;
			}else{
			$upfile2 = $_FILES['IMG_2']['tmp_name'];
			list($width2,$height2) = getimagesize($upfile2);
			if($width2 > $width_max){
				$height2 = round($height2 * $width_max / $width2);
				$width2 = $width_max;
			}
			if($type2 == 0){$uploadfile2 = "image/" . date("YmdHis") . "_2.jpg";}
			if($type2 == 1){$uploadfile2 = "image/" . date("YmdHis") . "_2.jpeg";}
			if($type2 == 2){$uploadfile2 = "image/" . date("YmdHis") . "_2.png";}
			if($type2 == 3){$uploadfile2 = "image/" . date("YmdHis") . "_2.gif";}
			$image2_tag = "<img src='" . $uploadfile2 . "' width='" . $width2 . "' height='" . $height2 . "'>";
			if(!empty($img_array)){$img_array = $img_array. "<br>" . $image2_tag;}
			else{$img_array = $image2_tag;}
			$image2upload = true;
			}
		}	// 画像2ここまで
		if (is_uploaded_file($_FILES["IMG_3"]["tmp_name"])){	// 画像3
			$target3_a = $_FILES["IMG_3"]["name"];
			$target3_a = strtoupper($target3_a);
			$ext = array("JPG","JPEG","PNG","GIF");
			$type3_ok = false;
			foreach($ext as $key3 => $Value) {
				$target3_b = basename($target3_a, $Value);
				if (strlen($target3_b . $Value) == strlen($target3_a)) {
					$type3_ok = true;
					$type3 = $key3;
					break;
				}
			}
			if (!$type3_ok){
				echo error_message("アップロードエラー","認められていない拡張子です");
				exit;
			}else{
			$upfile3 = $_FILES['IMG_3']['tmp_name'];
			list($width3,$height3) = getimagesize($upfile3);
			if($width3 > $width_max){
				$height3 = round($height3 * $width_max / $width3);
				$width3 = $width_max;
			}
			if($type3 == 0){$uploadfile3 = "image/" . date("YmdHis") . "_3.jpg";}
			if($type3 == 1){$uploadfile3 = "image/" . date("YmdHis") . "_3.jpeg";}
			if($type3 == 2){$uploadfile3 = "image/" . date("YmdHis") . "_3.png";}
			if($type3 == 3){$uploadfile3 = "image/" . date("YmdHis") . "_3.gif";}
			$image3_tag = "<img src='" . $uploadfile3 . "' width='" . $width3 . "' height='" . $height3 . "'>";
			if(!empty($img_array)){$img_array = $img_array. "<br>" . $image3_tag;}
			else{$img_array = $image3_tag;}
			$image3upload = true;
			}	// 画像3ここまで
		}
		if($image1upload){move_uploaded_file($_FILES['IMG_1']['tmp_name'], $uploadfile1);}
		if($image2upload){move_uploaded_file($_FILES['IMG_2']['tmp_name'], $uploadfile2);}
		if($image3upload){move_uploaded_file($_FILES['IMG_3']['tmp_name'], $uploadfile3);}
		// 画像アップロードここまで
		// HTML取除き
		$newodaititle = htmlspecialchars("$newodaititle", ENT_QUOTES);
		$newdeadline = htmlspecialchars("$newdeadline", ENT_QUOTES);
		// クオートエスケープ処理を削除
		if( get_magic_quotes_gpc()) { $newodaititle = stripslashes("$newodaititle"); }
		if (get_magic_quotes_gpc()) { $newodaibody = stripslashes("$newodaibody"); }
		if (get_magic_quotes_gpc()) { $newodai_pre_body = stripslashes("$newodai_pre_body"); }
		if( get_magic_quotes_gpc()) { $newdeadline = stripslashes("$newdeadline"); }
		$newodaibody = str_replace("\r\n", "<br>", $newodaibody);
		$newodaibody = str_replace(",", "", $newodaibody);
		$newodai_pre_body = str_replace("\r\n", "<br>", $newodai_pre_body);
		$newodai_pre_body = str_replace(",", "", $newodai_pre_body);
		$newodaititle = str_replace("\r\n", "", $newodaititle);
		$newodaititle = str_replace(",", "", $newodaititle);
		$newanaume1 = str_replace("\r\n", "", $newanaume1);
		$newanaume1 = str_replace(",", "", $newanaume1);
		$newanaume2 = str_replace("\r\n", "", $newanaume2);
		$newanaume2 = str_replace(",", "", $newanaume2);
		$newdeadline = str_replace("\r\n", "", $newdeadline);
		$newdeadline = str_replace(",", "", $newdeadline);
		if(!empty($img_array)){	// 画像挿入あれば
			if(is_array($img_array)){$body_image = implode("<br>", $img_array);}
			else{$body_image = $img_array;}
			if($image_position == 0){$newodaibody = $body_image . "<br>" . $newodaibody ;}
			if($image_position == 1){$newodaibody = $newodaibody . "<br>" . $body_image ;}
		}
		$newodaiddata = $newodaititle . "," . $newodaibody . "," . $limit0date . "," . $newodai_pre_disp .",". $limit1date . "," . $limit2date . "," . $newodai_mode . "," . $newcmt_mode . "," . $newpostlimit . "," . $newanaume1 . "," . $newanaume2 . "," . $newp4v . "," . $newp4limit . "," . $newp3v . "," . $newp3limit . "," . $newp2v . "," . $newp2limit . "," . $newchk_count . "," . $newvoter_disp . "," . $newodai_pre_body . "," . $newvote_self . "," . $newvote_bonus . "," . $newodai_manual . "," . $newdeadline ;
		$odaidataurl = "log2/" . $inputid . ".csv";
		if( !file_exists($odaidataurl) ){
			touch($odaidataurl);
		}
		$fp = fopen("$odaidataurl", "w");
		flock($fp, LOCK_SH);
		fwrite($fp, "$newodaiddata");
		flock($fp, LOCK_UN);
		fclose($fp);
		$fp2 = fopen("$odaiindexurl", "w");
		flock($fp2, LOCK_SH);
		if(isset($inputnew)){
			fwrite($fp2, "$inputid,$newodaititle,$limit0date,$limit1date,$limit2date,$newodai_manual,$newdeadline\n");
			foreach($odaiindex as $v){
				fwrite($fp2, "$v");
			}
		}else{
			foreach($odaiindex as $i => $v){
				$line = explode(",", $v);
				if($line[0]==$inputid){
					$v = "$inputid,$newodaititle,$limit0date,$limit1date,$limit2date,$newodai_manual,$newdeadline\n";
				}
				fwrite($fp2, "$v");
			}
		}
		flock($fp2, LOCK_UN);
		fclose($fp2);
		echo thanks("送信されました");
		exit;
	}
	if ($_SESSION["deleteodai"] and $_GET['s']=="delete") {	// お題削除作業ここから
		$deletekey = $_SESSION["sdeletekey"];
		$odaiurl = "log2/" . $deletekey . ".csv";
		$bokeurl = "log2/" . $deletekey . "boke.csv";
		$voteurl = "log2/" . $deletekey . "vote.csv";
		if ( file_exists($odaiurl)) {
			unlink($odaiurl);
		}
		if ( file_exists($bokeurl)) {
			unlink($bokeurl);
		}
		if ( file_exists($voteurl)) {
			unlink($voteurl);
		}
		$fp = fopen("$odaiindexurl", "w");
		flock($fp, LOCK_SH);
		foreach($odaiindex as $i => $v){
			$line = explode(",", $v);
			if($line[0]==$deletekey){
				unset($odaiindex[$i]);
				foreach ($odaiindex as $value) {
						fwrite($fp, "$value");
				}
			}
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		echo thanks("削除されました");
		$_SESSION = array();
		session_destroy();
		exit;
	}	// お題削除作業ここまで
	if ($_POST["DELETE_ODAI"]) {	// お題削除確認画面ここから
		if($_POST["DELETE"]){
		$deletekey = $_POST["DELETE"];
		$inputid = $deletekey;
		$odaidataurl = "log2/" . $inputid . ".csv";
		$odaidatafile = file($odaidataurl);
		$odaidata = explode(",", $odaidatafile[0]);
		$_SESSION["sdeletekey"] = $deletekey;
		$_SESSION["deleteodai"] = 'ok';
		echo "<div id='container'><div id='box_table'><table id='main'><tr class='header_title'><td colspan='4'>{$sitename}</td></tr><tr class='header1'><td colspan='4'>◆削除内容の確認　<span class='note'>※まだ削除されていません</span><br>◆この内容でよろしければ削除ボタンを押してください。<br>◆変更する場合はブラウザのバックで戻って変更してください。</td></tr><tr class='header2'><td colspan='4'>第{$deletekey}回お題</td></tr><tr class='odai'><td colspan='4'>{$odaidata[1]}</td></tr><tr><td class='boke_cell2' colspan='4'><table><form method='post' action='admin2.php?s=delete' accept-charset='utf-8'><tr class='postform'><td><input type='submit' name='DELETE_ODAI' value='お題を削除する' class='button'></td></tr></form></table></td></tr></table></div></div><div class='footer_c'><a href='http://bokegram.web.fc2.com/'>- Bokegram -</a></div></body></html>";
		exit;
		}else{
		echo "<table class='error'><tr><td class='error_header'>エラー</td></tr><tr><td class='error_body'>不正なアクセスです<br><a href='./admin2.php'>戻る</a></td></tr></table></body></html>";
			$_SESSION = array();
			session_destroy();
			exit;
		}
	}	// お題削除確認画面ここまで

	if ($_POST["DELETE_DATA"]) {	// データ削除作業ここから
		$inputid = $_POST["INPUTID"];
		$bokeurl = "log2/" . $inputid . "boke.csv";
		$bokedata = file($bokeurl);
		$cmtchk = $_POST["CMTCHK"];
		$votechk = $_POST["VOTECHK"];
		$bokechk = $_POST["BOKECHK"];
		if(!$cmtchk and !$votechk and !$bokechk){
			echo error_message("エラー","何も選択されていません");
			exit;
		}
		$fp = fopen("$bokeurl", "w");
		flock($fp, LOCK_SH);
		if($cmtchk){	// 指定したコメントの削除作業ここから
			$delcmt_array = $_POST["CMTCHK"];
			krsort($delcmt_array);
			foreach($delcmt_array as $delcmt_value){
				$deletecomment = explode(",", $delcmt_value);
				foreach($bokedata as $i => $v){
					if($i==$deletecomment[0]){	// 指定したボケ探し
						$line = explode(",", $v);
						$commentdataarray = explode("\c", $line[7]);
						unset($commentdataarray[$deletecomment[1]]);
						$line[7]=implode("\c", $commentdataarray);
						$v=implode(",", $line);
						$bokedata[$i] = $v;
					}else{$bokedata[$i] = $v;}
				}
			}
		}	// 指定したコメントの削除作業ここまで
		if($votechk){	// 指定した投票の削除作業ここから
			$delvote_array = $_POST["VOTECHK"];
			krsort($delvote_array);
			foreach($delvote_array as $delvote_value){
				$deletevote = explode(",", $delvote_value);
				foreach($bokedata as $i => $v){
					if($i==$deletevote[0]){
						$line = explode(",", $v);
						$votedataarray = explode("\v", $line[6]);
						unset($votedataarray[$deletevote[1]]);
						$line[6]=implode("\v", $votedataarray);
						$v=implode(",", $line);
						$bokedata[$i] = $v;
					}else{$bokedata[$i] = $v;}
				}
			}
		}	// 指定した投票の削除作業ここまで
		if($bokechk){	// 指定したボケの削除作業ここから
			$delboke_array= $_POST["BOKECHK"];
			krsort($delboke_array);
			foreach($delboke_array as $delboke_value){
				unset($bokedata[$delboke_value]);
			}
		}	// 指定したボケの削除作業ここまで
		foreach($bokedata as $v){	// 書き込み
			fwrite($fp, "$v");
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		echo thanks("削除されました");
		exit;
	}	// データ削除作業ここまで
	if ($_POST["DELETE_IMAGE"]) {	// 画像削除作業ここから
		if($_POST["IMAGECHK"]){
			$delimage_array = $_POST["IMAGECHK"];
			foreach($delimage_array as $delimage_value){
				unlink("./image/$delimage_value");
			}
			echo thanks("削除されました");
			exit;
		}else{
			echo error_message("エラー","何も選択されていません");
			exit;
		}
	}	// 画像削除作業ここまで
	if ($_POST["SUBMIT_SETTING"]) {	// 設定作業ここから
		$newsitename = $_POST["SITENAME"];
		$newhomepage = $_POST["HOMEPAGE"];;
		$newpageby = $_POST["PAGEBY"];
		$newodaiby = $_POST["ODAIBY"];
		$newvotelimit = $_POST["VOTELIMIT"];
		$newvote_report = $_POST["VOTE_REPORT"];
		$newbodylimit = $_POST["BODYLIMIT"];
		$newcmt_bodylimit = $_POST["CMT_BODYLIMIT"];
		$newtweet_button = $_POST["TWEET_BUTTON"];
		$newdescription = $_POST["DESCRIPTION"];
		if(!preg_match("/^[0-9]+$/",$newpageby) or !preg_match("/^[0-9]+$/",$newodaiby) or !preg_match("/^[0-9]+$/",$newbodylimit) or !preg_match("/^[0-9]+$/",$newcmt_bodylimit)){
			echo error_message("設定エラー","数値の欄には半角数字のみを入力してください");
			exit;
		}
		if($newpageby <= 0){
			echo error_message("設定エラー","0より大きい数値を入力してください");
			exit;
		}
		if($newbodylimit < 0 or $newcmt_bodylimit < 0){
			echo error_message("設定エラー","正の数値を入力してください");
			exit;
		}
		if($newsitename==""){
			echo error_message("設定エラー","サイト名が空欄です");
			exit;
		}
		$newsitename = htmlspecialchars("$newsitename", ENT_QUOTES);
		$newhomepage = htmlspecialchars("$newhomepage", ENT_QUOTES);
		if( get_magic_quotes_gpc() ) { $newsitename = stripslashes("$newsitename"); }
		if( get_magic_quotes_gpc() ) { $newhomepage = stripslashes("$newhomepage"); }
		if( !get_magic_quotes_gpc() ) { $newdescription = addslashes("$newdescription"); }
		$newdescription = str_replace("\r\n", "<br>", $newdescription);
		if( get_magic_quotes_gpc() ) {$newdescription = str_replace("\"", "'", $newdescription);}
		else{$newdescription = str_replace("\"", "\'", $newdescription);}
		$newsetting = "sitename = \"".$newsitename."\"\n"."homepage = \"".$newhomepage."\"\n"."pageby = \"".$newpageby."\"\n"."odaiby = \"".$newodaiby."\"\n"."votelimit = \"".$newvotelimit."\"\n"."bodylimit = \"".$newbodylimit."\"\n"."cmt_bodylimit = \"".$newcmt_bodylimit."\"\n"."tweet_button = \"".$newtweet_button."\"\n"."description = \"".$newdescription."\"\n"."vote_report = \"".$newvote_report."\"";
		$settingurl = "log2/setting.ini";
		$fp = fopen("$settingurl", "w");
		flock($fp, LOCK_SH);
		fwrite($fp, "$newsetting");
		flock($fp, LOCK_UN);
		fclose($fp);
		echo thanks("設定されました");
		exit;
	}	// 設定作業ここまで
	if ($_POST["SUBMIT_DESIGN"]) {	// デザイン設定作業ここから
		$body_color = $_POST["BODY_COLOR"]; // 文字色
		$a_color = $_POST["A_COLOR"]; // リンク文字色
		$a_visited_color = $_POST["A_VISITED_COLOR"]; // 訪問済みリンク文字色
		$a_hover_color = $_POST["A_HOVER_COLOR"]; // カーソルを乗せたときのリンク文字色
		$body_bgcolor = $_POST["BODY_BGCOLOR"]; // ページ背景色
		$body_bgimage = $_POST["BODY_BGIMAGE"]; // ページ背景画像ファイル名
		$body_bgimage_tile = $_POST["BODY_BGIMAGE_TILE"]; // ページ背景画像をタイルさせるか（0ならタイル）
		$table_border_color = $_POST["TABLE_BORDER_COLOR"]; // テーブル外枠線色
		$td_border_color = $_POST["TD_BORDER_COLOR"]; // テーブル内枠線色
		$td_bgcolor = $_POST["TD_BGCOLOR"]; // テーブル内背景色
		$title_color = $_POST["TITLE_COLOR"]; // タイトル文字色
		$title_bgcolor = $_POST["TITLE_BGCOLOR"]; // タイトルバー背景色
		$header_color = $_POST["HEADER_COLOR"]; // ヘッダー文字色
		$header_bgcolor = $_POST["HEADER_BGCOLOR"]; // ヘッダー背景色
		$headline_color = $_POST["HEADLINE_COLOR"]; // 見出し欄文字色
		$headline_bgcolor = $_POST["HEADLINE_BGCOLOR"]; // 見出し欄背景色
		$odai_color = $_POST["ODAI_COLOR"]; // お題文文字色
		$odai_bgcolor = $_POST["ODAI_BGCOLOR"]; // お題文背景色
		$boke_color = $_POST["BOKE_COLOR"]; // ボケ一覧ページでのボケ文字色
		$boke2_color = $_POST["BOKE2_COLOR"]; // ボケ個別ページでのボケ文字色
		$boke2_bgcolor = $_POST["BOKE2_BGCOLOR"]; // ボケ個別ページでのボケ背景色
		$anaume_color = $_POST["ANAUME_COLOR"]; // 穴埋め問題文字色
		$limit_color = $_POST["LIMIT_COLOR"]; // 締め切り日文字色
		$post_color = $_POST["POST_COLOR"]; // 投稿欄文字色
		$post_bgcolor = $_POST["POST_BGCOLOR"]; // 投稿欄背景色
		$textarea_color = $_POST["TEXTAREA_COLOR"]; // 文字入力欄文字色
		$textarea_bgcolor = $_POST["TEXTAREA_BGCOLOR"]; // 文字入力欄背景色
		$button_color = $_POST["BUTTON_COLOR"]; // ボタン文字色
		$button_bgcolor = $_POST["BUTTON_BGCOLOR"]; // ボタン背景色
		$nav_button_bgcolor = $_POST["NAV_BUTTON_BGCOLOR"]; // ページナビボタン背景色
		$nav_button_current_bgcolor = $_POST["NAV_BUTTON_CURRENT_BGCOLOR"]; // 現在のページナビボタン背景色
		$description_color = $_POST["DESCRIPTION_COLOR"]; // 説明欄文字色
		$description_bgcolor = $_POST["DESCRIPTION_BGCOLOR"]; // 説明欄背景色
		$rank_color = $_POST["RANK_COLOR"]; // 順位・得点文字色
		$cmt_color = $_POST["CMT_COLOR"]; // コメント文字色
		$nav_button_color = $_POST["NAV_BUTTON_COLOR"]; // ページナビボタン文字色
		$nav_button_current_color = $_POST["NAV_BUTTON_CURRENT_COLOR"]; // 現在のページナビボタン文字色
		$design_check = array($body_color, $a_color, $a_visited_color, $a_hover_color, $body_bgcolor, $body_bgimage_tile, $table_border_color, $td_border_color, $td_bgcolor, $title_color, $title_bgcolor, $header_color, $header_bgcolor, $headline_color, $headline_bgcolor, $odai_color, $odai_bgcolor, $boke_color, $boke2_color, $boke2_bgcolor, $anaume_color, $limit_color, $post_color, $post_bgcolor, $textarea_color, $textarea_bgcolor, $button_color, $button_bgcolor, $nav_button_bgcolor, $nav_button_current_bgcolor, $description_color, $description_bgcolor, $rank_color, $cmt_color, $nav_button_color, $nav_button_current_color);
		foreach($design_check as $design_check_value){
			str_replace("#", "", $design_check_value);
			if(!preg_match("/^[a-fA-F0-9]+$/",$design_check_value) and !empty($design_check_value)){
				echo error_message("設定エラー","無効なカラーコードです");
				exit;
			}
		}
		$newdesign = "\n$body_color\n$a_color\n$a_visited_color\n$a_hover_color\n$body_bgcolor\n$body_bgimage\n$body_bgimage_tile\n$table_border_color\n$td_border_color\n$td_bgcolor\n$title_color\n$title_bgcolor\n$header_color\n$header_bgcolor\n$headline_color\n$headline_bgcolor\n$odai_color\n$odai_bgcolor\n$boke_color\n$boke2_color\n$boke2_bgcolor\n$anaume_color\n$limit_color\n$post_color\n$post_bgcolor\n$textarea_color\n$textarea_bgcolor\n$button_color\n$button_bgcolor\n$nav_button_bgcolor\n$nav_button_current_bgcolor\n$description_color\n$description_bgcolor\n$rank_color\n$cmt_color\n$nav_button_color\n$nav_button_current_color";
		$designurl = "log2/user_css.csv";
		$fp = fopen("$designurl", "w");
		flock($fp, LOCK_SH);
		fwrite($fp, "$newdesign");
		flock($fp, LOCK_UN);
		fclose($fp);
		echo thanks("設定されました");
		exit;
	}	// デザイン設定作業ここまで
	if(isset($odaikey) & is_numeric($odaikey)){	// 過去お題編集時用の読み込み
		$odaidataurl = "log2/" . $odaikey . ".csv";
		if(isset($odaidataurl)){
			$odaidatafile = file($odaidataurl);
			$odaidata = explode(",", $odaidatafile[0]);
			$odaititle = $odaidata[0];
			$odaibody = $odaidata[1];
			$odaibody = str_replace("\n", "", $odaibody);
			$odaibody = str_replace("<br>", "\r\n", $odaibody);
			if(!empty($odaidata[2])){
				$limit0y = substr($odaidata[2], 0, 4);	// 受付開始年
				$limit0m = substr($odaidata[2], 4, 2);	// 受付開始月
				$limit0d = substr($odaidata[2], 6, 2);	// 受付開始日
				$limit0H = substr($odaidata[2], 8, 2);	// 受付開始時
				$limit0i = substr($odaidata[2], 10, 2);	// 受付開始分
			}
			$odai_pre_disp = $odaidata[3];
			$limit1y = substr($odaidata[4], 0, 4);	// 投稿締切年
			$limit1m = substr($odaidata[4], 4, 2);	// 投稿締切月
			$limit1d = substr($odaidata[4], 6, 2);	// 投稿締切日
			$limit1H = substr($odaidata[4], 8, 2);	// 投稿締切時
			$limit1i = substr($odaidata[4], 10, 2);	// 投稿締切分
			$limit2y = substr($odaidata[5], 0, 4);	// 投票締切年
			$limit2m = substr($odaidata[5], 4, 2);	// 投票締切月
			$limit2d = substr($odaidata[5], 6, 2);	// 投票締切日
			$limit2H = substr($odaidata[5], 8, 2);	// 投票締切時
			$limit2i = substr($odaidata[5], 10, 2);	// 投票締切分
			$odai_mode = $odaidata[6];
			$cmt_mode = $odaidata[7];
			$postlimit = $odaidata[8];
			$anaume1 = $odaidata[9];
			$anaume2 = $odaidata[10];
			$p4v = $odaidata[11];	// 点aの点数
			$p4limit = $odaidata[12];	// 点aの制限数
			$p3v = $odaidata[13];	// 点bの点数
			$p3limit = $odaidata[14];	// 点bの制限数
			$p2v = $odaidata[15];	// 点cの点数
			$p2limit = $odaidata[16];	// 点cの制限数
			$chk_count = $odaidata[17];	// 一つの作品への重複チェック　0なら制限、1なら許可
			$voter_disp = $odaidata[18];	// 投票者公開モード（0が公開、1が非公開）
			$odai_pre_body = $odaidata[19];	// 投稿受付前にお題非表示設定にした際に、受付前に表示しておく文章（空欄だと「投稿受付開始前です。」に）
			$vote_self = $odaidata[20];	// 自薦禁止
			$vote_bonus = $odaidata[21];	// 投票ボーナス
			$odai_manual = $odaidata[22];	// 0なら自動、1なら投稿、2なら投票、3なら結果、4なら準備、5なら掲示、6なら凍結
			$deadline = $odaidata[23];
		}
	}
	$cssdataurl = "log2/user_css.csv";
	if( !file_exists($cssdataurl) ){
		touch($cssdataurl);
	}
	$cssdata = file($cssdataurl);

	$user_edit = $cssdata[0]; // 自由記入欄から
	$body_color = $cssdata[1]; // 文字色
	$a_color = $cssdata[2]; // リンク文字色
	$a_visited_color = $cssdata[3]; // 訪問済みリンク文字色
	$a_hover_color = $cssdata[4]; // カーソルを乗せたときのリンク文字色
	$body_bgcolor = $cssdata[5]; // ページ背景色
	$body_bgimage = $cssdata[6]; // ページ背景画像ファイル名
	$body_bgimage_tile = $cssdata[7]; // ページ背景画像をタイルさせるか（0ならタイル）
	$table_border_color = $cssdata[8]; // テーブル外枠線色
	$td_border_color = $cssdata[9]; // テーブル内枠線色
	$td_bgcolor = $cssdata[10]; // テーブル内背景色
	$title_color = $cssdata[11]; // タイトル文字色
	$title_bgcolor = $cssdata[12]; // タイトルバー背景色
	$header_color = $cssdata[13]; // ヘッダー文字色
	$header_bgcolor = $cssdata[14]; // ヘッダー背景色
	$headline_color = $cssdata[15]; // 見出し欄文字色
	$headline_bgcolor = $cssdata[16]; // 見出し欄背景色
	$odai_color = $cssdata[17]; // お題文文字色
	$odai_bgcolor = $cssdata[18]; // お題文背景色
	$boke_color = $cssdata[19]; // ボケ一覧ページでのボケ文字色
	$boke2_color = $cssdata[20]; // ボケ個別ページでのボケ文字色
	$boke2_bgcolor = $cssdata[21]; // ボケ個別ページでのボケ背景色
	$anaume_color = $cssdata[22]; // 穴埋め問題文字色
	$limit_color = $cssdata[23]; // 締め切り日文字色
	$post_color = $cssdata[24]; // 投稿欄文字色
	$post_bgcolor = $cssdata[25]; // 投稿欄背景色
	$textarea_color = $cssdata[26]; // 文字入力欄文字色
	$textarea_bgcolor = $cssdata[27]; // 文字入力欄背景色
	$button_color = $cssdata[28]; // ボタン文字色
	$button_bgcolor = $cssdata[29]; // ボタン背景色
	$nav_button_bgcolor = $cssdata[30]; // ページナビボタン背景色
	$nav_button_current_bgcolor = $cssdata[31]; // 現在のページナビボタン背景色
	$description_color = $cssdata[32]; // 説明欄文字色
	$description_bgcolor = $cssdata[33]; // 説明欄背景色
	$rank_color = $cssdata[34]; // 順位・得点文字色
	$cmt_color = $cssdata[35]; // コメント文字色
	$nav_button_color = $cssdata[36]; // ページナビボタン文字色
	$nav_button_current_color = $cssdata[37]; // 現在のページナビボタン文字色

	echo "<div id='container'><div id='box_table'><table id='main'><tr class='header_title'><td colspan='4'><a href='./admin2.php' class='sitetitle'>{$sitename}</a></td></tr><tr class='header1'><td colspan='4'>◆管理人モードです。</td></tr>";
	echo "<tr class='header2'><td colspan='4' class='menutab'><form method='GET' class='inlineform'><input type='hidden' name='l' value='1'><input type='submit' value='お題一覧' class='button'></form><form method='GET' class='inlineform'><input type='hidden' name='odai' value='new'><input type='submit' value='新規お題作成' class='button'></form><form method='GET' class='inlineform'><input type='hidden' name='file' value='1'><input type='submit' value='画像ファイル一覧を開く' class='button'></form><form method='GET' class='inlineform'><input type='hidden' name='p' value='setting'><input type='submit' value='ボケグラムの設定' class='button'></form><form method='GET' class='inlineform'><input type='hidden' name='p' value='design'><input type='submit' value='デザインの設定' class='button'></form></td></tr>";
	if(!isset($listkey)){$listkey = 1;}
	if(!isset($odaikey) and !isset($bokekey ) and !isset( $votekey ) and !isset( $filekey ) and !isset( $pagekey)){	// お題一覧画面
	echo"<tr class='header_info'><td class='nolist' nowrap>回</td><td class='titlelist'>タイトル</td><td class='infolist' nowrap>状態</td><td class='limitlist' nowrap>締め切り</td></tr>";
	$L = $listkey ;
	$Pd = $L-1;
	$pageby = 10;
	for($i=$Pd*$pageby;$i<$Pd*$pageby+$pageby;$i++) {
		$i2=$i+1;
		$viewo = explode(",", $odaiindex[$i]);
		$limit0y = substr($viewo[2], 0, 4);	// 受付開始年
		$limit0m = substr($viewo[2], 4, 2);	// 受付開始月
		$limit0d = substr($viewo[2], 6, 2);	// 受付開始日
		$limit0H = substr($viewo[2], 8, 2);	// 受付開始時
		$limit1y = substr($viewo[3], 0, 4);	// 投稿締切年
		$limit1m = substr($viewo[3], 4, 2);	// 投稿締切月
		$limit1d = substr($viewo[3], 6, 2);	// 投稿締切日
		$limit1H = substr($viewo[3], 8, 2);	// 投稿締切時
		$limit2y = substr($viewo[4], 0, 4);	// 投票締切年
		$limit2m = substr($viewo[4], 4, 2);	// 投票締切月
		$limit2d = substr($viewo[4], 6, 2);	// 投票締切日
		$limit2H = substr($viewo[4], 8, 2);	// 投票締切時
		$id = $viewo[0];
		$title = $viewo[1];
		$odai_manual = $viewo[5];
		$deadline = $viewo[6];
		if(empty($odai_manual)){
			if ($viewo[2] < date("YmdHis") and $viewo[3] >= date("YmdHis") ) {$odai_manual = 1;$deadline = "{$limit1m}月{$limit1d}日{$limit1H}時";}
			if ($viewo[3] < date("YmdHis") and $viewo[4] >= date("YmdHis") ) {$odai_manual = 2;$deadline = "{$limit2m}月{$limit2d}日{$limit2H}時";}
			if(!empty($viewo[4])){if ($viewo[4] < date("YmdHis") ) {$odai_manual = 3;}}
			if ($viewo[2] >= date("YmdHis") ) {$odai_manual = 4;$deadline = "--";}
		}
	// 準備ページへのリンク
		if ($odai_manual==4) {
		echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}{$i2}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>準備</td><td class='limitlist'>{$deadline}</td></tr>";
		}

	// 投稿ページへのリンク
		if ($odai_manual==1) {
		echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>投稿</td><td class='limitlist'><span class='limit'>{$deadline}</span></td></tr>";
		}

	// 投票ページへのリンク
		if ($odai_manual==2) {
		echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>投票</td><td class='limitlist'><span class='limit'>{$deadline}</span></td></tr>";
		}

	// 結果ページへのリンク
		if ($odai_manual==3) {
			echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>結果</td><td class='limitlist'>終了</td></tr>";
		}

	// 掲示ページへのリンク
		if ($odai_manual==5) {
			echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>掲示</td><td class='limitlist'>{$deadline}</td></tr>";
		}

	// 凍結ページへのリンク
		if ($odai_manual==6) {
			echo "<tr class='list'><td class='nolist' nowrap>{$id}</td><td class='titlelist'><div><a href='pagevent2.php?id={$id}' target='_blank'>{$title}</a></div><div><span class='odaidata'><a href='admin2.php?odai={$id}'>編集</a></span><span class='odaidata'><a href='admin2.php?boke={$id}'>作品データ</a></span><span class='odaidata'><a href='admin2.php?vote={$id}'>投票者一覧</a></span><span class='odaidata'><a href='' onclick='document.form_del{$i2}.submit();return false;'>この回を削除</a></span><form method='post' name='form_del{$i2}' class='inlineform'><input type='hidden' name='DELETE' value='{$id}'><input type='hidden' name='DELETE_ODAI' value='del'></form><span class='odaidata'><a href='' onclick='document.form_u{$i2}.submit();return false;'>上へ</a></span><form method='post' class='inlineform' name='form_u{$i2}'><input type='hidden' name='ODAI_UP' value='{$i2}'></form><span class='odaidata'><a href='' onclick='document.form_d{$i2}.submit();return false;'>下へ</a></span><form method='post' class='inlineform' name='form_d{$i2}'><input type='hidden' name='ODAI_DOWN' value='{$i2}'></form></div></td><td class='infolist' nowrap>凍結</td><td class='limitlist'>{$deadline}</td></tr>";
		}

	}
	function paging($limit, $page, $disp=5){
	//$dispはページ番号の表示数
		$next = $page+1;
		$prev = $page-1;
		//ページ番号リンク用
		$start =  ($page-floor($disp/2)> 0) ? ($page-floor($disp/2)) : 1;//始点
		$end =  ($start> 1) ? ($page+floor($disp/2)) : $disp;//終点
		$start = ($limit <$end)? $start-($end-$limit):$start;//始点再計算
		if($page != 1 ) {
			print '<a href="?l='.$prev.'">&lt;&lt; 前へ</a>';
		}
		//最初のページへのリンク
		if($start>= floor($disp/2)){
			print '<a href="?l=1">1</a>';
			if($start> floor($disp/2)) print "..."; //ドットの表示
		}
		for($i=$start; $i <= $end ; $i++){//ページリンク表示ループ
			$class = ($page == $i) ? ' class="current"':"";//現在地を表すCSSクラス
			if($i <= $limit && $i> 0 )//1以上最大ページ数以下の場合
			print '<a href="?l='.$i.'"'.$class.'>'.$i.'</a>';//ページ番号リンク表示
		}
		//最後のページへのリンク
		if($limit> $end){
			if($limit-1> $end ) print "...";	//ドットの表示
			print '<a href="?l='.$limit.'">'.$limit.'</a>';
		}
		if($page <$limit){
			print '<a href="?l='.$next.'">次へ &gt;&gt;</a>';
		}
	}
	$Size=sizeof($odaiindex);
	$limit = ceil($Size/$pageby);//最大ページ数
	if(isset($_GET["l"])){$page = $_GET["l"];}else{$page = 1;};	//ページ番号
	echo "<tr><td colspan='4' class='pagenav'>PAGE：";paging($limit, $page);echo"</td></tr>";
	}
	if(isset($odaikey)){	// お題編集画面
		if($odaikey=="new"){	// 新規お題画面
		$odaiindexurl = "log2/odaidata.csv";
		$odaiindex = file("log2/odaidata.csv");
		$lastno = 0;
		foreach($odaiindex as $value){
			$line = explode(",", $value);
			if($line[0]>$lastno){$lastno = $line[0];}
		}
		$newid=$lastno+1;
		echo"<tr class='header1'><td colspan='4'>◆第{$newid}回のお題を作成</td></tr>
<form enctype='multipart/form-data' method='post' accept-charset='UTF-8' name='odaiform'>
<tr><td colspan='2' class='edit_l' nowrap>タイトル</td><td colspan='2' class='edit_r'><input type='text' name='TITLE' value='' class='inputform'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題本文</td><td colspan='2' class='edit_r'><textarea wrap='soft' name='BODY'></textarea><br><ul><li>画像はimgタグで直接貼ることも可能です。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題画像</td><td colspan='2' class='edit_r'><input type='hidden' name='MAX_FILE_SIZE' value='300000'><input type='file' name='IMG_1' size='30' class='inputfile'><br><input type='file' name='IMG_2' size='30' class='inputfile'><br><input type='file' name='IMG_3' size='30' class='inputfile'><br><span>画像をお題文の<select name='IMAGE_POSITION'><option value='0'>上部</option><option value='1'>下部</option></select>に挿入</span><br><ul><li>拡張子が（jpg,jpeg,png,gif）のファイルに対応。</li><li>ファイルサイズは300KBまでです。</li><li>横幅が400ピクセルを超えた場合、縮小して表示されます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>状態</td><td colspan='2' class='edit_r'><select name='ODAI_MANUAL'><option value='0'>自動切替</option><option value='1'>投稿</option><option value='2'>投票</option><option value='3'>結果</option><option value='4'>準備</option><option value='5'>掲示</option><option value='6'>凍結</option></select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>手動時の締切日時</td><td colspan='2' class='edit_r'><input type='text' name='DEADLINE' value='' class='inputform'><br><ul><li>状態を「自動切替」以外に設定した場合に適用されます。</li><li>「未定」「◯時頃」など自由に記入できます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>予約投稿</td><td colspan='2' class='edit_r'><div>する<input type='radio'  name='PREPOST' value='1' onClick='setTextField(false)'>　しない<input type='radio' name='PREPOST' value='0'  onClick='setTextField(true)' checked><br><ul><li>状態が「自動切替」の場合のみ有効になります。</li></ul></div><div>
<table class='cmt_box'>
<tr><td class='cmt_l' nowrap>受付開始時刻</td><td class='cmt_r'><select name='LIMIT0Y' disabled>";
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>".date("Y", strtotime("+$i year"))."</option>";}
		else{echo "<option>".date("Y", strtotime("+$i year"))."</option>";}
	}
	echo"</select> 年　<select name='LIMIT0M' disabled>";
	$m = date("m");
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT0D' disabled>";
	$d = date("d");
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT0H' disabled>";
	$h = date("H");
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$h){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td class='cmt_l' nowrap>お題公開設定</td><td class='cmt_r'><select name='PRE_DISP' disabled><option value='0'>投稿受付前にお題文を表示する（公開）</option><option value='1'>投稿受付前にお題文を表示しない（非公開）</option></select></td></tr>
<tr><td class='cmt_l' nowrap>準備中の<br>メッセージ</td><td class='cmt_r'>お題を非公開に設定した場合に表示されるメッセージです。空欄の場合は「投稿受付開始前です。」と表示されます。<br><textarea wrap='soft' name='ODAI_PRE_BODY' class='pre_textarea' disabled></textarea></td></tr>
</table></div></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>自動投稿締切</td><td colspan='2' class='edit_r'><select name='LIMIT1Y'>";
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>".date("Y", strtotime("+$i year"))."</option>";}
		else{echo "<option>".date("Y", strtotime("+$i year"))."</option>";}
	}
	echo"</select> 年　<select name='LIMIT1M'>";
	$m = date("m");
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT1D'>";
	$d = date("d");
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT1H'>";
	$h = date("H");
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$h){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
	<tr><td colspan='2' class='edit_l' nowrap>自動投票締切</td><td colspan='2' class='edit_r'>	<select name='LIMIT2Y'>";
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>".date("Y", strtotime("+$i year"))."</option>";}
		else{echo "<option>".date("Y", strtotime("+$i year"))."</option>";}
	}
	echo"</select> 年　<select name='LIMIT2M'>";
	$m = date("m");
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT2D'>";
	$d = date("d");
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT2H'>";
	$h = date("H");
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$h){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数A</td><td colspan='2' class='edit_r'><input type='text' name='P4V' value='4' class='inputform2'>点（必ず0以外の数字を入力してください）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Aの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P4LIMIT' value='' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数B</td><td colspan='2' class='edit_r'><input type='text' name='P3V' value='3' class='inputform2'>点（0・空欄の場合は使用しません）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Bの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P3LIMIT' value='' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数C</td><td colspan='2' class='edit_r'><input type='text' name='P2V' value='2' class='inputform2'>点（0・空欄の場合は使用しません）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Cの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P2LIMIT' value='' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>自薦禁止</td><td colspan='2' class='edit_r'><select name='VOTE_SELF'><option value='0'>制限しない</option><option value='1'>同一名の場合に制限</option><option value='2' selected>同一IPの場合に制限</option><option value='2'>同一名・もしくは同一IPの場合に制限</option></select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投票ボーナス</td><td colspan='2' class='edit_r'><input type='text' name='VOTE_BONUS' value='' class='inputform2'>点<ul><li>この回に投稿した人が投票に参加した際にもらえる点数</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>重複チェック</td><td colspan='2' class='edit_r'><select name='CHK_COUNT'><option value='0'>禁止</option><option value='1'>許可</option></select><ul><li>１作品内での投票の重複チェックを制限します。（2点と3点を両方付けた場合など）</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投稿採用数</td><td colspan='2' class='edit_r'><input type='text' name='POSTLIMIT' value='2' class='inputform2'>件（0の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投票者公開モード</td><td colspan='2' class='edit_r'><select name='VOTER_DISP'><option value='0'>投票者を公開する</option><option value='1'>投票者を公開しない</option></select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>作品へのコメント</td><td colspan='2' class='edit_r'><select name='CMT_MODE'><option value='0'>投票中・結果発表後ともに可能</option><option value='1'>投票中のみ可能</option><option value='2'>結果発表後のみ可能</option><option value='3'>コメントを受け付けない</option></select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題モード</td><td colspan='2' class='edit_r'><select name='ODAI_MODE'><option value='0'>一般お題</option><option value='1'>一言・穴埋めお題</option></select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>穴埋め用ワード1</td><td colspan='2' class='edit_r'><input type='text' name='ANAUME1' value='' class='inputform'><ul><li>一言・穴埋めお題モードを選んだ場合、作品の前方部分に挿入されます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>穴埋め用ワード2</td><td colspan='2' class='edit_r'><input type='text' name='ANAUME2' value='' class='inputform'><ul><li>一言・穴埋めお題モードを選んだ場合、作品の後方部分に挿入されます。</li></ul></td></tr>
<tr><td colspan='4'><input type='hidden' value='new' name='INPUTNEW'><input type='submit' name='SUBMIT_ODAI' value='送信' class='button'></td></tr></form>";
}else{	// 過去お題編集画面
echo"<tr class='header1'><td colspan='4'>◆第{$odaikey}回のお題を編集</td></tr>
<form enctype='multipart/form-data' method='post' accept-charset='utf-8' name='odaiform'>
<tr><td colspan='2' class='edit_l' nowrap>タイトル</td><td colspan='2' class='edit_r'><input type='text' name='TITLE' value='{$odaititle}' class='inputform'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題本文</td><td colspan='2' class='edit_r'><textarea wrap='soft' name='BODY'>{$odaibody}</textarea><br><ul><li>画像はimgタグで直接貼ることも可能です。</li><ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題画像</td><td colspan='2' class='edit_r'><input type='hidden' name='MAX_FILE_SIZE' value='300000'><input type='file' name='IMG_1' size='30' class='inputfile'><br><input type='file' name='IMG_2' size='30' class='inputfile'><br><input type='file' name='IMG_3' size='30' class='inputfile'><br><span>画像をお題文の<select name='IMAGE_POSITION'><option value='0'>上部</option><option value='1'>下部</option></select>に挿入</span><br><ul><li>拡張子が（jpg,jpeg,png,gif）のファイルに対応。</li><li>ファイルサイズは300KBまでです。</li><li>横幅が400ピクセルを超えた場合、縮小して表示されます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>状態</td><td colspan='2' class='edit_r'><select name='ODAI_MANUAL'>";
if($odai_manual==0){echo"<option value='0' selected>自動切替</option>";}else{echo"<option value='0'>自動切替</option>";}
if($odai_manual==1){echo"<option value='1' selected>投稿</option>";}else{echo"<option value='1'>投稿</option>";}
if($odai_manual==2){echo"<option value='2' selected>投票</option>";}else{echo"<option value='2'>投票</option>";}
if($odai_manual==3){echo"<option value='3' selected>結果</option>";}else{echo"<option value='3'>結果</option>";}
if($odai_manual==4){echo"<option value='4' selected>準備</option>";}else{echo"<option value='4'>準備</option>";}
if($odai_manual==5){echo"<option value='5' selected>掲示</option>";}else{echo"<option value='5'>掲示</option>";}
if($odai_manual==6){echo"<option value='6' selected>凍結</option>";}else{echo"<option value='6'>凍結</option>";}
echo"</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>手動時の締切日時</td><td colspan='2' class='edit_r'><input type='text' name='DEADLINE' value='$deadline' class='inputform'><br><ul><li>状態を自動切替以外に設定した場合に適用されます。</li><li>「未定」「◯時頃」など自由に記入できます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>予約投稿</td><td colspan='2' class='edit_r'><div>";
if(empty($odaidata[2])){echo "する<input type='radio'  name='PREPOST' value='1' onClick='setTextField(false)'>　しない<input type='radio' name='PREPOST' value='0'  onClick='setTextField(true)' checked>
<br><ul><li>状態が「自動切替」の場合のみ有効になります。</li><li>「しない」でお題設定が書き込まれると予約投稿の設定は破棄されます。</li></ul></div><div><table class='cmt_box'>
<tr><td class='cmt_l' nowrap>受付開始時刻</td><td class='cmt_r'><select name='LIMIT0Y' disabled>";
	if(!empty($limit0y)){$y = $limit0y - 4;}
	else{$y = $limit1y - 4;}
	if(empty($limit0m)){$limit0m = $limit1m ;}
	if(empty($limit0d)){$limit0d = $limit1d ;}
	if(empty($limit0H)){$limit0H = $limit1H ;}
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>{$y}</option>";}
		else{echo "<option>{$y}</option>";}
		$y++;
	}
	echo"</select> 年　<select name='LIMIT0M' disabled>";
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT0D' disabled>";
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT0H' disabled>";
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0H){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td class='cmt_l' nowrap>お題公開設定</td><td class='cmt_r'><select name='PRE_DISP' disabled>";
		if($odai_pre_disp==0){echo" <option value='0' selected>投稿受付前にお題文を表示する（公開）</option><option value='1'>投稿受付前にお題文を表示しない（非公開）</option>";}
		if($odai_pre_disp==1){echo" <option value='0'>投稿受付前にお題文を表示する（公開）</option><option value='1' selected>投稿受付前にお題文を表示しない（非公開）</option>";}
echo"</select></td></tr>
<tr><td class='cmt_l' nowrap>準備中の<br>メッセージ</td><td class='cmt_r'>お題を非公開に設定した場合に表示されるメッセージです。空欄の場合は「投稿受付開始前です。」と表示されます。<br><textarea wrap='soft' name='ODAI_PRE_BODY' class='pre_textarea' disabled>{$odai_pre_body}</textarea></td></tr>";}
else{echo "する<input type='radio'  name='PREPOST' value='1' onClick='setTextField(false)' checked>　しない<input type='radio' name='PREPOST' value='0'  onClick='setTextField(true)'>
<br><ul><li>「しない」でお題設定が書き込まれると予約投稿の設定は破棄されます。</li></ul></div><div><table class='cmt_box'>
<tr><td class='cmt_l' nowrap>受付開始時刻</td><td class='cmt_r'><select name='LIMIT0Y'>";
	if(!empty($limit0y)){$y = $limit0y - 4;}
	else{$y = $limit1y - 4;}
	if(empty($limit0m)){$limit0m = $limit1m ;}
	if(empty($limit0d)){$limit0d = $limit1d ;}
	if(empty($limit0H)){$limit0H = $limit1H ;}
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>{$y}</option>";}
		else{echo "<option>{$y}</option>";}
		$y++;
	}
	echo"</select> 年　<select name='LIMIT0M'>";
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT0D'>";
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT0H'>";
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit0H){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td class='cmt_l' nowrap>お題公開設定</td><td class='cmt_r'><select name='PRE_DISP'>";
		if($odai_pre_disp==0){echo" <option value='0' selected>投稿受付前にお題文を表示する（公開）</option><option value='1'>投稿受付前にお題文を表示しない（非公開）</option>";}
		if($odai_pre_disp==1){echo" <option value='0'>投稿受付前にお題文を表示する（公開）</option><option value='1' selected>投稿受付前にお題文を表示しない（非公開）</option>";}
echo"</select></td></tr>
<tr><td class='cmt_l' nowrap>準備中の<br>メッセージ</td><td class='cmt_r'>お題を非公開に設定した場合に表示されるメッセージです。空欄の場合は「投稿受付開始前です。」と表示されます。<br><textarea wrap='soft' name='ODAI_PRE_BODY' class='pre_textarea'>{$odai_pre_body}</textarea></td></tr>";}
echo"</table></div></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>自動投稿締切</td><td colspan='2' class='edit_r'><select name='LIMIT1Y'>";
	$y = $limit1y - 4;
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>{$y}</option>";}
		else{echo "<option>{$y}</option>";}
		$y++;
	}
	echo"</select> 年　<select name='LIMIT1M'>";
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit1m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT1D'>";
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit1d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT1H'>";
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit1H){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>自動投票締切</td><td colspan='2' class='edit_r'><select name='LIMIT2Y'>";
	$y = $limit2y - 4;
	for ($i = -4; $i < 5; $i++) {
		if($i==0){echo "<option selected>{$y}</option>";}
		else{echo "<option>{$y}</option>";}
		$y++;
	}
	echo"</select> 年　<select name='LIMIT2M'>";
	for ($i = 1; $i < 13; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit2m){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 月　<select name='LIMIT2D'>";
	for ($i = 1; $i < 32; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit2d){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 日　<select name='LIMIT2H'>";
	for ($i = 0; $i < 25; $i++) {
		$i = sprintf("%02d", $i);
		if($i==$limit2H){echo "<option selected>{$i}</option>";}
		else{echo "<option>{$i}</option>";}
	}
	echo"</select> 時</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数A</td><td colspan='2' class='edit_r'><input type='text' name='P4V' value='{$p4v}' class='inputform2'>点（必ず0以外の数字を入力してください）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Aの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P4LIMIT' value='{$p4limit}' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数B</td><td colspan='2' class='edit_r'><input type='text' name='P3V' value='{$p3v}' class='inputform2'>点（0・空欄の場合は使用しません）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Bの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P3LIMIT' value='{$p3limit}' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数C</td><td colspan='2' class='edit_r'><input type='text' name='P2V' value='{$p2v}' class='inputform2'>点（0・空欄の場合は使用しません）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>点数Cの使用制限数</td><td colspan='2' class='edit_r'><input type='text' name='P2LIMIT' value='{$p2limit}' class='inputform2'>個まで（0・空欄の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>自薦禁止</td><td colspan='2' class='edit_r'><select name='VOTE_SELF'>";
	if(empty($vote_self)){echo"<option value='0' selected>制限しない</option><option value='1'>同一名の場合に制限</option><option value='2'>同一IPの場合に制限</option><option value='2'>同一名・もしくは同一IPの場合に制限</option>";}
	if($vote_self==1){echo"<option value='0'>制限しない</option><option value='1' selected>同一名の場合に制限</option><option value='2'>同一IPの場合に制限</option><option value='3'>同一名・もしくは同一IPの場合に制限</option>";}
	if($vote_self==2){echo"<option value='0'>制限しない</option><option value='1'>同一名の場合に制限</option><option value='2' selected>同一IPの場合に制限</option><option value='3'>同一名・もしくは同一IPの場合に制限</option>";}
	if($vote_self==3){echo"<option value='0'>制限しない</option><option value='1'>同一名の場合に制限</option><option value='2'>同一IPの場合に制限</option><option value='3' selected>同一名・もしくは同一IPの場合に制限</option>";}
echo"</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投票ボーナス</td><td colspan='2' class='edit_r'><input type='text' name='VOTE_BONUS' value='{$vote_bonus}' class='inputform2'>点<ul><li>この回に投稿した人が投票に参加した際にもらえる点数</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>重複チェック</td><td colspan='2' class='edit_r'><select name='CHK_COUNT'>";
		if(empty($chk_count)){echo"<option value='0' selected>禁止</option><option value='1'>許可</option>";}
		if($chk_count==1){echo"<option value='0'>禁止</option><option value='1' selected>許可</option>";}
	echo"</select><ul><li>１作品内での投票の重複チェックを制限します。（2点と3点を両方付けた場合など）</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投稿採用数</td><td colspan='2' class='edit_r'><input type='text' name='POSTLIMIT' value='{$postlimit}' class='inputform2'>件（0の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投票者公開モード</td><td colspan='2' class='edit_r'><select name='VOTER_DISP'>";
		if(empty($voter_disp)){echo"<option value='0' selected>投票者を公開する</option><option value='1'>投票者を公開しない</option>";}
		if($voter_disp==1){echo"<option value='0'>投票者を公開する</option><option value='1' selected>投票者を公開しない</option>";}
echo "</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>作品へのコメント</td><td colspan='2' class='edit_r'><select name='CMT_MODE'>";
			if(empty($cmt_mode)){echo "<option value='0' selected>投票中・結果発表後ともに可能</option>";}else{echo "<option value='0'>投票中・結果発表後ともに可能</option>";}
			if($cmt_mode==1){echo "<option value='1' selected>投票中のみ可能</option>";}else{echo "<option value='1'>投票中のみ可能</option>";}
			if($cmt_mode==2){echo "<option value='2' selected>結果発表後のみ可能</option>";}else{echo "<option value='2'>結果発表後のみ可能</option>";}
			if($cmt_mode==3){echo "<option value='3' selected>コメントを受け付けない</option>";}else{echo "<option value='3'>コメントを受け付けない</option>";}
echo "</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題モード</td><td colspan='2' class='edit_r'><select name='ODAI_MODE'>";
			if(empty($odai_mode)){echo "<option value='0' selected>一般お題</option>";}else{echo "<option value='0'>一般お題</option>";}
			if($odai_mode==1){echo "<option value='1' selected>一言・穴埋めお題</option>";}else{echo "<option value='1'>一言・穴埋めお題</option>";}
echo "</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>穴埋め用ワード1</td><td colspan='2' class='edit_r'><input type='text' name='ANAUME1' value='{$anaume1}' class='inputform'><ul><li>一言・穴埋めお題モードを選んだ場合、作品の前方部分に挿入されます。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>穴埋め用ワード2</td><td colspan='2' class='edit_r'><input type='text' name='ANAUME2' value='{$anaume2}' class='inputform'><ul><li>一言・穴埋めお題モードを選んだ場合、作品の後方部分に挿入されます。</li></ul></td></tr>
<tr><td colspan='4'><input type='hidden' value='$odaikey' name='INPUTID'><input type='submit' name='SUBMIT_ODAI' value='送信' class='button'></td></tr></form>";
			}
	}
	if(isset($bokekey)){	// データ閲覧画面
echo"<tr class='header1'><td colspan='4'>◆第{$bokekey}回のデータ</td></tr><form method='post' accept-charset='utf-8'>";
		$odaidataurl = "log2/" . $bokekey . ".csv";
		if( file_exists($odaidataurl)) {
			$odaidatafile = file($odaidataurl);
			$odaidata = explode(",", $odaidatafile[0]);
			$vote_bonus = $odaidata[21];	// 投票ボーナス
		}
		$bokedataurl="log2/". $bokekey . "boke.csv";
		if( !file_exists($bokedataurl) ){
			touch($bokedataurl);
		}
		$bokedata = file($bokedataurl);
		$votedataurl = "log2/" . $bokekey . "vote.csv";
		if( !file_exists($votedataurl) ){
			touch($votedataurl);
		}
		$votedata = file($votedataurl);
		foreach($bokedata as $i => $v){
			$lineboke = explode(",", $v);
			$point=0;
			$rownum=9;
			if(!empty($vote_bonus)){$rownum++;}
echo"<tr class='header2'><td colspan='4'>No.{$i}</td></tr>
<tr><td class='edit_l' nowrap>お名前</td><td colspan='2' class='edit_r'>{$lineboke[0]}</td><td rowspan='{$rownum}'><input type='checkbox' name='BOKECHK[]' value='{$i}'></td></tr>
<tr><td class='edit_l' nowrap>ホームページ</td><td colspan='2' class='edit_r'>{$lineboke[1]}</td></tr>
<tr><td class='edit_l' nowrap>作品</td><td colspan='2' class='edit_r'>{$lineboke[2]}</td></tr>";
			$boke_y = substr($lineboke[3], 0, 4);	// 投稿年
			$boke_m = substr($lineboke[3], 4, 2);	// 投稿月
			$boke_d = substr($lineboke[3], 6, 2);	// 投稿日
			$boke_H = substr($lineboke[3], 8, 2);	// 投稿時
			$boke_i = substr($lineboke[3], 10, 2);	// 投稿分
echo"<tr><td class='edit_l' nowrap>投稿日時</td><td colspan='2' class='edit_r'>{$boke_y}年{$boke_m}月{$boke_d}日{$boke_H}時{$boke_i}分</td></tr>
<tr><td class='edit_l' nowrap>IPアドレス</td><td colspan='2' class='edit_r'>{$lineboke[4]}</td></tr>
<tr><td class='edit_l' nowrap>ホスト</td><td colspan='2' class='edit_r'>{$lineboke[5]}</td></tr>";
			$votedataarray=explode("\v", $lineboke[6]);
			foreach($votedataarray as $voteval){
				$votedataparts=explode("|", $voteval);
				$point+=(int)$votedataparts[0];
			}
			if(!empty($vote_bonus)){
				$isvote=false;
				foreach($votedata as $votevalue){
					$linev=explode(",", $votevalue);
					if($linev[0]==$lineboke[0]){$point+=$vote_bonus;$isvote=true;}	// 名前で判断（投票ボーナス）
				}
				if($isvote){echo"<tr><td class='edit_l' nowrap>投票</td><td colspan='2' class='edit_r'>○</td></tr>";}
				else{echo"<tr><td class='edit_l' nowrap>投票</td><td colspan='2' class='edit_r'>-</td></tr>";}
			}
echo"<tr><td class='edit_l' nowrap>総得点</td><td colspan='2' class='edit_r'>{$point}点</td></tr>
<tr><td class='edit_l' nowrap>投票者<br>(点|名前|IP)</td><td colspan='2' class='edit_r'>";
				for($k=0;$k<sizeof($votedataarray)-1;$k++){echo"<div><input type='checkbox' name='VOTECHK[]' value='{$i},{$k}'>：{$votedataarray[$k]}</div>";}
echo"</td></tr>
<tr><td class='edit_l' nowrap>コメント</td><td colspan='2' class='edit_r_cmt'>";
			if(!empty($lineboke[7])){	// コメントがあった場合
				$comments = explode("\c", $lineboke[7]);
				for($ci=0;$ci<sizeof($comments)-1;$ci++){
					$commentdata = explode("|", $comments[$ci]);
echo"<table class='cmt_box'>
<tr><td class='cmt_l' nowrap>お名前</td><td class='cmt_r'><div class='wordbreak_cmt'>{$commentdata[0]}</div></td><td rowspan='4'><input type='checkbox' name='CMTCHK[]' value='{$i},{$ci}'></td></tr>
<tr><td class='cmt_l' nowrap>コメント</td><td class='cmt_r'><div class='wordbreak_cmt'>{$commentdata[1]}</div></td></tr>
<tr><td class='cmt_l' nowrap>IPアドレス</td><td class='cmt_r'><div class='wordbreak_cmt'>{$commentdata[2]}</div></td></tr>
<tr><td class='cmt_l' nowrap>ホスト</td><td class='cmt_r'><div class='wordbreak_cmt'>{$commentdata[3]}</div></td></tr>
</table>";
				}
			}
echo"</td></tr>";
	}
	if(empty($bokedata)){echo"<tr><td colspan='4' class='menubody'>この回の投稿はありません。</td></tr>";}
	else{echo"<tr><td colspan='4'><input type='hidden' value='$bokekey' name='INPUTID'><input type='submit' name='DELETE_DATA' value='チェックを付けたものを削除' class='button'></td></tr>";}
echo"</form>";
	}


	if(isset($votekey)){	// 投票者一覧画面
echo"<tr class='header1'><td colspan='4'>◆第{$votekey}回の投票者一覧</td></tr>";
		$votedataurl="log2/". $votekey . "vote.csv";
		if( !file_exists($votedataurl) ){
			touch($votedataurl);
		}
		$votedata = file($votedataurl);
		foreach($votedata as $i => $v){
			$linevote = explode(",", $v);
echo"<tr class='header2'><td colspan='4'>No.{$i}</td></tr>
<tr><td class='edit_l'>お名前</td><td colspan='3' class='edit_r'>{$linevote[0]}</td></tr>
<tr><td class='edit_l'>ホームページ</td><td colspan='3' class='edit_r'>{$linevote[1]}</td></tr>";
			$vote_y = substr($linevote[2], 0, 4);	// 投票年
			$vote_m = substr($linevote[2], 4, 2);	// 投票月
			$vote_d = substr($linevote[2], 6, 2);	// 投票日
			$vote_H = substr($linevote[2], 8, 2);	// 投票時
			$vote_i = substr($linevote[2], 10, 2);	// 投票分
echo" <tr><td class='edit_l'>投票日時</td><td colspan='3' class='edit_r'>{$vote_y}年{$vote_m}月{$vote_d}日{$vote_H}時{$vote_i}分</td></tr>
<tr><td class='edit_l'>IPアドレス</td><td colspan='3' class='edit_r'>{$linevote[3]}</td></tr>
<tr><td class='edit_l'>ホスト</td><td colspan='3' class='edit_r'>{$linevote[4]}</td></tr>";
		}
		if(empty($votedata)){echo"<tr><td colspan='4' class='menubody'>この回の投票はありません。</td></tr>";}
	}
	if(isset($filekey) and preg_match("/^[0-9]+$/",$filekey)){	// 画像ファイル一覧画面
		echo"<form method='post' accept-charset='utf-8'>";
		if ($handle = opendir('./image')) {
			while (false !== ($filev = readdir($handle))){$file[] = $filev;}
			natsort($file);
			reset($file);
			$reverse = array_reverse($file, true);
			$fileby = 20;	// １ページあたりの画像ファイル表示件数
			$filekey = $filekey -1;
			$filestartkey = $filekey * $fileby;
			$fileendkey = $filestartkey + $fileby;
			$f = 0;
			foreach($reverse as $filevalue) {
				if ($filevalue != "." && $filevalue != "..") {
					if($f >= $filestartkey and $f < $fileendkey){echo "<tr><td class='edit_chk'><input type='checkbox' name='IMAGECHK[]' value='$filevalue'></td><td  class='edit_l'>$filevalue</td><td colspan='2' class='edit_r'><img src='./image/$filevalue'></td></tr>";}
					$f++;
				}
			}
			closedir($handle);
		}
		function paging($limit, $page, $disp=5){
		//$dispはページ番号の表示数
			$next = $page+1;
			$prev = $page-1;
			//ページ番号リンク用
			$start =  ($page-floor($disp/2)> 0) ? ($page-floor($disp/2)) : 1;//始点
			$end =  ($start> 1) ? ($page+floor($disp/2)) : $disp;//終点
			$start = ($limit <$end)? $start-($end-$limit):$start;//始点再計算
			if($page != 1 ) {
				print '<a href="?file='.$prev.'">&lt;&lt; 前へ</a>';
			}
			//最初のページへのリンク
			if($start>= floor($disp/2)){
				print '<a href="?file=1">1</a>';
				if($start> floor($disp/2)) print "..."; //ドットの表示
			}
			for($i=$start; $i <= $end ; $i++){//ページリンク表示ループ
				$class = ($page == $i) ? ' class="current"':"";//現在地を表すCSSクラス
				if($i <= $limit && $i> 0 )//1以上最大ページ数以下の場合
				print '<a href="?file='.$i.'"'.$class.'>'.$i.'</a>';//ページ番号リンク表示
			}
			//最後のページへのリンク
			if($limit> $end){
				if($limit-1> $end ) print "...";	//ドットの表示
				print '<a href="?file='.$limit.'">'.$limit.'</a>';
			}
			if($page <$limit){
				print '<a href="?file='.$next.'">次へ &gt;&gt;</a>';
			}
		}
		$limit = ceil($f / $fileby);//最大ページ数
		$page = $_GET["file"];//ページ番号
echo"<tr class='filepagenav'><td colspan='4' class='pagenav'>PAGE：";paging($limit, $page);echo"</td></tr><tr><td colspan='4'><input type='submit' name='DELETE_IMAGE' value='チェックを付けた画像を削除' class='button'></td></tr></form>";
	}
	if($pagekey == "setting"){	// 設定画面
		$homepage = $setting["homepage"];
		$pageby = $setting["pageby"];
		$odaiby = $setting["odaiby"];
		$votelimit = $setting["votelimit"];
		$vote_report = $setting["vote_report"];
		$bodylimit = $setting["bodylimit"];
		$cmt_bodylimit = $setting["cmt_bodylimit"];
		$tweet_button = $setting["tweet_button"];
		$description = $setting["description"];
		$description = str_replace("<br>", "\r\n", $description);
		$description = stripslashes("$description");
echo"<tr class='header1'><td colspan='4'>◆ボケグラムの設定</td></tr><form method='post' accept-charset='utf-8'>
<tr><td colspan='2' class='edit_l' nowrap>サイト名</td><td colspan='2' class='edit_r'><input type='text' name='SITENAME' value='{$sitename}' class='inputform'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ホームページアドレス</td><td colspan='2' class='edit_r'><input type='text' name='HOMEPAGE' value='{$homepage}' class='inputform'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題表示件数</td><td colspan='2' class='edit_r'><input type='text' name='PAGEBY' value='{$pageby}' class='inputform2'><br><span>タイトルリストのページでお題を何件ずつ表示するか</span></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題文の表示間隔</td><td colspan='2' class='edit_r'><input type='text' name='ODAIBY' value='{$odaiby}' class='inputform2'><br><span>投票画面で何作品ごとにお題文を挟むか（0の場合は途中に挟みません）</span></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投票の途中経過</td><td colspan='2' class='edit_r'><select name='VOTE_REPORT'>";
	if($vote_report==0){echo"<option value='0' selected>表示しない</option>";}else{echo"<option value='0'>表示しない</option>";}
	if($vote_report==1){echo"<option value='1' selected>表示する</option>";}else{echo"<option value='1'>表示する</option>";}
echo"</select><br><span>投票期間中、得点経過を表示します</span></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>二重投票制限</td><td colspan='2' class='edit_r'><select name='VOTELIMIT'>";
	if($votelimit==0){echo"<option value='0' selected>制限しない</option>";}else{echo"<option value='0'>制限しない</option>";}
	if($votelimit==1){echo"<option value='1' selected>同一IPからの投票を制限</option>";}else{echo"<option value='1'>同一IPからの投票を制限</option>";}
	if($votelimit==2){echo"<option value='2' selected>同一名からの投票を制限</option>";}else{echo"<option value='2'>同一名からの投票を制限</option>";}
	if($votelimit==3){echo"<option value='3' selected>同一IP・同一名どちらからの投票も制限</option>";}else{echo"<option value='3'>同一IP・同一名どちらかからの投票を制限</option>";}
echo"</select></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>作品の上限文字数</td><td colspan='2' class='edit_r'><input type='text' name='BODYLIMIT' value='{$bodylimit}' class='inputform2'>（0の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>コメントの上限文字数</td><td colspan='2' class='edit_r'><input type='text' name='CMT_BODYLIMIT' value='{$cmt_bodylimit}' class='inputform2'>（0の場合は無制限）</td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ツイートボタン</td><td colspan='2' class='edit_r'><select name='TWEET_BUTTON'>";
	if($tweet_button==0){echo"<option value='0' selected>表示しない</option>";}else{echo"<option value='0'>表示しない</option>";}
	if($tweet_button==1){echo"<option value='1' selected>カウンター付きのボタンを設置</option>";}else{echo"<option value='1'>カウンター付きのボタンを設置</option>";}
	if($tweet_button==2){echo"<option value='2' selected>カウンター無しのボタンを設置</option>";}else{echo"<option value='2'>カウンター無しのボタンを設置</option>";}
echo"</select><br><span>各お題ページにツイッターの共有ボタンが設置されます</span></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>説明文</td><td colspan='2' class='edit_r'><textarea wrap='soft' name='DESCRIPTION'>{$description}</textarea><br><ul><li>タイトルリストのページに表示されます。</li><li>タグが使えます。</li><li>改行は&lt;br&gt;に置き換えられます。</li><li>tableタグを使用する場合は、&lt;table&gt;&lt;tr&gt;&lt;td&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt; の間に改行を入れないようにしてください。</li></ul></td></tr>
<tr><td colspan='4'><input type='submit' name='SUBMIT_SETTING' value='設定する' class='button'></td></tr>
</form>";
	}
	if($pagekey == "design"){	// デザイン設定画面
	echo"<tr class='header1'><td colspan='4'>◆デザインの設定</td></tr><form method='post' accept-charset='utf-8'>
	<tr><td colspan='4' class='menubody'><ul class='admin'><li>管理ページにはデザインが適用されません。</li><li>空欄の項目はデフォルトのデザインが適用されます。</li><li>default2.cssと同じディレクトリにskin.cssを自分で設置することでも変更が可能です。</li></ul></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='BODY_COLOR' value='{$body_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>リンク文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='A_COLOR' value='{$a_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>訪問済みリンク文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='A_VISITED_COLOR' value='{$a_visited_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>マウスオーバー時のリンク文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='A_HOVER_COLOR' value='{$a_hover_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ページ背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='BODY_BGCOLOR' value='{$body_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>テーブル外枠線色</td><td colspan='2' class='edit_r'>#<input type='text' name='TABLE_BORDER_COLOR' value='{$table_border_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>テーブル内枠線色</td><td colspan='2' class='edit_r'>#<input type='text' name='TD_BORDER_COLOR' value='{$td_border_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>テーブル内背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='TD_BGCOLOR' value='{$td_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>タイトル文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='TITLE_COLOR' value='{$title_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>タイトルバー背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='TITLE_BGCOLOR' value='{$title_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ヘッダー文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='HEADER_COLOR' value='{$header_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ヘッダー背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='HEADER_BGCOLOR' value='{$header_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>見出し欄文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='HEADLINE_COLOR' value='{$headline_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>見出し欄背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='HEADLINE_BGCOLOR' value='{$headline_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題文文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='ODAI_COLOR' value='{$odai_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>お題文背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='ODAI_BGCOLOR' value='{$odai_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ボケ文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='BOKE_COLOR' value='{$boke_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>作品個別ページでのボケ文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='BOKE2_COLOR' value='{$boke2_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>作品個別ページでのボケ背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='BOKE2_BGCOLOR' value='{$boke2_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>穴埋め問題文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='ANAUME_COLOR' value='{$anaume_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>コメント文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='CMT_COLOR' value='{$cmt_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>締め切り日文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='LIMIT_COLOR' value='{$limit_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>順位・得点文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='RANK_COLOR' value='{$rank_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投稿欄文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='POST_COLOR' value='{$post_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>投稿欄背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='POST_BGCOLOR' value='{$post_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>文字入力欄文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='TEXTAREA_COLOR' value='{$textarea_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>文字入力欄背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='TEXTAREA_BGCOLOR' value='{$textarea_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ボタン文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='BUTTON_COLOR' value='{$button_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ボタン背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='BUTTON_BGCOLOR' value='{$button_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ページナビボタン文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='NAV_BUTTON_COLOR' value='{$nav_button_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>ページナビボタン背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='NAV_BUTTON_BGCOLOR' value='{$nav_button_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>現在のページ番号ボタン文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='NAV_BUTTON_CURRENT_COLOR' value='{$nav_button_current_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>現在のページ番号ボタン背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='NAV_BUTTON_CURRENT_BGCOLOR' value='{$nav_button_current_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>説明欄文字色</td><td colspan='2' class='edit_r'>#<input type='text' name='DESCRIPTION_COLOR' value='{$description_color}' class='inputform2'></td></tr>
<tr><td colspan='2' class='edit_l' nowrap>説明欄背景色</td><td colspan='2' class='edit_r'>#<input type='text' name='DESCRIPTION_BGCOLOR' value='{$description_bgcolor}' class='inputform2'></td></tr>
<tr><td colspan='4'><input type='submit' name='SUBMIT_DESIGN' value='設定する' class='button'></td></tr>
</form>";
	}
echo"<tr><td colspan='4'><form action='' method='post'><p><button type='submit' name='logout'>ログアウト</button></p></form></td></tr>
</table>
</div>
</div>
</body>
</html>";
	$_SESSION = array();
	session_destroy();
	}else{
echo "<html lang='ja'>
<head>
<title>管理ページ</title>
<link rel='stylesheet' href='./default2.css' type='text/css' media='all'>
<link rel='stylesheet' href='./user_css2.php' type='text/css' media='all'>
<link rel='stylesheet' href='./skin.css' type='text/css' media='all'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
</head>
<body>
<table class='error'><tr><td class='error_header'>エラー</td></tr><tr><td class='error_body'>トップページからログインしてください<br><a href='./pafevent2.php'>戻る</a></td></tr></table></body></html>";
	}
?>
