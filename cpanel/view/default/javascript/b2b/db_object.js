function dba_object() {
	this.conn = null;
}
dba_object.prototype = {
	table_exists : function(name) {
		this.conn.query("SHOW TABLES LIKE '" + name + "';");
		return this.conn.result_rows() > 0;
	},
	exec : function(sql) {
		return this.conn.query(sql);
	},
	connect : function(host, username, password, dbname) {
		if (this.conn == null) {
			this.conn = external.mysql_connect(host, username, password, dbname);
			if (this.conn == null){
				return false;
			}
		}
		return true;
	},
	check : function(env) {
		if (this.conn == null) {
			return -1;
		}
		if (this.table_exists("task")) {
			return 0;
		}
		var stream;
		if (external.file_exists(env.db_init)) {
			stream = external.open_file(env.db_init);
		} else {
			stream = external.http_get(env.db_init, 1);
		}
		if (stream == null) {
			return -2;
		}
		var stmt, parser = external.sql_parser(stream.to_string(65001));
		stream.close();
		while ((stmt = parser.next()) != null) {
			this.exec(stmt);
		}
		return this.table_exists("task") ? 0 : -3;
	},
	query_task : function(item_id, task_type) {
		var sql = "SELECT * FROM task WHERE item_id=" + item_id	+ " AND task_type=" + task_type;
		if (!this.conn.query(sql)) {
			return null;
		}
		return this.conn.fetch_row();
	},
	query_product : function(product_id) {
		var sql = "SELECT * FROM product WHERE id=" + product_id;
		if (!this.conn.query(sql)){
			return null;
		}
		return this.conn.fetch_row();
	},
	query_seller : function(seller_id) {
		var sql = "SELECT * FROM store WHERE id=" + seller_id;
		if (this.conn.query(sql)){
			return this.conn.fetch_row();
		}else{
			return null;
		}
	},
	delete_all_seller : function() {
		this.exec("truncate table store;");
	},
	add_seller : function(id, name, url, address, meta_title, meta_keywords, meta_descript) {
		var row = this.query_seller(id);
		if (row == null) {//add
			var sql = "INSERT INTO store(id,store_name,store_url,meta_title,meta_keywords,meta_description) VALUES("
					+ id
					+ ",'"
					+ this.conn.escape_string(name)
					+ "','"
					+ this.conn.escape_string(url)
					+ "','"
					+ this.conn.escape_string(meta_title)
					+ "','"
					+ this.conn.escape_string(meta_keywords)
					+ "','"
					+ this.conn.escape_string(meta_descript) + "'" + ");";
			this.exec(sql);
		} else {//update: TODO
		}
	},
	add_task : function(item_id, task_type, states, item_url) {
		var row = this.query_task(item_id, task_type);
		if (row != null) {// exist
			this.set_task_state(row.id, states, 0);
			return;
		}
		item_url = this.conn.escape_string(item_url);
		var sql = "INSERT INTO task(item_id,task_type,task_url,data_states) VALUES("
				+ item_id
				+ ","
				+ task_type
				+ ",'"
				+ item_url
				+ "',"
				+ states
				+ ");";
		this.exec(sql); // add
	},
	add_product : function(product_id, name, category_id, url, quantity, price,
			keywords, title, descript) {
		var row = this.query_product(product_id);
		if (row == null) {// add
			var sql = "INSERT INTO product(id,product_name,product_url,category_id,product_quantity,product_price,meta_title,meta_keywords,meta_description) VALUES("
					+ product_id
					+ ",'"
					+ name
					+ "','"
					+ this.conn.escape_string(url)
					+ "',"
					+ category_id
					+ ","
					+ quantity
					+ ","
					+ price
					+ ",'"
					+ this.conn.escape_string(title)
					+ "','"
					+ this.conn.escape_string(keywords)
					+ "','"
					+ this.conn.escape_string(descript) + "'" + ");";
			this.exec(sql);
		} else {// update: TODO

		}
	},
	delete_all_table:function(){
		this.exec("drop table task;");
		this.exec("drop table product;");		
		this.exec("drop table store;");
	},
	delete_all_product : function() {
		this.exec("truncate table product;");
	},
	delete_all_task : function() {
		this.exec("truncate table task;");
	},
	get_next_task : function(now_sec) {
		var time_limit = now_sec - 60; // 同一任务的采集间隔不能小于60秒
		var sql = "SELECT * FROM task WHERE data_states>=0 AND last_time<="	+ time_limit + " ORDER BY data_states;";
		if (this.conn.query(sql)) {
			return this.conn.fetch_row();
		}
		return null;
	},
	set_task_state : function(id, state, now_sec) {
		var sql = "UPDATE task SET data_states=" + state + ", last_time=" + now_sec + " WHERE id=" + id;
		return this.conn.query(sql);
	},
	close : function() {
		this.conn.close();
		this.conn = null;
	}
};