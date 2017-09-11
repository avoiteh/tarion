//данный компонент предназначен для хранения данных произвольной конфигурации грузимых с сервера
function TDataLoad(name){
	this.name=name;
	
	this.content = null;
	this.flagRepaintOnLoad = false;
	
	this.dataQuery = '';
	this.onLoad = null;
	this.SendQuest=function(){//послать запрос относительно карты и объектов
		main.AJAXquery(this.dataQuery, this.name);
	}
	this.AJAXresult=function(json_serial){//на основании полученного JSON объекта
		this.content=eval(json_serial);
		if(this.flagRepaintOnLoad){
			main.Paint();
		}
	}
}