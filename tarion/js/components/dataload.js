//������ ��������� ������������ ��� �������� ������ ������������ ������������ �������� � �������
function TDataLoad(name){
	this.name=name;
	
	this.content = null;
	this.flagRepaintOnLoad = false;
	
	this.dataQuery = '';
	this.onLoad = null;
	this.SendQuest=function(){//������� ������ ������������ ����� � ��������
		main.AJAXquery(this.dataQuery, this.name);
	}
	this.AJAXresult=function(json_serial){//�� ��������� ����������� JSON �������
		this.content=eval(json_serial);
		if(this.flagRepaintOnLoad){
			main.Paint();
		}
	}
}