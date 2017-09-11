//визуальный компонент для отображения статического меню каталога
function TEcomagCatalog(name,hname,parent){
	this.name = name;
	this.hname=hname;
	this.parent=parent;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.sel_color='#ffffff';
	this.sel_bgcolor='#0000ff';
	this.width='100%';
	this.height='100%';
	
	this.style = 0;
	this.basketMess='&nbsp;Ваша корзина пуста';


	this.Paint = function(){
		s='<table border=0 cellpadding=0 cellspacing=0 width=100% class="topBack">';
		s+='<tr><td width="760px">';
		s+='<img src="../images/ecomag_catalog.png" border=0 usemap="#map1">';
		//s+='</td><td class="rightZaglushka">&nbsp;';
		s+='<div style="position:relative;top:-520px;left:400px;width:550px;" align="right"><span style="font-family:Arial;color:#ff0000;size:20px;font-weight:bold;">ICQ: 472-791-140, тел. (056) 734 37 74, (093) 988 64 24, (099) 707 92 29</span><br>';
		s+='<span style="font-family:Arial;color:#666666;size:20px;font-weight:bold;" onclick="'+this.name+'.callBack();" onmouseover="this.style.color=\'#ff6666\';" onmouseout="this.style.color=\'#666666\';">Заказать обратный звонок</span></div>';
			s+='<input type=text id="search_quest" value="Поиск" style="float:left;border:0px;background-color:transparent;color:#ffffff;font-weight:bold;font-family:arial;font-size:12px;position:relative;left:775px;top:-435px;width:130px;" onclick="this.value=\'\';" onkeydown="if(event.keyCode==13){articleView.searchQuest(this.value);}">';
		//}
		s+='<map name="map1">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(8);" alt="Шампуни" shape=rect coords="5,344,78,420">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(10);" alt="Пена для ванн" shape=rect coords="52,244,115,320">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(11);" alt="Жидкие мыла" shape=rect coords="135,311,206,385">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(12);" alt="Натуральное мыло" shape=rect coords="228,260,301,341">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(13);" alt="Моющие средства" shape=rect coords="308,341,393,413">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(14);" alt="Фильтры для воды" shape=rect coords="360,257,447,427">';
		s+='<area href="javascript: '+this.parent.name.name+'.loadCatalog(15);" alt="Порошки Дакос" shape=rect coords="461,278,536,346">';
		s+='<area href="javascript: '+this.parent+'.loadCatalog(16);" alt="Гели для душа" shape=rect coords="527,185,602,254">';
		s+='<area href="javascript: '+this.parent.name+'.loadCatalog(17);" alt="Гигиеническое средство \'Люсана\'" shape=rect coords="648,202,722,366">';
		s+='</map>';
		s+='</td></tr></table>';
		
		s+='<table style="position:relative;left:';
		s+=Math.round(this.parent.context.width/2)+100;
		s+='px;top:-205px;"><tr>';
		//s+='<td style="color:#ff3300;font-weight:bold;font-family:arial;font-size:12px;" nowrap>'+this.basketMess+'</td>';
		s+='</tr></table>';
		
		return s;
	}

	this.callBack=function(){
		panelCallBack=new TPanelCallBack('panelCallBack', 'hpanelCallBack', main);
		main.elements[main.elements.length]=panelCallBack;
		main.Paint();
	}
}