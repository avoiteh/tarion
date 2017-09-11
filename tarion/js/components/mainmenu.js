function TMainMenu(name,hname,maincontext){
	this.type='TMainMenu';
	this.name=name;
	this.hname=hname;
	this.context=maincontext;//на каком контексте лежит
	this.style=0;//числовой указатель стиля
	this.color=0;//числовой указатель цвета фона 0-белый
	
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
				var s="<table id='"+this.hname+"' style='font-size:12px;position:relative;top:-95px;left:3px;' cellpadding=0 cellspacing=0>";
				//нарисовать кнопки меню
				s+="<tr><td><br><div class='BtnMain' align=center valign=middle onclick='"+this.name+".Press(0);'><span style='position:relative;top:7px;'>Главная</span></div></td></tr>";
				s+="<tr><td><div class='";
				if(panelArticles){
					if(panelArticles.open){s+="BtnMainDown";}else{s+="BtnMain";}
				}else{s+="BtnMain";}
				s+="' align=center valign=middle onclick='"+this.name+".Press(1);'><span style='position:relative;top:7px;'>Статьи</span></div></td></tr>";
				s+="<tr><td><div class='";
				if(panelCatalog){
					if(panelCatalog.open){s+="BtnMainDown";}else{s+="BtnMain";}
				}else{s+="BtnMain";}
				s+="' align=center valign=middle onclick='"+this.name+".Press(2);'><span style='position:relative;top:7px;'>Каталог</span></div></td></tr>";
				if(this.context.authorize){
					s+="<tr><td><div class='";
				if(panelBasket){
					if(panelBasket.open){s+="BtnMainDown";}else{s+="BtnMain";}
				}else{s+="BtnMain";}
				s+="' align=center valign=middle onclick='"+this.name+".Press(3);'><span style='position:relative;top:7px;'>Корзина</span></div></td></tr>";
				}
				s+="<tr><td><div class='";
				if(panelAbout){
					if(panelAbout.open){s+="BtnMainDown";}else{s+="BtnMain";}
				}else{s+="BtnMain";}
				s+="' align=center valign=middle onclick='"+this.name+".Press(4);'><span style='position:relative;top:3px;'>Контакты</span></div></td></tr>";
				//s+="<tr><td><div class='BtnMain' align=center valign=middle onclick='"+this.name+".Press(5);'><span style='position:relative;top:7px;'>Контакты</span></div></td></tr>";
				s+="<tr><td><div class='";
				if(panelAuth){
					if(panelAuth.open){s+="BtnMainDown";}else{s+="BtnMain";}
				}else{s+="BtnMain";}
				s+="' align=center valign=middle onclick='"+this.name+".Press(7);'><span style='position:relative;top:7px;'>";
				if(panelAuth){
					s+=panelAuth.title;
				}else{
					s+="Вход";
				}
				s+="</span></div></td></tr>";
				s+="<tr><td><div class='BtnMain' align=center valign=middle onclick='"+this.name+".Press(6);'><span style='position:relative;top:7px;'>Получить ссылку</span></div></td></tr>";
				s+="<tr><td height='100%' id='"+this.hname+"_megaLink'>&nbsp;</td></tr>";
				s+="<tr><td height='100%'><img src='../images/apteka.png'></td></tr>";
				s+="</table>";
			break;
		}
		return s;
	}//функция отрисовки, однако, она просто возвращает HTML! 
	//ибо непосредственной отрисовкой занимается контекст
	
	this.createMegalink=function(){
		var s=this.context.megaLink();
		this.SendQuestMegaLink(s);
		//document.getElementById(this.hname+"_megaLink").innerHTML=s;
	}
	
	this.SendQuestMegaLink=function(slink){
		var t=slink.split('"').join('\\"');
		var q='{"id":"megaLink","content":"'+escape(t)+'"}';
//alert(q);
//document.getElementById(this.hname+"_megaLink").innerHTML=q;
		this.context.AJAXquery(q, this.name);
	}
	
	this.AJAXresult=function(json_serial){//на основании полученного JSON объекта
//alert(json_serial);
		var json=eval(json_serial);
		switch(json['id']){
			case 'megaLink':
				document.getElementById(this.hname+"_megaLink").innerHTML='<a href="'+json['megaLink']+'">Ссылка сюда</a>';
			break;
		}
	}
	
	this.Press=function(id){
		switch(id){
			case 0:
				articleView.mode='article';
				articleView.article_id=0;
				articleView.SendQuestArticle();
			break;
			case 1:
				if(this.context.resources && this.context.resources['EditArticle']){
					var panel = main.getObjectByName('panelArticles');
					if(panel){
						panel.open=true;
						this.context.Paint();
					}else{
						panelArticles = new TPanelArticles('panelArticles', 'hpanelArticles', main);
						main.elements[main.elements.length]=panelArticles;
						panelArticles.title='Статьи';
						panelArticles.open=true;
						panelArticles.SendQuest();
					}
				}else{
					articleView.mode='article_list';
					main.Paint();
				}
			break;
			case 2:
				if(this.context.resources && this.context.resources['EditCatalog']){
					var panel = main.getObjectByName('panelCatalog');
					if(panel){
						panel.open=true;
						this.context.Paint();
					}else{
						panelCatalog = new TPanelCatalog('panelCatalog', 'hpanelCatalog', main);
						main.elements[main.elements.length]=panelCatalog;
						panelCatalog.title='Каталог';
						panelCatalog.open=true;
						panelCatalog.SendQuest();
					}
				}else{
					articleView.SendQuestCatalog();
				}
			break;
			case 3:
				var panel = main.getObjectByName('panelBasket');
				if(panel){
					panel.open=true;
					this.context.Paint();
				}else{
					panelCatalog = new TPanelBasket('panelBasket', 'hpanelBasket', main);
					main.elements[main.elements.length]=panelBasket;
					//panelBasket.title='Каталог';
					panelBasket.open=true;
					panelBasket.SendQuest();
				}
			break;
			case 4:
				if(this.context.resources && this.context.resources['EditAbout']){
					var panel = main.getObjectByName('panelAbout');
					if(panel){
						panel.open=true;
						panel.SendQuestGet();
					}else{
						panelAbout = new TPanelAbout('panelAbout', 'hpanelAbout', main);
						main.elements[main.elements.length]=panelAbout;
						panelAbout.open=true;
						panelAbout.SendQuestGet();
					}
				}else{
					articleView.mode='article_list';
					articleView.SendQuestGetAbout();
				}
				
			break;
			case 5:
			break;
			case 6:
				this.createMegalink();
			break;
			case 7:
				var panel = main.getObjectByName('panelAuth');
				if(panel){
					if(main.authorize){
						panel.title='Выход';	
					}else{
						panel.title='Вход';
					}
					panel.open=open;
				}else{
					panelAuth = new TPanelAuth('panelAuth', 'HpanelAuth', main);
					if(main.authorize){
						panelAuth.title='Выход';	
					}else{
						panelAuth.title='Вход';
					}
					panelAuth.open=open;
					main.elements[main.elements.length]=panelAuth;
				}
				this.context.Paint();
			break;
		}
	}
}

