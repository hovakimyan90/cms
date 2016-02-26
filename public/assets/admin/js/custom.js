$(document).ready(function () {
    /**
     * Check selected categories
     */
    select_all_categories.click(function () {
        if ($(this).is(":checked")) {
            category_checkbox.each(function () {
                $(this).prop('checked', true);
            });
        } else {
            category_checkbox.each(function () {
                $(this).prop('checked', false);
                $(this).removeProp('checked');
            });
        }
    });

    /**
     * Delete selected categories
     */
    delete_all_button.click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Confirm delete?",
            buttons: {
                success: {
                    label: "Cancel",
                    callback: function () {
                    }
                },
                danger: {
                    label: "Delete",
                    className: "btn-danger",
                    callback: function () {
                        categories = [];
                        category_checkbox.each(function () {
                            if ($(this).is(':checked')) {
                                categories.push($(this).data('id'));
                            }
                        });
                        if (categories.length > 0) {
                            deleteCategories(categories);
                        }
                    }
                }
            }
        });
    });

    /**
     * Delete category
     */
    delete_button.click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Conform delete?",
            className: "category_delete_confirm",
            buttons: {
                success: {
                    label: "Cancel",
                    callback: function () {
                        console.log("great success");
                    }
                },
                danger: {
                    label: "Delete",
                    className: "btn-danger",
                    callback: function () {
                        window.location = admin_path + '/category/delete/' + $(this).data('id');
                    }
                }
            }
        });
        $('.category_delete_confirm').attr('data-id', $(this).data('id'));
    });

    tinymce.init({
        selector: '#post_content',
        height: 500,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image moxiemanager charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
});