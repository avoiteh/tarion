function TPanelTranslate(name,hname,context){
	this.type='TPanelTranslate';
	this.title='����������';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = false;
	this.context=context;//�� ����� ��������� �����
	this.style=0;//�������� ��������� �����
	this.color=0;//�������� ��������� ����� ���� 0-�����
	this.left=400;
	this.top=25;
	this.width=500;
	this.height=500;
	this.stage=0;

	this.Paint=function(){
		//��������� ���� ����
		var bgk=this.color;
		var s="<table id='" + this.hname + "' style='width:" + this.width + "px;height:" + this.height + "px;background-color:#ffffcc;border:1px solid #000000;position:absolute;left:" + this.left + ";top:" + this.top + ";z-index:100' onmouseover='" + this.context.name + ".currentobject=" + this.name + ";'><tr bgcolor='#cccccc'><td>" + this.title + "</td><td align='right' height=10><img src='" + this.context.images_path + "close.gif' onmousedown='" + this.context.name + ".Opened(" + this.name + ", false);'>";
				//<img src='"+context.images_path+"free.gif' onmousedown='"+this.context.name+".freeObject("+this.name+");'>

		s+="</td></tr><tr><td valign=top colspan=2>";
		s+="<input type=button value=' ������ ���������� ������� ' onclick='"+this.name+".stage=0;"+this.name+".stageTranslate();'>";
		s+="<div style='overflow:scroll;width:100%;height:"+(this.height-50)+"px;font-size:12px;' id='"+this.hname+"_logTranslate'>";
		s+="</div>";
		s+="</table>";
		return s;
	}
	
	this.stageTranslate=function(){
		switch(this.stage){
			case 0://�������� ����������� ��
				document.getElementById(this.hname+'_logTranslate').innerHTML='';
				this.SendQuest('checkDB');
			break;
			case 1://�������� ����������� �����
				this.SendQuest('checkDir');
			break;
			case 2://�������� ������
				this.SendQuest('createTables');
			break;
			case 3://�������� ������� ������� ��� ������� ����������� � ���������� �������
				this.SendQuest('checkAuthDB');
			break;
			case 4://�������� �������, ���� � ������� ��� ������� ����������� � ���������� �������
				this.SendQuest('createAuth');
			break;
			case 5://�������� ����� ���� ��
				this.SendQuest('createMenuBO');
			break;
			case 6://�������� ������� ��� ���� CRUD & TreeCRUD ��
				this.SendQuest('createCRUDsBO');
			break;
		
			case 7://�������� ����� ���� ��
				this.SendQuest('createMenuFO');
			break;
			case 8://�������� ������� ��� ���� CRUD & TreeCRUD ��
				this.SendQuest('createCRUDsFO');
			break;
		}
	}
	this.stageResult=function(res){
		var obj=document.getElementById(this.hname+'_logTranslate');
//alert(obj+"\n"+res['Flag']+"\n"+res['Mess']);
		if(res['Flag']=='OK'){
			obj.innerHTML+=res['Mess']+'<br><hr>';
			this.stage++;
			if(this.stage<9){
				this.stageTranslate();
			}else{
				this.stage=0;
				alert('���������� ���������!');
			}
		}
		if(res['Flag']=='Error'){
			obj.innerHTML+='<hr><span style="color:#ff0000;">'+res['Mess']+'</span><br><hr>';
			alert('������ ����������.');
			this.stage=0;
		}
	}
	
	this.SendQuest=function(mode){
		var q='{"id":"Translate","mode":"'+mode+'"}';
//alert(q);
		context.AJAXquery(q, this.name);
	}
	
	this.AJAXresult=function(json_serial){//�� ��������� ����������� JSON �������
//alert(json_serial);
		var json=eval(json_serial);
//alert(json['Translate']);
		if(json['id']=='Translate'){
			this.stageResult(json['Translate']);
		}
		if(json['sendMess']=='Refresh'){
			this.SendQuest();
		}
	}
}