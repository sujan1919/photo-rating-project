// JavaScript Document
jQuery(function ($) {
	
	"use strict";
	
	var base_url = location.protocol + '//' + location.host + location.pathname ;
	base_url = base_url.substring(0, base_url.lastIndexOf("/") + 1);
	
	var managePicsTable = $('#managePicsTable').DataTable({
		'ajax': base_url+'fetchPics.php',
		'order': []
	});
	var manageactivePicsTable = $('#manageactivePicsTable').DataTable({
		'ajax': base_url+'fetchactivePics.php',
		'order': []
	});
	var managedeactivePicsTable = $('#managedeactivePicsTable').DataTable({
		'ajax': base_url+'fetchdeactivePics.php',
		'order': []
	});
	var manageIpTable = $('#manageIpTable').DataTable({
		'ajax': base_url+'fetchip.php',
		'order': []
	});
  	$(document).on("click","#hide", function() {
		$(".errorMessage").hide();
	});
	
	$(document).on('click', '.editRating', function(){
		var pId = $(this).attr("id"); 
		var btn_action_view = 'fetch_image' ;
		var rating = $(this).data("status");
		$('.modal-title').html("<i class='fa fa-image'></i> Edit Rating");
		$('#editratingModal').modal('show');
		$('#rating').val(rating);
		$('.oldRating').html('<small>Old Rating : '+rating+'&ensp;</small>');
		$('#pId').val(pId);
	});
	$(document).on('submit','.editrating_form', function(event){
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
			url: base_url+"submit_editrating.php",
			method:"POST",
			data:data,
			success:function(data)
			{	
				$('.editrating_form')[0].reset();
				$('#editratingModal').modal('hide');
				$('#action_sb').attr('disabled',false);
				$('.remove-messages').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				manageIpTable.ajax.reload();
			}
		});
		return false;
	});
	$(document).on('click', '.editCaption', function(){
		var picId = $(this).attr("id"); 
		var btn_action_view = 'fetch_caption' ;
		$.ajax({
			url: base_url+"action_view_image.php",
			method:"POST",
			data:{picId:picId, btn_action_view:btn_action_view},
			success:function(data)
			{
				data = JSON.parse(data);
				$('#captionImage')[0].reset();
				$('.modal-title').html("<i class='fa fa-pencil-alt'></i> Edit Caption");
				$('#editcaptionModal').modal('show');
				$('#imgId').val(data.picId);
				$('#editcaption').val(data.caption) ;
				
			}
		});
	});
	$(document).on('submit','#captionImage', function(event){
		event.preventDefault();
		$('#action_cap').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_edit_caption.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#captionImage')[0].reset();
				$('#editcaptionModal').modal('hide');
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
				$('#action_cap').attr('disabled',false);
				managePicsTable.ajax.reload();
				manageactivePicsTable.ajax.reload();
				managedeactivePicsTable.ajax.reload();
			}
		})
	});
	$(document).on('click', '.viewPic', function(){
		var picId = $(this).attr("id"); 
		var btn_action_view = 'fetch_image' ;
		$.ajax({
			url: base_url+"action_view_image.php",
			method:"POST",
			data:{picId:picId, btn_action_view:btn_action_view},
			success:function(data)
			{
				$('.modal-title').html("<i class='fa fa-image'></i> Click On Photo to View");
				$('#viewpicModal').modal('show');
				$('.myImage').html(data);
			}
		});
	});
	$(document).on('click', '.editPic', function(){
		$('#uploadReplaceImage')[0].reset();
		var picId = $(this).attr("id"); 
		var btn_action_view = 'fetch_replace_image' ;
		$.ajax({
			url: base_url+"action_view_image.php",
			method:"POST",
			data:{picId:picId, btn_action_view:btn_action_view},
			success:function(data)
			{
				$('#pid').val(picId) ;
				$('#uploadReplaceFile').val('') ;
				$('.modal-title').html("<i class='fa fa-image'></i> Replace Photo or Caption");
				$('#replacepicModal').modal('show');
				$('.viewReplaceImage').html(data);
			}
		});
	});
	$(document).on('submit','#uploadReplaceImage', function(event){
		event.preventDefault();
		$('#action_pic_replace').attr('disabled','disabled');
		var allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		var FileSize = (document.getElementById("uploadReplaceFile").files[0].size/1024)/1024; 
        var file = $('#uploadReplaceFile').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		if($('#uploadReplaceFile').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 10) {
					event.preventDefault();
					$('#targetLayer').hide();
					$(this).ajaxSubmit({
						target: '#targetLayer',
						beforeSubmit:function(){
							$('.progress').show();
							$('.progress-bar').width('50%');
						},
						uploadProgress: function(event, position, total, percentageComplete)
						{
							$('.progress-bar').animate({
								width: percentageComplete + '%'
							}, {
								duration: 500
							});
						},
						success:function(){
							$('#replacepicModal').modal('hide');
							$('.remove-messages').fadeIn().html('<div class="alert alert-success">Photo Edited Successfully.</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
							$('#uploadReplaceFile').val('');
							$('.progress').hide();
							$('#action_pic_replace').attr('disabled',false);
							managePicsTable.ajax.reload();
							manageactivePicsTable.ajax.reload();
							managedeactivePicsTable.ajax.reload();
						},
						resetForm: true
					});
				} else {
					alert("Image must not be greater than 10 MB.") ;
					$('#uploadReplaceFile').val('');
					$('#action_pic_replace').attr('disabled',false);
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadReplaceFile').val('');
				$('#action_pic_replace').attr('disabled',false);
				return false;
			}
		} else {
			alert("Please Select an Image.") ;
			$('#uploadReplaceFile').val('');
			$('#action_pic_replace').attr('disabled',false);
			return false;
		}
		return false;
	});
	$(document).on('click', '#add_pic', function(){
		$('#picModal').modal('show');
		$('#uploadImage')[0].reset();
		$('.modal-title').html("<i class='fa fa-image'></i> Add Photo");
		$('#action_pic').val('Upload');
		$('#btn_action_pic').val('AddPhoto');
	});
	$(document).on('submit','#uploadImage', function(event){
		event.preventDefault();
		$('#action_pic').attr('disabled','disabled');
		var allowedTypes = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
		var FileSize = (document.getElementById("uploadFile").files[0].size/1024)/1024; 
        var file = $('#uploadFile').val().split('\\').pop();
        var fileType = file.allowedTypes;
		var extension = file.substr( (file.lastIndexOf('.') +1) );
		if($('#uploadFile').val()) {
			if(allowedTypes.includes(extension))
			{
				if(FileSize < 10) {
					event.preventDefault();
					$('#targetLayer').hide();
					$(this).ajaxSubmit({
						target: '#targetLayer',
						beforeSubmit:function(){
							$('.progress').show();
							$('.progress-bar').width('50%');
						},
						uploadProgress: function(event, position, total, percentageComplete)
						{
							$('.progress-bar').animate({
								width: percentageComplete + '%'
							}, {
								duration: 500
							});
						},
						success:function(){
							$('#picModal').modal('hide');
							$('.remove-messages').fadeIn().html('<div class="alert alert-success">Photo Uploaded Successfully & Live Now.</div>');
							setTimeout(function(){
								$(".remove-messages").fadeOut("slow");
							},2000);
							$('#uploadFile').val('');
							$('.progress').hide();
							$('#action_pic').attr('disabled',false);
							managePicsTable.ajax.reload();
							manageactivePicsTable.ajax.reload();
							managedeactivePicsTable.ajax.reload();
						},
						resetForm: true
					});
				} else {
					alert("Image must not be greater than 10 MB.") ;
					$('#uploadFile').val('');
					$('#action_pic').attr('disabled',false);
					return false;
				}
			} else {
				alert("Wrong File Type") ;
				$('#uploadFile').val('');
				$('#action_pic').attr('disabled',false);
				return false;
			}
		} else {
			alert("Please Select an Image.") ;
			$('#uploadFile').val('');
			$('#action_pic').attr('disabled',false);
			return false;
		}
		return false;
	});
	
	$(document).on('click', '.changePicStatus', function(){
			var picId = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action_view = "changePicStatus";
			if(confirm("Are you sure you want to change Photo Status?"))
			{
				$.ajax({
					url: base_url+"action_view_image.php",
					method:"POST",
					data:{picId:picId, status:status, btn_action_view:btn_action_view},
					success:function(data)
					{
						$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},2000);
						managePicsTable.ajax.reload();
						manageactivePicsTable.ajax.reload();
						managedeactivePicsTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		
		});
	
	
	$(document).on('submit','.password_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_password_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#password_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	$(document).on('submit','.email_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url: base_url+"action_email_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				$('#email_validation')[0].reset();
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
			}
		})
	});
	
	$(document).on('submit','.limit_validation', function(event){
		event.preventDefault();
		var form_data = $(this).serialize();
		$.ajax({
			url:"action_limit_detail.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{	
				data = JSON.parse(data);
				$('.remove-messages').fadeIn().html('<div class="alert alert-info">'+(data.form_message)+'</div>');
						setTimeout(function(){
							$(".remove-messages").fadeOut("slow");
						},3000);
				$('#startLimit').val(data.startLimit);
				$('#loadLimit').val(data.loadLimit);
				$('#darkMode').val(data.darkMode);
			}
		})
	});
	
	
});