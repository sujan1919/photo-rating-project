// JavaScript Document
jQuery(function ($) {
	
	"use strict";
	
	var base_url = location.protocol + '//' + location.host + location.pathname ;
	base_url = base_url.substring(0, base_url.lastIndexOf("/") + 1);
	base_url = base_url+'admin/';
	
	$(document).on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	$(document).on('click', '.openRating', function(){
		var picId = $(this).attr("id"); 
		var btn_action_view = 'fetch_data' ;
		$('.rating_form')[0].reset();
		$.ajax({
			url: base_url+"action_fetch_rating.php",
			method:"POST",
			data:{picId:picId, btn_action_view:btn_action_view},
			dataType:"json",
			success:function(data)
			{
				$('#ratingModal').modal('show');
				$('#imageId').val(data.imageId);
				$('#people').val(data.people);
				$('#rate').val(data.rate);
			}
		});
	});
	$(document).on('submit','.rating_form', function(event){
		event.preventDefault();
		var that = $(this),
        url = that.attr('action'),
        type = that.attr('method'),
        data = {};

		that.find('[name]').each(function(index, value){
			var that = $(this),
			name = that.attr('name'),
			value = that.val();
	
			data[name] = value;
		});
		data = $(this).serialize() ;
		$.ajax({
			url: base_url+"submit_rating.php",
			method:"POST",
			data:data,
			dataType:"json",
			success:function(data)
			{	
				$('#ratingModal').modal('hide');
				$('.star'+data.imageId).hide() ;
				$('.newStar'+data.imageId).html(data.rating +'<img src="' + base_url + 'images/fillStar.png" class = "img-fluid img-star mt-n1" /> (' + data.people + ')') ;
				
				$('#action_sb').attr('disabled',false);
			}
		});
		return false;
	});
	
	$(document).on('click','.show_more',function(){
        var ID = $(this).attr('id');
        $('.show_more').hide();
        $('#loader-icon').show();
        $.ajax({
            type:'POST',
            url:base_url+'getPics.php',
            data:'id='+ID,
            success:function(html){
                $('#show_more_new'+ID).remove();
                $('.announce-res').append(html);
            }
        });
    });
	
});