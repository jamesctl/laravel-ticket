jQuery(document).ready(function(){
    jQuery('.authentication-login-button').click(function(){
    	jQuery('.form-authentication').validate({
  			submitHandler: function(form) {
					  			
      $('.authentication-login-button').login({theId:'.form-authentication'});
  }
})
    })
  })