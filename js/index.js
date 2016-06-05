$(document).ready(function() {
		$( "#contactMsg" ).dialog({
			autoOpen : false,
			width: 450,
			modal: true
	    });
		$("#txtPasswordDlg").dialog({
			autoOpen : false,
			height : 250,
			width : 450,
			position: ['top', 'center'],
			buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    //console.log($( this ).getPassword());
                    localStorage.flag3D="true";
                    localStorage.objNotActivate="true";
                    var textualPassword = $("#password").val();
                    var object = $("#txtObjectAction").val();
                    console.log(textualPassword);
                    console.log(object);
                    logDebug(">> You input is "+textualPassword+"<br>");
                    //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
                    writelog("get user input","textualPassword",textualPassword,"-",">> You input is "+textualPassword);
                    //call ajax
                    $.post("../control/sessionManager.php", {
						data1: textualPassword,
						data2: object,
						call: 'storeScenario'},
						function(data){
							$("#debugging").html(data);
						}
					);
                }
            },
			close : function() {
				$(this).dialog( "close" );
				localStorage.flag3D="true";
				localStorage.objNotActivate="true";
			}
		});
		$("#passPointDlg").dialog({
			autoOpen : false,
			maxWidth : 800,
			position: ['center', 'top'],
			buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    localStorage.flag3D="true";
                    localStorage.objNotActivate="true";
                    var passPoint = $("#password").val();
                    var object = $("#ppObjectAction").val();
                    console.log(passPoint);
                    console.log(object);
                    logDebug(">> You input is "+passPoint+"<br>");
                    //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
                    writelog("get user input","passPoint",passPoint,"-",">> You input is "+passPoint);
                    //call ajax
                    $.post("../control/sessionManager.php", {
						data1: passPoint,
						data2: object,
						call: 'storeScenario'},
						function(data){
							$("#debugging").html(data);
						}
					);
                }
            },
			close : function() {
				$(this).dialog( "close" );
				localStorage.flag3D="true";
				localStorage.objNotActivate="true";
			}
		});
		$("#patternUnlockDlg").dialog({
			autoOpen : false,
			height : 370,
			width : 250,
			position: ['center', 'center'],
			buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    localStorage.flag3D="true";
                    localStorage.objNotActivate="true";
                    var patternUnlock = $("#password").val();
                    var object = $("#patternObjectAction").val();
                    console.log(patternUnlock);
                    console.log(object);
                    //call ajax
                    logDebug(">> You input is "+patternUnlock+"<br>");
                    //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
                    writelog("get user input","patternUnlock",patternUnlock,"-",">> You input is "+patternUnlock);
                    $.post("../control/sessionManager.php", {
						data1: patternUnlock,
						data2: object,
						call: 'storeScenario'},
						function(data){
							$("#debugging").html(data);
						}
					);
                }
            },
			close : function() {
				$(this).dialog( "close" );
				localStorage.flag3D="true";
				localStorage.objNotActivate="true";
			}
		});

		$("#errorMsg").dialog({
			autoOpen : false,
			modal: true,
			//position: ['center', 'center'],
			buttons: {
		        Ok: function() {
		        	//close
		        	$( this ).dialog( "close" );
		        	//call unset scenario
		        	$.ajax({
		    			type: 'POST',
		    			url: '../control/sessionManager.php',
		    			data: {'call':'unsetAllScenario'},
		    			success: function(data){
		    				$('#debugging').html(data);
		    				//redirect
				        	location.href = '/sci422/proj3D/pageElement/createPassword.php';
		    			},
		    			async:true
		    		});
		        }
		     },
			close : function() {
				$(this).dialog( "close" );
			}
		});
		
		var delayID=null;
		$("#txtUsername").keyup(function(event){
			if(delayID==null){
				delayID=setTimeout(function(){
					var input_data=$("#txtUsername").val();
					//alert(input_data);
					logDebug(">> You input username is "+input_data+"<br>");
	                //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
	                writelog("get user input","username",input_data,"-",">> You input username is "+input_data);
					delayID=null;
				},1000);							
			}else{
				if(delayID){
					clearTimeout(delayID);
					delayID=setTimeout(function(){
						var input_data=$("#txtUsername").val();
						//alert(input_data);
						logDebug(">> You input username is "+input_data+"<br>");
		                //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
		                writelog("get user input","username",input_data,"-",">> You input username is "+input_data);
						delayID=null;
					},1000);						
				}		
			}
		});
		//auto load page
		localStorage.CanvasOffset = "false";
		logDebug(">> Ready <br/>");
		//writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
        writelog("Ready","-","-","Ready",">> Ready!!!");
		//check event 
		$('#registration').click(function(e) {
			logDebug(">> User click registration <br/>");
			localStorage.CanvasOffset = "true";
			e.preventDefault();
			$.post("../control/sessionManager.php", {
				call: 'unSetUserStatus'},
				function(data){
					//$("#debugging").html(data);
					//window.location.href = "index.php";
				}
			);
			$('#container').load('1instruction.php',{
				userStatus: "registration"
				}
			);
			writelog("Start mode","-","-","registration",">> User click registration");
			
		});
		//authentication
		$('#authentication').click(function(e) {
			 logDebug(">> Ready for authentication <br/>");
			 //writelog(logD_action,logD_interaction,logD_input,logD_status,logD_remark)
			 localStorage.CanvasOffset = "false";
			 e.preventDefault();
			 $.post("../control/sessionManager.php", {
				call: 'unSetUserStatus'},
				function(data){
					$("#debugging").html(data);
					location.href = "/sci422/proj3D/pageElement/login.php";
				}
			);
			writelog("Start mode","-","-","authentication",">> Ready for authentication");
			
		});
		//forgot password
		$('#forgotPassword').click(function(e) {
			logDebug(">> User click forgot password <br/>");	
			localStorage.CanvasOffset = "true";
			e.preventDefault();
			$.post("../control/sessionManager.php", {
				call: 'unSetUserStatus'},
				function(data){
					//$("#debugging").html(data);
					//window.location.href = "index.php";
				}
			);
			$('#container').load('/sci422/proj3D/pageElement/forgotPassword.php',{
				userStatus: "forgotPwd"
				}
			);
			writelog("Start mode","-","-","forgot password",">> User click forgot password");
		});
		
		//contact us
		$('#contactus').click(function(e) {
			$("#contactMsg").dialog("open");
		});
		//contact us
		
		
	});