<?php
	$dbhost = "mysql.sansfera.myjino.ru";
	$dbuser = "045881084_site";
	$dbpass = "Ks5V0d6304";
	$dbname = "sansfera_site";
	$con = mysqli_connect($dbhost, $dbuser, $dbpass);
	if(!$con){
		die("Database conn failed: ". mysql_error());
	}else{
		$db_select = mysqli_select_db($con, $dbname) ;
		if(!$db_select){
			die("Database selection failed: ". mysql_error()) ;
		}
	}
	mysqli_query($con, "set names utf8") or die("set names utf8 failed");
	$sql = "SELECT * FROM `page` WHERE `price` != '' ORDER BY `edit`";
	$res = mysqli_query($con, $sql);
	while($row = mysqli_fetch_assoc($res)){
			$cities[$row['id']] = $row;
	}
?>
<main>
	<div class="wrap4">
		<div class="control left">
			<?=$this->render('/layouts/menu')?>
		</div>
		<div class="clear"></div>
	</div>
	<ul>
		<?foreach($cities as $id => $city):?>
		<?='<li><a href="https://sansfera.ru/admin/page/edit/'.$city['id'].'" target="_blank">'.$city['name'].'</a>-'.$city['price'].'</li>'?>
		<?endforeach;?>
	</ul>
</main>