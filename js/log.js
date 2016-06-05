function logDebug(Message){
	var now=new Date();
	//var date = d.toDateString();
	//var time = d.toLocaleTimeString();
	//var then = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDay(); 
    //then += ' '+now.getHours()+':'+now.getMinutes();
	then = '';
    var fullMsg = then+" "+Message;
    $("#log").append(fullMsg);
}

function writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark){
	//call logControl
	//alert('ready to call');
	//make json
	//logD_action,logD_interaction,logD_input,logD_status,logD_remark
	var str = '{"call":"writeLog",';
	str = str+ '"logD_action":"'+logD_action+'","logD_interaction":"'+logD_interaction+'",';
	str = str+ '"logD_input":"'+logD_input+'","logD_status":"'+logD_status+'",';
	str = str+ '"logD_remark":"'+logD_remark+'"}';
	console.log(str);
	var obj = jQuery.parseJSON(str);
	var postData = JSON.stringify(obj);
	var postArray = {json:postData};
	$.ajax({
		type: 'POST',
		url: '../control/logControl.php',
		data: postArray,
		/*data: {'call':'writeLog',
				 'logD_action': logD_action,
				 'logD_interaction': logD_interaction,
				 'logD_input': logD_input,
				 'logD_status': logD_status,
				 'logD_remark': logD_remark},*/
		//contentType: "application/json; charset=utf-8",
		//dataType: "json",
		success: function(html){
			//alert('call finish');
			localStorage.requestFlag="false";
			$('#debugging').append(html);
		},
	});
}