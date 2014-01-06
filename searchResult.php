<?php

include '../src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '406720666028542',
  'secret' => '86375d14b20fb6328c3adf36bd92e21f',
));

// Get User ID
$user = $facebook->getUser();


if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$user_checkin = $facebook->api('/me/locations');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl(array("scope" => "user_photos,user_friends,friends_about_me"));
}

// This call will always work since we are fetching public data.
//$naitik = $facebook->api('/naitik');

?>


<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/final.css" rel="stylesheet" media="screen">

	<!-- include JQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<!-- JavaScript control -->
	<script type="text/javascript" src="control.js" ></script>

	<title>搜尋結果 - 揪球友</title>
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
		
			echo "選擇的球類: <br>";
			for ( $i=0;$i<count($ball);$i++ )
			{
				echo "<img width='60' height='60' src='img/".$ball[$i].".png' alt='".$ball[$i]."' align='center'>";
//				echo $ball[$i]."  ";
			}
			echo "<br><br>";
		echo "</div>";
		
		
		echo "<div id='choosePlace'>";
		
			echo "選擇的地區:<br>";
			
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
	
			echo "選擇的時段: <br>";
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
		
		$strQuery = "SELECT uid, name, pic_square FROM user WHERE uid = me() OR uid IN (SELECT uid2 FROM friend WHERE uid1 = me())";
//		$strQuery = "SELECT uid2 FROM friend WHERE uid1==me()";
		//User's friends
		$allfriend = $facebook->api(array(
                 'method' => 'fql.query',
                 'query' => $strQuery));
/*		
//		echo "<pre>";
//		print_r($allfriend);
		print_r($allfriend[0]['uid2']);
//		echo "</pre> <br><br>";
*/
	?>
	
	<input type='button' name='backBtn' id='backBtn' value='回首頁' onclick='javascript:location.href="index_1.html"' /> <br>
	<!-- 直接PO文到FB: FB.ui() -->
	<input type='button' name='fbFeed' id='fbFeed' value='FB PO文' onclick='fbUI_feed()' />
	
	<?php
		echo "<div id='chooseTime'>";
	
			echo "可能球友清單: <br>";
//			echo "<table cellpadding='20' border='1'>";
//			echo "<tbody>";
			
			$tableNum = 1;
			for ( $i=1;$i<count($allfriend);$i++ )
			{
			
				if ( $i%10==1 )	//餘數為1時 換table
				{
					echo "<table cellpadding='20' border='1' id='showFriend_".$tableNum."' class='resultTable'>";
					echo "<tbody>";
				}
			
			
				echo "<tr>";
					$strUid = $allfriend[$i]['uid'];
					$strName = $allfriend[$i]['name'];
					
					echo "<td>";
						$strA = "https://graph.facebook.com/".$strUid."/picture?type=large";
						echo "<div style='border:0px solid #999; overflow:auto;'>";
						echo "<img src='".$strA."' width='100px' height='100px'>";
						echo "</div>";
					echo "</td>";
					
					echo "<td>";
						echo "<a href='https://www.facebook.com/".$strUid."' target='_blank' >".$strName."</a>";
					echo "</td>";
					
					echo "<td>";
						echo "<input type='button' name='fbMessage' class='SendToUser' value='私訊他' onclick='fbUI_message(".$strUid.")' />";
					echo "</td>";
				echo "</tr>";
								
				
				if ( $i%10==0 )	//餘數為0時 換table + more
				{
					echo "<tr>";
						echo "<td colspan='3' align='right'>";
							echo "<h4 class='showMore' id='more_".$tableNum."' value='".$tableNum."'>More...</h4>";
						echo "</td>";
					echo "</tr>";
				
					echo "</tbody>";
					echo "</table>";
					
					$tableNum = $tableNum + 1;
				}
				
			}
			
			// 對最後一個table進行處理 (因為 $i%10==0 進不去)
			if ( (count($allfriend)-1)%10!=0 )
			{
				echo "<tr>";
					echo "<td colspan='3' align='right'>";
						echo "<h4 class='finishMore' id='finishTable' value='".$tableNum."'>Finish...</h4>";
					echo "</td>";
				echo "</tr>";
			
				echo "</tbody>";
				echo "</table>";
			}
			
			echo "<input type='hidden' name='tableTotalNum' id='tableTotalNum' value='".$tableNum."'>";
			
			echo "<br><br>";
		echo "</div>";
			
		
	?>
	
	
	
	<div id="fb-root"></div>

	<script>
	  window.fbAsyncInit = function() {
		// init the FB JS SDK
		FB.init({
		  appId      : '406720666028542',                        // App ID from the app dashboard
		  status     : true,                                 // Check Facebook Login status
		  xfbml      : true,                                  // Look for social plugins on the page
		  cookie     : true
		});

		// Additional initialization code such as adding Event Listeners goes here
	  };


	  // Load the SDK asynchronously
	  (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/en_US/all.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	   

		function fbUI_feed()
		{
			FB.ui(
				{
					method: 'feed',
					name: '揪球友',
					link: 'http://www.cs.nccu.edu.tw/~g10209/fbTest/SNAfinal/examples/index_1.html',
					picture: 'http://fbrell.com/f8.jpg',
					caption: 'Reference Documentation',
					description: '揪球友：發佈訊息'
				},

			  function(response) {
				if (response && response.post_id) {
				  alert('已經發佈到FaceBook');
				} else {
				  alert('發佈失敗，請再試一次');
				}
			  }
			);

		}
		
		
		function fbUI_message( UID )
		{
//			alert (UID);
			FB.ui(
				{
					method: 'send',
					link: 'http://www.cs.nccu.edu.tw/~g10209/fbTest/SNAfinal/examples/index_1.html',
					to:  UID,
				}
				
			);
						
		}


	</script>

	

</body>



</html>
