(function( $ ) {
    "use strict";

    // FUNCTIONS //
    function removeNotifications(){
        jQuery('.gdprcono-front__wrapper').remove();
    }

    $(document).ready(function(){
        var consentGDPRStatus = Cookies.get('gdprconostatus');
        if('reject' == consentGDPRStatus) {
            removeNotifications();
        }

        // Tab.
        jQuery('.gdprcono-tab__list li').first().addClass('active');
        jQuery('#gdprcono-modal__main .gdprcono-tab__content').first().addClass('active');
        jQuery('.gdprcono-tab__list li').on('click', function(){
            var currentTabContent = jQuery(this).attr('data-tab-name');
            jQuery(this).addClass('active').siblings().removeClass('active');
            jQuery('#'+currentTabContent).addClass('active').siblings().removeClass('active');
        });

        jQuery('.gdprcono-front__dialog').on('click', function(e){
            e.preventDefault();
        });

        // Form submit (accept).
        jQuery('#gdprcono-accept-btn').on('click', function(e){
            e.preventDefault();

            // Submission controller.
            var dataPosts = {
                    'action' : 'gdprcono_accept_cookie_handler',
                    'permit' : 'accept'
                };

            jQuery.ajax({
                url : gdprcono_handler_params.ajaxurl,
                data : dataPosts,
                dataType: "text",
                type : 'POST',
                beforeSend : function () {

                },
                success : function(data){
                    var json = jQuery.parseJSON(data);
                    console.log(json);

                    if( json.status == true ) {
                        removeNotifications();
                    }
                }
            });
        });

        // Form submit (reject).
        jQuery('#gdprcono-reject-btn').on('click', function(e){
            e.preventDefault();

            // Submission controller.
            var dataPosts = {
                    'action' : 'gdprcono_reject_cookie_handler',
                    'permit' : 'reject'
                };

            jQuery.ajax({
                url : gdprcono_handler_params.ajaxurl,
                data : dataPosts,
                dataType: "text",
                type : 'POST',
                beforeSend : function () {

                },
                success : function(data){
                    var json = jQuery.parseJSON(data);
                    console.log(json);

                    if( json.status == true ) {
                        removeNotifications();
                        location.reload();
                    }
                }
            });
        });
    });

    $(window).load(function(){
        var consentGDPRStatus = Cookies.get('gdprconostatus');
        if('reject' == consentGDPRStatus) {
            removeNotifications();
        }
    });
})(jQuery);