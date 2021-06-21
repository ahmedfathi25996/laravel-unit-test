$(function () {


    /**
     * Start open_save_product_group_modal
     */

        $('body').on('click', '.open_save_product_group_modal', function () {

            var this_element                = $(this);
            var modal                       = $('#saveGroupModal');
            var id                          = this_element.attr('data-id');
            var product_id                  = this_element.attr('data-product_id');
            var product_groups_option_id    = this_element.attr('data-product_groups_option_id');

            if(modal.length)
            {
                this_element.attr("disabled","disabled");

                $.ajax({
                    url : base_url2 + '/admin/products/' + product_id + '/groups/prepareSave',
                    type: 'POST',
                    data: {'_token': _token, 'id': id, 'product_id': product_id, 'product_groups_option_id': product_groups_option_id},
                    success: function (data) {

                        var returned_data = JSON.parse(data);

                        if (returned_data.status == "1") {

                            modal.modal('show');
                            modal.find('.modal-header b').html(returned_data.header);
                            modal.find('.modal-body').html(returned_data.data);

                            modal.find('.product_groups_option_id').val(product_groups_option_id);

                            modal.find('.submit_btn').removeAttr('disabled');
                            modal.find('.submit_btn').attr('data-id', id);
                            modal.find('.submit_btn').attr('data-product_id', product_id);
                            modal.find('.submit_btn').attr('data-product_groups_option_id', product_groups_option_id);

                        }else{
                            $('#errorsModal').modal('show');
                            $('#errorsModal').find('.display_errors_msg').html(returned_data.msg);
                        }

                    }
                });


            }

            return false;
        });

    /**
     * End open_save_product_group_modal
     */


    /**
     * Start save product group
     */

        $('body').on('click', '#saveGroupModal .submit_btn', function () {

        var this_element                = $(this);
        var modal                       = $('#saveGroupModal');
        var id                          = this_element.attr('data-id');
        var product_id                  = this_element.attr('data-product_id');
        var product_groups_option_id    = this_element.attr('data-product_groups_option_id');

        if(modal.length)
        {
            this_element.attr("disabled","disabled");

            var url = base_url2 + '/admin/products/' + product_id + '/groups/save';
            if(typeof id != undefined && id != "")
            {
                url = base_url2 + '/admin/products/' + product_id + '/groups/save/'+ id;
            }

            $.ajax({
                url : url,
                type: 'POST',
                data: modal.find('form').serialize(),
                success: function (data) {

                    var returned_data = JSON.parse(data);

                    if (returned_data.status == "1") {

                        location.reload();

                    }else{

                        this_element.removeAttr('disabled');

                        $('#errorsModal').modal('show');
                        $('#errorsModal').find('.display_errors_msg').html(returned_data.msg);
                    }

                }
            });


        }

        return false;
    });


    /**
     * End save product group
     */


    /**
     * Start open_save_group_option_modal
     */

    $('body').on('click', '.open_save_group_option_modal', function () {

        var this_element        = $(this);
        var modal               = $('#saveGroupOptionModal');
        var id                  = this_element.attr('data-id');
        var product_id          = this_element.attr('data-product_id');
        var product_group_id    = this_element.attr('data-product_group_id');

        console.log('modal.length');
        console.log(modal.length);
        if(modal.length)
        {
            this_element.attr("disabled","disabled");

            $.ajax({
                url : base_url2 + '/admin/products/' + product_id + '/groups/' + product_group_id + '/options/prepareSave',
                type: 'POST',
                data: {'_token': _token, 'id': id, 'product_id': product_id, 'product_group_id': product_group_id},
                success: function (data) {

                    var returned_data = JSON.parse(data);

                    if (returned_data.status == "1") {

                        modal.modal('show');
                        modal.find('.modal-header b').html(returned_data.header);
                        modal.find('.modal-body').html(returned_data.data);

                        modal.find('.submit_btn').removeAttr('disabled');
                        modal.find('.submit_btn').attr('data-id', id);
                        modal.find('.submit_btn').attr('data-product_id', product_id);
                        modal.find('.submit_btn').attr('data-product_group_id', product_group_id);

                    }else{
                        $('#errorsModal').modal('show');
                        $('#errorsModal').find('.display_errors_msg').html(returned_data.msg);
                    }

                }
            });

        }

        return false;
    });

    /**
     * End open_save_group_option_modal
     */



    /**
     * Start save product group option
     */

    $('body').on('click', '#saveGroupOptionModal .submit_btn', function () {

        var this_element        = $(this);
        var modal               = $('#saveGroupOptionModal');
        var id                  = this_element.attr('data-id');
        var product_id          = this_element.attr('data-product_id');
        var product_group_id    = this_element.attr('data-product_group_id');

        if(modal.length)
        {
            this_element.attr("disabled","disabled");

            var url = base_url2 + '/admin/products/' + product_id + '/groups/' + product_group_id + '/options/save';
            if(typeof id != undefined && id != "")
            {
                url = base_url2 + '/admin/products/' + product_id + '/groups/' + product_group_id + '/options/save/'+ id;
            }

            $.ajax({
                url : url,
                type: 'POST',
                data: modal.find('form').serialize(),
                success: function (data) {

                    var returned_data = JSON.parse(data);

                    if (returned_data.status == "1") {

                        location.reload();

                    }else{

                        this_element.removeAttr('disabled');

                        $('#errorsModal').modal('show');
                        $('#errorsModal').find('.display_errors_msg').html(returned_data.msg);
                    }

                }
            });

        }

        return false;
    });


    /**
     * End save product group option
     */


});