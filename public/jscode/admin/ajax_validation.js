$(function () {

    $("body").on("click",".validate_ajax_before_submit",function(){

        var this_element = $(this);
        this_element.append(ajax_loader_img_func("15px"));
        this_element.attr("disabled","disabled");


        var formElement=this_element.parents("form");
        var formData=new FormData(formElement[0]);

        formData.append("check_validate","yes");

        $.ajax({
            url: formElement.attr("action"),
            type: "POST",
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                this_element.removeAttr("disabled");
                $("img",this_element).remove();

                if(data==""){
                    show_flash_message("info","تم التحقق وسيتم حفظ البيانات");
                    this_element.removeClass("validate_ajax_before_submit");
                    this_element.click();
                }
                else
                {
                    show_flash_message("warning",data);
                }

            }
        });

        return true;

    });

});
