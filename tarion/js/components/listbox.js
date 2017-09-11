//данный компонент предназначен для реализации выпадающего списка
function TListBox(name, hname, parent){
	this.name=name;
	this.hname=hname;
	this.filename='images/null.png';
	this.parent=parent;
	this.style = 0;//0 - oneselect / multiselect - 1
	this.dx=0;
	this.dy=0;
	
	this.decoration='';
	this.list = new Array;
	this.selected = new Array;
	
	this.Paint = function(){
		var x=parseInt(this.parent.left)+this.dx;
		var y=parseInt(this.parent.top)+this.dy;
		var s='<select id="'+this.hname+'"';
		if(this.style==1){s+=' multiple="multiple"';}
		if(this.decoration!=''){
			s+=' style="'+this.decoration+'"';
		}
		s+='>';
		for(var id in this.list){
			s+='<option value="'+id+'"';
			if(this.selected[id]=='1'){s+=' selected';}
			s+='>'+this.list[id]+'</option>';
		}
		s+='</select>';
		return s;
	}
}