$(document).ready(function(){

	$('#myModal').modal('toggle');
	
	$('#myCollapsible').collapse({
			  toggle: false
			});
			
									
												
												
	$('#user_type').change(function()
		{
				var type=$('#user_type').val();
				//alert( type);
				$.ajax(
						{
						
							type : 'POST',
							data : 'type=' + type  ,
							url : "../files/userlogin.php" ,
							beforeSend: function(){
								//$(".loading").css('display','block');
								$("#myloginform").html('');
							},
							success : function( result )
							{
								
									//$(".loading").css('display','none');
									$("#myloginform").html(result);	
							}
						});
					
			});	
			
			
	
			

  
});