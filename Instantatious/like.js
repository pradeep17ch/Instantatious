function like_add(image_id){
	$.post('like_add.php', {image_id:image_id},function(data){
		if(data == 'successliked'){
			like_get(image_id);
			$('#iflike_'+image_id).text("Unlike");
		}
		else if(data == 'successunliked'){
			like_get(image_id);
			$('#iflike_'+image_id).text("Like");
		}
		else{
			alert(data);
		}
	});
}
function like_get(image_id){
	$.post('like_get.php',{image_id:image_id},function(data){
		$('#article_'+image_id+'_likes').text(data);
	});
}