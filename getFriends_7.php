<?php

include 'src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '1438113799749811',
  'secret' => 'd383c9de203bfb51a06d48a0b00f926d',
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


<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="http://www.cs.nccu.edu.tw/~s99102/fb-js-codelab/css/final.css" rel="stylesheet" media="screen">
    <title>註冊 - 揪球友</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
	
	
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	
	
	<script language="JavaScript">
	
		function setHidValue()
		{
			// test 是否已寫入hidden
			alert('uid: ' + $("#userID").val());
			alert('uname: ' + $("#userNAME").val());

		}
	
	</script> 
	
	
  </head>
  
  
  <body>
    <h1>註冊</h1>
    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
	
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

	<!--
    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>
	-->

	<!-- User&Friend information -->
    <?php if ($user): ?>
	<table cellpadding="10 border="0">
	<tbody>
        <tr>
            <td>
                <center>
                    <b>
					User Picture
                    </b>
                </center>
                <div style="border:0px solid #999; overflow:auto;">
                    <img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large">
                </div>
            </td>
			<td>
                <center>
                    <b>
					User Information
                    </b>
                </center>
                <div style="border:0px solid #999; overflow:auto;">
				<pre><?php echo "User id: ".$user_profile['id']; ?></pre>
				<pre><?php echo "User Name: ".$user_profile['name']; ?></pre>
				<pre><?php echo "User link: ".$user_profile['link']; ?></pre>
                </div>
            </td>
		</tr>
		
	</tbody>
	</table>
	
	<br><br>
	<form name='newUser' method='POST' action='loginFinish.php'>
		
		<!-- 選擇球類 複選 checkbox -->
		喜好球類(可複選)
		<table width='600px' border='0'>
			<tbody>
				<tr>
					<td>
						<input type="checkbox" name="ball[]" value="PingPong" align='center'>
						<img width='60' height='60' src="img/PingPong.png" alt="乒乓球" align='center'>
					</td>
					<td>
						<input type="checkbox" name="ball[]" value="Basketball" align='center'>
						<img width='60' height='60' src="img/Basketball.png" alt="籃球" align='center'>
					</td>
					<td>
						<input type="checkbox" name="ball[]" value="Tennis" align='center'>
						<img width='60' height='60' src="img/Tennis.png" alt="網球" align='center'>
					</td>
					<td>
						<input type="checkbox" name="ball[]" value="Volley" align='center'>
						<img width='60' height='60' src="img/Volley.png" alt="排球" align='center'>
					</td>
				</tr>
			</tbody>
		</table>
		<br><br>
		
		<!-- 選擇地區 下拉式選單 -->
		常活動地區
		<select name='place'>
			<option value="1">北部</option>
			<option value="2">中部</option>
			<option value="3">南部</option>
			<option value="4">東部</option>
		</select>
		<br><br>
		
		<!-- 選擇時段 複選 checkbox -->
		常活動時段(可複選)
		<table cellpadding="20" border="1">
			<tbody>
				<tr>
					<td></td>
					<td>星期一</td>
					<td>星期二</td>
					<td>星期三</td>
					<td>星期四</td>
					<td>星期五</td>
					<td>星期六</td>
					<td>星期日</td>
				</tr>
				<tr>
					<td>上午</td>
					<td><input type="checkbox" name="timeslot[]" value="1" id="timeslot1"></td>
					<td><input type="checkbox" name="timeslot[]" value="2" id="timeslot2"></td>
					<td><input type="checkbox" name="timeslot[]" value="3" id="timeslot3"></td>
					<td><input type="checkbox" name="timeslot[]" value="4" id="timeslot4"></td>
					<td><input type="checkbox" name="timeslot[]" value="5" id="timeslot5"></td>
					<td><input type="checkbox" name="timeslot[]" value="6" id="timeslot6"></td>
					<td><input type="checkbox" name="timeslot[]" value="7" id="timeslot7"></td>
				</tr>
				<tr>
					<td>下午</td>
					<td><input type="checkbox" name="timeslot[]" value="8" id="timeslot8"></td>
					<td><input type="checkbox" name="timeslot[]" value="9" id="timeslot9"></td>
					<td><input type="checkbox" name="timeslot[]" value="10" id="timeslot10"></td>
					<td><input type="checkbox" name="timeslot[]" value="11" id="timeslot11"></td>
					<td><input type="checkbox" name="timeslot[]" value="12" id="timeslot12"></td>
					<td><input type="checkbox" name="timeslot[]" value="13" id="timeslot13"></td>
					<td><input type="checkbox" name="timeslot[]" value="14" id="timeslot14"></td>
				</tr>
				<tr>
					<td>晚上</td>
					<td><input type="checkbox" name="timeslot[]" value="15" id="timeslot15"></td>
					<td><input type="checkbox" name="timeslot[]" value="16" id="timeslot16"></td>
					<td><input type="checkbox" name="timeslot[]" value="17" id="timeslot17"></td>
					<td><input type="checkbox" name="timeslot[]" value="18" id="timeslot18"></td>
					<td><input type="checkbox" name="timeslot[]" value="19" id="timeslot19"></td>
					<td><input type="checkbox" name="timeslot[]" value="20" id="timeslot20"></td>
					<td><input type="checkbox" name="timeslot[]" value="21" id="timeslot21"></td>
				</tr>
			</tbody>
		</table>
		<br><br>
		
		
		<?php echo "<input type='hidden' id='userID' name='userID' value='".$user_profile['id']."'>"; ?>
		<?php echo "<input type='hidden' id='userNAME' name='userNAME' value='".$user_profile['name']."'>"; ?>	
		
		<input type="submit" name="sendBtn" id="sendBtn" value="確認送出" />
		
	</form>
	
	
	
	<!-- User's friends -->
	<?php

	$allfriend = $facebook->api(array(
                 'method' => 'fql.query',
                 'query' => 'SELECT uid1, uid2 FROM friend WHERE uid1==me()'));
	
	?>

	<!-- <pre><?php print_r($allfriend); ?></pre> -->
	

    <?php else: ?>
      <strong><em><br>You are not Connected.</em></strong>
    <?php endif ?>

    <!--	
	<h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>
	-->
	
  </body>
</html>
