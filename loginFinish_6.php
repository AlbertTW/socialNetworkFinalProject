<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/final.css" rel="stylesheet" media="screen">
<title>註冊資料 - 揪球友</title>
</head>

<body>

	<?php

		$ball = $_POST[ball];
		$place = $_POST[place];
		$timeslot = $_POST[timeslot];
		$userID = $_POST[userID];
		$userNAME = $_POST[userNAME];


/*		echo "ball:".$ball."<br>";
		echo "ball:".$ball[0]."<br>";
		echo "place:".$place."<br>";
		echo "timeslot:".$timeslot."<br>";
*/

/*		echo "ball: <br>";
		print_r($ball);
		echo "<br>";
		echo "place: ".$place." <br>";
		echo "timeslot: <br>";
		print_r($timeslot);
		echo "<br>";

		echo "userID:".$userID."<br>";
		echo "userNAME:".$userNAME."<br>";
*/


		echo "<div id='userInfo'>";
			echo "<img src='https://graph.facebook.com/".$userID."/picture?type=large'> <br>";
			echo "userNAME: ".$userNAME."<br><br><br>";
			
		echo "</div>";

		
		echo "<div id='chooseBall'>";
		
			echo "您喜好的球類: <br>";
			for ( $i=0;$i<count($ball);$i++ )
			{
				echo "<img width='60' height='60' src='img/".$ball[$i].".png' alt='".$ball[$i]."' align='center'>";
//				echo $ball[$i]."  ";
			}
			echo "<br><br>";
		echo "</div>";
		
		
		echo "<div id='choosePlace'>";
		
			echo "您常活動的地區:<br>";
			
			if ( $place==1 )
				echo "北部";
			elseif ( $place==2 )
				echo "中部";
			elseif ( $place==3 )
				echo "南部";
			elseif ( $place==4 )
				echo "東部";
							
			echo "<br><br>";
		echo "</div>";
		
		
		echo "<div id='chooseTime'>";
	
			echo "您常活動的時段: <br>";
			echo "<table cellpadding='20' border='1'>";
			echo "<tbody>";
				
			$k = 0;
			$temp = 0;
			for ( $i=0;$i<4;$i++ )
			{
				echo "<tr>";
				
				for ( $j=0;$j<=7;$j++ )
				{
					if ( $j==0 )
					{
						if ( $i==0 )
							echo "<td></td>";
						elseif ( $i==1 )
							echo "<td>上午</td>";
						elseif ( $i==2 )
							echo "<td>中午</td>";
						elseif ( $i==3 )
							echo "<td>晚上</td>";
					}
					else
					{
						if ( $i==0 )
							echo "<td>".$j."</td>";
						else
						{
							$temp = ($i-1) * 7 + $j;
							echo "<td id='timeslot".$temp."'>";
								if ( $timeslot[$k]==$temp )
								{
									echo "v";
									$k = $k + 1;
								}
							echo "</td>";
						}
					}
					
				}
	
				echo "</tr>";
			}
			
			echo "</tbody>";
			echo "</table>";
			echo "<br><br>";
		echo "</div>";
		
	?>	
		
		<input type='button' name='backBtn' id='backBtn' value='回首頁' onclick='javascript:location.href="index.html"' />
	

</body>



</html>