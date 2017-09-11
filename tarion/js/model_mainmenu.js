function TMenuItem(name, parentItem, title, mainMenu){
	this.name=name;
	this.mainMenu=mainMenu;
	this.parentItem=parentItem;
	this.title=title;
	this.position='relative';
	this.left=0;
	this.top=0;
	this.style=0;//0 - горизонтальный
				//1 - вертикальный
	this.itemList = new Array;
	this.ChildsPaint=function(){
		switch(this.style){
			case 0:
				var s="<table id='H"+this.name+"' style='width:100%;border:1px solid #000000;background-color:#dddddd;position:"+this.position+";left:"+this.left+";top:"+this.top+";display:block'><tr>";
				for(var id in this.itemList){
					s+="<td nowrap ";
					s+="onmouseover='"+this.parentItem.name+".DropDown(\""+this.itemList[id].name+"\")' ";//выпасть меню
					s+="onmousedown='"+this.parentItem.name+".OnMenuItemClick(\"" +this.itemList[id].name+"\");' ";//передать клик
					s+=">"+this.itemList[id].title+"</td>";
				}
				s+="</tr></table>";
			break;
			case 1:
				var s="<table style='width:100%;border:1px solid #000000;background-color:#dddddd;position:"+this.position+";left:"+this.left+";top:"+this.top+"'>";
				for(var id in this.itemList){
					s+="<tr><td nowrap ";
					s+="onmouseover='"+this.parentItem.name+".DropDown(\""+this.itemList[id].name+"\")' ";//выпасть меню
					s+="onmousedown='"+this.parentItem.name+".OnMenuItemClick(\"" +this.itemList[id].name+"\");' ";//передать клик
					s+=">"+this.itemList[id].title+"</td></tr>";
				}
				s+="</table>";
			break;
		}
		return s;
	}
}

function TMainMenu(name, hname, parent){
	this.name=name;
	this.hname=hname;
	this.parent=parent;
	this.style=0;
	this.mainItem= new TMenuItem(this.name+'_item0', 0, '', this);
	this.Paint=function(){
		//отрисовываем горизонтально пункты главного меню
		switch(this.style){
			case 0:
				var s=this.mainItem.ChildsPaint();
			break;
		}
		return s;
	}
	this.OnMenuItemClick=function(name){
		alert(back);
	}
	this.DropDown=function(name){
		alert(name);
	}
}