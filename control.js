
$(document).ready(function(){

//	alert('load');
	var tableTotalNum = $('#tableTotalNum').val();
	
	
	$('.resultTable').hide();	// 查詢回來結果的table全部隱藏
	$('#showFriend_1').show();	// 先show出第一個table
	
	// click "More" event
	$('.showMore').click(function(){
//			alert('in click');
			var num;

			eval("num = $(this).attr('value');");
			eval("$('#showFriend_"+ num + "').hide();");
			num++;
			eval("$('#showFriend_"+ num + "').show();");
			
		});

});
