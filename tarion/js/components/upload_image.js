//данный компонент предназначен для создания объекта загружающего файл
//представляет собой кнопочку, при нажатии на которую открывается окошко выбора файла, а после выбора файла
//автоматически грузится на сервер и в зависимости от типа отображается рядом с кнопкочкой
function TUploadImage(name, hname, parent){
	this.name=name;
	this.hname=hname;
	this.filename='images/null.png';
	this.parent=parent;
	this.style = 0;//0-image;1-file
	this.dx=0;
	this.dy=0;
	
	this.onUpload=function(){
		var frm = document.getElementById(this.hname+'_form');
		frm.submit();
	}
	this.afterUpload=function(filename){
		this.filename=filename;
	}
	/*
	this.move=function(){
		var obj=document.getElementById(this.hname);
		obj.outerHTML=this.Paint();
	}
	*/
	this.Paint = function(){
		var x=parseInt(this.parent.left)+this.dx;
		var y=parseInt(this.parent.top)+this.dy;
		//style="position:absolute;left:'+x+'px;top:'+y+'px"
		var s='<div id="'+this.hname+'"><form id="'+this.hname+'_form" action="upload_file.php" target="upload_iframe" method="POST" enctype="multipart/form-data"><input type=hidden name="who_upload" value="'+this.parent.name+'"><input type="file" name="file" onchange="'+this.parent.name+'.'+this.name+'.onUpload();"><input type="hidden" name="img_name" value="'+this.name+'"></form>';
		//s+='<a href="'+this.filename+'"><img src="../images/fileicon.jpg">';
		//s+='</a>';
		s+='</div>';
		return s;
	}
}