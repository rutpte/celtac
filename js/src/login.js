celtac.prototype.login = function() {
   celtac = this;
   celtac.login = {};
   celtac.login.authen = function(user, password){
		$.ajax({
			method: "POST",
			url: "some.php",
			data: { "user": user, "password": password }
		})
		.done(function( msg ) {
			alert( "Data Saved: " + msg );
		});
		
   }
};