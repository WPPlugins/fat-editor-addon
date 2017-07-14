/**
 * Created by phuongth on 6/7/2017.
 */
var sc_utils = {};

(function ($) {
    "use strict";

    sc_utils.showPopup = function(fat_sc_id,title, content, callback){
        title = typeof title =='undefined' ? '': title;
        var footer = $('<div class="fat-sc-popup-footer"><div class="fat-sc-popup-button-groups"><a class="fat-sc-popup-bt-cancel">Cancel</a><a class="fat-sc-popup-bt-insert">Save</a></div></div>');
        content = typeof content =='undefined' ? '': content;

        var divPopup = $('<div class="fat-sc-popup-dialog fat-sc-video-button" data-fat-sc-id="' + fat_sc_id + '" ></div>');
        divPopup.append($('<div class="fat-sc-popup-inner"></div>'));

        $('.fat-sc-popup-inner',divPopup).append($('<div class="fat-sc-popup-title">' + title + ' <a href="javascript:void(0)" class="fat-sc-popup-close-icon"><i class="fa fa-close"></i></a> </div>'));
        $('.fat-sc-popup-inner',divPopup).append($('<div class="fat-sc-popup-content"></div>'));
        $('.fat-sc-popup-content',divPopup).append($(content));
        $('.fat-sc-popup-inner',divPopup).append(footer);
        $('body').append(divPopup);

        $('a.fat-sc-popup-close-icon, a.fat-sc-popup-bt-cancel').on('click',function(){
            sc_utils.closePopup();
        });
        if(callback){
            callback();
        }
    };

    sc_utils.closePopup = function(){
        $('.fat-sc-popup-dialog').remove();
        $('body').css('overflow','auto');
    };

    sc_utils.bindImageItem = function (field_name, attachments, template_id, bindTo) {
        $.ajax({
            url: ajax.url,
            type: 'POST',
            data: ({
                action: 'get_attachment_info',
                ids: attachments
            }),
            success: function (data) {
                try {
                    var images = JSON.parse(data),
                        image_template;
                    for (var $i = 0; $i < images.length; $i++) {
                        image_template = wp.template(template_id);
                        image_template = $(image_template({
                            'image_id': images[$i].id,
                            'image_url': images[$i].url
                        }));
                        $(bindTo).append(image_template);
                    }

                    $('a.fat-delete-single-image','.fat-add-single-image-wrap').on('click',function(){
                        var parent = $(this).closest('.fat-add-single-image-wrap');
                        $('input[data-field-type="single-image"]', parent).val();
                        $('.fat-list-image .fat-image-thumb',parent).remove();
                    });
                }
                catch (e) {
                }
            },
            error: function () {
            }
        });
    };

}(jQuery));
