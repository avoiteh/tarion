function TEditMenu(name,hname,parent){
	this.type='TEditMenu';
	this.title='Мастер пункта меню';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.parent=parent;//родитель
	this.style=0;//числовой указатель стиля
	this.color=0;//числовой указатель цвета фона 0-белый
	this.elementId=null;
	this.element=null;
	
	this.Paint=function(){
		if(this.elementId!=null){
			this.element=this.parent.bo[this.elementId];
		}
		if(this.element!=null){
			var s="<h4>"+this.title+"</h4>";
			s+="Наименование : <input type=text id='"+this.hname+"_name' value='"+this.element['name']+"'>";
			s+="<input type=button value=' Сохранить ' onclick='"+this.name+".saveElement();'><br>";
			//проверим кто у данного пункта в потомках
			s+="<table cellspacing=0 cellpadding=0><tr bgcolor='#cccccc'><td colspan=3>Потомки данного элемента<br><small>Потомками элемента типа <b>menu</b> могут быть:<br> - произвольное количество элементов типа <b>menu</b>;<br> - или один элемент типа <b>\"Таблица\"</b>;<br> - или один элемент типа <b>\"Дерево\"</b>;</small></td></tr>";
			s+="<tr bgcolor='#cccccc'><td>Наименование</td><td>Тип</td><td></td></tr>";
			var j, flag;
			var cntMenu=0;
			var cntCRUD=0;
			var cntTreeCRUD=0;
			var bcol='ffffff';
			for(var i in this.parent.bo){
				if(this.parent.bo[i]['parent']==this.elementId){
					s+="<tr bgcolor='#"+bcol+"'><td>";
					s+=this.parent.bo[i]['name'];
					s+='</td><td>'+this.nameOfType(this.parent.bo[i]['type'])+'</td><td>';
					if(this.parent.bo[i]['type']=='menu'){cntMenu++;}
					if(this.parent.bo[i]['type']=='CRUD'){cntCRUD++;}
					if(this.parent.bo[i]['type']=='TreeCRUD'){cntTreeCRUD++;}
					//проверить есть ли у данного элемента потомки, если нет, то показать иконку "удалить"
					flag=true;
					for(j in this.parent.bo){
						if(this.parent.bo[j]['parent']==i){
							flag=false;
						}
					}
					if(flag){
						s+="<img src='images/del.jpg' width=12px title='Удалить элемент' onclick='"+this.name+".deleteElement("+i+");'>";
					}
					s+='</td></tr>';
					if(bcol=='cccccc'){bcol='ffffff';}else{bcol='cccccc';}
				}
			}
			//добавить элемент
			s+="<tr><td colspan=3>"+this.makeAddElement(cntMenu,cntCRUD,cntTreeCRUD)+"</td></tr>";
			s+="</table>";
			return s;
		}
	}
	this.nameOfType=function(type){
		switch(type){
			case 'menu':
				return 'Пункт меню';
			break;
			case 'CRUD':
				return 'Таблица';
			break;
			case 'TreeCRUD':
				return 'Дерево';
			break;
		}
	}
	this.deleteElement=function(i){
		this.parent.deleteElement(i);
	}
	this.newElement=function(){
		var obj=document.getElementById(this.hname+'_addElem');
		var type=obj.value;
		this.parent.newElement(this.elementId, type);
	}
	this.saveElement=function(){
		var obj=document.getElementById(this.hname+'_name');
		this.element['name']=obj.value;
		this.parent.saveQuest();
		//this.parent.context.Paint();
	}
	this.makeAddElement=function(cntMenu,cntCRUD,cntTreeCRUD){
		s='';
		if(cntCRUD==0 && cntTreeCRUD==0){
			s+="Добавить элемент типа <select id="+this.hname+"_addElem>";
			s+="<option value='menu'>Пункт меню</option>";
			if(cntMenu==0){
				s+="<option value='CRUD'>Таблица</option>";
				s+="<option value='TreeCRUD'>Дерево</option>";
			}
			s+="</select>&nbsp;<img src='images/new.jpg' width=12px title='Создать элемент - потомок' onclick='"+this.name+".newElement();'>";
		}
		return s;
	}
}