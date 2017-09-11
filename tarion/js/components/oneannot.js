//визуальный компонент дл€ отображени€ одного объ€влени€
function TOneAnnot(name,hname,maincontext){
	this.name = name;
	this.hname=hname;
	this.maincontext=maincontext;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.width = '100%';
	this.height= '100%';
	this.chet = false;
	this.Annot = null;//сюда будем передавать объ€вление
	
	this.style = 0;
	
	this.Paint=function(){
		switch(this.style){
			case 0:
				if(this.Annot['super']==1){
					if(this.chet){this.bgcolor='#ffffcc';}else{this.bgcolor='#f0f0c0';}
				}else{
					if(this.chet){this.bgcolor='#ffffff';}else{this.bgcolor='#e0e0e0';}
				}
				var s="<table width=100% bgcolor='"+this.bgcolor+"' cellspacing=0 cellpadding=0 style='border:1px solid #ccaa88'>";
				s+="<tr style='font-size:11px'><td valign=top><b>"+this.Annot["type"]+"<br>"+trade_typeById(this.Annot["trade_type"])+"</b></td><td valign=top align=right style='font-size:11px'><b>"+this.Annot["dt"]+"</b></td></tr></table>";
				s+="<table width=100% bgcolor='"+this.bgcolor+"' cellspacing=0 cellpadding=0 style='border:1px solid #ccaa88'><tr><td valign=top>";
				if(this.Annot['image']!=0){
					s+="<td><img src='upload_files/"+this.Annot['image']+"'></td>";
				}
				s+="<td valign=top width=100% style='font-size:18px;font-family:courier'>"+this.Annot["descr"]+"</td></tr>";
				s+="</table><img src='../images/null.png' width='1px' height='2px'>";
			break;
			case 1:
				if(this.Annot['super']==1){
					if(this.chet){this.bgcolor='#ffffcc';}else{this.bgcolor='#f0f0c0';}
				}else{
					if(this.chet){this.bgcolor='#ffffff';}else{this.bgcolor='#e0e0e0';}
				}
				var s="<table width=100% bgcolor='"+this.bgcolor+"' cellspacing=0 cellpadding=0 style='border:1px solid #ccaa88'>";
				s+="<tr style='font-size:11px'><td valign=top><input type='checkbox' id='"+this.hname+"_check'><b>"+this.Annot["type"]+"<br>"+trade_typeById(this.Annot["trade_type"])+"</b></td><td valign=top align=right style='font-size:11px'><b>"+this.Annot["dt"]+"</b></td></tr></table>";
				s+="<table width=100% bgcolor='"+this.bgcolor+"' cellspacing=0 cellpadding=0 style='border:1px solid #ccaa88'><tr><td valign=top>";
				if(this.Annot['image']!=0){
					s+="<td><img src='upload_files/"+this.Annot['image']+"'></td>";
				}
				s+="<td valign=top width=100% style='font-size:18px;font-family:courier'><textarea style='width:100%' rows=4 id='"+this.hname+"_descr'>"+this.Annot["descr"]+"</textarea></td></tr>";
				s+="</table><img src='../images/null.png' width='1px' height='2px'>";
			break;
		}
		return s;
	}
	
	this.putToAnnot=function(){
		//складывает измененЄнные данные обратно в итем
		this.Annot["descr"]=document.getElementById(this.hname+'_descr').innerText;
		if(document.getElementById(this.hname+'_check').checked){this.Annot["check"]=1;}else{this.Annot["check"]=0;}
	}
}
