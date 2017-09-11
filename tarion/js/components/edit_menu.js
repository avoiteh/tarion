function TEditMenu(name,hname,parent){
	this.type='TEditMenu';
	this.title='������ ������ ����';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.parent=parent;//��������
	this.style=0;//�������� ��������� �����
	this.color=0;//�������� ��������� ����� ���� 0-�����
	this.elementId=null;
	this.element=null;
	
	this.Paint=function(){
		if(this.elementId!=null){
			this.element=this.parent.bo[this.elementId];
		}
		if(this.element!=null){
			var s="<h4>"+this.title+"</h4>";
			s+="������������ : <input type=text id='"+this.hname+"_name' value='"+this.element['name']+"'>";
			s+="<input type=button value=' ��������� ' onclick='"+this.name+".saveElement();'><br>";
			//�������� ��� � ������� ������ � ��������
			s+="<table cellspacing=0 cellpadding=0><tr bgcolor='#cccccc'><td colspan=3>������� ������� ��������<br><small>��������� �������� ���� <b>menu</b> ����� ����:<br> - ������������ ���������� ��������� ���� <b>menu</b>;<br> - ��� ���� ������� ���� <b>\"�������\"</b>;<br> - ��� ���� ������� ���� <b>\"������\"</b>;</small></td></tr>";
			s+="<tr bgcolor='#cccccc'><td>������������</td><td>���</td><td></td></tr>";
			var j, flag;
			var cntMenu=0;
			var cntCRUD=0;
			var cntTreeCRUD=0;
			var bcol='ffffff';
			for(var i in this.parent.bo){
				if(this.parent.bo[i]['parent']==this.elementId){
					s+="<tr bgcolor='#"+bcol+"'><td>";
					s+=this.parent.bo[i]['name'];
					s+='</td><td>'+this.nameOfType(this.parent.bo[i]['type'])+'</td><td>';
					if(this.parent.bo[i]['type']=='menu'){cntMenu++;}
					if(this.parent.bo[i]['type']=='CRUD'){cntCRUD++;}
					if(this.parent.bo[i]['type']=='TreeCRUD'){cntTreeCRUD++;}
					//��������� ���� �� � ������� �������� �������, ���� ���, �� �������� ������ "�������"
					flag=true;
					for(j in this.parent.bo){
						if(this.parent.bo[j]['parent']==i){
							flag=false;
						}
					}
					if(flag){
						s+="<img src='images/del.jpg' width=12px title='������� �������' onclick='"+this.name+".deleteElement("+i+");'>";
					}
					s+='</td></tr>';
					if(bcol=='cccccc'){bcol='ffffff';}else{bcol='cccccc';}
				}
			}
			//�������� �������
			s+="<tr><td colspan=3>"+this.makeAddElement(cntMenu,cntCRUD,cntTreeCRUD)+"</td></tr>";
			s+="</table>";
			return s;
		}
	}
	this.nameOfType=function(type){
		switch(type){
			case 'menu':
				return '����� ����';
			break;
			case 'CRUD':
				return '�������';
			break;
			case 'TreeCRUD':
				return '������';
			break;
		}
	}
	this.deleteElement=function(i){
		this.parent.deleteElement(i);
	}
	this.newElement=function(){
		var obj=document.getElementById(this.hname+'_addElem');
		var type=obj.value;
		this.parent.newElement(this.elementId, type);
	}
	this.saveElement=function(){
		var obj=document.getElementById(this.hname+'_name');
		this.element['name']=obj.value;
		this.parent.saveQuest();
		//this.parent.context.Paint();
	}
	this.makeAddElement=function(cntMenu,cntCRUD,cntTreeCRUD){
		s='';
		if(cntCRUD==0 && cntTreeCRUD==0){
			s+="�������� ������� ���� <select id="+this.hname+"_addElem>";
			s+="<option value='menu'>����� ����</option>";
			if(cntMenu==0){
				s+="<option value='CRUD'>�������</option>";
				s+="<option value='TreeCRUD'>������</option>";
			}
			s+="</select>&nbsp;<img src='images/new.jpg' width=12px title='������� ������� - �������' onclick='"+this.name+".newElement();'>";
		}
		return s;
	}
}