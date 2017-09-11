//визуальный компонент для отображения таблиц базы данных
function TDBTables(name,hname,maincontext){
	this.name = name;
	this.hname=hname;
	this.maincontext=maincontext;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.sel_color='#ffffff';
	this.sel_bgcolor='#0000ff';
	this.width='100%';
	this.height='100%';
	this.tables = new Array;//многовложенный массив, собственно отображаемый список таблиц
	this.divScroll=0;//чтобы сохранять прокрутку div
	
	this.style = 0;
		
	this.onmousemove=function(){}//очень нужная заглушка!!!
	
	this.collectData=function(){
		//собрать все данные из полей
		var id, newtable;
		var newfield;
		var type,remark;
		var obj;
		
		for(var i in this.tables){
			//имя таблицы
			id=this.hname+'_'+this.tables[i]['name'];
			obj=document.getElementById(id);
			//alert(id+"\n"+obj);
			newtable=obj.value;
			
			for(field in this.tables[i]['fields']){
				//имя поля
				id=this.hname+'_'+this.tables[i]['name']+'_'+field+'_name';
				obj=document.getElementById(id);
				//alert(id+"\n"+obj);
				newfield=obj.value;
				//type
				id=this.hname+'_'+this.tables[i]['name']+'_'+field+'_type';
				this.tables[i]['fields'][field]['type']=document.getElementById(id).value;
				//remark
				id=this.hname+'_'+this.tables[i]['name']+'_'+field+'_remark';
				this.tables[i]['fields'][field]['remark']=document.getElementById(id).value;
				
				if(newfield!=field){
					this.tables[i]['fields'][newfield]=this.tables[i]['fields'][field];
					delete this.tables[i]['fields'][field];
				}
			}
			this.tables[i]['name']=newtable;
		}
	}
	this.idByTableName=function(table){
		var j=false;
		for(var i in this.tables){
			if(this.tables[i]['name']==table){
				j=i;
			}
		}
		return j;
	}
	this.onDropTable=function(table){
		this.collectData();
		var j=this.idByTableName(table);
		if(j){
			this.tables.splice(j,1);
			this.maincontext.Paint();
			document.getElementById(this.hname).scrollTop=this.divScroll;//восстановить прокрутку DIV
		}
	}
	this.onDropField=function(table,field){
		this.collectData();
		var j=this.idByTableName(table);
		if(j){
			delete this.tables[j]['fields'][field];
			this.maincontext.Paint();
			document.getElementById(this.hname).scrollTop=this.divScroll;//восстановить прокрутку DIV
		}
	}
	this.onAddTable=function(){
		this.collectData();
		var n=this.tables.length;
		this.tables[n]=new Array;
		this.tables[n]['name']='new_table';
		this.tables[n]['fields']=new Array;
		this.maincontext.Paint();
		document.getElementById(this.hname).scrollTop=this.divScroll;//восстановить прокрутку DIV
	}
	this.onAddField=function(table){
		this.collectData();
		var j=this.idByTableName(table);
		if(j){
			var id=0;
			while(this.tables[j]['fields']['newField'+id]!=null){id++;}
			this.tables[j]['fields']['newField'+id]=new Array;
			this.tables[j]['fields']['newField'+id]['type']='int';
			this.tables[j]['fields']['newField'+id]['remark']='новое поле';
			this.maincontext.Paint();
			document.getElementById(this.hname).scrollTop=this.divScroll;//восстановить прокрутку DIV
		}
	}
	this.Paint = function(){
		this.debug='';
		var obj=document.getElementById(this.hname);//запомнить прокрутку DIV
		if(obj!=null){this.divScroll=obj.scrollTop;}
		
		switch(this.style){
			case 0:
				s = "<div onmousemove='" + this.name + ".onmousemove(event);' style='overflow:scroll;width:" + this.width + ";height:" + this.height + "' id='" + this.hname + "'>";
				//оттут унутре dbtree
				//для каждой таблицы
				s+="<br><img src='images/new.jpg' width='12px' title='Создать новую таблицу' onclick='"+this.name+".onAddTable();'>";
				s+="<table cellspacing=0 cellpadding=0 style='font-size:12px;width:100%;'>";
				var field;
				var tcol='cccccc';
				for(var i in this.tables){
					s+="<tr bgcolor='"+tcol+"'>";
					s+="<td colspan=4>"+this.paintInput(this.hname+'_'+this.tables[i]['name'], this.tables[i]['name'], 'font-size:14px; font-weight:bold; background-color:#'+tcol) +"</td>";
					s+="<td><img src='images/new.jpg' width='12px' title='Добавить поле' onclick='"+this.name+".onAddField(\""+this.tables[i]['name']+"\")'>";
					s+="<img src='images/del.jpg' width='12px' title='Удалить таблицу' onclick='"+this.name+".onDropTable(\""+this.tables[i]['name']+"\")'></td></tr>";
					s+="<tr bgcolor='"+tcol+"'><td width='50px'>&nbsp;</td><td colspan=3>ID +</td><td> </td></tr>";
					for(field in this.tables[i]['fields']){
						s+="<tr bgcolor='"+tcol+"'><td width='50px'>&nbsp;</td>";
						s+="<td width='50px'>"+this.paintInput(this.hname+'_'+this.tables[i]['name']+'_'+field+'_name', field, 'font-size:12px; background-color:#'+tcol) +"</td>";
						s+="<td width='50px'>" + this.paintSelectType(this.hname+'_'+this.tables[i]['name']+'_'+field+'_type', this.tables[i]['fields'][field]['type'], 'font-size:12px; background-color:#'+tcol) + "</td>";
						s+="<td>" + this.paintInput(this.hname+'_'+this.tables[i]['name']+'_'+field+'_remark', this.tables[i]['fields'][field]['remark'], 'font-size:12px; background-color:#'+tcol) + "</td>";
						s+="<td><img src='images/del.jpg' width='12px' title='Удалить поле' onclick='"+this.name+".onDropField(\""+this.tables[i]['name']+"\", \""+field+"\");'></td></tr>";
					}

					if(tcol=='cccccc'){tcol='ffffff';}else{tcol='cccccc';}
				}
				s+="</table>";
				s+="</div>";
			break;
		}
		//alert(this.debug);
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
	
	this.paintSelectType=function(id,type,style){
		s="<select style='"+style+"' id='"+id+"'>";
		s+="<option value='int'";if(type=='int'){s+=" selected";}s+=">int</option>";
		s+="<option value='string'";if(type=='string'){s+=" selected";}s+=">string</option>";
		s+="<option value='date'";if(type=='date'){s+=" selected";}s+=">date</option>";
		s+="<option value='text'";if(type=='text'){s+=" selected";}s+=">text</option>";
		s+="<option value='file'";if(type=='file'){s+=" selected";}s+=">file</option>";
		s+="<option value='on_off'";if(type=='on_off'){s+=" selected";}s+=">on\\off</option>";
		s+="</select>";
		return s;
	}
	this.paintInput=function(id,value,style){
		s="<input type=text id='"+id+"' style='"+style+"' value='"+value+"'>";
		return s;
	}
}
