<style>
a {
	text-decoration: none;
}
</style>
<main>
	<div class="wrap4">
		<div class="control left">
			<?=$this->render('/layouts/menu')?>
		</div>
		<div class="clear"></div>
	</div>
<?
$m = (isset($_GET['m']))?($_GET['m']):'0';
$minus = (int)$m - 1;
$plus = (int)$m + 1;
$minus1 = 0;
$plus1 = 0;
echo '<h1 class="wrap1"><a href="?m='.$minus.'"><<</a>Статистика новой базы с 1 октября.<a href="?m='.$plus.'">>></a></h2>';
$user = ['51' => 'Порошина', '74' => 'Кириллов', '84' => 'Ермилова', '86' => 'Макаров', '90' => 'Порошин', '94' => 'Дурманова'];
$limit = count($user) * 63;
$dbhostSt = '81.177.165.56';
$dbuserSt = 'root';
$dbNameSt = 'crmstatistic';
$dbpassSt = 'aea-ADMIN_12';

$month = ['04' => 'Апрель', '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август', '09' => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь', '01' => 'Январь', '02' => 'Февраль', '03' => 'Март',];
$mFirst = $m - 1;#количество месяцев назад
$date1 = new DateTime();
$date1->modify($mFirst.' month');
$my1 = $date1->format('my');
$m1 = $date1->format('m');
$y1 = $date1->format('Y');

$date2 = new DateTime();
$mod = ($m>=0)?'+'.$m:$m;
$date2->modify($mod.' month');
$my2 = $date2->format('my');
$m2 = $date2->format('m');
$y2 = $date2->format('Y');
$month1 = $month[$m1];
$month2 = $month[$m2];
foreach ($user as $id => $manager) {
	$all1[$id] = ['livecnt' => 0, 'liveopen' => 0, 'livenote' => 0, 'targetcnt' => 0, 'targetopen' => 0, 'targetnote' => 0];
	$all2[$id] = ['livecnt' => 0, 'liveopen' => 0, 'livenote' => 0, 'targetcnt' => 0, 'targetopen' => 0, 'targetnote' => 0];	
}

$con = mysqli_connect($dbhostSt, $dbuserSt, $dbpassSt);
if(!$con){
	die("Database conn failed: ". mysql_error());
}else{
	$db_select = mysqli_select_db($con, $dbNameSt) ;
	if(!$db_select){
		die("Database selection failed: ". mysql_error()) ;
	}
}
mysqli_query($con, "set names utf8") or die("set names utf8 failed");
$cnt = abs($m)*31*count($user);
$sql = "SELECT * FROM `statistic` WHERE `date` LIKE '".$date1->format('Y-m')."%' OR `date` LIKE '".$date2->format('Y-m')."%' ORDER BY `id` DESC, `user` DESC";
//echo $sql;
$res = mysqli_query($con, $sql);

while($row = mysqli_fetch_assoc($res)){
	if(date('my', strtotime($row['date'])) == $my1){
		$statistic1[$row['date']][] = $row;
	}
	if(date('my', strtotime($row['date'])) == $my2){
		$statistic2[$row['date']][] = $row;
	}
	$test[] = $row;
}
//echo '<pre>test = '; print_r($test); echo '</pre>';die();
#месяц предыдущий
if (!empty($statistic1) && is_array($statistic1)) {
	ksort($statistic1);
	foreach($statistic1 as $stdate1){

		$tr1[] = '<tr><td>Дата</td><td>Фамилия</td><td>Рабочих</td><td>Открыто рабочих</td><td>Запись рабочих</td><td>Потенц.</td><td>Открыто пот.</td><td>Запись пот.</td></tr>';
		//$emptargetcnt1 = 0;
		foreach($stdate1 as $note1){
			//$addTargetCnt = (int)$emptargetcnt1[$note1['user']]? '+'.((int)$emptargetcnt1[$note1['user']]-(int)$note1['emptargetcnt']) : '+0';
			$tr1[] = '<tr><td>'.date('d.m', strtotime($note1['date'])).'</td>
			<td>'.$user[$note1['user']].'</td>
			<td>'.$note1['livecnt'].($note1['emplivecnt']? '('.$note1['emplivecnt'].')':'').'</td>
			<td>'.$note1['liveopen'].'</td>
			<td>'.$note1['livenote'].'</td>
			<td>'.$note1['targetcnt'].'</td>
			<td>'.$note1['targetopen'].'</td>
			<td>'.$note1['targetnote'].'</td></tr>';
			$all1[$note1['user']]['liveopen'] += $note1['liveopen'];
			$all1[$note1['user']]['livenote'] += $note1['livenote'];
			$all1[$note1['user']]['targetopen'] += $note1['targetopen'];
			$all1[$note1['user']]['targetnote'] += $note1['targetnote'];
			$emptargetcnt1[$note1['user']] = $note1['emptargetcnt'];
		}
	}
}
#месяц текущий
if (!empty($statistic2) && is_array($statistic2)){
	ksort($statistic2);
	//$emptargetcnt = $emptargetcnt1;
	//echo '<pre>'; print_r($emptargetcnt); echo '</pre>';
	foreach($statistic2 as $stdate2){
		$tr2[] = '<tr><td>Дата</td><td>Фамилия</td><td>Рабочих</td><td>Открыто рабочих</td><td>Запись рабочих</td><td>Рабочие не откр. > 1мес.</td><td>Рабочие не откр. > 2мес.</td><td>Потенц.</td><td>Открыто пот.</td><td>Запись пот.</td><td>Потенц. не&nbsp;откр. > 1мес.</td><td>Потенц. не&nbsp;откр. > 2мес.</td></tr>';
		foreach($stdate2 as $note2){
			//$addTargetCnt = (int)$emptargetcnt[$note2['user']]? '+'.((int)$emptargetcnt[$note2['user']]-(int)$note2['emptargetcnt']) : '+0';
			$tr2[] = '<tr>
			<td>'.date('d.m', strtotime($note2['date'])).'</td>
			<td>'.$user[$note2['user']].'</td>
			<td>'.$note2['livecnt'].($note2['emplivecnt']? '('.$note2['emplivecnt'].')':'').'</td>
			<td>'.$note2['liveopen'].'</td>
			<td>'.$note2['livenote'].'</td>
			<td>'.($note2['notopen1_20']?$note2['notopen1_20']:'&mdash;').'</td>
			<td>'.($note2['notopen2_20']?$note2['notopen2_20']:'&mdash;').'</td>			
			<td>'.$note2['targetcnt'].'</td>
			<td>'.$note2['targetopen'].'</td>
			<td>'.$note2['targetnote'].'</td>
			<td>'.($note2['notopen1_10']?$note2['notopen1_10']:'&mdash;').'</td>
			<td>'.($note2['notopen2_10']?$note2['notopen2_10']:'&mdash;').'</td>			
			</tr>';
			$all2[$note2['user']]['liveopen'] += $note2['liveopen'];
			$all2[$note2['user']]['livenote'] += $note2['livenote'];
			$all2[$note2['user']]['targetopen'] += $note2['targetopen'];
			$all2[$note2['user']]['targetnote'] += $note2['targetnote'];
			$emptargetcnt[$note2['user']] = $note2['emptargetcnt'];
		}
	}
}
?>
  <style type="text/css">
   table{
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
    width: 300px;
   }     
   TH { 
    background: #fc0; /* Цвет фона ячейки */
    text-align: left; /* Выравнивание по левому краю */
   }
   TD {
    background: #fff; /* Цвет фона ячеек */
    text-align: center; /* Выравнивание по центру */
   }
   TH, TD {
    border: 1px solid black; /* Параметры рамки */
    padding: 1px; /* Поля вокруг текста */
   font-size: 14px;
   font-weight: none;
   }
   
  </style>
<?
//echo '<pre>'; print_r($test); echo '</pre>';

$trAll1[] = '<tr><td colspan="5">'.$month1.'('.$y1.')</td></tr>';
$trAll1[] = '<tr><td>Фамилия</td><td>Открыто рабочих</td><td>Записи рабочих</td><td>Открыто потенциальных</td><td>Записи потенциальных</td></tr>';
if (!empty($statistic1) && is_array($all1)) {
	foreach($all1 as $userID => $stat){
		$trAll11[] = '<tr><td>'.$user[$userID].'</td><td>'.$stat['liveopen'].'</td><td>'.$stat['livenote'].'</td><td>'.$stat['targetopen'].'</td><td>'.$stat['targetnote'].'</td></tr>';
	}
	$trAll11 = array_reverse($trAll11);
	echo '<div style="display:inline-block;"><table class="first">'.implode('',$trAll1).implode('',$trAll11).'</table><br><table class="first">'.implode('',$tr1).'</table></div>';
}

$trAll2[] = '<tr><td colspan="5">'.$month2.'('.$y2.')</td></tr>';
$trAll2[] = '<tr><td>Фамилия</td><td>Открыто рабочих</td><td>Записи рабочих</td><td>Открыто потенциальных</td><td>Записи потенциальных</td></tr>';
if (!empty($statistic2) && is_array($all2)) {
	foreach($all2 as $userID => $stat){
		$trAll22[] = '<tr><td>'.$user[$userID].'</td><td>'.$stat['liveopen'].'</td><td>'.$stat['livenote'].'</td><td>'.$stat['targetopen'].'</td><td>'.$stat['targetnote'].'</td></tr>';
	}
	$trAll22 = array_reverse($trAll22);
 echo '<div style="display:inline-block;padding-left:5px;"><table class="second">'.implode('',$trAll2).implode('',$trAll22).'</table><br><table class="second">'.implode('',$tr2).'</table></div>';
}
?>
</main>