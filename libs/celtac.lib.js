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
		//"ext/ext-all.js"
		//,"ext/adapter/ext/ext-base.js"
		//,"ext/ux/TableGrid.js"
		//,"ext/ux/SearchField.js"
		//,"ext/ux/fileuploadfield/FileUploadField.js"
		//,"ext/ux/statusbar/StatusBar.js"
		
		
		// [jquery]
		"assets/js/vendor/jquery.js"
		,"assets/js/vendor/jquery-cookie.js"
		,"assets/js/vendor/jquery-qrcode.js"
		,"assets/js/vendor/jq_ui/jquery-ui.js"
		// ,"assets/js/vendor/jq_plugin/date_time/picker.date.js"
		// ,"assets/js/vendor/jq_plugin/date_time/picker.time.js"
		// ,"assets/js/vendor/jq_plugin/date_time/legacy.js"
		
		//[bootstrap]
		,"dist/js/bootstrap.min.js"
		//,"dist/js/bootstrap.bundle.min.js"
		//,"dist/js/ie10-viewport-bug-workaround.js"
		//,"dist/js/ie-emulation-modes-warning.js"
		//,"dist/js/xxxx"
		

		
		//[popper]
		,"assets/js/vendor/popper.min.js"
		


		
		//[fancybox]
		//,"fancyBox/jquery-1.7.1.min.js"
		//,"fancyBox/jquery.mousewheel-3.0.6.pack.js"
		//,"fancyBox/jquery.fancybox.js"
		//,"fancyBox/helpers/jquery.fancybox-buttons.js?v=2.0.3"

	];

	var cssFiles = [

		// [css bootstrap]
		"dist/css/bootstrap.min.css"
		,"dist/css/bootstrap-grid.min.css"
		,"dist/css/bootstrap-reboot.min.css"
		//,"dist/css/ie10-viewport-bug-workaround.css"
		//,"dist/css/jumbotron-narrow.css"
		// [FancyBox]
		//,"fancyBox/jquery.fancybox.css"
		//,"fancyBox/helpers/jquery.fancybox-buttons.css?v=2.0.3"
		
		// [jq-plugin]
		,"assets/js/vendor/jq_ui/jquery-ui.css"
		// ,"assets/js/vendor/jq_plugin/date_time/themes/classic.date.css"
		// ,"assets/js/vendor/jq_plugin/date_time/themes/classic.time.css"
		// ,"assets/js/vendor/jq_plugin/date_time/themes/default.css"
		// ,"assets/js/vendor/jq_plugin/date_time/themes/default.date.css"
		// ,"assets/js/vendor/jq_plugin/date_time/themes/default.time.css"
		
	];

	//--> write js lib file.
	while (jsFiles.length) {//debugger; //splice
		scriptTags += "<script type='text/javascript' src='" + host + jsFiles.shift() + "'></script>";
	}
	document.write(scriptTags);
	//console.log(scriptTags);
	
	
	//--> write css for lib file.
	while (cssFiles.length) {
		styleTags += "<link rel='stylesheet' type='text/css' href='" + host + cssFiles.shift() + "'></script>";
	}
	document.write(styleTags);
	//console.log(styleTags);
        
	//debugger;

}());