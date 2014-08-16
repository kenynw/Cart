function patten_load(patten, file) {
	if (external.file_exists(file))
		return patten.load(file);

	if (!external.valid_url(file))
		return false;

	var http = external.http_get(file, 1);
	if (http == null)
		return false;

	var ok = patten.load_from_string(http.to_string());
	http.close();
	return ok;
}

function alibaba_data_cj(window_id, patten_url) {
	// 属性定义
	this._window = external.get_window(window_id);
	this._page = 1;
	this._month_or_week = "week"; // 按月还是按周统计
	this._callback = null;
	this._patten = null;
	this._patten_url = patten_url;
	this._tick_count = 0;
	this._load_tick = 0;
	this._wait_tick = 0;
	this._step = null;
	this._filter_word = null; // 过滤词
}

alibaba_data_cj.prototype = {
	// 方法定义
	run : function(callback, start_page, month_or_week, filter) {
		if (start_page < 1)
			start_page = 1;
		this._page = start_page;
		this._month_or_week = month_or_week;
		this._callback = callback;
		this._tick_count = 0;
		this._load_tick = 0;
		this._filter_word = filter;
		this._step = this.select_type;
		this._wait_tick = 0;
	},
	done : function() {
		this._tick_count++;
		if (this._window.isClosed) {
			this._window.open("http://hz.my.data.alibaba.com/self/keyword.htm?tracelog=biz_ma_home_gs");
			this._window.show("show");
			this._load_tick = this._tick_count;
			this._step = this.select_type;
			return false;
		}

		if (this._patten == null) {
			var patten = external.new_patten();
			if (!patten_load(patten, this._patten_url)) {
				this._callback.on_error("模板[" + this._patten_url + "]载入失败!");
				patten = null;
				return true;
			}
			this._patten = patten;
		}

		var doc = this._window.document;
		if (doc == null || doc.body == null)
			return false;

		var inter = this._tick_count - this._load_tick;
		if (inter < 2) // 控制采集速度
			return false;

		this._load_tick = this._tick_count;

		var tree = doc.node_tree();
		if (tree == null) {
			this._load_tick += 3;
			return false;
		}
		try {
			return this._step(tree);
		} finally {
			tree.close(); // JS会自动释放，但主动调用close()会更快释放内存。
		}
	},

	select_type : function(tree) {
		var res = tree.match(this._patten, "type-select");
		if (res != null) {
			if (this._month_or_week == "week") {
				res.week_link.click();
			} else {
				res.month_link.click();
			}

			if (this._filter_word == null)
				this._step = this.analyse; // 采我的词
			else
				this._step = this.keyword_filter; // 采过滤词
			this._load_tick++;
		}
		return false;
	},

	keyword_filter : function(tree) {
		var res = tree.match(this._patten, "keyword-filter");
		if (res == null)
			return false;

		var input = res.input;
		var class_name = "ui-textfield ui-textfield-system";
		input.className = class_name;
		input.setAttribute("class", class_name);
		input.value = this._filter_word;
		if (input.value == this._filter_word) {
			res.go.click();
			this._step = this.analyse;
			this._load_tick++;
		}
		return false;
	},

	analyse : function(tree) {
		var page_info_res = tree.match(this._patten, "page-info");
		if (page_info_res == null) {
			if (this._wait_tick == 3)
				this._window.close();
			return ++this._wait_tick > 5;
		}

		var page_num = page_info_res.info.split("/", 2);
		var current_page = parseInt(page_num[0]);
		var max_page = parseInt(page_num[1]);
		if (current_page != this._page) {
			if (max_page < this._page)
				return true;

			return !this.goto_page(tree); // 点击需要时间,等下个时间片再处理
		}

		var keyword_res = tree.match(this._patten, "keyword-table");
		if (keyword_res == null)
			return true; // 页面错误?

		var base_stat_res = tree.match(this._patten, "base-stat");
		var p4p_stat_res = tree.match(this._patten, "p4p-stat");
		var other_stat_res = tree.match(this._patten, "other-stat");
		if (base_stat_res == null || p4p_stat_res == null
				|| other_stat_res == null)
			return true; // 页面错误?

		var keyword_array = keyword_res.list;
		var base_array = base_stat_res.list;
		var p4p_array = p4p_stat_res.list;
		var other_array = other_stat_res.list;

		var count = keyword_array.array_length;
		for ( var i = 0; i < count; i++) {
			var base_stat = base_array[i];
			var p4p_stat = p4p_array[i];
			var other_stat = other_array[i];
					}

		if (this._page == max_page) {
			this._callback.on_complete(this._page); // 全部完成
			return true;
		}

		this._page++;
		if (this.goto_page(tree)) {
			this._wait_tick = 0;
			this._callback.on_nextpage(this._page);
			return false;
		}
		return true; // 无法切换到下一页?
	},

	goto_page : function(tree) {
		var res = tree.match(this._patten, "page-goto");
		if (res == null)
			return false;

		var page_list = res.list;
		var count = page_list.array_length;
		for ( var i = 0; i < count; i++) {
			if (this._page == parseInt(page_list[i].num)) {
				page_list[i].click();
				return true;
			}
		}
		res.input.value = this._page;
		if (this._page == res.input.value)
			res.go.click();
		return true;
	}
};
