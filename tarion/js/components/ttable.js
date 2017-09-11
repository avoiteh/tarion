//���������� ��������� ��� ����������� �������
function TTable(name,hname,maincontext){
	this.name = name;
	this.hname=hname;
	this.maincontext=maincontext;
	
	this.color='#000000';
	this.bgcolor='#ffffff';
	this.sel_color='#ffffff';
	this.sel_bgcolor='#0000ff';
	this.headercolor='#000000';
	this.headerbgcolor='#cccccc';
	this.width = '100%';
	this.height= '100%';
	this.direction = 'asc';//����������� ������ �� ����������� ������� - asc|desc - �� ����������
	this.columns = new Array;
	this.records = new Array;//������ ������ - ��� ������ �� ��������
	
	this.style = 0;
	this.Init = function(){
		//�������������, � ������ ������ ���� ���������� ���� ['_sel'] � ������ ������, ����� ������������ ��� ������������
		//��������� �����
		for(i in this.records){
			this.records[i]['_sel']=false;
		}
	}
	this.onmousemove=function(){
		//��������
	}
	this.onclick=function(id){
		this.records[id]['_sel'] = !this.records[id]['_sel'];
		this.maincontext.Paint();
	}
	this.Paint = function(){
		switch(this.style){
			case 0:
				s = "<div onmousemove='" + this.name + ".onmousemove(event);' style='overflow:scroll;width:" + this.width + ";height:" + this.height + "' id='" + this.hname + "'>";
				//����� ������ �������
				s+="<table cellspacing=0 cellpadding=0>";
				//������� ������ ����������
				s+="<tr style='color:"+this.headercolor+";' bgcolor='"+this.headerbgcolor+"'>";
				for(i in this.columns){
					s+="<td width='"+this.columns[i]["width"]+"' style='border:#000000 1px solid'>"+this.columns[i]["name"]+"</td>";
				}
				s+='</tr>';
				//������� ������
				var ts='';
				var dts='';
				var j;
				for(var i in this.records){
					//jlyf cnhjrf
					if(this.direction=='asc'){
						if(this.records[i]['_sel']){
							ts+="<tr style='color:"+this.sel_color+";' bgcolor='"+this.sel_bgcolor+"'";
						}else{
							ts+="<tr style='color:"+this.color+";' bgcolor='"+this.bgcolor+"'";
						}
						ts+=" onmousedown='"+this.name+".onclick(\""+i+"\");'>";
						for(j in this.records[i]){
							if(j!='_sel'){
								ts+="<td style='border:#000000 1px solid;'>"+this.records[i][j]+"</td>";
							}
						}
						ts+="</tr>";
					}
					if(this.direction=='desc'){
						dts='';
						if(this.records[i]['_sel']){
							dts+="<tr style='color:"+this.sel_color+";' bgcolor='"+this.sel_bgcolor+"'";
						}else{
							dts+="<tr style='color:"+this.color+";' bgcolor='"+this.bgcolor+"'";
						}
						dts+=" onmousedown='"+this.name+".onclick(\""+i+"\");'>";
						for(j in this.records[i]){
							if(j!='_sel'){
								dts+="<td style='border:#000000 1px solid;'>"+this.records[i][j]+"</td>";
							}
						}
						dts+="</tr>";
						ts=dts+ts;
					}
				}
				s+=ts;
				s+="</table>";
				s+="</div>";
			break;
		}
		return s;
	}//������� ���������, ������, ��� ������ ���������� HTML! 
}
