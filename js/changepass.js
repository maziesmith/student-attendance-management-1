logout = function()
{
    $.ajax({
        type:"POST",
        url:"./utils/logout.php",
        success:function(){
            window.location ="./";
        }
    })
}
$(document).ready(function(){
/* CHECK SESSION*/
	$.ajax({
		type: 'POST',
		url: './utils/checkSessionNull.php',
		success: function (data) {
			console.log(data);
			if(data == true)
			{
				$.confirm({
					closeIcon: false,
					title:'You are not Logged In.',
					columnClass: 'medium',
				    content: ' Please Login first to change password.',
				    theme:'supervan',
				    opacity:1,
				    buttons: {
				        Activate: {
				        	btnClass:'btn-green',
				            text: 'Login',
				            action: function () {
				                location.href = 'index.html';
				            }
				        }
				    }
				});
			}
			
			else
			{
				console.log("yes");	
			}        
	}});
	
	

	$(document.body).on('click', '#changePassBtn', function(){		
		var oldpass = $('#oldpass').val();
		var newpass1 = $('#newpass1').val();
		var newpass2 = $('#newpass2').val();
		// console.log(phone);
		// console.log(password);
		if(newpass1=='')
		{
			$.alert("New Password can't be empty.");
		}else if(newpass1 != newpass2)
		{
			$.alert("Password don't match."); 
		}else{
			$.ajax({
				type: 'POST',
				url: './utils/changepass.php',
				data: {oldpass:oldpass,newpass:newpass1},
				success: function (data) {	
                   				
                    $.confirm({
                        closeIcon: false,
                        title:'Successful',
                        columnClass: 'medium',
                        content: ' Sucessfully changed Password.',
                        theme:'supervan',
                        opacity:1,
                        buttons: {
                            Activate: {
                                btnClass:'btn-green',
                                text: 'Login',
								action: function () {
									logout();
                                    location.href = 'index.html';
                                }
                            }
                        }
                    });
				}         
			});
		}	
		
	})
})

