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

/**
 * Get notifications count
 */
function getNotificationsCount() {
    $.ajax({
        url: "/notifications/count",
        async: false,
        success: function (count) {
            if (parseInt($('li.notifications span.count').text()) < count) {
                var sound = $('#notification_sound')[0];
                sound.play();
            }
            $('li.notifications span.count').text(count);
        }
    });
}

/**
 * Get notifications
 */
function getNotifications() {
    $.ajax({
        url: "/notifications",
        async: false,
        success: function (notifications) {
            $('li.notifications ul.notifications_list').html(notifications);
            $.ajax({
                url: "/notifications/seen",
                async: false,
                success: function () {
                    $('li.notifications span.count').text(0);
                }
            });
        }
    });
}