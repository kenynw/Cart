var _env; // 环境变量
var _dba; // 数据库访问
var _cj; // 采集调度器
var _timerid;

// 各种解析器，用于对模板匹配的补充，
// 有些字段无法直接从模板匹配结果中获取,
// 利用JS字符串工具函数可以实现更灵活的内容提取。
var _aliexpress_parser;
var _taobao_parser;
var _alibaba_parser;

// 事件ID
var EVENTID_ERROR = 1, // 发生错误
EVENTID_DB_OK = 2, // 数据库检测成功
EVENTID_PAGE_LOAD = 3, // 载入了一个页面
EVENTID_ADD_TASK = 5 // 新增了一个任务
;

// 任务类型
var TASK_IS_ALIEXPRESS_LIST = 1000, 
TASK_IS_ALIEXPRESS_ITEM = 1001, 
TASK_IS_TAOBAO_LIST = 2000, 
TASK_IS_TAOBAO_ITEM = 2001, 
TASK_IS_ALIBABA_LIST = 3000, 
TASK_IS_ALIBABA_ITEM = 3001;

// 模板规则名
var REG_NAME_ITEMS = "items", 
REG_NAME_ITEM = "item", 
REG_NAME_CATEGORY = "category", 
REG_NAME_NEXTPAGE = "nextpage", 
REG_NAME_ITEM_DETAIL = "item_detail", 
REG_NAME_SELLER = "seller";

// HTTP超时 (15秒)
var HTTP_TIMEOUT = 15000;

function load_js(url, callback) {
	var head = document.getElementsByTagName('head')[0];
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = url;
	script.onreadystatechange = callback;
	script.onload = callback;
	head.appendChild(script);
}

function cj_init() {
	load_js("http://soe.freeoa.cc/cpanel/index.php?route=common/api/db_conf", null);
	load_js("http://soe.freeoa.cc/cpanel/index.php?route=common/api/db_obj", null);
	_timerid = setInterval("cj_loading()", 500);
}
function cj_loading() {
	if (typeof (cj_event) == "function" && typeof (dba_object) == "function" && typeof (env_object) == "function") {
		clearInterval(_timerid);
		_env = new env_object();
		_dba = new dba_object();
		if (!_dba.connect(_env.db_host, _env.db_username, _env.db_password,	_env.db_name)) {
			cj_event({
				id : EVENTID_ERROR,
				desc : "连接数据库失败"
			});
			return;
		}
		var ecode = _dba.check(_env);
		if (ecode != 0) {
			cj_event({
				id : EVENTID_ERROR,
				desc : "数据库初始化错误:" + ecode
			});
			return;
		}
		_cj = new cj_object();
		cj_event({
			id : EVENTID_DB_OK,
			desc : "数据库检测OK"
		});
		_timerid = setInterval("_cj.on_timer()", 500);

		_aliexpress_parser = new aliexpress_parser();
		_taobao_parser = new taobao_parser();
		_alibaba_parser = new alibaba_parser();
	}
}

function task_object(row, patten) {
	this.patten = patten;
	this.id = row.id;
	this.item_id = row.item_id;
	this.task_type = row.task_type;
	this.state = row.data_states;
	this.task_url = row.task_url;

	// 浏览模式判断
	this.uses_browser = this.task_type == TASK_IS_TAOBAO_LIST || this.task_type == TASK_IS_TAOBAO_ITEM;

	// 是否列表页
	this.page_is_list = this.task_type == TASK_IS_ALIEXPRESS_LIST || this.task_type == TASK_IS_ALIBABA_LIST || this.task_type == TASK_IS_TAOBAO_LIST;

	// 商品类ID
	this.category = 0;
	if (this.page_is_list){
		this.category = this.item_id;
	}

	// 文档对象
	this.doc = this.uses_browser ? new browser_document(this.task_url) : new static_document(this.task_url);
}
task_object.prototype = {
	done : function() {
		if (!this.doc.done()) {
			if (this.uses_browser && this.doc.interval() > HTTP_TIMEOUT	&& !this.doc.reload()) // 浏览模式下可能会卡住，需要刷新页面
			{
				this.doc.close();
				return true;
			}
			return false;
		}

		var tree = this.doc.get_tree();
		if (tree != null) {
			if (this.category == 0) {
				var res = this.find_category(tree);
				if (res != null) {
					this.category = res.id;
				}
			}

			var error_code = 0;
			if (this.page_is_list) {
				error_code = this.process_item_list(tree);
				if (error_code == 0 && this.goto_nextpage(tree)) {
					return false;
				}
			} else {
				error_code = this.process_item_detail(tree);
			}

			var states;
			if (error_code == 0) {
				if (this.page_is_list){
					states = this.state + 2;
				}else{
					states = this.state + 1;
				}
			} else {
				states = error_code;
			}
			_dba.set_task_state(this.id, states, external.now_sec());
		}
		this.doc.close();
		return true;
	},

	goto_nextpage : function(tree) {
		var nextp = this.find_nextpage(tree);
		if (nextp == null) {
			return false;
		}
		if (this.uses_browser) {
			return this.doc.click(nextp); // 浏览模式
		}
		var new_url = external.complete_url(tree.base_url, nextp.url); // 拼成完整URL
		if (new_url.length < 20) {
			return false;
		}
		return this.doc.go(new_url);// 静态模式
	},

	find_nextpage : function(tree) {
		var res = tree.match(this.patten, REG_NAME_NEXTPAGE);
		if (res == null){
			return null;
		}
		return res.nextpage;
	},

	find_category : function(tree) {
		return tree.match(this.patten, REG_NAME_CATEGORY);
	},

	// 处理商品列表页，返回错误ID
	process_item_list : function(tree) {
		cj_event({
			id : EVENTID_PAGE_LOAD,
			task : this,
			content : tree
		}); // 事件回调

		var res = tree.match(this.patten, REG_NAME_ITEMS);
		if (res == null) {
			cj_event({
				id : EVENTID_ERROR,
				desc : "列表匹配失败,任务URL:" + this.task_url
			});
			return -1;
		}

		// 新增任务(商品详细页采集)
		var items = res.items;
		if (items == null)
			return 0;

		var task_type = this.task_type + 1;
		var L = items.array_length;
		var i;
		for (i = 0; i < L; i++) {
			var item = items[i];
			if (external.valid_url(item.url)) {
				var item_id = 0;
				if (typeof (item.id) == "string")
					item_id = item.id;
				else if (task_type == TASK_IS_TAOBAO_ITEM)
					item_id = _taobao_parser.parse_itemid(item.url);
				_dba.add_task(item_id, task_type, 1, item.url); // 商品初始状态从1开始
				cj_event({
					id : EVENTID_ADD_TASK,
					url : item.url
				});// 事件回调
			}
		}
		return 0;
	},

	// 处理商品详细页，返回错误ID
	process_item_detail : function(tree) {

		cj_event({
			id : EVENTID_PAGE_LOAD,
			task : this,
			content : tree
		}); // 事件回调

		var res = tree.match(this.patten, REG_NAME_ITEM_DETAIL);
		if (res == null) {
			cj_event({
				id : EVENTID_ERROR,
				desc : "详细页匹配失败,任务URL:" + this.task_url
			});
			return -1;
		}

		var category_list = res.category_list;
		var L = category_list == null ? 0 : category_list.array_length;
		// for (i=0; i < L; i++)
		// {
		// var cate = category_list[i];
		// alert(cate.name + ":" + cate.url);
		// }

		var quantity, price, cate;
		if (this.task_type == TASK_IS_ALIEXPRESS_ITEM) {
			// 速卖通解析
			var script = tree.script;
			quantity = _aliexpress_parser.get_quantity(script);
			price = _aliexpress_parser.get_price(script);
			cate = _aliexpress_parser.get_category(category_list[L - 1].url);
		} else if (this.task_type == TASK_IS_ALIBABA_ITEM) {
			// 阿里巴巴解析
			quantity = parseInt(res.quantity);
			price = res.price;
			cate = _alibaba_parser.get_category(category_list[L - 1].url);
		} else if (this.task_type == TASK_IS_TAOBAO_ITEM) {
			// TAOBAO详细页
			price = res.price;
			quantity = res.quantity;
			cate = 0;
		}
		_dba.add_product(this.item_id, res.name, cate, this.task_url, quantity,	price, tree.keywords, tree.title, tree.description);

		if (this.task_type == TASK_IS_ALIEXPRESS_ITEM) {
			// 获取卖家信息
			res = tree.match(this.patten, REG_NAME_SELLER);
			if (res != null) {
				_dba.add_seller(res.id, res.name, res.url, res.address,
						tree.title, tree.keywords, tree.description);
			}
		} else if (this.task_type == TASK_IS_ALIBABA_ITEM) {
			res = tree.match(this.patten, REG_NAME_SELLER);
			if (res != null) {
				var id_info = res.id_info;
				var offs = id_info.indexOf("company_id=");
				var sellerID = parseInt(id_info.substr(offs + 11));
				var address = "";
				if (res != null) {
					_dba.add_seller(sellerID, res.name, res.url, address,
							tree.title, tree.keywords, tree.description);
				}
			}
		} else if (this.task_type == TASK_IS_TAOBAO_ITEM) {
			// TODO
		}
		return 0;
	}
};

function aliexpress_parser() {
	this.get_quantity = function(s) // 从脚本中获取数量
	{
		var index = s.indexOf("totalAvailQuantity=\"");
		if (index == -1) {
			return 0;
		}
		return parseInt(s.substr(index + 20));
	};
	this.get_price = function(s) // 从脚本中获取价格
	{
		var index = s.indexOf("\"actSkuPrice\":\"");
		if (index == -1) {
			return 0;
		}
		return parseFloat(s.substr(index + 15));
	};
	this.get_category = function(url) // 从URL中获取分类ID
	{
		var index = url.indexOf("/category/");
		if (index == -1) {
			return 0;
		}
		return parseInt(url.substr(index + 10));
	};
}

function alibaba_parser() {
	this.get_category = function(url) {
		var index = url.indexOf("_pid");
		if (index == -1) {
			return 0;
		}
		return parseInt(url.substr(index + 4));
	};
}

function taobao_parser() {
	this.parse_itemid = function(url) // 通过URL获取商品ID，在列表页中
	{
		var index = url.indexOf("?id=");
		if (index == -1) {
			return 0;
		}
		return parseInt(url.substr(index + 4));
	};
}

// 载入模板，参数file可以是本地文件，也可以是HTTP URL
function load_patten(patten, file) {
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

function cj_object() {
	this.running = true;
	this.task = null;
	this.pattens = new Array();
}
cj_object.prototype = {
	on_timer : function() {
		if (this.running) { // 暂停？
			if (this.task == null) {
				this.run_next();
			} else if (this.task.done()) {
				this.task = null;
			}
		}
	},
	reset : function() {
		this.task = null; // 取消当前任务
	},
	run_next : function() { // 取下一个任务
		var now_second = external.now_sec();
		var row = _dba.get_next_task(now_second);
		if (null == row)
			return;

		var patten = this.get_patten(row.task_type);
		if (patten == null)
			return;

		this.task = new task_object(row, patten);
	},
	get_patten : function(task_type) { // 根据任务类型返回模板对象
		var name = null;
		if (task_type == TASK_IS_ALIEXPRESS_LIST || task_type == TASK_IS_ALIEXPRESS_ITEM) {
			name = "http://soe.freeoa.cc/cpanel/index.php?route=common/api/patten&f=aliexpress";
		} else if (task_type == TASK_IS_ALIBABA_LIST || task_type == TASK_IS_ALIBABA_ITEM) {
			name = "http://soe.freeoa.cc/cpanel/index.php?route=common/api/patten&f=alibaba";
		} else if (task_type == TASK_IS_TAOBAO_LIST	|| task_type == TASK_IS_TAOBAO_ITEM) {
			name = "http://soe.freeoa.cc/cpanel/index.php?route=common/api/patten&f=taobao";
		} else {
			return null;
		}
		if (typeof (this.pattens[name]) == "object") {
			return this.pattens[name];
		}
		var patten = external.new_patten();
		if (!load_patten(patten, name)) {
			cj_event({
				id : EVENTID_ERROR,
				desc : "模板(" + name + ")载入失败:" + patten.last_error
			});
			patten = null;
			return null;
		}
		this.pattens[name] = patten;
		return patten;
	}
};

// 静态页文档对象
function static_document(url) {
	this.stream = null;
	this.url = url;
	this.tick = 0;
}
static_document.prototype = {

	done : function() // 返回是否完成 (或失败)
	{
		var now = external.now_msec();
		if (this.stream == null) {
			this.stream = external.http_get(this.url, 0); // 异步
			if (this.stream == null)
				return true;
			this.tick = now;
			return false;
		}
		if (this.stream.status != 0) {
			var status = this.stream.status;
			if (status >= 300 && status < 310)
				return false; // 重定向

			if (status != 200) // 下载失败了
			{
				this.stream.close();
				this.stream = null;
			}
			return true;
		}
		if (now - this.tick < HTTP_TIMEOUT) {
			return false;
		}
		this.stream.close();
		this.stream = null;
		return true;
	},

	get_tree : function() {
		if (this.stream == null)
			return null;

		return this.stream.html_parse();
	},

	close : function() {
		if (this.stream != null) {
			this.stream.close();
			this.stream = null;
		}
	},

	go : function(url) {
		this.close();
		this.url = url;
		return true;
	}
};

// 浏览器文档对象
function browser_document(url) {
	this.status = 0; // 页面状态: 0=closed 1=loading 2=scroll 3=done 4=fail
	this.scroll_pos = 0;// 滚动条位置，用于判断是否滑到底部(即完全载入)
	this.doc_cy = 0; // 文档高度
	this.url = url;
	this.wnd = external.get_window(1); // 有9个窗口可供使用 [1-9]
	this.tick = 0;
	this.reload_count = 0;
}
browser_document.prototype = {
	done : function() {
		if (this.status >= 3)
			return true; // 完全载入或失败了

		var now_tick = external.now_msec(); // 当前时刻（毫秒)

		if (this.status == 0) {
			if (!this.wnd.open(this.url)) {
				this.status = 4;
				return true;
			}
			this.status = 1; // 状态切换到"loading"
			this.tick = now_tick;
			this.wnd.show("show");
			return false;
		}

		if (this.wnd.isClosed) {
			this.status = 0;
			return true; // 窗口被人为关闭了?
		}

		var doc = this.wnd.document;
		if (doc == null) {
			if (this.status == 1)
				return false;
			this.status = 4; // 文档载入后又丢失了？
			return true;
		}

		if (this.status == 1) {
			if (doc.body == null)
				return false; // 载入中...

			if (this.doc_cy != 0) {
				// 点击页面上按钮或链接后产生的刷新，需要根据文档高度是否变化来判断是否载入
				if (this.doc_cy == doc.height)
					return false;
			}
			this.status = 2;
			this.url = doc.url;
			this.scroll_pos = 0;
			this.tick = now_tick;
			return false;
		}

		if (this.status == 2) {
			var cy = doc.height;
			if (this.scroll_pos < cy) {
				var move = cy >> 3;
				if (move < 500)
					move = 500;
				this.scroll_pos += move;
				doc.scroll(0, this.scroll_pos);
				this.tick = now_tick;
				return false; // 继续滑动
			}
			if (cy == 0 || now_tick - this.tick < 900) {
				return false; // 未稳定
			}
			// 滑到底部，完全载入了？
			this.doc_cy = cy;
			this.tick = now_tick;
			this.status = 3;
			return true;
		}
		return true;
	},

	get_tree : function() {
		var doc = this.wnd.document;
		if (doc == null)
			return null;
		return doc.node_tree();
	},

	click : function(elem) {
		if (this.wnd == null || this.wnd.isClosed)
			return false;

		var doc = this.wnd.document;
		if (doc == null)
			return false;

		var cy = doc.height;
		if (cy == 0)
			return false;

		this.doc_cy = cy;
		this.tick = external.now_msec();
		this.status = 1;
		elem.click();
		return true;
	},
	close : function() {
		this.wnd.close();
		this.status = 0;
	},

	interval : function() { // 返回页面停顿的时长（毫秒）
		return external.now_msec() - this.tick;
	},

	reload : function() { // 刷新
		if (this.reload_count > 1)
			return false;

		this.tick = external.now_msec();
		this.reload_count++;
		this.wnd.refresh();
		return true;
	}
};

cj_init();
