// Проверяем знает ли браузер про HTMLElement.
if (typeof(HTMLElement) != "undefined") {
    var _emptyTags = {
       "IMG": true,
       "BR": true,
       "INPUT": true,
       "META": true,
       "LINK": true,
       "PARAM": true,
       "HR": true
    };
    
    HTMLElement.prototype.__defineGetter__("outerHTML", function () {
       var attrs = this.attributes;
       var str = "<" + this.tagName;
       for (var i = 0; i < attrs.length; i++)
          str += " " + attrs[ i ].name + "=\"" + attrs[ i ].value + "\"";
    
       if (_emptyTags[this.tagName])
          return str + ">";
    
       return str + ">" + this.innerHTML + "</" + this.tagName + ">";
    });
    
    HTMLElement.prototype.__defineSetter__("outerHTML", function (sHTML) {
       var r = this.ownerDocument.createRange();
       r.setStartBefore(this);
       var df = r.createContextualFragment(sHTML);
       this.parentNode.replaceChild(df, this);
    });
}
