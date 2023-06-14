/* noti */
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
		delay:1500,
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
		'<button type="button" aria-hidden="true" class="close notify-close" data-notify="dismiss">×</button>' +
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

/* 비밀 번호 정규식 */
function checkPassword(strVal){
	var regExp = /^.*(?=^.{8,16}$)(?=.*\d)(?=.*[a-zA-Z0-9])(?=.*[\{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]).*$/;

	if(strVal.search(/\s/g) > -1){
		showNotification("alert-warning", "비밀번호는 공백없이 입력해주세요.", "top", "center", "", "");
		return false;
	}

	if (!strVal.match(regExp)) {
		showNotification("alert-warning", "비밀번호는 영문, 숫자, 특수문자를 조합하여 최소 8자리 ~ 최대 16자리 이내로 입력해주세요.", "top", "center", "", "");
		return false;
	}	
	return true;
}

/* 이름 확인 */
function checkName(strVal){	
	var regExp = /^[ㄱ-ㅎ|가-힣|a-z|A-Z|0-9|\*]+$/;
	if (!strVal.match(regExp)) {
		showNotification("alert-warning", "이름은 한글, 영문, 숫자만 가능하며 최소 2자리 ~ 최대 10자리 이내로 입력해주세요.", "top", "center", "", "");
		return false;
	}
	if(strVal.length > 10 || strVal.length < 2){
		showNotification("alert-warning", "이름은 한글, 영문, 숫자만 가능하며 최소 2자리 ~ 최대 10자리 이내로 입력해주세요.", "top", "center", "", "");
		return false;
	}	
	return true;
}

/* email 확인 */
function checkEmail(strVal){	
	var regExp = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
	if (!strVal.match(regExp)) {
		showNotification("alert-warning", "이메일 형식이 잘못 입력되었습니다.", "top", "center", "", "");
		return false;
	}	
	return true;
}

/* from reset */
function resetForm(){
	$('form').each(function() {
      this.reset();
  });
}

function lodingModal(str, type = 'N'){
	if(str == 'show'){
		$('#modal-loading').modal('show');
	}
	else {
		if(type == 'T'){
			setTimeout(function() {
				$('#modal-loading').modal('hide');
			}, 1000);
		} else {
			$('#modal-loading').modal('hide');
		}
	}
}

/* 함수설정 */
function slide(idx){
	var list = $("#bernertxtlist");
	list.animate({top:-idx * 20});
	list.find(">li.active").removeClass('active');
	list.find(">li").eq(idx).addClass('active');
}

function auto(){
	var listN = $("#bernertxtlist li").length;
	var Num = $("#bernertxtlist li.active").index();
	if(Num >= listN-1){
		Num = 0;
	}else{
		Num ++;         
	}
	slide(Num);
}

function closeDmodal() {
	$(".dmodal").hide();
	$("#newmask").hide();
}

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

function topMove(){
	window.scrollTo({ top: 0, behavior: "smooth" });  
}

;(function() {
	"use strict";
	/**
	* Easy selector helper function
	*/
	const select = (el, all = false) => {
		el = el.trim()
		if (all) {
			return [...document.querySelectorAll(el)]
		} else {
			return document.querySelector(el)
		}
	}
	
	/**
	* Easy event listener function
	*/
	const on = (type, el, listener, all = false) => {
		if (all) {
			select(el, all).forEach(e => e.addEventListener(type, listener))
		} else {
			select(el, all).addEventListener(type, listener)
		}
	}
	
	/**
	* Easy on scroll event listener 
	*/
	const onscroll = (el, listener) => {
		el.addEventListener('scroll', listener)
	}
		
	/**
	* Sidebar toggle
	*/
	if (select('.toggle-sidebar-btn')) {
		on('click', '.toggle-sidebar-btn', function(e) {
			select('body').classList.toggle('toggle-sidebar')
		})
	}
	
	/**
	* Navbar links active state on scroll
	*/
	let navbarlinks = select('#navbar .scrollto', true)
		const navbarlinksActive = () => {
			let position = window.scrollY + 200
			navbarlinks.forEach(navbarlink => {
				if (!navbarlink.hash) return
				let section = select(navbarlink.hash)
				if (!section) return
				if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
					navbarlink.classList.add('active')
				} else {
					navbarlink.classList.remove('active')
				}
		})
	}
	window.addEventListener('load', navbarlinksActive)
	onscroll(document, navbarlinksActive)
	
	/**
	* Toggle .header-scrolled class to #header when page is scrolled
	*/
	let selectHeader = select('#header')
	if (selectHeader) {
		const headerScrolled = () => {
			if (window.scrollY > 100) {
				selectHeader.classList.add('header-scrolled')
			} else {
				selectHeader.classList.remove('header-scrolled')
			}
		}
		window.addEventListener('load', headerScrolled)
		onscroll(document, headerScrolled)
	}
		
	/**
	* Back to top button
	*/
	let backtotop = select('.back-to-top')
	if (backtotop) {
		const toggleBacktotop = () => {
			if (window.scrollY > 100) {
				backtotop.classList.add('active')
			} else {
				backtotop.classList.remove('active')
			}
		}
		window.addEventListener('load', toggleBacktotop)
		onscroll(document, toggleBacktotop)
	}

	/**
	* Initiate tooltips
	*/
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})
	
	/**
	* Initiate Datatables
	*/
	const datatables = select('.datatable', true)
	datatables.forEach(datatable => {
		new simpleDatatables.DataTable(datatable);
	})    
    /* 초기설정 */
    $("#bernertxtlist li:eq(0)").addClass('active');
    $("#bernertxtlist").addClass('ing');
    setInterval(auto, 2500);
})(jQuery);
