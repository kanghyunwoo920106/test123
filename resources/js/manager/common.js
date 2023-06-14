function completed() {}

$.fn.serializeObject = function() {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function() {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};


function number_format(d) {
	if (typeof d == "string") {
		var num = parseFloat(d);
		if (isNaN(num)) return "0";
		return number_format(num);
	} else if (typeof d == "number") {
		if (d == 0) return 0;
		var reg = /(^[+-]?\d+)(\d{3})/;
		var n = d + "";
		while (reg.test(n)) n = n.replace(reg, "$1" + "," + "$2");
		return n;
	}
}

//노티
function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    var allowDismiss = true;

    $.notify({
        message: text
    },
	{
		type: colorName,
		allow_dismiss: allowDismiss,
		newest_on_top: true,
		z_index: 1060,
		delay:1000,
		timer: 1000,
		placement: {
			from: placementFrom,
			align: placementAlign
		},
		animate: {
			enter: animateEnter,
			exit: animateExit
		},
		template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert" style="width:500px">' +
		'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
		'<span data-notify="icon"></span> ' +
		'<span data-notify="title">{1}</span> ' +
		'<span data-notify="message">{2}</span>' +
		'<div class="progress" data-notify="progressbar">' +
		'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
		'</div>' +
		'<a href="{3}" target="{4}" data-notify="url"></a>' +
		'</div>'
	});
}

function closeDmodal() {
	$(".dmodal").hide();
	$("#newmask").hide();
}
function lodingModal(str){
	$('#modal-loading').modal(str);
}
