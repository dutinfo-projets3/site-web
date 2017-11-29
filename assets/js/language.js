if(Cookies.get("lang") == null){
    Cookies.set("lang","en");
}
jQuery(function($){
    if(Cookies.get("lang") == "en"){
	   $.getJSON("assets/translation/lang.en.json",function(json){
            var doc = document.getElementsByTagName("html");
            searchAndTranslate(doc.item(0),json);
        });
    }
    else if(Cookies.get("lang") == "fr"){
        $.getJSON("assets/translation/lang.fr.json",function(json){
            var doc = document.getElementsByTagName("html");
            searchAndTranslate(doc.item(0),json);
        });
    }
})
     function searchAndTranslate(doc,json){
        if(doc.firstChild != null && doc.firstChild.nodeValue != null){
            var index =0;
            console.log(doc);
            while(doc.firstChild.nodeValue.indexOf("__",index)!=-1){
                index =doc.firstChild.nodeValue.indexOf("__",index);
                var translationString ="__";
                var string =doc.firstChild.nodeValue;
                if(doc.firstChild.nodeValue.indexOf("__",index+2)!=-1){
                    translationString += doc.firstChild.nodeValue.substr(index+2,doc.firstChild.nodeValue.indexOf("__",index+2)-index);
                    index =doc.firstChild.nodeValue.indexOf("__",index+2)+1;
                    if(json[translationString] != null){
                        string = string.replace(translationString,json[translationString]);
                        doc.innerText = string;
                    }
                }
                else(index = index+2);
            }
        }
        if(doc.attributes.item(0)!=null){
            for(var i=0;i<doc.attributes.length;i++){
                var index =0;
                var docAttrib = doc.attributes.item(i);
                while(docAttrib.value.indexOf("__",index)!=-1){
                    index = docAttrib.value.indexOf("__",index);
                    var translationString ="__";
                    var string = docAttrib.value;
                    if(docAttrib.value.indexOf("__",index+2)!=-1){
                        translationString += docAttrib.value.substr(index+2,docAttrib.value.indexOf("__",index+2)-index);
                        index = docAttrib.value.indexOf("__",index+2)+1;
                        if(json[translationString] != null){
                            string = string.replace(translationString,json[translationString]);
                            docAttrib.value = string;
                        }
                    }
                    else(index=index+2);
                }
            }
        }   
        doc = doc.children;
        for(var i =0;i<doc.length;i++){
            searchAndTranslate(doc.item(i),json);
        }
    }