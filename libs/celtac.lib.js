(function () {
    var scriptName = "celtac.lib.js";
    var index;

    var r = new RegExp("(^|(.*?\\/))(" + scriptName + ")(\\?|$)");
    var s = document.getElementsByTagName("script");
    var scriptTags = "";
    var styleTags  = "";
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

    var e,
        a = /\+/g,  // Regex for replacing addition symbol with a space
        r = /([^&=]+)=?([^&]*)/g,
        d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
        q = window.location.search.substring(1);

    while (e = r.exec(q))
       urlParams[d(e[1])] = d(e[2]);
	   
	//------------------------------------------------------------------------
	var jsFiles = [
		// [Ext]
		"ext/adapter/ext/ext-base.js"
		,"ext/ext-all.js"
		,"ext/ux/TableGrid.js"
		,"ext/ux/SearchField.js"
		,"ext/ux/fileuploadfield/FileUploadField.js"
		,"ext/ux/statusbar/StatusBar.js"

		
		// [FancyBox]
		//,"fancyBox/jquery-1.7.1.min.js"
		//,"fancyBox/jquery.mousewheel-3.0.6.pack.js"
		//,"fancyBox/jquery.fancybox.js"
		//,"fancyBox/helpers/jquery.fancybox-buttons.js?v=2.0.3"

	];

	var cssFiles = [
		// [Ext]
		"ext/resources/css/ext-all.css"
		,"ext/ux/fileuploadfield/css/fileuploadfield.css"
		
		// [FancyBox]
		//,"fancyBox/jquery.fancybox.css"
		//,"fancyBox/helpers/jquery.fancybox-buttons.css?v=2.0.3"
	];

	//--> write js lib file.
	while (jsFiles.length) {//debugger;
		scriptTags += "<script type='text/javascript' src='" + host + jsFiles.shift() + "'></script>";
	}
	document.write(scriptTags);
	console.log(scriptTags);
	
	
	//--> write css for lib file.
	while (cssFiles.length) {
		styleTags += "<link rel='stylesheet' type='text/css' href='" + host + cssFiles.shift() + "'></script>";
	}
	document.write(styleTags);
	console.log(styleTags);
        
	//debugger;

}());