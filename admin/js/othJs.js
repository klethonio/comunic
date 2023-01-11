$(document).ready(function(){
//tinyMCE
	tinymce.init({
		selector: '.editor',
		relative_urls: false,
		resize: false,
		remove_script_host: false,
		plugins : 'code paste fullscreen textcolor link image media directionality hr preview print insertdatetime emoticons searchreplace visualblocks table charmap responsivefilemanager',
		menubar: "file edit insert view format table",
		toolbar: 'fullscreen code removeformat | undo redo | styleselect | bold italic underline | forecolor backcolor | bullist numlist | link unlink | outdent indent ltr rtl hr | insertdatetime emoticons responsivefilemanager',
		link_class_list: [
			{title: 'None', value: ''},
		],
		image_advtab: true,
		image_title: true,
		image_prepend_url: "uploads",
		insertdatetime_formats: ["%d/%m/%Y %H:%M", "%d/%m/%Y"],
		external_filemanager_path: '../filemanager/',
		filemanager_title:"Browser - Uploads",
		external_plugins: { "filemanager" : "/comunic/filemanager/plugin.min.js"}
	});

	//FancyUploader
	var postId = $('ul.gblist').attr('rel');
	$('#galleryFile').FancyFileUpload({
		url: 'fancyuploader.php',
		params : {
			action : 'fileuploader',
			postId : postId,
		},
		edit : false,
		maxfilesize : 5000000,
	});
	
	$('a[title="excluir"]').click(function(e){
		e.preventDefault();
		var id = $(this).attr('href');
			href = $(this).attr('rel');
		
		$('a[name=excluir]').attr('href', href);
	
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		$('#mask').css({'width':maskWidth,'height':maskHeight});

		$('#mask').fadeIn(200);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		$(id).css('top',  (winH-$(id).height())/2);
		$(id).css('left', (winW-$(id).width())/2);
	
		$(id).fadeIn(300);
    });
	$('#window-del .close-del').click(function (e) {
		e.preventDefault();
		
		$('#mask').hide();
		$('#window-del').hide();
	});
	$('#mask').click(function () {
		$(this).hide();
		$('#window-del').hide();
	});	
});