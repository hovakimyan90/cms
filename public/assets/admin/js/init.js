var admin_path = '/admin';
var body = $("body");
var delete_all_button = body.find('button.delete_all');
var categories_table = body.find("table.categories");
var categories_table_thead = categories_table.find('thead');
var categories_table_tbody = categories_table.find('tbody');
var select_all_categories = categories_table_thead.find("input[type='checkbox'].select_all");
var category_checkbox = categories_table_tbody.find("td input[type='checkbox']");
var categories = [];