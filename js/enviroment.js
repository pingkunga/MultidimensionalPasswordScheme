var spotlight1;
var doc = new GLGE.Document();
var counter = 0;
doc.onLoad=function(){
	var flag = "true";
	localStorage.flag3D="true";
	localStorage.objNotActivate="true";
	//get a main light
	spotlight1=doc.getElement("mainlight");
	//กำหนดจุดที่จะแสดงผลภาพสามมิติ
	var gameRenderer=new GLGE.Renderer(document.getElementById('canvas'));
	
	/*var gameRenderer=new GLGE.Renderer(document.getElementById('canvas'),null, 
		{
			alpha:false,
			depth:true,
			stencil:true,
			antialias:false,
			premultipliedAlpha:false
		} 
	);*/
	//กำหนดฉากการแสดงผล
	if(typeof gameScene != 'undefined'){
		console.log("Before");
		console.log(gameScene);
		//gameScene=undefined
		//gameScene = null;
		//GLGE.GLDestroy(gameScene);
		console.log(gameScene);
	}
	
	gameScene=new GLGE.Scene();
	console.log("After");
	console.log(gameScene);
	//เลือกส่วนของฉากสามมิติตจากไฟล์ xml ในส่วนของ mainscene
	gameScene=doc.getElement("mainscene");
	//กำหนดใน mainscene มาทำการแสดงผลที่ canvass
	gameRenderer.setScene(gameScene);
	//gameRenderer.clearViewport();
	//รับพิกัดจากเมาส์ ในบริเวณของ canvas
	var mouse=new GLGE.MouseInput(document.getElementById('canvas'));
	//รับค่าจาก keyboard
	//var keys=new GLGE.KeyInput();
	//var txtPassword = ["ID300","ID301","ID302","ID303","ID304","ID305","ID306","ID307","ID308","ID309","ID310","ID311"];
	//var passPoint = ["ID100","ID101","ID102","ID200","ID201","ID202","ID203"];
	//var patternUnlock = ["ID347","ID281","ID301"];
	//var tv = ["ID100","ID101","ID102"];
	//var swuPic = ["ID200","ID201","ID202","ID203"];
	//var computer = ["ID300","ID301","ID302","ID303","ID304","ID305","ID306","ID307","ID308","ID309","ID310","ID311"];
	//var refrigerator = ["ID347","ID281","ID301"];
	var keys=new GLGE.KeyInput();
	var txtPassword = ["ID39","ID45","ID51","ID57","ID63","ID16","ID28","ID72","ID85","ID95","ID103"];
	var passPoint = ["ID38","ID23","ID85","ID36","ID15","ID30","ID2","ID51"];
	var patternUnlock = ["ID347","ID281","ID301","ID760","ID766","ID14","ID22","ID28","ID34","ID40"];
	var tv = ["ID38","ID30","ID51"];
	var swuPic = ["ID23","ID36","ID15","ID2"];
	var computer = ["ID39","ID45","ID51","ID57","ID63","ID16","ID28","ID72","ID85","ID95","ID103"];
	var refrigerator = ["ID347","ID281","ID301","ID760","ID766","ID14","ID22","ID28","ID34","ID40"];
	//flag ตรวจดูว่า 3D นั้นอยู่บนส่วนของ canvas หรือภาพสามมิติ หรือไม่
	var mouseovercanvas=false;
	function mouselook(){
		if(mouseovercanvas){
			var mousepos=mouse.getMousePosition();
			mousepos.x=mousepos.x-document.getElementById("container").offsetLeft;
			mousepos.y=mousepos.y-document.getElementById("container").offsetTop;
			if(mousepos.x && mousepos.y){
				//เอาข้อมูลของ object ที่ถูกเก็บใน 3D เอามาเก็บในตัวแปร  obj
				if(typeof gameScene.pick(mousepos.x,mousepos.y).object != 'null'){
					//if(localStorage.CanvasOffset=="true"){
					//	obj=gameScene.pick(mousepos.x,(mousepos.y-100)).object;
						//obj=gameScene.pick(mousepos.x,mousepos.y).object;
					//}else{
						obj=gameScene.pick(mousepos.x,mousepos.y).object;
					//}
					//obj=gameScene.pick(mousepos.x,mousepos.y).object;
					//ตรวจสอบว่าไม่ใส่ wall obejct (Cube ที่เจาะกลวงด้านในจนกลายเป็นห้อง)
					//console.log(obj.getId());
					if(obj.getId()!="wallobject") {
						//alert(obj.getId());
						function getPasswordPrompt()
						{
							var objid = obj.getId();
							localStorage.requestFlag="true";
							console.log(objid);
							localStorage.objid=objid;
							//jQuery Ajax
							//$('#passwordPrompt').load('passwordType/textPassword.html');
							//$('#passPoint').load('passwordType/passPoint.html');
							console.log(jQuery.inArray(objid, txtPassword));
							console.log(jQuery.inArray(objid, passPoint));
							console.log(jQuery.inArray(objid, patternUnlock));
							//console.log(jQuery.inArray(objid, refrigerator));
							if(localStorage.objNotActivate=="true"){
								if(jQuery.inArray(objid, txtPassword)!=-1){
									if(jQuery.inArray(objid, computer)!=-1){
										//if(localStorage.requestFlag="true"){
											$("#txtPasswordDlg").on( "dialogopen", function(e) {
												$('#txtPasswordForm').remove();
										        if(e.handled !== true){
													$.ajax({
														 type: 'POST',
														 url: '../passwordType/textPassword.php/',
														 data: {'object':'computer'},
														 success: function(html){
															$('#txtPasswordDlg').append(html);
														 },
														 async:true
													});
													e.handled = true;
										        }
											} );
											$("#txtPasswordDlg").dialog("open");
											localStorage.Activate="computer";
											//}
											//function log
											var html = ">> Action: activate computer("+objid+")&& Interaction: texual password <br/>";
											//$("#log").append(html);
											localStorage.flag3D="false";
											logDebug(html);
											writelog("computer","textual_password","click","prompt_dialog",html);
										//}
									}
								}else if(jQuery.inArray(objid, passPoint)!=-1){
									if(jQuery.inArray(objid, tv)!=-1){
										if(localStorage.requestFlag="true"){
											$("#passPointDlg").on( "dialogopen", function(e) {
										        //e.preventDefault();
										        //if(e.handled !== true){
													$('#passPointDlg').load('../passwordType/passPoint.php',{
														object: "television"}
													);
													//e.handled = true;
										        //}
											} );
											$("#passPointDlg").dialog("open");
											localStorage.Activate="television";
											var html = ">> Action: activate television("+objid+") && Interaction: graphical password(passpoint)<br/>";
											localStorage.flag3D="false";
											logDebug(html);
											writelog("television","graphical_password","click","prompt_dialog",html);
										}
									}else if(jQuery.inArray(objid, swuPic)!=-1){
										if(localStorage.requestFlag="true"){
											$("#passPointDlg").on( "dialogopen", function(e) {
										        //e.preventDefault();
										        //prevent ajax multiple fire
										        //if(e.handled !== true){
													$('#passPointDlg').load('../passwordType/passPoint.php',{
														object: "pictureOfSWU"}
													);
													//e.handled = true;
										        //}
											} );
											$("#passPointDlg").dialog("open");
											localStorage.Activate="pictureOfSWU";
											var html = ">> Action: activate picture of SWU("+objid+") && Interaction: graphical password(passpoint)<br/>";
											localStorage.flag3D="false";
											logDebug(html);
											writelog("picture of SWU","graphical_password","click","prompt_dialog",html);
										}
									}
								}else if(jQuery.inArray(objid, patternUnlock)!=-1){
									if(jQuery.inArray(objid, refrigerator)!=-1){
										if(localStorage.requestFlag="true"){
											$("#patternUnlockDlg").on( "dialogopen", function(e) { 
												e.preventDefault();
												if(e.handled !== true){
													$('#patternUnlockDlg').load('../passwordType/patternUnlock.php',{
														object: "refrigerator"}
													);
													e.handled = true;
										        }
											} );
											//alert('55');
											$("#patternUnlockDlg").dialog("open");
											localStorage.Activate="refrigerator";
											var html = ">> Action: activate refrigerator("+objid+") && Interaction: graphical password(pattern unlock)<br/>";
											localStorage.flag3D="false";
											logDebug(html);
											writelog("refrigerator","graphical_password","click","prompt_dialog",html);
										}
									}
								}
								//localStorage.flag3D="false";
								localStorage.objNotActivate="false";
							}
						}
						//obj.oldmaterial=obj.getMaterial();

						document.onmousedown=function(e){
							//e.preventDefault();
							if(obj.getId()!="wallobject"){
								//e.preventDefault();
								getPasswordPrompt();
								//flag = false;	
							}             				
						};
					}
				}
			}
			//ดึงข้อมูล camara ออกมาจาก scene
			var camera=gameScene.camera;
			//อ่านค่า rotation ของ camera ออกมา
			camerarot=camera.getRotation();
			inc=(mousepos.y-(document.getElementById('canvas').offsetHeight/2))/500;
			//หาค่าของ transition ออกมา
			var trans=GLGE.mulMat4Vec4(camera.getRotMatrix(),[0,0,-1,1]);
			//หาค่า manitude ของฉาก
			var mag=Math.pow(Math.pow(trans[0],2)+Math.pow(trans[1],2),0.5);
			trans[0]=trans[0]/mag;
			trans[1]=trans[1]/mag;
			//กำหนดมุมในแกน X ของกล้อง
			camera.setRotX(1.56-trans[1]*inc);
			//กำหนดมุมในแกน Z ของกล้อง (การยกกล้องขึ้น-ลง)
			camera.setRotZ(-trans[0]*inc);
			//เอาค่าความกว้างของ canvas ที่กำหนดเอาไว้ออกมา
			var width=document.getElementById('canvas').offsetWidth;
			//กำหนดการ pan มุมกล้องไปในแกน Y (การหมุุนกล้องไปทางซ้าย-ขวา)
			if(mousepos.x<width*0.3){
				var turn=Math.pow((mousepos.x-width*0.3)/(width*0.3),2)*0.005*(now-lasttime);
				camera.setRotY(camerarot.y+turn);
			}
			if(mousepos.x>width*0.7){
				var turn=Math.pow((mousepos.x-width*0.7)/(width*0.3),2)*0.005*(now-lasttime);
				camera.setRotY(camerarot.y-turn);
			}
		}
	}
	
	function checkkeys(){
		//ดึงข้อมูล camara ออกมาจาก scene
		var camera=gameScene.camera;
		//ดึงตำแหน่งของกล้อง
		camerapos=camera.getPosition();
		//อ่านค่า rotation ของ camera ออกมา
		camerarot=camera.getRotation();
		//ดึงค่า  rotation Matrix ของกล้องออกมา
		var mat=camera.getRotMatrix();
		//หาค่าของ transition ออกมา
		var trans=GLGE.mulMat4Vec4(mat,[0,0,-1,1]);
		//หาค่า manitude ของฉาก
		var mag=Math.pow(Math.pow(trans[0],2)+Math.pow(trans[1],2),0.5);
		trans[0]=trans[0]/mag;
		trans[1]=trans[1]/mag;
		var yinc=0;
		var xinc=0;
		//ตรวจสอบ keyboard ที่กดขึ้นมา
		if(keys.isKeyPressed(GLGE.KI_W)) {yinc=yinc+parseFloat(trans[1]);xinc=xinc+parseFloat(trans[0]);}
		if(keys.isKeyPressed(GLGE.KI_S)) {yinc=yinc-parseFloat(trans[1]);xinc=xinc-parseFloat(trans[0]);}
		if(keys.isKeyPressed(GLGE.KI_A)) {yinc=yinc+parseFloat(trans[0]);xinc=xinc-parseFloat(trans[1]);}
		if(keys.isKeyPressed(GLGE.KI_D)) {yinc=yinc-parseFloat(trans[0]);xinc=xinc+parseFloat(trans[1]);}
		if(keys.isKeyPressed(GLGE.KI_LEFT_ARROW)) {camera.setRotZ(0.5);}
		if(levelmap.getHeightAt(camerapos.x+xinc,camerapos.y)>30) xinc=0;
		if(levelmap.getHeightAt(camerapos.x,camerapos.y+yinc)>30) yinc=0;
		if(levelmap.getHeightAt(camerapos.x+xinc,camerapos.y+yinc)>30){yinc=0;xinc=0;}
		else{
			camera.setLocZ(levelmap.getHeightAt(camerapos.x+xinc,camerapos.y+yinc)+8);
		}
		if(xinc!=0 || yinc!=0){
			camera.setLocY(camerapos.y+yinc*0.05*(now-lasttime));camera.setLocX(camerapos.x+xinc*0.05*(now-lasttime));
		}
	}

	//levelmap มีไว้เพื่อที่จะกำหนดพื้นที่การเคลื่อนที่ไปได้ภายใน 3D Enviroment ของเราว่าสามารถที่จะไปในตามแกน x, y และ z ตามลำดับ 
	//Create a world map(imgPath,width,imageWidth,imageWidth,x1,x2,y1,y2,z1,z2)
	levelmap=new GLGE.HeightMap("../3Delement/3Dimg/map.png",120,120,-50,50,-50,50,0,50);
	
	var lasttime=0;
	var frameratebuffer=60;
	start=parseInt(new Date().getTime());
	var now;
	var cnt=0;
	//ฟังค์ชั่น render ภาพออกมาตลอดเวลา (มองว่าเป็นส่วนของ main ก็ได้)
	function render(){
		//ระหว่างที่ทำงาน ก็จะมีการตรวจสอบข้อมูลต่างๆดังนี้
		//1.ตรวจสอบ FrameRate ของระบบ
		now=parseInt(new Date().getTime());
		frameratebuffer=Math.round(((frameratebuffer*9)+1000/(now-lasttime))/10);
		//document.getElementById("debug").innerHTML="Frame Rate:"+frameratebuffer;
		$('#debug').html("Frame Rate:"+frameratebuffer);
		flag = localStorage.flag3D;
		//console.log(flag);
		if(flag=="true"){
			//2.ดักจับ Event ที่เกิดจาก mouse
			mouselook();
			//3.ดักจับ Event ที่เกิดจาก keyboard
			checkkeys();
		}
		//4.ตัวสั่ง render ภาพขึ้นมาแสดงผล
		gameRenderer.render();
		lasttime=now;
	}
	//กำหนดเวลาในการ render ทุกๆ 1 วินาที
	setInterval(render,1);
	var inc=0.2;
	document.getElementById("canvas").onmousedown=function(e){gameScene.pick(e.clientX-this.parentNode.offsetLeft,e.clientY-this.parentNode.offsetTop); }
	document.getElementById("canvas").onmouseover=function(e){mouseovercanvas=true;}
	document.getElementById("canvas").onmousemove=function(e){mouseovercanvas=true;}
	document.getElementById("canvas").onmouseout=function(e){mouseovercanvas=false;}
}
doc.load("../passwordType/level.xml");