		var d = new Date();
		var refresh_param = d.toLocaleString();
		//var jq_rut = jQuery.noConflict();
		//------------------------------------------------------------------------------------------------
		
		var jsFiles = [
			"libs/celtac.lib.js?_=\""+refresh_param+"\""
			,"js/celtac.src.js?_=\""+refresh_param+"\""
		];
		
		/*
		var jsFiles = [
			"libs/celtac.lib.js"
			,"js/celtac.src.js"
		];
		*/
		//--> write js lib file.
		var scriptTags = "";
		while (jsFiles.length) {
			scriptTags += "<script type='text/javascript' src='" + jsFiles.shift() + "'></script>";
		}
		//debugger;
		document.write(scriptTags);
		
		