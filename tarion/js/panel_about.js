function TPanelAbout(name,hname,context){
	this.type='TPanelAbout';
	this.name=name;
	this.hname=hname;
	this.title='Что это за сайт?';
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = false;
	this.context=context;//на каком контексте лежит
	this.style=0;//числовой указатель стиля
	this.left=100;
	this.top=100;
	this.width=600;
	this.height=300;
	this.Paint=function(){
		//собственно панель
		switch(this.style){
			case 0:
				var s="<table id='" + this.hname + "' style='width:" + this.width + "px;height:" + this.height + "px;background-color:#ffffcc;border:1px solid #000000;position:absolute;left:" + this.left + ";top:" + this.top + ";z-index:100' onmouseover='" + this.context.name + ".currentobject=" + this.name + ";'><tr bgcolor='#cccccc'><td>" + this.title + "</td><td align='right' height=10><img src='" + this.context.images_path + "close.gif' onmousedown='" + this.context.name + ".Opened(" + this.name + ", false);'>";
				s+="</td></tr><tr><td valign=top colspan=2>";
				s+="&nbsp;&nbsp;&nbsp;&nbsp;Tarion CMS.<br>";
				
				s+='&nbsp;&nbsp;&nbsp;&nbsp;Эта CMS создана по мотивам Clarion. По функциональности примерно соответствует Clarion 2.0 for DOS. Написана в первую очередь дабы избавить себя любимого от массы рутинных повторяющихся операций.<br>';
				s+="&nbsp;&nbsp;&nbsp;&nbsp;al_mt (с)<br>";
				s+="</td></tr></table>";
			break;
		}
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
					//ибо непосредственной отрисовкой занимается контекст
}
