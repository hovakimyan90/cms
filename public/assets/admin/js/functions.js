/**
 * Delete selected categories
 *
 * @param categories
 */
function deleteCategories(categories) {
    $.ajax({
        url: admin_path + "/category/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), categories: categories},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Delete selected tags
 *
 * @param tags
 */
function deleteTags(tags) {
    $.ajax({
        url: admin_path + "/tag/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), tags: tags},
        success: function () {
            window.location.reload();
        }
    });
}