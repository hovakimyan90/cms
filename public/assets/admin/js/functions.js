var admin_path = '/admin';
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

/**
 * Delete selected posts
 *
 * @param posts
 */
function deletePosts(posts) {
    $.ajax({
        url: admin_path + "/post/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), posts: posts},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Delete selected users
 *
 * @param users
 */
function deleteUsers(users) {
    $.ajax({
        url: admin_path + "/user/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), users: users},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Delete selected pages
 * @param pages
 */
function deletePages(pages) {
    $.ajax({
        url: admin_path + "/page/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), pages: pages},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Delete selected albums
 * @param albums
 */
function deleteAlbums(albums) {
    $.ajax({
        url: admin_path + "/album/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), albums: albums},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Delete selected gallery images
 * @param images
 */
function deleteGalleryImages(images) {
    $.ajax({
        url: admin_path + "/gallery/delete",
        type: 'POST',
        data: {_token: $("input[name='_token']").val(), images: images},
        success: function () {
            window.location.reload();
        }
    });
}

/**
 * Get notifications count
 */
function getNotificationsCount() {
    $.ajax({
        url: admin_path + "/notifications/count",
        async: false,
        success: function (count) {
            if (parseInt($('li.notifications.dropdown .badge-info').text()) < count) {
                var sound = $('#notification_sound')[0];
                sound.play();
            }
            $('li.notifications.dropdown .badge-info').text(count);
        }
    });
}

/**
 * Get notifications
 */
function getNotifications() {
    $.ajax({
        url: admin_path + "/notifications",
        async: false,
        success: function (notifications) {
            $('li.notifications.dropdown .dropdown-menu-list').html(notifications);
            $.ajax({
                url: admin_path + "/notifications/seen",
                async: false,
                success: function () {
                    $('li.notifications.dropdown .badge-info').text(0);
                }
            });
        }
    });
}