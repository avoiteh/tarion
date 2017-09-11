function TFieldData(name,hname,data){
	this.name=name;
	this.hname=hname;
	this.data=data;//is array day, month, year
	this.months= new Array('январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
	this.m_days= new Array(31,28,31,30,31,30,31,30,31,31,30,31);
	this.style=0;
	
	this.Paint = function(){
		switch(this.style){
			case 0:
				var s="<a id='"+this.hname+"' href='javascript: "+this.name+".onEdit();' style='text-decoration:none; font-size:12px; color:#000000; background-color: #ffff80'> "+this.data[0]+" "+this.months[this.data[1]-1]+" "+this.data[2]+" </a>";
			break;
			case 1:
				var s='<table id="'+this.hname+'" cellpadding=0 cellspacing=0 border=0 style="font-size:9px"><tr>';
				s+='<td><input size=2 type=text id="'+this.hname+'_day"  value="'+this.data[0]+'"></td>';
				s+='<td><input size=2 type=text id="'+this.hname+'_month" value="'+this.data[1]+'"></td>';
				s+='<td><input size=4 type=text id="'+this.hname+'_year" value="'+this.data[2]+'"></td>';
				s+='<td><input type=button value=OK onclick="'+this.name+'.setEdit();"></td>';
				s+='</tr></table>';
			break;
		}
		return s;
	}
	this.asText=function(){
		return(this.data[2]+'-'+this.data[1]+'-'+this.data[0]);
	}
	this.onEdit = function(){
		//что делать если надо редактировать?
		this.style=1;
		main.Paint();
	}
	this.setEdit=function(){
		this.style=0;
		var s=document.getElementById(this.hname+'_day').value;
		this.data[0]=parseInt(s);
		s=document.getElementById(this.hname+'_month').value;
		this.data[1]=parseInt(s);
		s=document.getElementById(this.hname+'_year').value;
		this.data[2]=parseInt(s);
		main.Paint();
	}
	
	this.dayPlus = function(){
		this.data[0]++;
		if(this.data[0]>this.m_days[this.data[1]-1]){
			this.data[0]=1;
			this.data[1]++;
		}
		if(this.data[1]>12){
			this.data[1]=1;
			this.data[2]++;
		}
	}
	this.dayMinus=function(){
		this.data[0]--;
		if(this.data[0]==0){
			this.data[1]--;
			if(this.data[1]==0){
				this.data[1]=12;
				this.data[2]--;
			}		
			this.data[0]=this.m_days[this.data[1]-1];
		}
	}
}