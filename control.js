
$(document).ready(function(){

	alert('load');
	var tableNum = 1;
	var tableTotalNum = $('#tableTotalNum').val();
	alert(tableTotalNum);
	
	
	$('.resultTable').hide();	// 查詢回來結果的table全部隱藏
	$('#showFriend_1').show();
	
	$('.showMore').click(function(){
			alert('in click');
			var num;
			
			{
				eval("num = $(this).attr('value');");
	//			$('.showMore').attr('value');
				alert(num);
				eval("$('#showFriend_"+ num + "').hide();");
				num++;
				eval("$('#showFriend_"+ num + "').show();");
			}
			
		});
	
	

});
