function TPanelTranslate(name,hname,context){
	this.type='TPanelTranslate';
	this.title='Транслятор';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = false;
	this.context=context;//на каком контексте лежит
	this.style=0;//числовой указатель стиля
	this.color=0;//числовой указатель цвета фона 0-белый
	this.left=400;
	this.top=25;
	this.width=500;
	this.height=500;
	this.stage=0;

	this.Paint=function(){
		//назначить цвет фона
		var bgk=this.color;
		var s="<table id='" + this.hname + "' style='width:" + this.width + "px;height:" + this.height + "px;background-color:#ffffcc;border:1px solid #000000;position:absolute;left:" + this.left + ";top:" + this.top + ";z-index:100' onmouseover='" + this.context.name + ".currentobject=" + this.name + ";'><tr bgcolor='#cccccc'><td>" + this.title + "</td><td align='right' height=10><img src='" + this.context.images_path + "close.gif' onmousedown='" + this.context.name + ".Opened(" + this.name + ", false);'>";
				//<img src='"+context.images_path+"free.gif' onmousedown='"+this.context.name+".freeObject("+this.name+");'>

		s+="</td></tr><tr><td valign=top colspan=2>";
		s+="<input type=button value=' Начать трансляцию проекта ' onclick='"+this.name+".stage=0;"+this.name+".stageTranslate();'>";
		s+="<div style='overflow:scroll;width:100%;height:"+(this.height-50)+"px;font-size:12px;' id='"+this.hname+"_logTranslate'>";
		s+="</div>";
		s+="</table>";
		return s;
	}
	
	this.stageTranslate=function(){
		switch(this.stage){
			case 0://проверка доступности БД
				document.getElementById(this.hname+'_logTranslate').innerHTML='';
				this.SendQuest('checkDB');
			break;
			case 1://проверка доступности папки
				this.SendQuest('checkDir');
			break;
			case 2://создание таблиц
				this.SendQuest('createTables');
			break;
			case 3://проверка наличия таблицц для системы авторизации и разделения доступа
				this.SendQuest('checkAuthDB');
			break;
			case 4://создание моделей, вьюх и акшинов для системы авторизации и разделения доступа
				this.SendQuest('createAuth');
			break;
			case 5://создание вьюхи меню БО
				this.SendQuest('createMenuBO');
			break;
			case 6://создание моделей для всех CRUD & TreeCRUD БО
				this.SendQuest('createCRUDsBO');
			break;
		
			case 7://создание вьюхи меню ФО
				this.SendQuest('createMenuFO');
			break;
			case 8://создание моделей для всех CRUD & TreeCRUD ФО
				this.SendQuest('createCRUDsFO');
			break;
		}
	}
	this.stageResult=function(res){
		var obj=document.getElementById(this.hname+'_logTranslate');
//alert(obj+"\n"+res['Flag']+"\n"+res['Mess']);
		if(res['Flag']=='OK'){
			obj.innerHTML+=res['Mess']+'<br><hr>';
			this.stage++;
			if(this.stage<9){
				this.stageTranslate();
			}else{
				this.stage=0;
				alert('Трансляция завершена!');
			}
		}
		if(res['Flag']=='Error'){
			obj.innerHTML+='<hr><span style="color:#ff0000;">'+res['Mess']+'</span><br><hr>';
			alert('Ошибка трансляции.');
			this.stage=0;
		}
	}
	
	this.SendQuest=function(mode){
		var q='{"id":"Translate","mode":"'+mode+'"}';
//alert(q);
		context.AJAXquery(q, this.name);
	}
	
	this.AJAXresult=function(json_serial){//на основании полученного JSON объекта
//alert(json_serial);
		var json=eval(json_serial);
//alert(json['Translate']);
		if(json['id']=='Translate'){
			this.stageResult(json['Translate']);
		}
		if(json['sendMess']=='Refresh'){
			this.SendQuest();
		}
	}
}