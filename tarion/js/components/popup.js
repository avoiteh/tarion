//визуальный компонент для отображения всплывающего окна
function TPopUp(name,hname,parent){
	this.name = name;
	this.hname=hname;
	this.parent=parent;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.sel_color='#ffffff';
	this.sel_bgcolor='#0000ff';
	this.left=0;
	this.top=0;
	this.width='100';
	this.height='100';
	this.title='title';
	this.content='content';
	
	this.style = 0;
	
	this.Paint=function(){
		s = '<table id="'+this.name+'" name="'+this.name+'" style="position:absolute;left:' + this.left + 'px;top:' + this.top + 'px;width:' + this.width + 'px;height:' + this.height + 'px;background-color:' + this.bgcolor + ';display:none;" onmouseout="this.style.display=\'none\';" border=1>';
		
		s+='<tr><td>'+this.title+'</td></tr>';
		s+='<tr><td valign=top>'+this.content+'</td></tr>';
		s+='</table>';
		
		return s;
	}
}