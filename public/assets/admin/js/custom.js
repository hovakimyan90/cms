$(document).ready(function () {
    select_all_categories.click(function () {
        console.log($(this).is(":checked"));
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
    delete_all_button.click(function () {
        categories = [];
        category_checkbox.each(function () {
            if ($(this).is(':checked')) {
                categories.push($(this).data('id'));
            }
        });
        console.log(categories);
        if (categories.length > 0) {
            deleteCategory(categories);
        }
    });
});