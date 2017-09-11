function TContext(name,hname){//������� ����� ����������
	this.name=name;
	this.hname=hname;
	this.AJAX_URL = 'ajax.php';//������ URL ��� AJAX-��������
	this.images_path='images/';
	this.navigator=navigator.appName;
	
	//������ �������� ������
	this.user = '';//��������� � ������������
	this.user_id= 0;//id ������������
	this.authorize=false;//���� �����������
	this.title = '����� ����������';//������������� ��� �������� �����
	
	//���������� ���������
	this.width=document.body.clientWidth;
	this.height=document.body.clientHeight;
	this.mouseX=0;
	this.mouseY=0;
	this.mousedown=false;
	this.container = document.getElementById(hname);//������ ����������
	this.elements = new Array;//������ ������� ���������
	this.currentobject=null;//��������� ������� ������
	
	//��������� ���� � ������
	this.events = new Array;//��� ������� ������ �����
	//��� ������� ����� �������?
	this.AddEvent=function(name){
		if(this.events[name]==null){
			this.events[name]= new TResourceEvent();
			return true;
		}else{
			return false;
		}
	}
	//��� ������������ � ������������ �������?
	this.AddReaction=function(name, owner){
		if(this.events[name]!=null){
			this.events[name].subscribers[this.events[name].subscribers.length]=owner;
			return true;
		}else{
			return false;
		}
	}
	//��������� �������, ��� �������������?
	this.EnableEvent=function(name, message){
		var fname;
		for(var id in this.events[name].subscribers){
			fname=this.events[name].subscribers[id];
			eval(fname+'("'+message+'");');
		}
	}
	
	this.onmousemove = function(e){
		main.mouseX=e.screenX;
		main.mouseY=e.screenY;
//alert(main.currentobject);
		if(main.currentobject!=null){
    		var hobj= document.getElementById(main.currentobject.hname);
   			if(hobj!=null && main.currentobject!=null){
    			if(main.mousedown){
  					hobj.style.left=main.currentobject.mouseDX+main.mouseX;
  					hobj.style.top=main.currentobject.mouseDY+main.mouseY;
  					main.currentobject.left=hobj.style.left;
  					main.currentobject.top=hobj.style.top;
  					if(main.currentobject.onmove){main.currentobject.onmove();}
				}else{
					main.currentobject.mouseDX=hobj.offsetLeft-main.mouseX;
					main.currentobject.mouseDY=hobj.offsetTop-main.mouseY;
				}
   			}
		}
	}
	this.onmouseup=function(){
		main.mousedown=false;
		if(main.currentobject){
			if(main.currentobject.aftermove){main.currentobject.aftermove();}
		}
		main.currentobject=null;
	}
	this.onmousedown=function(){
		main.mousedown=true;
	}
	
	//���������� ��� �������� ��������
	this.createObject=function(tip, name, hname){
		//��������, ���������� �� ����� ������ ��� � ������� elements
		var flen=false;
		for(var id in this.elements){
			if(this.elements[id].name==name){
				//alert(id+'\n'+this.elements[id].name+'\n'+name);
				flen=true;
			}
		}
		if(!flen){
				var s=name+" = new "+tip+"('"+name+"', '"+hname+"', main);";
				eval(s);
				return(true);
		}else{return false;}
	}
	//������������ ��������
	this.freeObject=function(obj){
		for(var id in this.elements){
			if(obj.name==this.elements[id].name){
				//���� ����� ������ ������ � ������, �� ������� ���
				this.elements[id]=null;
				this.elements.splice(id,1);
			}
		}
		this.Paint();
	}
	//������������ �������� �� �����
	this.freeObjectByName=function(name){
		for(var id in this.elements){
			if(name==this.elements[id].name){
				//���� ����� ������ ������ � ������, �� ������� ���
				this.elements[id]=null;
				this.elements.splice(id,1);
			}
		}
		this.Paint();
	}
	
	this.UserAuthorize=function(auth, json){//��������� ������� �����������/��������������
		this.authorize=auth;
		this.user=json['nicname'];
		this.user_id=json['user_id'];
		if(this.authorize){
			//������ ������ ������ ������������� � ������ json['resources']
			//������� ������ Kabinet
			if(json['resources']['panelKabinet']){
			if(this.createObject('TPanelKabinet','panelKabinet','HpanelKabinet')){
				this.elements[this.elements.length]=panelKabinet;
				panelKabinet.title='������ ������';
				panelKabinet.SendQuest();
			}}
			//������� ������ ���� �������� isee
			if(json['resources']['panelIseeType']){
			if(this.createObject('TPanelIseeType','panelIseeType','HpanelIseeType')){
				this.elements[this.elements.length]=panelIseeType;
				panelIseeType.title='���� ��������';
				panelIseeType.askContent();
			}}
			//������� ������ ��������� �������� isee
			if(json['resources']['panelIseeModerate']){
			if(this.createObject('TPanelIseeModerate','panelIseeModerate','HpanelIseeModerate')){
				this.elements[this.elements.length]=panelIseeModerate;
				panelIseeModerate.SendQuest();
			}}
		}else{
			//������� ������ Kabinet
			this.freeObject(panelKabinet);
			this.freeObject(panelIseeType);
		}
		this.Paint();	
	}
	//������������� �����
	this.Paint = function(){
		var s='';
		//������������ ��������
		for(var i in this.elements){
			if(this.elements[i].enable && this.elements[i].open){s+=this.elements[i].Paint();}
		}
		//������������ BarPanels
		var pb="<table id='"+this.hname+"_bar_panels' style='width:"+this.width+"px;height:25px;background-color:#aaaaaa;border:1px solid #000000;position:absolute;left:0;top:0;z-index:11' align='right'><tr><td>";
		for(var id in this.elements){
			if(!this.elements[id].open){
				pb+="&nbsp;<span style='height:23px;border:2px;border-color:#ffffff;background-color:#dddd00;cursor:pointer;' onclick='"+this.name+".Opened("+this.elements[id].name+", true);'>&nbsp;"+this.elements[id].title+"&nbsp;</span>";
			}
		}
		pb+="</td></tr></table>";
		pb=pb+s;
		this.container.innerHTML=pb;
	}//���������������� �������� ���������
	
	this.Opened=function(element, open){
		element.open=open;
		this.Paint();
	}
	
	//��������� ������
	//����� ��� ����������� � �����
	//��� ������� �������� ���� � �������� � �������
	//������� ��������� �� ������� � ������������
	//���� ������ ����� ������, � ������������, �� � �������
	//����� ������ ���������� - ������������ ���������
	this.AJAXqueue = new Array;//������ �������
	this.AJAXquery=function(query, name){//query - ���������� ������, name - ��� �������, ������� ��������
		//��������� ������ � �������
		var c=this.AJAXqueue.length;
		this.AJAXqueue[c] = new Array(query, name);
		if(gloAJAXreq==null && this.AJAXqueue.length>0){
			//��������� ������
//alert('url='+this.AJAX_URL+', q='+this.AJAXqueue[0][0]);
			GloAJAXquery(this.AJAX_URL, this.AJAXqueue[0][0]); //post - version
		}
	}
	
	/* form-version 
	this.AJAXresult=function(answer){//���������� ������ ������������ �� �����
		var obj = eval(main.AJAXqueue[0][1]+';');
		//������� ������� ������� �������, ������ ��� ������, ������� ��� �� �������
		var obj = eval(main.AJAXqueue[0][1]+';');
		main.AJAXqueue.splice(0,1);
//alert(main.AJAXqueue[0]+"\n\n\n"+main.AJAXqueue[1]);
		//���� ������� �� ����� - �� ��������� ������
		//gloAJAXreq=null;
		if(main.AJAXqueue.length>0){
			GloAJAXquery(main.AJAXqueue[0][0]);
		}
		//������ ������
		obj.AJAXresult(answer);
	}
	*/
	
	
	this.AJAXresult=function(){//���������� ������������ ������// get - version
		//�������� ������
	if(gloAJAXreq!=null){
		if (gloAJAXreq.readyState == 4) {
   		    // ��� ������� "OK"
   		    if (gloAJAXreq.status == 200) {
   		    	//�������� ������
   		    	var img=document.getElementById('ajax_clock');
				img.style.display='none';
   		        // ����� ���� ������ ����� � ���������� �������
   		        var gettingText = gloAJAXreq.responseText;
   		        //������� ������� ������� �������, ������ ��� ������, ������� ��� �� �������
   		        var obj = eval(main.AJAXqueue[0][1]+';');
				main.AJAXqueue.splice(0,1);
				//���� ������� �� ����� - �� ��������� ������
				gloAJAXreq=null;
				if(main.AJAXqueue.length>0){
					GloAJAXquery(main.AJAX_URL, main.AJAXqueue[0][0]); //post - version
				}
				//������ ������
				obj.AJAXresult(gettingText);
   		    }else{
   		    		alert('error: '+gloAJAXreq.status);//Text);
   		   	}
   		}
	}
	}
	
		
	//��������� ���� ��������� ������
	//���� � ���������������, ���� ��������� ���������� �� ��������
	this.CliCkerCenter = function(who, mess){//who - ��� ������ "����", ��� �������; mess - ���� �� ������
		//alert(who+', '+mess);
		switch(who){
			case panelAuth.name:
				//�����������
				//����� �����, ������, ��������� �������
				//*����� ��������� ���������� ��������� ������� ������� �����������
			break;
			case 'mapView':
				mapView.ontoolbuttonclick(mess);
			break;
			case 'panelIseeType':
				panelIseeType.ontoolbuttonclick(mess);
			break;
			case 'panelGuestBox':
				panelGuestBox.ontoolbuttonclick(mess);
			break;
		}
	}
}
//end of TContext

//begin of TResourceEvent
function TResourceEvent(){
	this.subscribers = new Array;//������ �����������, ����� ������ ������, ������������ �� ������ �������
									//�������� panel1.CallMe(message), ��� message - �������� ������������ ��������-�����������
}
//end of TResourceEvent

/* form-version 
function GloAJAXquery(query){
	var spn=document.getElementById('mainSpanForm');
	spn.innerHTML='<form style="position:absolute;left:0;top:0;display:none;" id="mainAJAXform" name="mainAJAXform" action="ajax_test.php" method="post" target="upload_iframe"><input type="hidden" name="query" id="main_ajax_query"></form>';
	document.getElementById('main_ajax_query').value=query;
	var frm=document.getElementById('mainAJAXform');
	//alert(document.getElementById('main_ajax_query').value);
	document.mainAJAXform.submit();
}
*/

/*Post - version*/
function GloAJAXquery(url, query){// get - version
	var sendParam;
   	// ��� Mozilla, Safari, Opera:
   	if (window.XMLHttpRequest)
   	{
   	  gloAJAXreq = new XMLHttpRequest();
   	  sendParam = null;
   	}
   	// ��� IE:
   	else if (window.ActiveXObject)
   	{
   	  gloAJAXreq = new ActiveXObject("Microsoft.XMLHTTP");
   	}
   	else
   	{
   	  return false;
   	}
   	if (gloAJAXreq)
   	{
	  sendParam = 'query='+query;
   	  gloAJAXreq.onreadystatechange = main.AJAXresult;
   	  gloAJAXreq.open("post", url, true);
   	  gloAJAXreq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   	  //alert(sendParam);
   	  //�������� ������
   	  var x=Math.round(document.body.clientWidth/2-30);
	  var y=Math.round(document.body.clientHeight/2-30);
	  var img=document.getElementById('ajax_clock');
	  img.style.left=x+'px';
	  img.style.top=y+'px';
	  img.style.display='block';
//alert(query);
   	  gloAJAXreq.send(sendParam);
   	}
}

/*
function GloAJAXquery(url){// get - version
//alert(url);
	var sendParam = '';
   	// ��� Mozilla, Safari, Opera:
   	if (window.XMLHttpRequest)
   	{
   	  gloAJAXreq = new XMLHttpRequest();
   	  sendParam = null;
   	}
   	// ��� IE:
   	else if (window.ActiveXObject)
   	{
   	  gloAJAXreq = new ActiveXObject("Microsoft.XMLHTTP");
   	}
   	else
   	{
   	  return false;
   	}
   	if (gloAJAXreq)
   	{
   	  gloAJAXreq.onreadystatechange = main.AJAXresult;
   	  gloAJAXreq.open("GET", url, true);
   	  gloAJAXreq.send(sendParam);
   	}
}
*/

function Timer(){
	this.name='';
	this.enable=false;
	this.Interval=1000;
	this.ontimer='';//�����
	this.Start=function(){
		this.enable=true;
		this.innerontimer();
	}
	this.Stop=function(){
		this.enable=false;
	}
	this.innerontimer=function(){
		if(this.ontimer!=''){
			this.ontimer();
			if(this.enable){
				setTimeout(this.name+'.innerontimer();',this.Interval);
			}
		}
	}
}

function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
}

function tryConvertToJSON(obj){
	var s='';
	var d='';
	if(typeof obj=='object'){
		s+='{';
		for(var i in obj){
			s+=d+'"'+i+'":'+tryConvertToJSON(obj[i]);
			d=',';
		}
		s+='}';
	}else{
		if(typeof obj=='boolean'){
			s=String(obj);
		}else if(typeof obj=='string'){
			s='"'+escape(obj)+'"';
		}else{
			s='"'+obj+'"';
		}
	}
	return s;
}
