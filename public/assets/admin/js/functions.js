function deleteCategory(categories) {
    $.ajax({
        url: admin_path + "/category/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), categories: categories},
        success: function () {
            window.location.reload();
        }
    });
}