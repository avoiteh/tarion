function TEditCRUD(name,hname,parent){
	this.type='TEditCRUD';
	this.title='������ �������';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.parent=parent;//��������
	this.style=0;//�������� ��������� �����
	this.color=0;//�������� ��������� ����� ���� 0-�����
	this.element=null;
	this.elementId=null;
	this.tables=panelTables.tables;//������� �������. �� ����� �� ������� table �� ����������� :(
	
	this.Paint=function(){
		if(this.elementId!=null){
			this.element=this.parent.bo[this.elementId];
		}
		if(this.element!=null){
			var s="<h4>"+this.title+"</h4>";
			s+="������������ : <input type=text id='"+this.hname+"_name' value='"+this.element['name']+"' style='width:100%;'><br><br>";
			switch(this.style){
				case 0:
					//������� ������� �������
					s+="��� 1:<br><small>�������� ������� �������</small><br>";
					s+=this.paintSelectMainTable();
					s+="<br><input type=button value=' ����� >>> ' onclick='"+this.name+".step1();'>";
				break;
				case 1:
					//������� ������������ ����, ������� lookup ����, ������� ���� ����������
					s+="��� 2:<br><small>��������:<br> - ������������ ����;<br> - ���� ��� �������;<br> - ��������� lookup-�����</small><br>";
					s+=this.paintSelectFLF();
					s+="<br><input type=button value=' ����� >>> ' onclick='"+this.name+".step2();'>";
				break;
				case 2:
					//��������� ���������
					s+="��� 3:<br><small>����������� ��������� <b>������</b></small><br>";
					s+=this.paintConfirm();
					s+="<br><input id='"+this.hname+"_buttonOK' type=button value=' �� ' onclick='"+this.name+".step3();'>";
				break;
			}
			return s;
		}
	}
	this.paintSelectMainTable=function(){
		var s="<select id='"+this.hname+"_mainTable'>";
		for(var i in this.tables){
			s+="<option value="+i;
			if(this.element['content']['mainTable']!=null){
				if(this.element['content']['mainTable']==i){
					s+=" selected";
				}
			}
			s+=">"+this.tables[i]['name']+"</option>";
		}
		s+="</select><br>";
		
		//�������� ��� � ������� ������ � ��������
		s+="<table cellspacing=0 cellpadding=0><tr bgcolor='#cccccc'><td colspan=3>������� ������� ��������<br><small>��������� �������� ���� <b>��������</b> ����� ����:<br> - ���� ������� ���� <b>\"�������\"</b>;<br> - ��� ���� ������� ���� <b>\"������\"</b>;</small></td></tr>";
		s+="<tr bgcolor='#cccccc'><td>������������</td><td>���</td><td></td></tr>";
		var j, flag;
		var cntCRUD=0;
		var cntTreeCRUD=0;
		var bcol='ffffff';
		for(var i in this.parent.bo){
			if(this.parent.bo[i]['parent']==this.elementId){
				s+="<tr bgcolor='#"+bcol+"'><td>";
				s+=this.parent.bo[i]['name'];
				s+='</td><td>'+this.nameOfType(this.parent.bo[i]['type'])+'</td><td>';
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
		s+="<tr><td colspan=3>"+this.makeAddElement(cntCRUD,cntTreeCRUD)+"</td></tr>";
		s+="</table>";
		//alert(s);
		return s;
	}
	this.deleteElement=function(i){
		this.parent.deleteElement(i);
	}
	this.makeAddElement=function(cntCRUD,cntTreeCRUD){
		s='';
		if(cntCRUD==0 && cntTreeCRUD==0){
			s+="�������� ������� ���� <select id="+this.hname+"_addElem>";
			s+="<option value='CRUD'>�������</option>";
			s+="<option value='TreeCRUD'>������</option>";
			s+="</select>&nbsp;<img src='images/new.jpg' width=12px title='������� ������� - �������' onclick='"+this.name+".newElement();'>";
		}
		return s;
	}
	this.newElement=function(){
		var obj=document.getElementById(this.hname+'_addElem');
		var type=obj.value;
		this.parent.newElement(this.elementId, type);
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
	this.paintSelectFLF=function(){
		if(this.element['content']['view']==null){
			this.element['content']['view']=new Array;
			this.element['content']['view']['ID']=new Array;
			this.element['content']['view']['ID']['show']=true;
			this.element['content']['view']['ID']['lookup']=-1;
			this.element['content']['view']['ID']['lookupfield']=-1;
			this.element['content']['view']['ID']['filter']=true;
			for(var field in this.tables[this.element['content']['mainTable']]['fields']){
				this.element['content']['view'][field]=new Array;
				this.element['content']['view'][field]['show']=true;
				this.element['content']['view'][field]['lookup']=-1;
				this.element['content']['view'][field]['lookupfield']=-1;
				this.element['content']['view'][field]['filter']=true;
			}
		}
		var s=this.tables[this.element['content']['mainTable']]['name']+"<br><table border=1>";
		s+="<tr><td>����</td><td>����������</td><td>LookUp</td><td>������</td></tr>";
		s+="<tr><td>ID</td><td><input type=checkbox id='"+this.hname+"_show_ID'";
		if(this.element['content']['view']['ID']['show']){s+=" checked";}
		s+="></td>";
		s+="<td> - </td>";
		s+="<td><input type='checkbox' id='"+this.hname+"_filter_ID'";
		if(this.element['content']['view']['ID']['filter']){s+=" checked";}
		s+="></td></tr>";
		for(var field in this.tables[this.element['content']['mainTable']]['fields']){
			s+="<tr><td>"+field+"("+this.tables[this.element['content']['mainTable']]['fields'][field]['type']+")</td>";
			s+="<td><input type='checkbox' id='"+this.hname+"_show_"+field+"'";
			if(this.element['content']['view'][field]!=null && this.element['content']['view'][field]['show']){s+=" checked";}
			s+="></td>";
			s+="<td>";
			if(this.tables[this.element['content']['mainTable']]['fields'][field]['type']=='int'){
				s+=this.lookUpSelect(field);
			}else{
				s+=" - ";
			}
			s+="</td>";
			s+="<td><input type='checkbox' id='"+this.hname+"_filter_"+field+"'";
		if(this.element['content']['view'][field]!=null && this.element['content']['view'][field]['filter']){s+=" checked";}
		s+="></td></tr>";
		}
		s+="</table>";
		//���������, ���� �� �������
		var childI=-1;
		for(var i in this.parent.bo){
			if(this.parent.bo[i]['parent']==this.elementId){
				childI=i;
			}
		}
		if(childI!=-1){
			//����� ������� ��� ��������� �����
			s+="������� ���� ������� � ���������� ������������:";
			s+="<table><tr><td>";
			//��� ������ ����� �������
			s+=this.tables[this.element['content']['mainTable']]['name']+'.';
			s+=this.lookUpTablesField( this.tables[this.element['content']['mainTable']], this.element['content']['thistable'], 'thistable');
			s+="</td><td>=</td><td>";
			//��� ��������� ����� �������
			if(this.tables[this.parent.bo[childI]['content']['mainTable']]!=null){
				s+=this.tables[this.parent.bo[childI]['content']['mainTable']]['name']+'.';
				s+=this.lookUpTablesField( this.tables[this.parent.bo[childI]['content']['mainTable']], this.element['content']['childtable'], 'childtable');
			}else{
				s+=' ������� ������� �� ������� ';
			}
			s+="</td></tr></table>";
		}
		return s;
	}
	this.paintConfirm=function(){
		var s=this.tables[this.element['content']['mainTable']]['name']+"<br><table border=1>";
		s+="<tr><td>����</td><td>����������</td><td>LookUp</td><td>������</td></tr>";
		s+="<tr><td>ID</td><td>";
		if(this.element['content']['view']['ID']['show']){s+="<img src='images/flag.gif'>";}else{s+="&nbsp;";}
		s+="</td>";
		s+="<td> - </td>";
		s+="<td>";
		if(this.element['content']['view']['ID']['filter']){s+="<img src='images/flag.gif'>";}else{s+="&nbsp;";}
		s+="</td></tr>";
		for(var field in this.tables[this.element['content']['mainTable']]['fields']){
			s+="<tr><td>"+field+"("+this.tables[this.element['content']['mainTable']]['fields'][field]['type']+")</td>";
			s+="<td>";
			if(this.element['content']['view'][field]['show']){s+="<img src='images/flag.gif'>";}else{s+="&nbsp;";}
			s+="</td>";
			s+="<td>";
			if(this.tables[this.element['content']['mainTable']]['fields'][field]['type']=='int' && this.element['content']['view'][field]['lookupfield']!=-1){
				s+= this.tables[this.element['content']['mainTable']]['name'] + "." + this.element['content']['view'][field]['lookupfield'] + "=&gt;";
				s+= this.tables[this.element['content']['view'][field]['lookup']]['name'] + '.' + this.element['content']['view'][field]['lookupfield'];
			}else{
				s+=" - ";
			}
			s+="</td>";
			s+="<td>";
		if(this.element['content']['view'][field]['filter']){s+="<img src='images/flag.gif'>";}else{s+="&nbsp;";}
		s+="</td></tr>";
		}
		s+="</table>";
		//���������, ���� �� �������
		var childI=-1;
		for(var i in this.parent.bo){
			if(this.parent.bo[i]['parent']==this.elementId){
				childI=i;
			}
		}
		if(childI!=-1 && this.element['content']['thistable']!=-1 && this.element['content']['childtable']!=-1){
			//����� ������� ��� ��������� �����
			s+="����� ������� � ���������� ������������:";
			s+="<table><tr><td>";
			//��� ������ ����� �������
			s+=this.tables[this.element['content']['mainTable']]['name']+'.';
			s+=this.element['content']['thistable'];
			s+="</td><td>=</td><td>";
			//��� ��������� ����� �������
			if(this.tables[this.parent.bo[childI]['content']['mainTable']]!=null){
				s+=this.tables[this.parent.bo[childI]['content']['mainTable']]['name']+'.';
				s+=this.element['content']['childtable'];
			}else{
				s+=' ������� ������� �� ������� ';
			}
			/*
			//��� ��������� ����� �������
			s+=this.tables[this.parent.bo[childI]['content']['mainTable']]['name']+'.';
			s+=this.element['content']['childtable'];
			*/
			s+="</td></tr></table>";
		}
		return s;
	}
	
	this.step1=function(){
		var obj=document.getElementById(this.hname+'_mainTable');
		if(this.element['content']['mainTable']!=obj.value){
			this.element['content']['view']=null;
		}
		this.element['content']['mainTable']=obj.value;
		this.style=1;
		this.parent.context.Paint();
	}
	this.step2=function(){
		this.element['content']['view']=new Array;
		this.element['content']['view']['ID']=new Array;
		this.element['content']['view']['ID']['show']=document.getElementById(this.hname+'_show_ID').checked;
		this.element['content']['view']['ID']['lookup']=-1;
		this.element['content']['view']['ID']['lookupfield']=-1;
		this.element['content']['view']['ID']['filter']=document.getElementById(this.hname+'_filter_ID').checked;
		for(var field in this.tables[this.element['content']['mainTable']]['fields']){
			this.element['content']['view'][field]=new Array;
			this.element['content']['view'][field]['show']=document.getElementById(this.hname+'_show_'+field).checked;
			if(this.tables[this.element['content']['mainTable']]['fields'][field]['type']=='int'){
				this.element['content']['view'][field]['lookup']=document.getElementById(this.hname+"_lookup_"+field).value;
				this.element['content']['view'][field]['lookupfield'] = document.getElementById(this.hname + "_lookupfield_" + field).value;
			}
			this.element['content']['view'][field]['filter']=document.getElementById(this.hname+'_filter_'+field).checked;
		}
		//����� �� ���������
		var thistable=document.getElementById(this.hname+'_thistable');
		var childtable=document.getElementById(this.hname+'_childtable');
		if(thistable!=null && childtable!=null){
			this.element['content']['thistable']=thistable.value;
			this.element['content']['childtable']=childtable.value;
		}
		this.style=2;
		this.parent.context.Paint();
	}
	this.step3=function(){
		var obj=document.getElementById(this.hname+'_name');
		this.element['name']=obj.value;
		document.getElementById(this.hname+"_buttonOK").style.display='none';
		this.parent.saveQuest();
	}
	this.lookUpTablesField=function(table,field,name){
		var s="<select id='"+this.hname+"_"+name+"'>";
		s+="<option value=-1> - </option>";
		s+="<option value='id'";
		if('id'==field){s+=" selected";}
		s+=">id</option>";
		for(i in table['fields']){
			s+="<option value='"+i+"'";
			if(field==i){s+=" selected";}
			s+=">"+i+"</option>";
		}
		s+="</select>";
		return s;
	}
	this.lookUpSelect=function(field){
		var s="<select id='"+this.hname+"_lookup_"+field+"' onchange='"+this.name+".afterSelectLookUpTable(\""+field+"\");'><option value=-1> - </option>";
		for(var i in this.tables){
			if(i!=this.element['content']['mainTable']){
				s+="<option value="+i;
				if(this.element['content']['view'][field]!=null && this.element['content']['view'][field]['lookup']==i){s+=" selected";}
				s+=">"+this.tables[i]['name']+"</option>";
			}
		}
		s+="</select>";
		s+="<select id='"+this.hname+"_lookupfield_"+field+"'>";
		s+="<option value=-1> - </option>";
		if(this.element['content']['view'][field]!=null && this.element['content']['view'][field]['lookup']!=-1){
			for(i in this.tables[this.element['content']['view'][field]['lookup']]['fields']){
				s+="<option value='"+i+"'";
				if(this.element['content']['view'][field]['lookupfield']==i){s+=" selected";}
				s+=">"+i+"</option>";
			}
		}
		s+="</select>";
		return s;
	}
	this.afterSelectLookUpTable=function(field){
		var obj=document.getElementById(this.hname+"_lookupfield_"+field);
		var objtable=document.getElementById(this.hname+"_lookup_"+field);
		var s="<select id='"+this.hname+"_lookupfield_"+field+"'>";
		for(var i in this.tables[objtable.value]['fields']){
			s+="<option value='"+i+"'>"+i+"</option>";
		}
		s+="</select>";
		obj.outerHTML=s;
	}
}
