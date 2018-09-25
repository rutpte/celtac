
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
			,"manage_page" : function(user_type){
				//--> not use but keep for prototype.
				if(user_type == "superuser"){
					window.location = window.location.origin+ "/" + celtac.pjName + "/admin_page.php";
				} else if(user_type == "staff"){
					window.location = window.location.origin+ "/" + celtac.pjName + "/staff_page.php";
				} else if(user_type == "customer"){
					window.location = window.location.origin+ "/" + celtac.pjName + "/customer_page.php";
				}
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
			,"notice_div_error" : function(arr_dom_id,str_current_dom_id){
				for (i = 0; i < arr_dom_id.length; i++) {
					if(arr_dom_id[i] == str_current_dom_id){
						$('#'+arr_dom_id[i]+'').addClass('ui-state-error ui-corner-all');
					} else {
						$('#'+arr_dom_id[i]+'').removeClass('ui-state-error ui-corner-all');
					}
				}
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
						var arr_dom_id = new Array();
						arr_dom_id.push('firstName');
						arr_dom_id.push('lastName');
						arr_dom_id.push('email');
						arr_dom_id.push('pass');
						arr_dom_id.push('company');
						arr_dom_id.push('phone');
						arr_dom_id.push('address');

						
						var sta_validate = true;
						if (firstName == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"firstName");
							//$('#firstName').addClass('ui-state-error ui-corner-all');
							//$('#firstName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (lastName == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"lastName");
							//$('#lastName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (email == ""){
							//$('#email_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"email");
							sta_validate = false;
						} else if (pass == ""){
							//$('#pass_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"pass");
							sta_validate = false;
						} else if(company == ""){
							//$('#company_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"company");
							sta_validate = false;
						} else if (phone == ""){
							//$('#phone_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"phone");
							sta_validate = false;

						} else if (address == ""){
							//$('#address_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"address");
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
									//debugger;
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										//alert("complete.");
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
					case "edit_user_model":
						var id_user = obj;
						$('#modal_edit_user').modal('show');
						console.log(obj_all_user[id_user]);
						
						var email = obj_all_user[id_user].email;
						var pass = obj_all_user[id_user].pass;
						var company = obj_all_user[id_user].company;
						var phone = obj_all_user[id_user].phone_no;
						var firstName = obj_all_user[id_user].first_name;
						var lastName = obj_all_user[id_user].last_name;
						var address = obj_all_user[id_user].address;
						var is_staff = obj_all_user[id_user].is_staff;
						
						
						//--> auto add exits data.
						
						$('#modal_edit_user').find('#user_id_edit').val(id_user);
						$('#modal_edit_user').find('#email_edit').val(email);
						$('#modal_edit_user').find('#pass_edit').val(pass);
						$('#modal_edit_user').find('#company_edit').val(company);
						$('#modal_edit_user').find('#phone_edit').val(phone);
						$('#modal_edit_user').find('#firstName_edit').val(firstName);
						$('#modal_edit_user').find('#lastName_edit').val(lastName);
						$('#modal_edit_user').find('#address_edit').val(address);
						$('#modal_edit_user').find('#is_staff_edit').prop('checked', is_staff);
						//--> mission complete.

					break;
					case "update_user":
						var id_user 	= $('#modal_edit_user').find('#user_id_edit').val();
						var email		= $('#modal_edit_user').find('#email_edit').val();
						var pass		= $('#modal_edit_user').find('#pass_edit').val();
						var company		= $('#modal_edit_user').find('#company_edit').val();
						var phone		= $('#modal_edit_user').find('#phone_edit').val();
						var firstName	= $('#modal_edit_user').find('#firstName_edit').val();
						var lastName	= $('#modal_edit_user').find('#lastName_edit').val();
						var address		= $('#modal_edit_user').find('#address_edit').val();
						var is_staff	= $('#modal_edit_user').find('#is_staff_edit').is(":checked");
						

						var arr_dom_id = new Array();
						arr_dom_id.push('firstName');
						arr_dom_id.push('lastName');
						arr_dom_id.push('email');
						arr_dom_id.push('company');
						arr_dom_id.push('phone');
						arr_dom_id.push('address');
						
						/*
						var sta_validate = true;
						if (email == ""){
							$('#email_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if(company == ""){
							$('#company_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (phone == ""){
							$('#phone_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (firstName == ""){
							$('#firstName_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (lastName == ""){
							$('#lastName_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (address == ""){
							$('#address_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						}
						*/
						//------------------
						var sta_validate = true;
						if (firstName == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"firstName");
							//$('#firstName').addClass('ui-state-error ui-corner-all');
							//$('#firstName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (lastName == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"lastName");
							//$('#lastName_vlid').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (email == ""){
							//$('#email_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"email");
							sta_validate = false;
						} else if(company == ""){
							//$('#company_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"company");
							sta_validate = false;
						} else if (phone == ""){
							//$('#phone_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"phone");
							sta_validate = false;

						} else if (address == ""){
							//$('#address_vlid').text("*needed value.").css('color', 'red');
							celtac.g_func.notice_div_error(arr_dom_id,"address");
							sta_validate = false;
						}
						//------------------
						if(sta_validate){
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: {
									"q"              : "update_user"
									,"id"		     : id_user 
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
									
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										
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
					case "delete_user":
						var id_user = obj;
						$('#modal_delete_confirm').modal('show');
						var cilck_ok = false;
						$('#modal_delete_confirm').find('#del_ok').click(function() {
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q" : "delete_user"
									,"id" : id_user
								},
								type: "GET",
								success:function(response){
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									var obj_response = jQuery.parseJSON(response);
									
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										console.log(obj_response);
										location.reload();
										//window.location = window.location.hostname+"/"+celtac.pjName+"/admin_page.php";
										//header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");
									} else {

									}
								},
								error:function(response){
									console.debug(response);
								}
							});
						});

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
			,"order" : function(q,obj){
				switch (q) {
					case "show_model_addorder": 
						
						$('#modal_add_order').modal('show');
						$('#delivery_date').datepicker();
						
						$("#quantity").on("keypress keyup blur",function (event) {   
							$(this).val($(this).val().replace(/[^\d].+/, ""));
							if ((event.which < 48 || event.which > 57)) {
								event.preventDefault();
							}
						});
						$("#vial").on("keypress keyup blur",function (event) {   
							$(this).val($(this).val().replace(/[^\d].+/, ""));
							if ((event.which < 48 || event.which > 57)) {
								event.preventDefault();
							}
						});
						break;
					case "add":
						var customer_name			= $('#customer_name').val();
						var product_type			= $('#product_type').val();
						var quantity				= $('#quantity').val();
						var vial					= $('#vial').val();
						var total_cel				= $('#total_cel').val();
						var package_type			= $('#package_type').val();
						var delivery_date			= $('#delivery_date').val();
						var delivery_time_hour		= $('#delivery_time_hour').val();
						var delivery_time_minute	= $('#delivery_time_minute').val();
						var giveaway				= $('#giveaway').val();
						var receiver				= $('#receiver').val();
						var dealer_person			= $('#dealer_person').val();
						var dealer_company			= $('#dealer_company').val();
						var price_rate				= $('#price_rate').val();
						var comment_else			= $('#comment_else').val();

						

						var arr_dom_id = new Array();
						arr_dom_id.push('customer_name');
						arr_dom_id.push('product_type');
						arr_dom_id.push('quantity');
						arr_dom_id.push('vial');
						arr_dom_id.push('package_type');
						arr_dom_id.push('delivery_date');
						arr_dom_id.push('delivery_time_hour');
						arr_dom_id.push('delivery_time_minute');
						arr_dom_id.push('giveaway');
						arr_dom_id.push('receiver');
						arr_dom_id.push('dealer_person');
						arr_dom_id.push('dealer_company');
						arr_dom_id.push('price_rate');
						arr_dom_id.push('comment_else');

						
						var sta_validate = true;
						if (customer_name == ""){
							
							//$('#firstName').css('color', 'ui-state-error ui-corner-all');
							celtac.g_func.notice_div_error(arr_dom_id,"customer_name");
							sta_validate = false;
						} else if (product_type == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"product_type");
							sta_validate = false;
						} else if (quantity == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"quantity");
							sta_validate = false;
						} else if (vial == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"vial");
							sta_validate = false;
						} else if(total_cel == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"total_cel");
							sta_validate = false;
						} else if (package_type == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"package_type");
							sta_validate = false;

						} else if (delivery_date == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"delivery_date");
							sta_validate = false;
						
						} else if (delivery_time_hour == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"delivery_time_hour");
							sta_validate = false;
						
						} else if (delivery_time_minute == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"delivery_time_minute");
							sta_validate = false;
						
						} else if (giveaway == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"giveaway");
							sta_validate = false;
						
						} else if (receiver == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"receiver");
							sta_validate = false;
						
						} else if (dealer_person == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"dealer_person");
							sta_validate = false;
						
						} else if (dealer_company == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"dealer_company");
							sta_validate = false;
						
						} else if (price_rate == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"price_rate");
							sta_validate = false;
						
						} else if (comment_else == ""){
							celtac.g_func.notice_div_error(arr_dom_id,"comment_else");
							sta_validate = false;
						}
						
						if(sta_validate){
							$.ajax({
								url: "order.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q"              			: "add_order"
									,"customer_name"         	: customer_name	
									,"product_type"				: product_type		
									,"quantity"					: quantity			
									,"vial"						: vial				
									,"total_cel"				: total_cel				
									,"package_type"				: package_type			
									,"delivery_date"			: delivery_date			
									,"delivery_time_hour"		: delivery_time_hour		
									,"delivery_time_minute"		: delivery_time_minute
									,"giveaway"					: giveaway				
									,"receiver"					: receiver				
									,"dealer_person"			: dealer_person		
									,"dealer_company"			: dealer_company			
									,"price_rate"				: price_rate				
									,"comment_else"				: comment_else
									
								},
								type: "GET",
								success:function(response){
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									var obj_response = jQuery.parseJSON(response);
									//debugger;
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										//alert("complete.");
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
					case "edit_user_model":
						var id_user = obj;
						$('#modal_edit_user').modal('show');
						console.log(obj_all_user[id_user]);
						
						var email = obj_all_user[id_user].email;
						var pass = obj_all_user[id_user].pass;
						var company = obj_all_user[id_user].company;
						var phone = obj_all_user[id_user].phone_no;
						var firstName = obj_all_user[id_user].first_name;
						var lastName = obj_all_user[id_user].last_name;
						var address = obj_all_user[id_user].address;
						var is_staff = obj_all_user[id_user].is_staff;
						
						
						//--> auto add exits data.
						
						$('#modal_edit_user').find('#user_id_edit').val(id_user);
						$('#modal_edit_user').find('#email_edit').val(email);
						$('#modal_edit_user').find('#pass_edit').val(pass);
						$('#modal_edit_user').find('#company_edit').val(company);
						$('#modal_edit_user').find('#phone_edit').val(phone);
						$('#modal_edit_user').find('#firstName_edit').val(firstName);
						$('#modal_edit_user').find('#lastName_edit').val(lastName);
						$('#modal_edit_user').find('#address_edit').val(address);
						$('#modal_edit_user').find('#is_staff_edit').prop('checked', is_staff);
						//--> mission complete.

					break;
					case "update_user":
						var id_user 	= $('#modal_edit_user').find('#user_id_edit').val();
						var email		= $('#modal_edit_user').find('#email_edit').val();
						var pass		= $('#modal_edit_user').find('#pass_edit').val();
						var company		= $('#modal_edit_user').find('#company_edit').val();
						var phone		= $('#modal_edit_user').find('#phone_edit').val();
						var firstName	= $('#modal_edit_user').find('#firstName_edit').val();
						var lastName	= $('#modal_edit_user').find('#lastName_edit').val();
						var address		= $('#modal_edit_user').find('#address_edit').val();
						var is_staff	= $('#modal_edit_user').find('#is_staff_edit').is(":checked");
						

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
							$('#email_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if(company == ""){
							$('#company_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (phone == ""){
							$('#phone_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (firstName == ""){
							$('#firstName_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (lastName == ""){
							$('#lastName_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						} else if (address == ""){
							$('#address_vlid_edit').text("*needed value.").css('color', 'red');
							sta_validate = false;
						}
						
						if(sta_validate){
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: {
									"q"              : "update_user"
									,"id"		     : id_user 
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
									
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										
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
					case "delete_user":
						var id_user = obj;
						$('#modal_delete_confirm').modal('show');
						var cilck_ok = false;
						$('#modal_delete_confirm').find('#del_ok').click(function() {
							$.ajax({
								url: "usermanage.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q" : "delete_user"
									,"id" : id_user
								},
								type: "GET",
								success:function(response){
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									var obj_response = jQuery.parseJSON(response);
									
									//console.debug('respont : ',respont);
									if (obj_response.success) {
										console.log(obj_response);
										location.reload();
										//window.location = window.location.hostname+"/"+celtac.pjName+"/admin_page.php";
										//header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");
									} else {

									}
								},
								error:function(response){
									console.debug(response);
								}
							});
						});

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
				$("#sing_in").click(function() {
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
								window.location = window.location.origin+ "/" + celtac.pjName + "/index.php";
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
