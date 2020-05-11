//(function( $ ) {
    //"use strict";

    // Globals
    var bodyOfDOM = jQuery('html');

    // FUNCTIONS //
    function removeNotifications(){
        jQuery('.gdprcono-front__wrapper').remove();
    }

    function switchBoxSlide(currentStatusToggle) {
        if (currentStatusToggle == 2) {
            jQuery('.switchcontent-box').slideUp();
        } else {
            jQuery('.switchcontent-box').slideDown();
        }
    }

    jQuery(document).ready(function($){
        bodyOfDOM = jQuery('html');
        // Add GDPR class.
        bodyOfDOM.addClass('gpdrcono-activated');

        var consentGDPRStatus = Cookies.get('gdprconostatus');
        if('reject' == consentGDPRStatus) {
            removeNotifications();
        }

        // Switch.
        var currentStatusToggle = 1;
        jQuery('.gdprcono-togglefy').click(function(e){
            e.preventDefault();
            var addOrRemove = jQuery(this).toggleClass('toggle-on');
            currentStatusToggle = addOrRemove.context.classList.length;
            switchBoxSlide(currentStatusToggle);
            jQuery('.activateall-btn').hide();
            jQuery('.savesettings-btn').css('display', 'inline-block');
        });
        switchBoxSlide(currentStatusToggle);

        // Tab.
        var currentTabContent;
        jQuery('.gdprcono-tab__list li:first-child').addClass('active');
        jQuery('#gdprcono-modal__main .gdprcono-tab__content').first().addClass('active');
        jQuery('.gdprcono-tab__list li').on('click', function(){
            currentTabContent = jQuery(this).attr('data-tab-name');
            jQuery('#'+currentTabContent).addClass('active').siblings().removeClass('active');
            jQuery(this).addClass('active').siblings().removeClass('active');
        });

        jQuery('.gdprcono-front__dialog').on('click', function(e){
            e.preventDefault();
        });

        // Form submit (accept).
        jQuery('#gdprcono-accept-btn, .gdprcono-popactivate > a').on('click', function(e){
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

    jQuery(window).load(function($){
        bodyOfDOM = jQuery('html');
        // Add GDPR class.
        bodyOfDOM.addClass('gpdrcono-activated');

        var consentGDPRStatus = Cookies.get('gdprconostatus');
        if('reject' == consentGDPRStatus) {
            removeNotifications();
        }
    });
//})(jQuery);