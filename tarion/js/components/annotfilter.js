//���������� ��������� ��� ����������� ������� ����������
function TAnnotFilter(name,hname,maincontext,parent){
	this.name = name;
	this.hname=hname;
	this.maincontext=maincontext;
	this.parent=parent;
	
	this.color='#000000';
	this.bgcolor='#ffffcc';
	this.x=50;
	this.y=30;
	this.width = '250';
	this.height= '200';
	this.filter=new Array;
	
	
	
	
	this.filter['type']=new Array;
	
	this.filter['type']['ДОМ']=true;
	this.filter['type']['КВАРТИРА']=true;
	this.filter['type']['ДАЧА']=true;
	this.filter['type']['АВТО ЛЕГКОВОЙ']=true;
	this.filter['type']['АВТО ГРУЗОВОЙ']=true;
	this.filter['type']['КНИГИ']=true;
	this.filter['type']['МЕДИЦИНА']=true;
	this.filter['type']['СТРОИТЕЛЬСТВО']=true;
	this.filter['type']['ПАРФЮМЕРИЯ']=true;
	this.filter['tradetype']=new Array;
	this.filter['tradetype'][1]=true;
	this.filter['tradetype'][2]=true;
	this.filter['tradetype'][3]=true;
	this.filter['tradetype'][4]=true;
	this.filter['tradetype'][5]=true;
	this.filter['tradetype'][6]=true;
	this.filter['tradetype'][7]=true;
	this.filter['tradetype'][8]=true;
	
	this.style = 0;
	this.visible = false;
	this.onmousemove=function(){
		//��������
	}
	this.onclick=function(id){
		var selector = document.getElementById(this.hname+"_type");
		var s='';
		var n=selector.options.length;
		this.filter['type']=new Array();
		for(var i=1;i<n;i++){
			this.filter['type'][i]=selector.options[i].value+':'+selector.options[i].innerText+':'+selector.options[i].selected;
		}
		for(i=1;i<8;i++){
			this.filter["tradetype"][i]=document.getElementById(this.hname+"_tt_"+i).checked;
		}
		this.visible=false;
		//�� ��� ������ � ������� ���������� ������������...
		this.SendQuest();
//		this.maincontext.Paint();
	}
	
	this.SendQuest=function(){//������� ������ ������������ ����� � ��������
		var q = '{"id":"setFilter","annotFilter":[{"type":[';
		var f=false;
		var oneItem,oneType;
		for(var id in this.filter["type"]){
			if(f){q+=',';}
			q+='"'+this.filter["type"][id]+'"';
			f=true;
		}
		q+='],"tradetype":[';
		for(i=0;i<8;i++){
			if(i>1){q+=','}
			q+='"'+this.filter["tradetype"][i]+'"';
		}
		q+=']}]}';
	//alert(q);
		this.visible=false;
		this.maincontext.AJAXquery(q, this.parent.name);
	}
	
	this.Paint = function(){
		var s="";
		if(this.visible){
			switch(this.style){
			case 0:
				s="<table style='position:absolute;left:"+this.x+"px;top:"+this.y+"px;width:"+this.width+"px;height:"+this.height+"px;z-index:100;' name='"+this.hname+"' bgcolor='"+this.bgcolor+"'>";
				s+="<tr><td colspan=2 bgcolor='#cccccc'>������ ����������</td></tr>";
				s+="<tr><td valign=top>���������. ���:<br><select style='height:"+(this.height-10)+"px' id='"+this.hname+"_type' multiple='multiple'>";
				//������ �����
				var oneItem,oneType;
				for(var id in this.filter["type"]){
					oneItem=this.filter["type"][id];
					oneType=oneItem.split(':');
					s+='<option value="'+oneType[0]+'"';
					if(oneType[2]=='true'){s+=' selected';}
					s+='>'+oneType[1]+'</option>';
				}
				s+="</select></td><td valign=top>������. ���:<br><br>";
				//����� ����������� �������...
//alert(this.filter);
				for(i=1;i<8;i++){
					s+="<input type='checkbox' id='"+this.hname+"_tt_"+i+"' ";
					if(this.filter["tradetype"][i]){s+=' checked';}
					s+="> "+trade_typeById(i)+'<br>';
				}
				s+="</td></tr>";
				s+="<tr><td colspan=2 align=right><input type='button' value=' OK ' onclick='"+this.name+".onclick();'></td></tr></table>";
			break;
			}
		}
		return s;
	}//������� ���������, ������, ��� ������ ���������� HTML! 
}