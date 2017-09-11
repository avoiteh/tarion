function TPanelFO(name,hname,context){
	this.type='TPanelFO';
	this.title='Front Office';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = false;
	this.context=context;//на каком контексте лежит
	this.style=0;//числовой указатель стиля
	this.color=0;//числовой указатель цвета фона 0-белый
	this.left=50;
	this.top=30;
	this.width=900;
	this.height=500;
	this.bo=new Array;
	this.currentEdit=null;
		
	this.Paint=function(){
		//назначить цвет фона
		var bgk=this.color;
		switch(this.color){
			case 0:
				bgk='ffffff';
			break;
		}
		
		//собственно панель
		switch(this.style){
			case 0://<div style='width:100%;height:100%;overflow:scroll'>
				var s="<table id='" + this.hname + "' style='width:" + this.width + "px;height:" + this.height + "px;background-color:#ffffcc;border:1px solid #000000;position:absolute;left:" + this.left + ";top:" + this.top + ";z-index:100' onmouseover='" + this.context.name + ".currentobject=" + this.name + ";'><tr bgcolor='#cccccc'><td>" + this.title + "</td><td align='right' height=10><img src='" + this.context.images_path + "close.gif' onmousedown='" + this.context.name + ".Opened(" + this.name + ", false);'>";
				//<img src='"+context.images_path+"free.gif' onmousedown='"+this.context.name+".freeObject("+this.name+");'>

				s+="</td></tr><tr><td valign=top colspan=2>";
				s+="<table border=1 width=100% height="+(this.height)+"px><tr><td valign=top>";
				s+="<div style='overflow:scroll;width:100%;height:100%;font-size:12px;' class='step2'>";
				s+="<div>Главное меню <img src='images/new.jpg' width='12px' title='Создать новый пункт меню' onclick='"+this.name+".createNewMenuLine();'></div>";
				s+="<div style='overflow:scroll;height:450px;'>";
				s+="<ul class='Container'>";
				s+=this.objectTreePaint(0, 0);
				s+="</ul>";
				s+="</div>";
				s+="</div>";
				s+="</td><td valign=top id="+this.hname+"_Editor>";
				
				if(this.currentEdit!=null){s+="<div style='overflow:scroll;height:500px;'>"+this.currentEdit.Paint()+"</div>";}
				s+="</td></tr></table>";
				//нарисовать слева дерево элементов, справа панель редакторов
				s+="</table>";
			break;
		}
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
	//ибо непосредственной отрисовкой занимается контекст
	
	this.objectTreePaint=function(parent,level){
		var s='';
		var ts='';
		var i,j;
		var node=new Array;
		j=0;
		for(i in this.bo){
			if(this.bo[i]['parent']==parent){
				node[i]=this.bo[i];
				j++;
			}
		}
		var max=j-1;
		for(i in node){
			if(max>0){
				s+="<li class='Node ExpandLeaf'>";
			}else{
				s+="<li class='Node ExpandLeaf IsLast'>";
			}
			max--;
			s+="<div class='Expand'></div>";
			s+="<div class='Content' style='cursor:pointer;' onclick='"+this.name+".selectElement("+i+");'><img src='images/" + this.getImgByType(node[i]['type']) + "'>" + node[i]['name'];
			ts=this.objectTreePaint(i,level+1);
			if(ts==''){s+="<img src='images/del.jpg' width='12px' onclick='"+this.name+".deleteElement("+i+");'>";}
			s+="</div>";
			s+="<ul class='Container'>";
			s+=ts;
			s+="</ul>";
			s+="</li>";
		}
		return s;
	}
	this.selectElement=function(i){
		this.currentEdit=null;
		var s="this.currentEdit= new "+this.getFuncByType(this.bo[i]['type'])+"('"+this.name+".currentEdit', '"+this.hname+"_Hedit', this);";
//alert(s);
		eval(s);
//alert(this.currentEdit);
		this.currentEdit.elementId=i;
		this.context.Paint();
	}
	this.deleteElement=function(j){
		//проверить, допустимо ли удалять?
		var flag=true;
		for(var i in this.bo){
			if(this.bo[i]['parent']==j){flag=false;}
		}
		if(flag){
			delete this.bo[j];
			this.context.Paint();
		}else{
			alert('Нельзя удалить данный элемент, т.к. у него есть потомки!');
		}
	}
	this.createNewMenuLine=function(){
		this.newElement(0,'menu');
	}
	this.newElement=function(parent, type){
		var n=0;
		for(var i in this.bo){if(i*1>n){n=i*1;}}
		n++;
		this.bo[n]=new Array;
		this.bo[n]['name']='Новый элемент';
		this.bo[n]['type']=type;
		this.bo[n]['parent']=parent;
		this.bo[n]['content']=new Array;
		this.context.Paint();
	}
	this.getImgByType=function(type){
		switch(type){
			case 'menu':
				return 'menu.gif';
			break;
			case 'CRUD':
				return 'crud.gif';
			break;
			case 'TreeCRUD':
				return 'tree_crud.gif';
			break;
		}
	}
	this.getFuncByType=function(type){
		switch(type){
			case 'menu':
				return 'TEditMenu';
			break;
			case 'CRUD':
				return 'TEditCRUD';
			break;
			case 'TreeCRUD':
				return 'TEditTreeCRUD';
			break;
		}
	}
	
	this.SendQuest=function(){//послать запрос относительно листа пользователей
		var q='{"id":"FO","mode":"get"}';
		context.AJAXquery(q, this.name);
	}

	this.saveQuest=function(){
		var newJSONtext = tryConvertToJSON(this.bo);
		var q='{"id":"FO","mode":"save","fo":'+newJSONtext+'}';
//alert(q);
		context.AJAXquery(q, this.name);
	}
	
	this.AJAXresult=function(json_serial){//на основании полученного JSON объекта
//alert(json_serial);
		var json=eval(json_serial);
//alert(json['fo']);
		if(json['fo']){
			this.bo=json['fo'];
			context.Paint();
		}
		if(json['id']=='saveFO'){
			context.Paint();
		}
		if(json['sendMess']=='Refresh'){
			this.SendQuest();
		}
	}
}

