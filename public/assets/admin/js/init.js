var admin_path = '/admin';
var body = $("body");
var categories_delete_all_button = body.find('button.categories_delete_all');
var categories_table = body.find("table.categories");
var categories_table_tbody = categories_table.find('tbody');
var categories_table_tr = categories_table_tbody.find('tr');
var categories_table_td = categories_table_tr.find('td');
var category_delete_button = categories_table_td.find('button.delete');
var select_all = body.find("input[type='checkbox'].select_all");
var category_checkbox = categories_table_td.find("input[type='checkbox']");
var item = body.find(".item");
var categories = [];
var posts_delete_all_button = body.find('button.posts_delete_all');
var posts_table = body.find("table.posts");
var posts_table_tbody = posts_table.find('tbody');
var posts_table_tr = posts_table_tbody.find('tr');
var posts_table_td = posts_table_tr.find('td');
var post_delete_button = posts_table_td.find('button.delete');
var post_checkbox = posts_table_td.find("input[type='checkbox']");
var post_form = body.find('.post_form');
var post_tags_input = post_form.find('select.tags');
var posts = [];
var tags_delete_all_button = body.find('button.tags_delete_all');
var tags_table = body.find("table.tags");
var tags_table_tbody = tags_table.find('tbody');
var tags_table_tr = tags_table_tbody.find('tr');
var tags_table_td = tags_table_tr.find('td');
var tag_delete_button = tags_table_td.find('button.delete');
var tag_checkbox = tags_table_td.find("input[type='checkbox']");
var tags = [];
var user_image_field = body.find('input#user_image');
var user_image_button = body.find('#user_image_btn');