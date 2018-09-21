(function () {
    var scriptName = "celtac.src.js";
    var index;

    var r = new RegExp("(^|(.*?\\/))(" + scriptName + ")(\\?|$)");
    var s = document.getElementsByTagName("script");
    var scriptTags = "";
    var src, m, host;

    for (index = 0; index < s.length; index++) {
        src = s[index].getAttribute("src");
        if (src) {
            m = src.match(r);
            if (m) {
                host = m[1];
                break;
            }
        }
    }

    var time = new Date().getTime();

	//--> call file to dom.
    var jsFiles = [
        "src/celtac.js?_=" + time
        //,"src/init_xxx.js?_=" + time
        //,"src/init_xxx.js?_=" + time
		//,"src/init_xxx.js?_=" + time
		//,"src/init_xxx.js?_=" + time
		//,"src/init_xxx.js?_=" + time
		,"src/init_domready.js?_=" + time

 
 
    ];

    while (jsFiles.length) { 
        scriptTags += "<script type='text/javascript' src='" + host + jsFiles.shift() + "'></script>";
    }
	//debugger;
    document.write(scriptTags);
}());