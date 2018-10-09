
//--> create celtac class.

	function celtac () {
		this.pjName = "celtac";
		this.g_func = {
			"func1" : function(){
				console.log("usesing func1");
			}
			,"pad" : function(num, size){
				var s = num+"";
				while (s.length < size) s = "0" + s;
				return s;
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
			,"notice_div_error" : function(status,str_current_dom_id){
				
				if(status){
					$('#'+str_current_dom_id+'').addClass('ui-state-error ui-corner-all');
				} else {
					$('#'+str_current_dom_id+'').removeClass('ui-state-error ui-corner-all');
				}
				
			}
			,"notice_div_error_BC" : function(arr_dom_id,str_current_dom_id){
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
						if(true){
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
						}


						break;	
					case "edit_user_model":
						if(true){
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
						}


					break;
					case "update_user":
						if(true){
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
						}
						

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
						if(true){
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
						}
						

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
			// ,"add_items_arr" : function(arr_set_data){
				//--items_product_arr = new Array(); //--> for empty arr set.
				// items_product_arr.push(arr_set_data);
			// }
			,"order" : function(q,obj){
				switch (q) {

					case "show_model_addorder": 
						if(true){
							$('#modal_add_order').modal('show');
							$('#delivery_date').datepicker();
							$('#delivery_date').datepicker("option", "dateFormat", "yy-mm-dd");
							
							$( "#text_area_resizable" ).resizable();
							
							
							items_product_arr = new Array(); //--> for empty items product arr set.
							$( "#div_items_order" ).empty(); //--> clear div cache.
							/*						
							$(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
								//this.value = this.value.replace(/[^0-9\.]/g,'');
								$(this).val($(this).val().replace(/[^0-9\.]/g,''));
								if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
									event.preventDefault();
								}
							});
							*/
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
							
							$('#product_type').on('change', function() {
								if(this.value == "cell"){
									var quantity = $('#quantity').val();
									var vial = $('#vial').val();
									var total_cel = parseInt(quantity*vial);
									
									
									$('#quantity').prop('disabled', false);
									$('#total_cel').prop('disabled', false);
									$('#package_type').prop('disabled', false);
									
									$('#total_cel').val(total_cel);
									$('#package_type').val('ID');
								} else {
									//$('#quantity').hide();
									//$('#vial').hide();
									//$("#quantity").prop('disabled', true);
									//$("#vial").prop('disabled', true);
									$('#total_cel').prop('disabled', true);
									$('#quantity').prop('disabled', true);
									$('#package_type').prop('disabled', true);
									
									$('#total_cel').val('');
									$('#quantity').val('');
									$('#package_type').val('');
								
								}
							});
							
							$('#quantity').on('keyup', function(){
								var check_data = $('#product_type').val();
								if(check_data == 'cell'){
									var quantity = $('#quantity').val();
									var vial = $('#vial').val();
									var total_cel = parseInt(quantity*vial);
									$('#total_cel').val(total_cel);
								} 

							});
							$('#vial').on('keyup', function(){
								var check_data = $('#product_type').val();
								if(check_data == 'cell'){
									var quantity = $('#quantity').val();
									var vial = $('#vial').val();
									var total_cel = parseInt(quantity*vial);
									$('#total_cel').val(total_cel);
								}

							});
							//-------------------------------------------------------
							//alert( new Date().getTimezoneOffset() );
							//Date.parse('2012-01-26T13:51:50.417-07:00');
							
							//date = new Date('2018-09-30 03:00:02');
							//date.getTime();
							//celtac.g_func.pad();

							//-----
							$('#delivery_time_hour').on('change', function() {
								var str_daliverly_date 			= $('#delivery_date').datepicker().val();
								var h 							= $('#delivery_time_hour').val();
								var m 							= $('#delivery_time_minute').val();
								
								var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
								if(!rs){
									$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
									$('#modal_notice_customer').modal('show');
									
								}
								
							});
							//---
							$('#delivery_time_minute').on('change', function() {
								var str_daliverly_date 			= $('#delivery_date').datepicker().val();
								var h 							= $('#delivery_time_hour').val();
								var m 							= $('#delivery_time_minute').val();
								
								var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
								if(!rs){
									$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
									$('#modal_notice_customer').modal('show');
									

								}
								
							});
						}
						
						break;
					case "check_avalible_time_order":
						//--> not use. 
						if(true){
							var validate_date_daliverly = function(){
								var date 				= new Date();
								var current_timestamp 	= date.getTime();
								
								var str_daliverly_date 			= $('#delivery_date').datepicker("option", "dateFormat", "yy-mm-dd" ).val();
								var h 							= $('#delivery_time_hour').val();
								var m 							= $('#delivery_time_minute').val();
								var str_date_time				= str_daliverly_date+' '+celtac.g_func.pad(h,2)+':'+celtac.g_func.pad(m,2)+':'+'00';
								//debugger;
								var obj_daliverly_date  			= new Date(str_date_time);
								var timestamp_daliverly_date 		= obj_daliverly_date.getTime();
								var minli_different_time_daliverly	= timestamp_daliverly_date - current_timestamp;
								var min_different_time_daliverly	= (minli_different_time_daliverly / 1000)/60; //change to minute.
								if (min_different_time_daliverly < 1440){
									console.log("not avalible order in your time specify");
									return false;
								} else {
									return true;
								}
							}
							var rs = validate_date_daliverly();
							return rs;
						}

						break;
					case "add_order":
						if(true){
							var items_json 				= JSON.stringify(items_product_arr);
							var order_code				= $('#order_code').val();
							var customer_name			= $('#customer_name').val();
							// var product_type			= $('#product_type').val();
							// var quantity				= $('#quantity').val();
							// var vial					= $('#vial').val();
							// var total_cel				= $('#total_cel').val();
							// var package_type			= $('#package_type').val();
							var delivery_date			= $('#delivery_date').datepicker("option", "dateFormat", "dd-mm-yy" ).val();
							var delivery_time_hour		= $('#delivery_time_hour').val();
							var delivery_time_minute	= $('#delivery_time_minute').val();
							//var giveaway				= $('#giveaway').val();
							var sender					= $('#sender').val();
							var receiver				= $('#receiver').val();
							var dealer_person			= $('#dealer_person').val();
							var dealer_company			= $('#dealer_company').val();
							//var price_rate				= $('#price_rate').val();
							var comment_else			= $('#comment_else').val();

							
						
							var arr_dom_id = new Array();
							arr_dom_id.push('customer_name');
							// arr_dom_id.push('product_type');
							// arr_dom_id.push('quantity');
							// arr_dom_id.push('vial');
							// arr_dom_id.push('package_type');
							arr_dom_id.push('delivery_date');
							arr_dom_id.push('delivery_time_hour');
							arr_dom_id.push('delivery_time_minute');
							//arr_dom_id.push('giveaway');
							arr_dom_id.push('sender');
							arr_dom_id.push('receiver');
							arr_dom_id.push('dealer_person');
							arr_dom_id.push('dealer_company');
							//arr_dom_id.push('price_rate');
							arr_dom_id.push('comment_else');
							

							
							var sta_validate = true;
							
							// if (price_rate == ""){
								// celtac.g_func.notice_div_error(true,"price_rate");
								// sta_validate = false;
							
							// }else {
								// celtac.g_func.notice_div_error(false,"price_rate");
							// }
							//--
							if (dealer_company == ""){
								celtac.g_func.notice_div_error(true,"dealer_company");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"dealer_company");
							}
							//--
							if (dealer_person == ""){
								celtac.g_func.notice_div_error(true,"dealer_person");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"dealer_person");
							}
							//--
							if (receiver == ""){
								celtac.g_func.notice_div_error(true,"receiver");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"receiver");
							}
							//--
							if (sender == ""){
								celtac.g_func.notice_div_error(true,"sender");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"sender");
							}
							//--
							// if (giveaway == ""){
								// celtac.g_func.notice_div_error(true,"giveaway");
								// sta_validate = false;
							
							// }else {
								// celtac.g_func.notice_div_error(false,"giveaway");
							// }
							//--
							if (delivery_time_minute == ""){
								celtac.g_func.notice_div_error(true,"delivery_time_minute");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_time_minute");
							}
							//--
							if (delivery_time_hour == ""){
								celtac.g_func.notice_div_error(true,"delivery_time_hour");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_time_hour");
							} 
							//--
							if (delivery_date == ""){
								celtac.g_func.notice_div_error(true,"delivery_date");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_date");
							} 
							//--
				/* 			if (package_type == ""){
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(true,"package_type");
									sta_validate = false;
								}
							}else {
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(false,"package_type");
								}
							} 
							//--
							if(total_cel == ""){
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(true,"total_cel");
									sta_validate = false;
								}
							} else {
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(false,"total_cel");
								}
							} 
							//--
							if (vial == ""){
								celtac.g_func.notice_div_error(true,"vial");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"vial");
							}
							//--
							if (quantity == ""){
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(true,"quantity");
									sta_validate = false;
								}
							} else {
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(false,"quantity");
								}
							} 
							//--
							if (product_type == ""){
								celtac.g_func.notice_div_error(true,"product_type");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"product_type");
							} */
							//--
							if (customer_name == ""){
								celtac.g_func.notice_div_error(true,"customer_name");
								sta_validate = false;
							} else {
								celtac.g_func.notice_div_error(false,"customer_name");
							}

							/*
							if (comment_else == ""){
								celtac.g_func.notice_div_error(arr_dom_id,"comment_else");
								sta_validate = false;
							}*/
							
							var str_daliverly_date 			= $('#delivery_date').datepicker("option", "dateFormat", "yy-mm-dd" ).val();
							var h 							= $('#delivery_time_hour').val();
							var m 							= $('#delivery_time_minute').val();
							
							var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
							
							if(!rs){
								$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
								$('#modal_notice_customer').modal('show');
								
								sta_validate = false;
							}
							
							//----------------------
							if(items_product_arr.length <= 0){
								celtac.g_func.notice_div_error(true,"div_items_order");
								sta_validate = false;
							}
								
							if(sta_validate){
								$('#bt_save_add_order').prop('disabled', true);
								$('#loading_modal').modal('show');
								$.ajax({
									url: "order.php",
									dataType: 'text', // Notice! JSONP <-- P (lowercase)
									method : 'POST',
									data: { 
										"q"              			: "add_order"
										,"order_code"         		: order_code	
										,"customer_name"         	: customer_name	
										,"items_json"				: items_json
										//,"product_type"				: product_type		
										//,"quantity"					: quantity			
										//,"vial"						: vial				
										//,"total_cel"				: total_cel				
										//,"package_type"				: package_type			
										,"delivery_date"			: delivery_date			
										,"delivery_time_hour"		: delivery_time_hour		
										,"delivery_time_minute"		: delivery_time_minute
										//,"giveaway"					: giveaway
										,"sender"					: sender									
										,"receiver"					: receiver				
										,"dealer_person"			: dealer_person		
										,"dealer_company"			: dealer_company			
										//,"price_rate"				: price_rate				
										,"comment_else"				: comment_else
										
									},
									type: "GET",
									success:function(response){
										$('#loading_modal').modal('hide');
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
										$('#loading_modal').modal('hide');
										console.debug(response);
									}
								});
								
							}//end if false.
						}
						

						break;	
					case "edit_order":
						if(true){ 
							
							var order_id_edit			= $('#order_id_edit').val();
							var order_code				= $('#order_code_edit').val();
							var customer_name			= $('#customer_name_edit').val();
							var product_type			= $('#product_type_edit').val();
							var quantity				= $('#quantity_edit').val();
							var vial					= $('#vial_edit').val();
							var total_cel				= $('#total_cel_edit').val();
							var package_type			= $('#package_type_edit').val();
							var delivery_date			= $('#delivery_date_edit').datepicker("option", "dateFormat", "dd-mm-yy" ).val();
							var delivery_time_hour		= $('#delivery_time_hour_edit').val();
							var delivery_time_minute	= $('#delivery_time_minute_edit').val();
							var giveaway				= $('#giveaway_edit').val();
							var sender					= $('#sender_edit').val();
							var receiver				= $('#receiver_edit').val();
							var dealer_person			= $('#dealer_person_edit').val();
							var dealer_company			= $('#dealer_company_edit').val();
							var price_rate				= $('#price_rate_edit').val();
							var comment_else			= $('#comment_else_edit').val();

							console.log('order_id_edit  :  '+order_id_edit);
							console.log('order_code  :  '+order_code);
							console.log('customer_name  :  '+customer_name);
							console.log('product_type  :  '+product_type);
							console.log('quantity  :  '+quantity);
							console.log('vial  :  '+vial);
							console.log('total_cel  :  '+total_cel);
							console.log('package_type  :  '+package_type);
							console.log('delivery_date  :  '+delivery_date);
							console.log('delivery_time_hour  :  '+delivery_time_hour);
							console.log('delivery_time_minute  :  '+delivery_time_minute);
							console.log('giveaway  :  '+giveaway);
							console.log('sender  :  '+sender);
							console.log('receiver  :  '+receiver);
							console.log('dealer_person  :  '+dealer_person);
							console.log('dealer_company  :  '+dealer_company);
							console.log('price_rate  :  '+price_rate);
							console.log('comment_else  :  '+comment_else);
							
							//debugger;
							var arr_dom_id = new Array();
							arr_dom_id.push('customer_name_edit');
							arr_dom_id.push('product_type_edit');
							arr_dom_id.push('quantity_edit');
							arr_dom_id.push('vial_edit');
							arr_dom_id.push('package_type_edit');
							arr_dom_id.push('delivery_date_edit');
							arr_dom_id.push('delivery_time_hour_edit');
							arr_dom_id.push('delivery_time_minute_edit');
							arr_dom_id.push('giveaway_edit');
							arr_dom_id.push('sender_edit');
							arr_dom_id.push('receiver_edit');
							arr_dom_id.push('dealer_person_edit');
							arr_dom_id.push('dealer_company_edit');
							arr_dom_id.push('price_rate_edit');
							arr_dom_id.push('comment_else_edit');
							

							
							var sta_validate = true;
							if (price_rate == ""){
								celtac.g_func.notice_div_error(true,"price_rate_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"price_rate_edit");
							}
							//--
							if (dealer_company == ""){
								celtac.g_func.notice_div_error(true,"dealer_company_edit");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"dealer_company_edit");
							}
							//--
							if (dealer_person == ""){
								celtac.g_func.notice_div_error(true,"dealer_person_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"dealer_person_edit");
							}
							//--
							if (receiver == ""){
								celtac.g_func.notice_div_error(true,"receiver_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"receiver_edit");
							}
							//--
							if (sender == ""){
								celtac.g_func.notice_div_error(true,"sender_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"sender_edit");
							}
							//--
							if (giveaway == ""){
								celtac.g_func.notice_div_error(true,"giveaway_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"giveaway_edit");
							}
							//--
							if (delivery_time_minute == ""){
								celtac.g_func.notice_div_error(true,"delivery_time_minute_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_time_minute_edit");
							}
							//--
							if (delivery_time_hour == ""){
								celtac.g_func.notice_div_error(true,"delivery_time_hour_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_time_hour_edit");
							} 
							//--
							if (delivery_date == ""){
								celtac.g_func.notice_div_error(true,"delivery_date_edit");
								sta_validate = false;
							
							}else {
								celtac.g_func.notice_div_error(false,"delivery_date_edit");
							} 
							//--
							if (package_type == ""){
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(true,"package_type_edit");
									sta_validate = false;
								}
							}else {
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(false,"package_type_edit");
								}
							} 
							//--
							//debugger;
							if(total_cel == ""){
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(true,"total_cel_edit");
									sta_validate = false;
								}
							} else {
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(false,"total_cel_edit");
								}
							} 
							//--
							if (vial == ""){
								celtac.g_func.notice_div_error(true,"vial_edit");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"vial_edit");
							}
							//--
							if (quantity == ""){
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(true,"quantity_edit");
									sta_validate = false;
								}
							} else {
								if($('#product_type_edit').val() == "cell"){
									celtac.g_func.notice_div_error(false,"quantity_edit");
								}
							} 
							//--
							if (product_type == ""){
								celtac.g_func.notice_div_error(true,"product_type_edit");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"product_type_edit");
							}
							//--
							if (customer_name == ""){
								celtac.g_func.notice_div_error(true,"customer_name_edit");
								sta_validate = false;
							} else {
								celtac.g_func.notice_div_error(false,"customer_name_edit");
							}

							/*
							if (comment_else == ""){
								celtac.g_func.notice_div_error(arr_dom_id,"comment_else");
								sta_validate = false;
							}*/
							
							var str_daliverly_date 			= $('#delivery_date_edit').datepicker("option", "dateFormat", "yy-mm-dd" ).val();
							var h 							= $('#delivery_time_hour_edit').val();
							var m 							= $('#delivery_time_minute_edit').val();
							
							var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
							
							if(!rs){
								$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
								$('#modal_notice_customer').modal('show');
								
								sta_validate = false;
							}
								
							if(sta_validate){
								$('#bt_save_update_order').prop('disabled', true);
								$('#loading_modal').modal('show');
								$.ajax({
									url: "order.php",
									dataType: 'text', // Notice! JSONP <-- P (lowercase)
									method : 'POST',
									data: { 
										"q"              					: "edit_order"
										,"order_id_edit"					: order_id_edit
										,"order_code_edit"         			: order_code	
										,"customer_name_edit"         		: customer_name	
										,"product_type_edit"				: product_type		
										,"quantity_edit"					: quantity			
										,"vial_edit"						: vial				
										,"total_cel_edit"					: total_cel				
										,"package_type_edit"				: package_type			
										,"delivery_date_edit"				: delivery_date			
										,"delivery_time_hour_edit"			: delivery_time_hour		
										,"delivery_time_minute_edit"		: delivery_time_minute
										,"giveaway_edit"					: giveaway
										,"sender_edit"						: sender									
										,"receiver_edit"					: receiver				
										,"dealer_person_edit"				: dealer_person		
										,"dealer_company_edit"				: dealer_company			
										,"price_rate_edit"					: price_rate				
										,"comment_else_edit"				: comment_else
										
									},
									type: "GET",
									success:function(response){
										$('#loading_modal').modal('hide');
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
										$('#loading_modal').modal('hide');
										console.debug(response);
									}
								});
								
							}else{
								alert('test alert');
							}
						}


					break;
					case "update_order_bc":
						if(true){
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
						}
						break;										
					case "delete_order":
						if(true){
							var id = obj;
							$('#modal_delete_confirm').modal('show');
							var cilck_ok = false;
							$('#modal_delete_confirm').find('#del_ok').click(function() {
								$('#loading_modal').modal('show');
								$.ajax({
									url: "order.php",
									dataType: 'text', // Notice! JSONP <-- P (lowercase)
									method : 'POST',
									data: { 
										"q" : "delete_order"
										,"id" : id
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
										$('#loading_modal').modal('hide');
									},
									error:function(response){
										console.debug(response);
									}
								});
							});

						}
						
						break;					
					case "view_order":
						if(true){
							var id = obj;
							var data = obj_all_order[id]; //obj_all_order from customer_page.php
							//--> show modal view.
							$('#modal_view_order').modal('show');
							
							//--> add data from js_data.
							$('#order_code_view').val(data.order_code);
							$('#customer_name_view').val(data.customer_name);
							$('#product_type_view').val(data.product_type);
							$('#quantity_view').val(data.quantity);
							$('#vial_view').val(data.vial);
							$('#total_cel_view').val(data.total_cel);
							$('#package_type_view').val(data.package_type);
							$('#delivery_date_view').val(data.delivery_date_time);
							$('#giveaway_view').val(data.giveaway);
							$('#sender_view').val(data.sender);
							$('#receiver_view').val(data.receiver);
							$('#dealer_person_view').val(data.dealer_person);
							$('#dealer_company_view').val(data.dealer_company);
							$('#price_rate_view').val(data.price_rate);
							$('#comment_else_view').val(data.comment_else);
							$('#order_id_view').val(data.id);

							//--> disable view input.
							$('#order_code_view').prop('disabled', true);
							$('#customer_name_view').prop('disabled', true);
							$('#product_type_view').prop('disabled', true);
							$('#quantity_view').prop('disabled', true);
							$('#vial_view').prop('disabled', true);
							$('#total_cel_view').prop('disabled', true);
							$('#package_type_view').prop('disabled', true);
							$('#delivery_date_view').prop('disabled', true);
							$('#giveaway_view').prop('disabled', true);
							$('#sender_view').prop('disabled', true);
							$('#receiver_view').prop('disabled', true);
							$('#dealer_person_view').prop('disabled', true);
							$('#dealer_company_view').prop('disabled', true);
							$('#price_rate_view').prop('disabled', true);
							$('#comment_else_view').prop('disabled', true);
							
						}

						
						break;					
					case "edit_order_model": 
						if(true){
							var id = $('#order_id_view').val();
							//debugger;
							$('#modal_add_order_edit').modal('show');
							$('#delivery_date_edit').datepicker();
							$('#delivery_date_edit').datepicker("option", "dateFormat", "yy-mm-dd");
							//debugger;
							//--> replace exist data to form.
							var data 				= obj_all_order[id]; ////obj_all_order from customer_page.php
							var arr_full_date_time 	= data.delivery_date_time.split(" ");
							var arr_full_only_time	= arr_full_date_time[1].split(":");
							var full_date			= arr_full_date_time[0];
							
							//--> init_disable for edit.
							if(data.product_type != "cell"){
								$('#quantity_edit').prop('disabled', true);
								$('#total_cel_edit').prop('disabled', true);
								$('#package_type_edit').prop('disabled', true);
							}
							//debugger;
							//--> add data from js_data.
							$('#order_code_edit').val(data.order_code);
							$('#customer_name_edit').val(data.customer_name);
							$('#product_type_edit').val(data.product_type);
							$('#quantity_edit').val(data.quantity);
							$('#vial_edit').val(data.vial);
							$('#total_cel_edit').val(data.total_cel);
							$('#package_type_edit').val(data.package_type);
							
							$('#delivery_date_edit').val(full_date);
							$('#delivery_time_hour_edit').val(parseInt(arr_full_only_time[0]));
							$('#delivery_time_minute_edit').val(parseInt(arr_full_only_time[1]));
							
							$('#giveaway_edit').val(data.giveaway);
							$('#sender_edit').val(data.sender);
							$('#receiver_edit').val(data.receiver);
							$('#dealer_person_edit').val(data.dealer_person);
							$('#dealer_company_edit').val(data.dealer_company);
							$('#price_rate_edit').val(data.price_rate);
							$('#comment_else_edit').val(data.comment_else);
							$('#order_id_edit').val(data.id);
							//---------------------------------------------

							/*						
							$(".allownumericwithdecimal").on("keypress keyup blur",function (event) {
								//this.value = this.value.replace(/[^0-9\.]/g,'');
								$(this).val($(this).val().replace(/[^0-9\.]/g,''));
								if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
									event.preventDefault();
								}
							});
							*/
							$("#quantity_edit").on("keypress keyup blur",function (event) {   
								$(this).val($(this).val().replace(/[^\d].+/, ""));
								if ((event.which < 48 || event.which > 57)) {
									event.preventDefault();
								}
							});
							$("#vial_edit").on("keypress keyup blur",function (event) {   
								$(this).val($(this).val().replace(/[^\d].+/, ""));
								if ((event.which < 48 || event.which > 57)) {
									event.preventDefault();
								}
							});
							
							$('#product_type_edit').on('change', function() {
								if(this.value == "cell"){
									var quantity = $('#quantity_edit').val();
									var vial = $('#vial_edit').val();
									var total_cel = parseInt(quantity*vial);
									
									
									$('#quantity_edit').prop('disabled', false);
									$('#total_cel_edit').prop('disabled', false);
									$('#package_type_edit').prop('disabled', false);
									
									$('#total_cel_edit').val(total_cel);
									$('#package_type_edit').val('ID');
								} else {
									//$('#quantity').hide();
									//$('#vial').hide();
									//$("#quantity").prop('disabled', true);
									//$("#vial").prop('disabled', true);
									$('#total_cel_edit').prop('disabled', true);
									$('#quantity_edit').prop('disabled', true);
									$('#package_type_edit').prop('disabled', true);
									
									$('#total_cel_edit').val('');
									$('#quantity_edit').val('');
									$('#package_type_edit').val('');
								
								}
							});
							
							//--> cal auto.
							$('#quantity_edit').on('keyup', function(){
								var check_data = $('#product_type_edit').val();
								if(check_data == 'cell'){
									var quantity = $('#quantity_edit').val();
									var vial = $('#vial_edit').val();
									var total_cel = parseInt(quantity*vial);
									$('#total_cel_edit').val(total_cel);
								} 

							});
							$('#vial_edit').on('keyup', function(){
								var check_data = $('#product_type_edit').val();
								if(check_data == 'cell'){
									var quantity = $('#quantity_edit').val();
									var vial = $('#vial_edit').val();
									var total_cel = parseInt(quantity*vial);
									$('#total_cel_edit').val(total_cel);
								}

							});
							//-------------------------------------------------------
							//alert( new Date().getTimezoneOffset() );
							//Date.parse('2012-01-26T13:51:50.417-07:00');
							
							//date = new Date('2018-09-30 03:00:02');
							//date.getTime();
							//celtac.g_func.pad();

							//-----> check delay date time.1
							$('#delivery_time_hour_edit').on('change', function() {
								var str_daliverly_date 			= $('#delivery_date_edit').datepicker().val();
								var h 							= $('#delivery_time_hour_edit').val();
								var m 							= $('#delivery_time_minute_edit').val();
								
								var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
								
								if(!rs){
									$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
									$('#modal_notice_customer').modal('show');
									
								}
								
							});
							//-----> check delay date time.2
							$('#delivery_time_minute_edit').on('change', function() {
								var str_daliverly_date 			= $('#delivery_date_edit').datepicker().val();
								var h 							= $('#delivery_time_hour_edit').val();
								var m 							= $('#delivery_time_minute_edit').val();
								
								var rs = celtac.g_func.check_avalible_time_order(str_daliverly_date, h, m);
								
								if(!rs){
									$('#modal_notice_customer').find('#msg_modal_notice_customer').text('your order time less than 30 minute.');
									$('#modal_notice_customer').modal('show');
									

								}
								
							});
						}
						break;					
					case "send_mail":
						if(true){
							$('#loading_modal').modal('show');
							
							$.ajax({
								url: "sendOrder.php",
								dataType: 'text', // Notice! JSONP <-- P (lowercase)
								method : 'POST',
								data: { 
									"q"              					: "xxx"
								},
								type: "GET",
								success:function(response){
									$('#loading_modal').modal('hide');
									//console.debug('response : ',response);
									//debugger;
									//console.log(response);
									//var obj_response = jQuery.parseJSON(response);
									//debugger;
									//console.debug('respont : ',obj_response);
									
									if (true) {
										
										//--> notic confirm sended email.
										$.ajax({
											url: "sendOrderConfirmUser.php",
											dataType: 'text', // Notice! JSONP <-- P (lowercase)
											method : 'POST',
											data: { 
												"q"              					: "xxx"
											},
											type: "GET",
											success:function(response){
												$('#loading_modal').modal('hide');
												//location.reload();
											},
											error:function(response){
												$('#loading_modal').modal('hide');
												console.debug(response);
											}
										});
									} else {
										console.log('error sum email');
									}
								},
								error:function(response){
									$('#loading_modal').modal('hide');
									console.debug(response);
								}
							});
							
						}
					break;
					case "show_model_add_items_product":
					if(true){
						$('#bt_save_add_items_product').prop('disabled', false);
						$('#modal_add_items_product').modal('show');
					}
					break;
					case "add_order_temp": //1.
						if(true){
							$('#bt_save_add_items_product').prop('disabled', true);
							//debugger;
							//$('#loading_modal').modal('show'); //--> not show  at here i don't know why?
							var product_type			= $('#product_type').val();
							var quantity				= $('#quantity').val();
							var vial					= $('#vial').val();
							var total_cel				= $('#total_cel').val();
							var package_type			= $('#package_type').val();
							var giveaway				= $('#giveaway').val();
							var price_rate				= $('#price_rate').val();

							
						
							var arr_dom_id = new Array();
							arr_dom_id.push('product_type');
							arr_dom_id.push('quantity');
							arr_dom_id.push('vial');
							arr_dom_id.push('package_type');
							arr_dom_id.push('giveaway');
							arr_dom_id.push('price_rate');
	
							

							
							var sta_validate = true;

							// if (giveaway == ""){
								// celtac.g_func.notice_div_error(true,"giveaway");
								// sta_validate = false;
							
							// }else {
								// celtac.g_func.notice_div_error(false,"giveaway");
							// }

							//--
							if (package_type == ""){
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(true,"package_type");
									sta_validate = false;
								}
							}else {
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(false,"package_type");
								}
							} 
							//--
							if (vial == ""){
								celtac.g_func.notice_div_error(true,"vial");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"vial");
							}
							//--
							if (quantity == ""){
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(true,"quantity");
									sta_validate = false;
								}
							} else {
								if($('#product_type').val() == "cell"){
									celtac.g_func.notice_div_error(false,"quantity");
								}
							} 
							//--
							if (product_type == ""){
								celtac.g_func.notice_div_error(true,"product_type");
								sta_validate = false;
							}else {
								celtac.g_func.notice_div_error(false,"product_type");
							}

							//---------------------------------------------------------
							if(sta_validate){
								var obj_set_data = {};
								obj_set_data.product_type 	= product_type;
								obj_set_data.quantity 		= quantity;
								obj_set_data.vial			= vial;
								obj_set_data.total_cel 		= total_cel;

								if(package_type == null){
									package_type = "";
								}
								obj_set_data.package_type	= package_type;
								obj_set_data.giveaway		= giveaway;
								obj_set_data.price_rate 	= price_rate;

								//celtac.g_func.add_items_arr(obj_set_data);
								celtac.g_func.order("add_items_arr",obj_set_data);
								celtac.g_func.order('update_items_product');
								$('#modal_add_items_product').modal('hide');
							} else {
								//alert('data not complete.');
								$('#loading_modal').modal('hide');
								$('#bt_save_add_items_product').prop('disabled', false);
							}
							//----------------------------------------------------------
							
						}
					break;
					
					case "update_items_product":
						if(true){
							
							$('#div_items_order').empty();
							
							//loop items_product_arr
							var i;
							for (i = 0; i < items_product_arr.length; i++) { 
								var item = items_product_arr[i];
								if(typeof(item) != 'undefined'){
									//debugger;
									var str_items = "";
									
									str_items += "			<div id=\"xx\" class=\"row\">";
									str_items += "				<div class=\"col-10 text-truncate font-weight-light\">";

									str_items += 								item.product_type + " | ";
									str_items += 								item.vial + " vial | ";
									if(item.product_type == "cell"){
										str_items += 								item.quantity + " m | ";
										//--str_items += 								item.total_cel + " m | ";
										str_items += 								item.package_type + " | ";
									}
									if(item.giveaway == ""){
										str_items += 								"-";
									} else {
										str_items += 								item.giveaway + " | ";
									}
									str_items += 								item.price_rate + " ";
									str_items += "				</div>";
									str_items += "				<div class=\"col-2\">";
									str_items += "					<a href=\"#\" onclick=\"celtac.g_func.order('delete_items_product',"+i+")\">";
									str_items += "						<span style=\"margin-top:5px\" class=\"ui-icon ui-icon-trash\"></span>";
									str_items += "					</a>";
									str_items += "				</div>";
									str_items += "			</div>";
									
									$( "#div_items_order" ).append(str_items);
								}

							}
							//debugger;
							//$('#loading_modal').modal('hide');
						}
					break;
					
					case "add_items_arr":
						var arr_set_data = obj;
						if(true){
							items_product_arr.push(arr_set_data);
						}
					break;
					case "delete_items_product":
						var id = obj;
						if(true){
							//$('#loading_modal').modal('show');
							delete items_product_arr[id];
							celtac.g_func.order('update_items_product');
						}
					break;
				}
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
			,check_avalible_time_order : function(str_daliverly_date, h, m){
				if(true){
					var validate_date_daliverly = function(){
						var date 				= new Date();
						var current_timestamp 	= date.getTime();
						
						//var str_daliverly_date 			= $('#delivery_date').datepicker("option", "dateFormat", "yy-mm-dd" ).val();
						//var h 							= $('#delivery_time_hour').val();
						//var m 							= $('#delivery_time_minute').val();
						var str_date_time					= str_daliverly_date+' '+celtac.g_func.pad(h,2)+':'+celtac.g_func.pad(m,2)+':'+'00';
						//debugger;
						var obj_daliverly_date  			= new Date(str_date_time);
						var timestamp_daliverly_date 		= obj_daliverly_date.getTime();
						var minli_different_time_daliverly	= timestamp_daliverly_date - current_timestamp;
						var min_different_time_daliverly	= (minli_different_time_daliverly / 1000)/60; //change to minute.
						if (min_different_time_daliverly < 30){
							console.log("not avalible order in your time specify");
							return false;
						} else {
							return true;
						}
					}
					var rs = validate_date_daliverly();
					return rs;
				}
			}
		};
		this.g_var = {
			"var1" : "var1"
			,"var2" : "var2"
			,"var3" : "var3"
		};
	}
//debugger;
