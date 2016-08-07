$(document).ready(function () {
    var admin_path = '/admin';
    var categories;
    var tags;
    var posts;
    var users;

    if ($('li.notifications.dropdown').length >= 1) {
        getNotificationsCount();
        setInterval(function () {
            getNotificationsCount();
        }, 5000);
    }
    /**
     * Check selected items
     */
    $('input[type="checkbox"].select_all').click(function () {
        if ($(this).is(":checked")) {
            $('.item').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $('.item').each(function () {
                $(this).prop('checked', false);
                $(this).removeProp('checked');
            });
        }
    });

    /**
     * Delete selected categories
     */
    $('button.categories_delete_all').click(function () {
        categories = [];
        $('table.categories input[type="checkbox"]').each(function () {
            if ($(this).is(':checked')) {
                categories.push($(this).data('id'));
            }
        });
        if (categories.length > 0) {
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
                            deleteCategories(categories);
                        }
                    }
                }
            });
        }
    });

    /**
     * Delete selected tags
     */
    $('button.tags_delete_all').click(function () {
        tags = [];
        $('table.tags input[type="checkbox"]').each(function () {
            if ($(this).is(':checked')) {
                tags.push($(this).data('id'));
            }
        });
        if (tags.length > 0) {
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
                            deleteTags(tags);
                        }
                    }
                }
            });
        }
    });

    /**
     * Delete selected posts
     */
    $('button.posts_delete_all').click(function () {
        posts = [];
        $('table.posts input[type="checkbox"]').each(function () {
            if ($(this).is(':checked')) {
                posts.push($(this).data('id'));
            }
        });
        if (posts.length > 0) {
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
                            deletePosts(posts);
                        }
                    }
                }
            });
        }
    });

    /**
     * Delete selected users
     */
    $('button.users_delete_all').click(function () {
        users = [];
        $('table.users input[type="checkbox"]').each(function () {
            if ($(this).is(':checked')) {
                users.push($(this).data('id'));
            }
        });
        if (users.length > 0) {
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
                            deleteUsers(users);
                        }
                    }
                }
            });
        }
    });

    /**
     * Delete category
     */
    $('table.categories button.delete').click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Conform delete?",
            className: "category_delete_confirm",
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
                        window.location = admin_path + '/category/delete/' + $(this).data('id');
                    }
                }
            }
        });
        $('.category_delete_confirm').attr('data-id', $(this).data('id'));
    });

    /**
     * Delete tag
     */
    $('table.tags button.delete').click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Conform delete?",
            className: "tag_delete_confirm",
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
                        window.location = admin_path + '/tag/delete/' + $(this).data('id');
                    }
                }
            }
        });
        $('.tag_delete_confirm').attr('data-id', $(this).data('id'));
    });

    /**
     * Delete post
     */
    $('table.posts button.delete').click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Conform delete?",
            className: "post_delete_confirm",
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
                        window.location = admin_path + '/post/delete/' + $(this).data('id');
                    }
                }
            }
        });
        $('.post_delete_confirm').attr('data-id', $(this).data('id'));
    });

    $('table.users button.delete').click(function () {
        bootbox.dialog({
            message: "I am a custom dialog",
            title: "Conform delete?",
            className: "user_delete_confirm",
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
                        window.location = admin_path + '/user/delete/' + $(this).data('id');
                    }
                }
            }
        });
        $('.user_delete_confirm').attr('data-id', $(this).data('id'));
    });

    $('#user_image_btn').click(function () {
        $('input#user_image').click();
    });

    $('.post_form select.tags').chosen();

    /**
     * Initialize TinyMCE editor for post editor
     */
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
        relative_urls: false,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });

    $('li.notifications.dropdown').click(function () {
        if (!$(this).hasClass('open')) {
            getNotifications();
        }
    });
});