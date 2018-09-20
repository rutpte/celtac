
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
			,"user" : function(q,obj){
				switch (q) {
					case "show_model_adduser":
						$('#modal_add_user').modal('show');
						break;
					case "add":
						var email		= $('#email').val();
						var pass		= $('#pass').val();
						var company		= $('#company').val();
						var phone		= $('#phone').val();
						var firstName	= $('#firstName').val();
						var lastName	= $('#lastName').val();
						var address		= $('#address').val();
						var is_staff	= $('#is_staff').is(":checked");
						

						//debugger;
						// console.log(company);
						// console.log(phone);
						// console.log(firstName);
						// console.log(lastName);
						// console.log(address);
						// console.log(email);
						// console.log(pass);
						var sta_validate = true;
						if (email == ""){
							$('#email_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (pass == ""){
							$('#pass_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if(company == ""){
							$('#company_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (phone == ""){
							$('#phone_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (firstName == ""){
							$('#firstName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (lastName == ""){
							$('#lastName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (address == ""){
							$('#address_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						}
						
						if(sta_validate){
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q"              : "add_user"
									,"company"       : company
									,"phone"         : phone
									,"firstName"     : firstName
									,"lastName"      : lastName
									,"address"       : address
									,"email"         : email
									,"pass"          : pass
									,"is_staff"		 : is_staff	
									
								},
								type: "GET",
								success:function(response){
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									var obj_response = jQuery.parseJSON(response);
									debugger;
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										alert("complete.");
										location.reload();
									} else {

									}
								},
								error:function(response){
									console.debug(response);
								}
							});
							
						}//end if false.

						break;					
					case "init_admin_page":
						//--..yourcode.
						if(true){
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q" : "get_all_user"
								},
								type: "GET",
								success:function(response){
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									var obj_response = jQuery.parseJSON(response);
									debugger;
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										console.log(obj_response);
										window.location = window.location.hostname+"/"+celtac.pjName+"/admin_page.php";
										//header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");
									} else {

									}
								},
								error:function(response){
									console.debug(response);
								}
							});
							
						}//end if false.
						//header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");
						break;					
					case "xxx":
						//--..yourcode.
						break;					
					case "xxx":
						//--..yourcode.
						break;					
					case "xxx":
						//--..yourcode.
						break;					
					case "xxx":
						//--..yourcode.
						break;
					case  "get_all_user":
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
						break;
				}

					
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
								//debugger;
								//celtac.g_var.user = obj_response;
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
