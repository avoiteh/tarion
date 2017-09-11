function TPanel(name,hname,context){
	this.type='TPanel';
	this.name=name;
	this.hname=hname;
	this.title=name;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = true;
	this.context=context;//на каком контексте лежит
	this.style=0;//числовой указатель стиля
	this.color=0;//числовой указатель цвета фона 0-белый
	this.left=100;
	this.top=0;
	this.width=100;
	this.height=50;
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
			case 0:
				var s="<table id='"+this.hname+"' style='width:"+this.width+"px;height:"+this.height+"px;background-color:#"+bgk+";border:1px solid #000000;position:absolute;left:"+this.left+";top:"+this.top+";z-index:100' onmouseover='"+this.context.name+".currentobject="+this.name+";'><tr><td align='right' height=10><img src='"+context.images_path+"close.gif' onmousedown='"+this.context.name+".Opened("+this.name+", false);'><img src='"+context.images_path+"free.gif' onmousedown='"+this.context.name+".freeObject("+this.name+");'></td></tr><tr><td>&nbsp;</td></tr></table>";
			break;
		}
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
					//ибо непосредственной отрисовкой занимается контекст
}
