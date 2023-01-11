$(document).ready(function(){
//Mask Inputs
	function checkValue(input, length){
		var string = $(input).val();
			res = string.replace(/[\(|\)|\_|\-|\.|\:|\/|\ ]/g, '');
		if(res.length < length){
			$(input).val('');
		}
	}
	var SPMaskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
			field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};
	$('.formFone').change(function(){ checkValue($(this), 10); }).mask(SPMaskBehavior, spOptions);
	$(".formDate").change(function(){ checkValue($(this), 14); }).mask('00/00/0000 00:00:00',{placeholder:"mm/dd/yyyy hh:mm:ss"});
	$(".formCpf").change(function(){ checkValue($(this), 11); }).mask("000.000.000-00",{placeholder:"___.___.___-__"});
	$(".formCep").change(function(){ checkValue($(this), 8); }).mask("00000-000",{placeholder:"_____-___"});
	
	

	$('.small img').click(function() {
		$('.gbimgimg').attr('src', $(this).attr('src'));
		$('.gblink').attr('rel', $(this).attr('src'));
	});
	
	$('.slide ul').cycle({
		fx: 'fade',
		speed: 1000,
		timeout: 3000,
		pager: '.slidenav',
		pause: true
	})
	
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			$('.hnav').addClass("f-nav");
		} else {
			$('.hnav').removeClass("f-nav");
		}
	});

	Shadowbox.init();
});