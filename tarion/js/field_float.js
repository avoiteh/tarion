function TFieldFloat(name,hname,data){
	this.name=name;
	this.hname=hname;
	this.data=data;//is float
	this.callback=null;
	this.style=0;
	this.size=9;
	
	this.Paint = function(){
		switch(this.style){
			case 0:
				var s="<a id='"+this.hname+"' href='javascript: "+this.name+".onEdit();' style='text-decoration:none; font-size:12px; color:#000000; background-color: #ffff80'> "+this.data+" </a>";
			break;
			case 1:
				var s='<input type=text size='+this.size+' id="'+this.hname+'_float"  value="'+this.data+'"> ';
				s+='<input type=button value=OK onclick="'+this.name+'.setEdit();">';
			break;
		}
		return s;
	}
	this.asText=function(){
		return(this.data);
	}
	this.onEdit = function(){
		//что делать если надо редактировать?
		this.style=1;
		main.Paint();
	}
	this.setEdit=function(){
		this.style=0;
		var s=document.getElementById(this.hname+'_float').value;
		this.data=parseFloat(s);
		if(this.callback!=null){eval(this.callback);}
	}	
}