'use strict';

(function(){
    $(function(){
        function isSmartDevice()
    	{
    		var ua = window['navigator']['userAgent'] || window['navigator']['vendor'] || window['opera'];
    		return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
    	}

    	function responsiveView() {
    		var wSize = $(window).width();
    		if (wSize <= 768) {
    			$('#container').addClass('sidebar-close');
    			$('#sidebar > ul').hide();
    		}

    		if (wSize > 768) {
    			$('#container').removeClass('sidebar-close');
    			$('#sidebar > ul').show();

                $('#main-content').css({
                    'margin-left': '210px'
                });
                $('#sidebar').css({
                    'margin-left': '0'
                });
                $("#container").removeClass("sidebar-closed");
    		}
    	}

    	$(window).on('load', responsiveView);

    	if (!isSmartDevice()){
            $(window).on('resize', responsiveView);
    	}

        if ($.isFunction(jQuery.fn.dcAccordion)){
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: false,
                saveState: false,
                disableLink: true,
                speed: 'fast',
                showCount: false,
                autoExpand: false,
                classExpand: 'dcjq-current-parent'
            });
        }

        $('.fa-bars').click(function () {
            if ($('#sidebar > ul').is(":visible") === true) {
                $('#main-content').css({
                    'margin-left': '0px'
                });
                $('#sidebar').css({
                    'margin-left': '-210px'
                });
                $('#sidebar > ul').hide();
                $("#container").addClass("sidebar-closed");
            } else {
                $('#main-content').css({
                    'margin-left': '210px'
                });
                $('#sidebar > ul').show();
                $('#sidebar').css({
                    'margin-left': '0'
                });
                $("#container").removeClass("sidebar-closed");
            }
        });
    });
})();
