/**
 * Delete selected posts
 *
 * @param posts
 */
function deletePosts(posts) {
    $.ajax({
        url: "/post/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), posts: posts},
        success: function () {
            window.location.reload();
        }
    });
}