//визуальный компонент для отображения дерева
function TTree(name,hname,maincontext){
	this.name = name;
	this.hname=hname;
	this.maincontext=maincontext;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.sel_color='#ffffff';
	this.sel_bgcolor='#0000ff';
	this.width='100%';
	this.height='100%';
	this.tree = new Array;//многовложенный массив, собственно отображаемое дерево
	this.parent='';
	
	this.style = 0;
	
	this.levelsize=new Array(18,10,10,10,10,8,8);
	
	this.node_name='name';//имя поля для отображения названия пункта
	this.node_node='node';//имя поля для ветки данного пункта
	this.node_id='id';//имя поля для идентификатора пункта (возвращается при клике)
	this.node_level='level';//имя поля уровня ветки
	this.node_kolvo='kolvo';//количество элементов в подветке
	this.node_title='';
	this.edit=false;//флаг разрешающий редактировать дерево
	
	this.gloMegaTreeFlag=0;//тупо костыль, для присвоения сквозного идентификатора веткам дерева

	//this.backEdit=function(type,id){alert("type="+type+"\nid="+id);}//функция вызываемая при клике на кнопки редактирования
	this.backFunction=function(id, kolvo){alert(id);}//функция вызываемая при клике, её передаётся идентификатор пункта
	this.onmousemove=function(){}//очень нужная заглушка!!!
	
	this.editButtonsPaint=function(node){//id,kolvo,name){
		if(this.edit){
			s='';
			if(!node['noadd']){
				s+='<img src="images/new.jpg" onclick="' + this.name + '.newName('+node[this.node_id]+');">';
			}
			//([this.node_id], node[i][this.node_kolvo], node[i][this.node_name]);
			if(!node['noedit']){
				s+='<img src="images/edit.jpg" onclick="' + this.name + '.editName('+node[this.node_id]+');">';
			}
			s+='<img src="images/del.jpg" onclick="' + this.name + '.delName('+node[this.node_id]+');"></td><td width=100%>';
			s+='<span id="'+this.hname+'_nameEditCont_'+node[this.node_id]+'" value="'+name+'" style="display:none;"><input type="text" id="'+this.hname+'_nameEdit_'+node[this.node_id]+'" value="'+node[this.node_name]+'" style="width:100px;"><input type=button value="OK" onclick="'+this.name+'.okName('+node[this.node_id]+');"></span>';
		}else{
			s='';
		}
		return s;
	}
	this.newName=function(id){this.parent.newName(id);}
	this.newArticle=function(id){this.parent.newArticle(id);}
	this.delName=function(id){this.parent.delName(id);}
	this.saveName=function(id, name){this.parent.saveName(id,name);}
	this.okName=function(id){
		var obj0=document.getElementById(this.hname+'_name_'+id);
		var obj1=document.getElementById(this.hname+'_nameEditCont_'+id);
		var obj2=document.getElementById(this.hname+'_nameEdit_'+id);
		obj1.style.display='none';
		obj0.style.display='block';
		obj0.innerHTML=obj2.value;
		this.saveName(id, obj2.value);
	}
	this.editName=function(id){
		var obj0=document.getElementById(this.hname+'_name_'+id);
		var obj1=document.getElementById(this.hname+'_nameEditCont_'+id);
		if(obj1.style.display=='none'){
			obj0.style.display='none';
			obj1.style.display='block';
		}else{
			obj1.style.display='none';
			obj0.style.display='block';
			//а так же сохранить новое наименование
		}
	}
	
	this.paintTree=function(node){
		var s='';
		for(var i in node){
			//добавляем поле "ветка раскрыта", если его нет
			if(node[i]['open']==null){node[i]['open']=true;}
			s+="<table border=0 cellspacing=0 cellpadding=0 width=100%><tr><td valign=top nowrap>";
			s+="<img src='images/null.png' style='width:" + (node[i]['level'] * 10) + "px;height:10px;'>";
			this.gloMegaTreeFlag++;
			if(node[i][this.node_kolvo]==0){
				s+=this.editButtonsPaint(node[i]);
				//s+=this.editButtonsPaint(node[i][this.node_id], node[i][this.node_kolvo], node[i][this.node_name]);
				s+="<a id='" + this.hname + '_name';
				if(node[i]['type']){
					if(node[i]['type']=='article'){s+='A';}
				}
				s+='_' + node[i][this.node_id] + "' style='color:" + this.color + ";font-size:" + this.levelsize[node[i][this.node_level]] + "px;' onmousedown='" + this.name + ".backFunction(" + node[i][this.node_id] +", "+node[i][this.node_kolvo]+");' onmouseover='this.style.fontWeight=\"bold\";'";
				if(this.node_title!=''){
					s+="title='" + node[i][this.node_title] + "'";
				}
				s+=" onmouseout='this.style.fontWeight=\"\";'>";
				s+=node[i][this.node_name];
				s+="</a>";
			}else{
				s+=this.editButtonsPaint(node[i]);
				//([this.node_id], node[i][this.node_kolvo], node[i][this.node_name]);
				s+="<a id='" + this.hname + '_name_' + node[i][this.node_id] + "' style='color:" + this.color + ";font-size:" + this.levelsize[node[i][this.node_level]] + "px;' onclick='obj=document.getElementById(\"" + this.name + "_Node_" + this.gloMegaTreeFlag + "\"); if(obj.style.display == \"none\"){obj.style.display = \"block\";}else{obj.style.display = \"none\";}' onmouseover='this.style.fontWeight=\"bold\";'";
				if(this.node_title!=''){
					s+="title='" + node[i][this.node_title] + "'";
				}
				s+=" onmouseout='this.style.fontWeight=\"\";'>";
				s+=node[i][this.node_name];
				s+="</a>";
			}
			if(node[i][this.node_node] && this.edit){
				if(node[i][this.node_node][0] && node[i][this.node_node][0]['type']){
					if(node[i][this.node_node][0]['type']=='article'){
						s+='<div><img src="images/add_page.png" onclick="' + this.name + '.newArticle('+node[i][this.node_id]+');"></div>';
					}
				}
			}
			s+='<div id="'+this.name+'_Node_'+this.gloMegaTreeFlag+'">';
			s+=this.paintTree(node[i][this.node_node]);
			s+='</div>';
			s+="</td></tr></table>";
		}
		return s;
	}
	
	this.openclose=function(id){
		
	}
	this.Paint = function(){
		this.debug='';
		switch(this.style){
			case 0:
				s = "<div onmousemove='" + this.name + ".onmousemove(event);' style='overflow:scroll;width:" + this.width + ";height:" + this.height + "' id='" + this.hname + "'>";
				//оттут унутре tree
				this.gloMegaTreeFlag=0;
				if(this.edit){
					s+=s='<img src="images/add_page.png" onclick="' + this.name + '.newName(0);">';
				}
				s+=this.paintTree(this.tree);
				s+="</div>";
			break;
		}
		//alert(this.debug);
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
}
