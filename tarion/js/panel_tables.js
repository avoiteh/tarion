function TPanelTables(name,hname,context){
	this.type='TPanelTables';
	this.title='�������';
	this.name=name;
	this.hname=hname;
	this.mouseDX=0;
	this.mouseDY=0;
	this.enable = true;
	this.open = false;
	this.context=context;//�� ����� ��������� �����
	this.style=0;//�������� ��������� �����
	this.color=0;//�������� ��������� ����� ���� 0-�����
	this.left=150;
	this.top=30;
	this.width=600;
	this.height=500;
	this.tables = new Array();
	this.dbtable = new TDBTables(this.name+'.dbtable', this.hname+'_dbtable', this.context);
	
	this.urlC=function(){
		//���������� ���������� ��� ������
		return this.name + '={"type":"' + this.type + '","open":"' + this.open + '","send":"SendQuest"}';
	}
		
	this.Paint=function(){
		//��������� ���� ����
		var bgk=this.color;
		switch(this.color){
			case 0:
				bgk='ffffff';
			break;
		}
		
		this.dbtable.tables=this.tables;
		this.dbtable.width=this.width-15;
		this.dbtable.height=this.height-45;
		this.dbtable.parent=this;
		
		//���������� ������
		switch(this.style){
			case 0://<div style='width:100%;height:100%;overflow:scroll'>
				var s="<table id='" + this.hname + "' style='width:" + this.width + "px;height:" + this.height + "px;background-color:#ffffcc;border:1px solid #000000;position:absolute;left:" + this.left + ";top:" + this.top + ";z-index:100' onmouseover='" + this.context.name + ".currentobject=" + this.name + ";'><tr bgcolor='#cccccc'><td>" + this.title + "</td><td align='right' height=10><img src='" + this.context.images_path + "close.gif' onmousedown='" + this.context.name + ".Opened(" + this.name + ", false);'>";
				//<img src='"+context.images_path+"free.gif' onmousedown='"+this.context.name+".freeObject("+this.name+");'>

				s+="</td></tr><tr><td valign=top colspan=2>";
				
				//���������� ������ ������/�����
				s+="<input type='button' value='���������' title='��������� ���������' onclick='"+this.name+".saveTables();'>";
				s+="<input type='button' value='�������� ���������' title='�������� ���������' onclick='"+this.name+".SendQuest();'>";
				s+="<input type='button' value='������' title='������������� � ������ ������� �� ���� ������' onclick='"+this.name+".importTable()'>";
				s+=this.dbtable.Paint();
				s+="</table>";
			break;
		}
		return s;
	}//������� ���������, ������, ��� ������ ���������� HTML! 
	//��� ���������������� ���������� ���������� ��������
	
	this.SendQuest=function(){//������� ������ ������������ ����� �������������
		var q='{"id":"Tables","mode":"get"}';
		context.AJAXquery(q, this.name);
	}
	this.importTable=function(){
		var q='{"id":"Tables","mode":"import"}';
		context.AJAXquery(q, this.name);
	}
	this.saveTables=function(){
		this.dbtable.collectData();
		var q='{"id":"Tables","mode":"save","tables":"'+this.encodeTables()+'"}';
//alert(q);
		context.AJAXquery(q, this.name);
	}
	this.encodeTables=function(){
	    var s='array(';
	    var d0='';
	    var d1='';
	    var field;
	    for(var i in this.tables){
	    	s+=d0+"'"+i+"'=>array('name'=>'"+this.tables[i]['name']+"', 'fields'=>array(";
	    	d1='';
	    	for(field in this.tables[i]['fields']){
	    		s+=d1+"'"+field+"'=>array('type'=>'"+this.tables[i]['fields'][field]['type']+"', 'remark'=>'"+escape(this.tables[i]['fields'][field]['remark'])+"')";
	    		d1=',';
	    	}
	    	s+='))';
	    	d0=',';
	    }
	    s+=')';
		return s;
	}


	this.AJAXresult=function(json_serial){//�� ��������� ����������� JSON �������
//alert(json_serial);
		var json=eval(json_serial);
		if(json['tables']){
			this.tables=json['tables'];
			context.Paint();
			if(document.getElementById(this.hname+'_dbtable')!=null){
				document.getElementById(this.hname+'_dbtable').scrollTop=this.dbtable.divScroll;//������������ ��������� DIV
			}
		}
		if(json['sendMess']=='Refresh'){
			this.SendQuest();
		}
	}
}

