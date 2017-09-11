function TContext(name,hname){//главный класс приложения
	this.name=name;
	this.hname=hname;
	this.AJAX_URL = 'ajax.php';//полный URL для AJAX-запросов
	this.images_path='images/';
	this.navigator=navigator.appName;
	
	//данные текущего сеанса
	this.user = '';//обращение к пользователю
	this.user_id= 0;//id пользователя
	this.authorize=false;//флаг авторизации
	this.title = 'Добро пожаловать';//подставляемая при репаинте шапка
	
	//визуальные параметры
	this.width=document.body.clientWidth;
	this.height=document.body.clientHeight;
	this.mouseX=0;
	this.mouseY=0;
	this.mousedown=false;
	this.container = document.getElementById(hname);//объект контейнера
	this.elements = new Array;//хранит объекты контекста
	this.currentobject=null;//выбранный текущий объект
	
	//ресурсные поля и методы
	this.events = new Array;//все события храним здесь
	//как создать общее событие?
	this.AddEvent=function(name){
		if(this.events[name]==null){
			this.events[name]= new TResourceEvent();
			return true;
		}else{
			return false;
		}
	}
	//как подключиться к сработавшему событию?
	this.AddReaction=function(name, owner){
		if(this.events[name]!=null){
			this.events[name].subscribers[this.events[name].subscribers.length]=owner;
			return true;
		}else{
			return false;
		}
	}
	//произошло событие, как отреагировать?
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
	
	//специально для создания объектов
	this.createObject=function(tip, name, hname){
		//прверить, существует ли такой объект уже в массиве elements
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
	//освобождение объектов
	this.freeObject=function(obj){
		for(var id in this.elements){
			if(obj.name==this.elements[id].name){
				//если такой объект найден в списке, то удаляем его
				this.elements[id]=null;
				this.elements.splice(id,1);
			}
		}
		this.Paint();
	}
	//освобождение элемента по имени
	this.freeObjectByName=function(name){
		for(var id in this.elements){
			if(name==this.elements[id].name){
				//если такой объект найден в списке, то удаляем его
				this.elements[id]=null;
				this.elements.splice(id,1);
			}
		}
		this.Paint();
	}
	
	this.UserAuthorize=function(auth, json){//произошла удачная авторизация/разавторизация
		this.authorize=auth;
		this.user=json['nicname'];
		this.user_id=json['user_id'];
		if(this.authorize){
			//теперь создаём панели перечисленные в списке json['resources']
			//создать панель Kabinet
			if(json['resources']['panelKabinet']){
			if(this.createObject('TPanelKabinet','panelKabinet','HpanelKabinet')){
				this.elements[this.elements.length]=panelKabinet;
				panelKabinet.title='Личные данные';
				panelKabinet.SendQuest();
			}}
			//создать панель типы объектов isee
			if(json['resources']['panelIseeType']){
			if(this.createObject('TPanelIseeType','panelIseeType','HpanelIseeType')){
				this.elements[this.elements.length]=panelIseeType;
				panelIseeType.title='Типы объектов';
				panelIseeType.askContent();
			}}
			//создать панель модерации объектов isee
			if(json['resources']['panelIseeModerate']){
			if(this.createObject('TPanelIseeModerate','panelIseeModerate','HpanelIseeModerate')){
				this.elements[this.elements.length]=panelIseeModerate;
				panelIseeModerate.SendQuest();
			}}
		}else{
			//создать панель Kabinet
			this.freeObject(panelKabinet);
			this.freeObject(panelIseeType);
		}
		this.Paint();	
	}
	//мегаотрисовка всего
	this.Paint = function(){
		var s='';
		//отрисовываем элементы
		for(var i in this.elements){
			if(this.elements[i].enable && this.elements[i].open){s+=this.elements[i].Paint();}
		}
		//отрисовываем BarPanels
		var pb="<table id='"+this.hname+"_bar_panels' style='width:"+this.width+"px;height:25px;background-color:#aaaaaa;border:1px solid #000000;position:absolute;left:0;top:0;z-index:11' align='right'><tr><td>";
		for(var id in this.elements){
			if(!this.elements[id].open){
				pb+="&nbsp;<span style='height:23px;border:2px;border-color:#ffffff;background-color:#dddd00;cursor:pointer;' onclick='"+this.name+".Opened("+this.elements[id].name+", true);'>&nbsp;"+this.elements[id].title+"&nbsp;</span>";
			}
		}
		pb+="</td></tr></table>";
		pb=pb+s;
		this.container.innerHTML=pb;
	}//переотрисовывает элементы контекста
	
	this.Opened=function(element, open){
		element.open=open;
		this.Paint();
	}
	
	//системные методы
	//метод для подключения к аяксу
	//все запросы приходят сюда и ставятся в очередь
	//запросы изымаются из очереди и производятся
	//если пришёл новый запрос, а производится, то в очередь
	//когда запрос выполнился - производится очищается
	this.AJAXqueue = new Array;//собсно очередь
	this.AJAXquery=function(query, name){//query - собственно запрос, name - имя объекта, который запросил
		//поставить запрос в очередь
		var c=this.AJAXqueue.length;
		this.AJAXqueue[c] = new Array(query, name);
		if(gloAJAXreq==null && this.AJAXqueue.length>0){
			//выполнить запрос
console.log('url='+this.AJAX_URL+', q='+this.AJAXqueue[0][0]);
			GloAJAXquery(this.AJAX_URL, this.AJAXqueue[0][0]); //post - version
		}
	}
	
	/* form-version 
	this.AJAXresult=function(answer){//обработчик данных возвращаемых от формы
		var obj = eval(main.AJAXqueue[0][1]+';');
		//выбрать верхний элемент очереди, отдать ему данные, удалить его из очереди
		var obj = eval(main.AJAXqueue[0][1]+';');
		main.AJAXqueue.splice(0,1);
console.log(main.AJAXqueue[0]+"\n\n\n"+main.AJAXqueue[1]);
		//если очередь не пуста - то выполнить запрос
		//gloAJAXreq=null;
		if(main.AJAXqueue.length>0){
			GloAJAXquery(main.AJAXqueue[0][0]);
		}
		//отдать данные
		obj.AJAXresult(answer);
	}
	*/
	
	
	this.AJAXresult=function(){//обработчик возвращённых данных// get - version
		//получить объект
	if(gloAJAXreq!=null){
		if (gloAJAXreq.readyState == 4) {
   		    // для статуса "OK"
console.log(gloAJAXreq.status);
   		    if (gloAJAXreq.status == 200) {
   		    	//спрятать часики
   		    	var img=document.getElementById('ajax_clock');
				img.style.display='none';
   		        // здесь идут всякие штуки с полученным ответом
   		        var gettingText = gloAJAXreq.responseText;
   		        //выбрать верхний элемент очереди, отдать ему данные, удалить его из очереди
   		        var obj = eval(main.AJAXqueue[0][1]+';');
				main.AJAXqueue.splice(0,1);
				//если очередь не пуста - то выполнить запрос
				gloAJAXreq=null;
				if(main.AJAXqueue.length>0){
					GloAJAXquery(main.AJAX_URL, main.AJAXqueue[0][0]); //post - version
				}
				//отдать данные
				obj.AJAXresult(gettingText);
   		    }else{
   		    		alert('error: '+gloAJAXreq.status);//Text);
   		   	}
   		}
	}
	}
	
		
	//обработка всех абсолютно кликов
	//ведём её централизованно, дабы правильно подключать всё желаемое
	this.CliCkerCenter = function(who, mess){//who - кто сказал "клик", имя объекта; mess - чего он сказал
		//alert(who+', '+mess);
		switch(who){
			case panelAuth.name:
				//авторизация
				//взять логин, пароль, переслать серверу
				//*после отработки управление передаётся обратно объекту авторизации
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
	this.subscribers = new Array;//список подписантов, здесь храним вызовы, отзывающиеся на данное событие
									//например panel1.CallMe(message), где message - аргумент передаваемый объектом-инициатором
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
   	// для Mozilla, Safari, Opera:
   	if (window.XMLHttpRequest)
   	{
   	  gloAJAXreq = new XMLHttpRequest();
   	  sendParam = null;
   	}
   	// для IE:
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
   	  //показать часики
   	  var x=Math.round(document.body.clientWidth/2-30);
	  var y=Math.round(document.body.clientHeight/2-30);
	  var img=document.getElementById('ajax_clock');
	  img.style.left=x+'px';
	  img.style.top=y+'px';
	  img.style.display='block';
console.log(sendParam);
   	  gloAJAXreq.send(sendParam);
   	}
}

/*
function GloAJAXquery(url){// get - version
//alert(url);
	var sendParam = '';
   	// для Mozilla, Safari, Opera:
   	if (window.XMLHttpRequest)
   	{
   	  gloAJAXreq = new XMLHttpRequest();
   	  sendParam = null;
   	}
   	// для IE:
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
	this.ontimer='';//вызов
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
			//s='"'+escape(obj)+'"';
			s='"'+obj+'"';
		}else{
			s='"'+obj+'"';
		}
	}
	return s;
}
