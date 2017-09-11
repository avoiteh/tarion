//богатый редактор
//позволяет редактировать текст, выбирать размер и тип шрифта, делать шрифт жирным/курсивом/подчерком
//вставлять картинки
function TRichEdit(name, hname, parent){
	this.name=name;
	this.hname=hname;
	this.parent=parent;
	this.style = 0;//0-image;1-file
	this.dx=100;//размеры панели редактирования
	this.dy=100;
	this.text='';
	this.filename='';
	
	this.Paint=function(){
		s="<table><tr><td height='25px'>";
		//картинка
		s+="<div id='"+this.hname+"_up0' style='display:block;float:left;'>";
		s+="<img src='../images/text_img.png' border=0 onclick='"+this.name+".setImage()'>";
		s+="</div>";
		s+="<div id='"+this.hname+"_up1' style='display:none;float:left;'>";
		s+='<form id="'+this.hname+'_form" action="upload_file.php" target="upload_iframe" method="POST" enctype="multipart/form-data"><input type=hidden name="who_upload" value="'+this.name+'"><table bgcolor="#ffff00"><tr><td><input type="file" name="file" onchange="'+this.name+'.onUpload();"><input type="hidden" name="img_name" value="'+this.name+'">';
		s+="</td><dt><img src='../images/text_img_esc.png' border=0 onclick='"+this.name+".setImageEsc();'>";
		s+='</td></tr></table></form>';
		s+="</div>";
		//ссылка
		s+="<div id='"+this.hname+"_link0' style='display:block;float:left;'>";
		s+="<img src='../images/text_link.png' border=0 onclick='" + this.name + ".setOnCreateLink();'>";
		s+="</div>";
		s+="<div id='" + this.hname + "_link1' style='display:none;background-color:#ffcccc;float:left;padding:2 2 2 2;'>";
		s+="<input type='text' id='"+this.hname+"_link' value='' style='position:relative;top:-4px;'>";
		s+="<img src='../images/text_link.png' border=0 onclick='"+this.name+".setCreateLink();'>";
		s+="</div>";
		//таблица
		s+="<div id='"+this.hname+"_tab0' style='display:block;float:left;'>";
		s+="<img src='../images/text_table.png' border=0 onclick='" + this.name + ".setOnTable();'>";
		s+="</div>";
		s+="<div id='" + this.hname + "_tab1' style='display:none;background-color:#ccffcc;float:left;padding:2 2 2 2;'>";
		s+="<select style='position:relative;top:-4px;' id='"+this.hname+"_tab'>";
		s+="<option value='2'>Столбцов</option>";
		for(var i=1;i<12;i++){
			s+="<option value="+i+">"+i+"</option>";
		}
		s+="</select>"
		//s+="<input type='text' id='"+this.hname+"_tab' value='' style='position:relative;top:-4px;'>";
		s+="<img src='../images/text_table.png' border=0 onclick='"+this.name+".setTable();'>";
		s+="</div>";

		s+="<img src='../images/text_bold.png' border=0 onclick='"+this.name+".setBold()'>";
		s+="<img src='../images/text_italic.png' border=0 onclick='"+this.name+".setItal()'>";
		s+="<img src='../images/text_under.png' border=0 onclick='"+this.name+".setUnder()'>";
		//s+="</td><td>";
		//s+="</td><td width='100%'>";
		s+="<select style='position:relative;top:-4px;' id='"+this.hname+"_selFontSize' onchange='"+this.name+".setFontSize()'>";
		s+="<option value='2'>Размер</option>";
		for(var i=1;i<12;i++){
			s+="<option value="+i+">"+i+"</option>";
		}
		s+="</select>";
		s+="<select style='position:relative;top:-4px;' id='"+this.hname+"_selFontName' onchange='"+this.name+".setFontName()'>";
		s+="<option value='Times'>Шрифт</option>";
		s+="<option value='Arial'>Arial</option>";
		s+="<option value='Courier'>Courier</option>";
		s+="<option value='Times'>Times</option>";
		s+="</select>"
		s+="<img src='../images/text_center.png' border=0 onclick='"+this.name+".setJustifyCenter()'>";
		s+="<img src='../images/text_left.png' border=0 onclick='"+this.name+".setJustifyLeft()'>";
		s+="<img src='../images/text_right.png' border=0 onclick='"+this.name+".setJustifyRight()'>";
		s+="<img src='../images/text_order.png' border=0 onclick='"+this.name+".setInsertOrderedList()'>";
		s+="<img src='../images/text_unorder.png' border=0 onclick='"+this.name+".setInsertUnorderedList()'>";
		s+="</td></tr>";
		s+="</tr><td colspan=3>";
		s+="<iframe scrolling='yes' frameborder='1' src='#' id='"+this.hname+"_frameId' name='"+this.name+"_frameId' style='width:"+this.width+"px;height:"+this.height+"px;'></iframe><br>";
		s+="<input type='button' value='Сохранить' onclick='"+this.name+".saveHTML()'>";
		s+="</td></tr></table>";
		return s;
	}
	
	this.onUpload=function(){
		var frm = document.getElementById(this.hname+'_form');
		frm.submit();
	}
	this.afterUpload=function(filename){
		this.filename=filename;
		this.iWin.focus();
	 	this.iWin.document.execCommand("InsertImage",null,'upload_files/'+filename);
	 	document.getElementById(this.hname+'_up0').style.display='block';
		document.getElementById(this.hname+'_up1').style.display='none';
	}
	this.setBold=function(){
		this.iWin.focus();
 		this.iWin.document.execCommand("bold", null, "");
	}
	this.setItal=function(){
		this.iWin.focus();
 		this.iWin.document.execCommand("italic", null, "");
	}
	this.setUnder=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("underline", null, "");
	}
	this.setImage=function(){
		document.getElementById(this.hname+'_up0').style.display='none';
		document.getElementById(this.hname+'_up1').style.display='block';
		//this.iWin.focus();
	 	//var imgname=document.getElementById('myImg').value;
 		//this.iWin.document.execCommand("InsertImage",null,imgname);
	}
	this.setImageEsc=function(){
		document.getElementById(this.hname+'_up1').style.display='none';
		document.getElementById(this.hname+'_up0').style.display='block';
	}
	this.setOnTable=function(){
		document.getElementById(this.hname+'_tab0').style.display='none';
		document.getElementById(this.hname+'_tab1').style.display='block';
	}
	this.setTable=function(){
		this.iWin.focus();
		var tab=document.getElementById(this.hname + '_tab').value;
		if(tab!=''){
			var table="<table><tr>";
			for(var i=1;i<=tab;i++){
				table+='<td>&nbsp;</td>';
			}
			table+="</tr></table>";
	 		this.iWin.document.execCommand("Paste", null, table);
		}
	 	document.getElementById(this.hname+'_tab1').style.display='none';
		document.getElementById(this.hname+'_tab0').style.display='block';
	}
	this.setOnCreateLink=function(){
		document.getElementById(this.hname+'_link0').style.display='none';
		document.getElementById(this.hname+'_link1').style.display='block';
	}
	this.setCreateLink=function(){
		this.iWin.focus();
		var link=document.getElementById(this.hname + '_link').value;
		if(link!=''){
	 		this.iWin.document.execCommand("CreateLink", null, link);
		}
	 	document.getElementById(this.hname+'_link1').style.display='none';
		document.getElementById(this.hname+'_link0').style.display='block';
	}
	this.setFontName=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("FontName", null, "Arial Cyr");
	}
	this.setFontSize=function(){
		this.iWin.focus();
		var fs=document.getElementById(this.hname+"_selFontSize").value;
	 	this.iWin.document.execCommand("FontSize", null, fs);
	}
	this.setFormatBlock=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("FormatBlock", null, "xxx");
	}
	this.setInsertOrderedList=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("InsertOrderedList", null, "");
	}
	this.setInsertUnorderedList=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("InsertUnorderedList", null, "");
	}
	this.setJustifyCenter=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("JustifyCenter", null, "");
	}
	this.setJustifyLeft=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("JustifyLeft", null, "");
	}
	this.setJustifyRight=function(){
		this.iWin.focus();
	 	this.iWin.document.execCommand("JustifyRight", null, "");
	}
	
	this.saveHTML=function(){
		this.text=this.iDoc.body.innerHTML;
		this.iFrame=null;
		this.iWin=null;
		this.iDoc=null;
		this.parent.onAfterEdit(this.text);
	}
	this.initEditFrame=function(){
		var isGecko = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
		this.iFrame = (isGecko) ? document.getElementById(this.hname+"_frameId") : frames[this.hname+"_frameId"];
		this.iWin = (isGecko) ? this.iFrame.contentWindow : this.iFrame.window;
		this.iDoc = (isGecko) ? this.iFrame.contentDocument : this.iFrame.document;
		iHTML = "<html><head>\n";
		iHTML += "<style>\n";
		iHTML += "body, div, p, td {font-size:12px; font-family:tahoma; margin:0px; padding:0px;}";
		iHTML += "body {margin:5px;}";
		iHTML += "</style>\n";
		iHTML += "<body>"+this.text+"</body>";
		iHTML += "</html>";
		this.iDoc.open();
		this.iDoc.write(iHTML);
		this.iDoc.close();
		if (!this.iDoc.designMode){
			alert("В этом отстойном браузере наш совершенный редактор работать не будет!");
		}else{
			this.iDoc.designMode = (isGecko) ? "on" : "On";
		}
	}
}