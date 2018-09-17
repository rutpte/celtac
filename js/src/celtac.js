
//--> create celtac class.

	function celtac () {
		this.pjName = "celtac";
		this.g_func = {
			"func1" : function(){
				console.log("usesing func1");
			}
			,"func2" : function(){
				console.log("usesing func2");
			}
			,"func3" : function(){
				console.log("usesing func3");
			}
			,"modal_contact" : function(){
				
				$("#modalLabel").text("contect.");
				$string_address = "";
				$string_address += "<span>Telephone No. : +66 2 275 2500</span>";
				$string_address += "<br/><span>Hotline : +66 61 401 0345</span>";
				$string_address += "<br/><span>Line ID : CALLCENTERBYHEAT</span>";
				$string_address += "<br/><span>Address :</span>​";
				$string_address += "<br/><span>147 Soi Intamara 33 Yak 2, Suthisan Rd.,  Dindang Bangkok 10400 Thailand</span>";
				$("#contact_address").html($string_address);
				$('#modal_contact').modal('show');
				
				//--> create qrcode.
				celtac.g_func.gen_qrcode_contact();
				
			}
			,"modal_user" : function(){
				
					$.ajax({
						url: "usermanage.php",
						dataType: 'text', // Notice! JSONP <-- P (lowercase)
						method : 'POST',
						data: { 
							"q"              : "get_all_user"
						},
						type: "GET",
						success:function(response){
							//console.debug('response : ',response);
							//debugger;
							//console.log(response);
							var obj_response = jQuery.parseJSON(response);
							
							//console.debug('respont : ',respont);
							if (obj_response.success) {
								
							} else {

							}
						},
						error:function(response){
							console.debug(response);
						}
					});
					
					//-----------------------
					$('#modal_user').modal('show');
				
				
			}
			,"modal_add_order" : function(){
				

					
					//-----------------------
					$('#modal_add_order').modal('show');
				
				
			}
			,"init_cookie_login" : function(){
				
				//--> part 1. set auto complete by cookie.
				var remember = $.cookie('remember');
				if (remember == 'true') {
				
					var email = $.cookie('email');
					var password = $.cookie('password');
					// autofill the fields
					if(typeof(email) != "undefined"){
						$('#email').val(email);
						$('#password').val(password);
					}

				}

				//--> part 2. keep user pass word in cookie.
				$("#login").submit(function() {
					console.log("submited");
					
					//--> keep cookie.
					if ($('#remember').is(':checked')) {
						var email = $('#email').val();
						var password = $('#password').val();

						// set cookies to expire in 14 days
						$.cookie('email', email, { expires: 14 });
						$.cookie('password', password, { expires: 14 });
						$.cookie('remember', true, { expires: 14 });                
					}
					else
					{
						// reset cookies
						$.cookie('email', null);
						$.cookie('password', null);
						$.cookie('remember', null);
					}
				});
			}
			,"init_login" : function(){
				//$("#login").submit(function() {
				$("#sing_in").click(function() {
					
					console.log("login");
					//debugger;
					var email 		= $('#email').val();
					var password 	= $('#password').val();
					//debugger;
					//--> ajack create session.
					

					$.ajax({
						url: "authen.php",
						dataType: 'text', // Notice! JSONP <-- P (lowercase)
						method : 'POST',
						data: { 
							"q"              : "login",
							"email"          : email,
							"passwd"         : password
						},
						type: "GET",
						success:function(response){
							//console.debug('response : ',response);
							//debugger;
							var obj_response = jQuery.parseJSON(response);
							//debugger;
							//console.debug('respont : ',respont);
							if (obj_response.success) {
								location.reload();
							} else {
								//console.log(obj_response.msg);
								$("#error_login_info").text(obj_response.msg);
							}
						},
						error:function(response){
							console.debug(response);
						}      
					});
				});
			}
			,"init_logout" : function(){

				$("#logout").click(function() {
					
					console.log("logout");

					//--> ajack create session.
					

					$.ajax({
						url: "authen.php",
						dataType: 'text', // Notice! JSONP <-- P (lowercase)
						method : 'POST',
						data: { 
							"q"              : "logout"
						},
						type: "GET",
						success:function(response){
							//console.debug('response : ',response);
							
							//refresh a page.
							location.reload();
						},
						error:function(response){
							console.debug(response);
						}      
					});
				});
			}
			,"gen_qrcode_contact" : function(){
				$("#contact_qrcode").empty();
				$("#contact_qrcode").qrcode({
					//render:"table"
					width: 128,
					height: 128,
					text: "http://google.com"
				});
			}
		};
		this.g_var = {
			"var1" : "var1"
			,"var2" : "var2"
			,"var3" : "var3"
		};
	}
//debugger;
