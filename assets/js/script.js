$(function(){

	var link = $('#link').attr('href');  

	$('#nomeEditar').val();
    $('#emailEditar').val();


	$.ajax({
		type:'POST',
		url: link,		
		success:function(html){
			$('.modal-body').html(html);
		}
	});


});