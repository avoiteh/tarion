function FileManager() {
    /*
     * РјРµС‚РѕРґ Р·Р°РїСѓСЃРєР° С„Р°Р№Р»РѕРІРѕРіРѕ РјРµРЅРµРґР¶РµСЂР°
     *
     */
    this.Paint = function () {
        // СЃРѕР·РґР°С‘Рј РЅР° СЃС‚СЂР°РЅРёС†Рµ РЅРµРѕР±Р·РѕРґРёРјС‹Рµ РґР»СЏ РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ html-СЌР»РµРјРµРЅС‚С‹
        document.write ('<div id="file_manager">');
        document.write ('</div>');
        var div_fm = document.getElementById('file_manager');
        
        div_fm.innerHTML = '<div id="fm_panels"></div>';
        
        var div_panels = document.getElementById('fm_panels');
        div_panels.innerHTML = '<div id="fm_left"></div>';
        div_panels.innerHTML += '<div id="fm_right"></div>';

        
        // СЃРѕР·РґР°С‘Рј РЅРµРѕР±С…РѕРґРёРјС‹Рµ js-РѕР±СЉРµРєС‚С‹
        var div_left = document.getElementById('fm_left');
        var div_right = document.getElementById('fm_right');
        var div_button = document.getElementById('fm_right');
        
        // Р·Р°РїСѓСЃРєР°РµРј РјРµС‚РѕРґС‹ РѕС‚РѕР±СЂР°Р¶РµРЅРёСЏ Р»РµРІРѕР№ Рё РїСЂР°РІРѕР№ РєРѕР»РѕРЅРѕРє РјРµРЅРµРґР¶РµСЂР°
        this.getDir(div_left);
        this.getDir(div_right);
        
    }
    
    this.getDir = function(position,url) {
        var handleSuccess = function(o){
            if(o.responseText !== undefined)
            {
            	position.innerHTML = '';
                var data = eval("(" + o.responseText + ")");
    			position.innerHTML += "<div>РЎРѕРґРµСЂР¶РёРјРѕРµ РґРёСЂРµРєС‚РѕСЂРёРё: " + data['path'] + "</div>";
    			
    			for(i=0; i<data.dirs.length; i++)
    			{
    				if (data['dirs'][i]=='..') {
    				    if (data['path'].length>1) {
        				    for(j=(data['path'].length-1); j>0; j--)
        				    {
        				        if (data['path'].charAt(data['path'].length-j-2)=='/')
        				        {
        				            var path = data['path'].substr(0,data['path'].length-j-1);
        				        }
        				    }
        				    position.innerHTML += "<div onClick=FM.getDir(document.getElementById('" + position.id + "'),'" + path + "')>" + data['dirs'][i] + "</div>";
    				    }
    				}
    				else
    				{
    			        position.innerHTML += "<div onClick=FM.getDir(document.getElementById('" + position.id + "'),'" + data['path'] + data['dirs'][i] + "/')>" + data['dirs'][i] + "</div>";
    				}
    			}
    			if(data.files)
    			{
    				for(i=0; i<data.files.length; i++)
    				{
    					position.innerHTML += "<div>" + data['files'][i] + "</div>";
    				}
    			}
            }
        }
        
        var handleFailure = function(o){
            YAHOO.log("The failure handler was called.  tId: " + o.tId + ".", "info", "example");
    
            if(o.responseText !== undefined){
                    div.innerHTML = "<li>Transaction id: " + o.tId + "</li>";
                    div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
                    div.innerHTML += "<li>Status code message: " + o.statusText + "</li>";
            }
        };
        
        var callback =
        {
          success:handleSuccess,
          failure:handleFailure,
          argument:['foo']
        };
        
        var sUrl = "post.php";
        
        if(url == undefined) {
            url = '/var/www/vhs/golovchansky/';
        }
			
		
		var postDat = { 
В  В  В  В  В  	 'path'В  В :В  В url
В  В  В  В  };
		var postData = YAHOO.util.param(postDat);
        
		var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callback, postData);

        YAHOO.log("Initiating request; tId: " + request.tId + ".", "info", "example");
    }

}