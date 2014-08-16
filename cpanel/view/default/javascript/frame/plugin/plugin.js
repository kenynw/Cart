/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object  管理插件的插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	var IECPluginManageTempData = [];
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECPluginManage',
			'PlugName':'插件管理',
			'PlugAbout':'管理查看您系统已安装的插件，随时关闭或开启插件。Notice:保证插件能拥有最高的管理权限请第一个引用本插件。',
			'Sort':'Menu',
			'Version':'1.4.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},

		'_IECExtendControllerConfig':function ()
		{
			if (window._IECTag)
			{
				if(Cookies.get('IECPluginManage') == null ) 
				{
					var exp = new Date();
					exp.setTime(exp.getTime()*1.1);
					Cookies.set('IECPluginManage', ' ', exp, '/');
				}

				// Copy data
				for (var k in IECMainObject.IECExtend )
					IECPluginManageTempData[k] = IECMainObject.IECExtend[k];

				// 清空Deactivate插件数据
				for (var k in IECMainObject.IECExtend )
				{
					if(Cookies.get('IECPluginManage').indexOf('|' + IECMainObject.IECExtend[k]._ExtendInfo.ExtendId + '|') != -1)
						IECMainObject.IECExtend[k] = [];
				}
			}
		},

		'_IECLNIJson':[{
			'order':5,
			'id':'PlugIEC', 
			'name':'系统插件管理',
			'PlugIn':true,
			'url':'/cpanel/view/default/javascript/frame/plugin/plugin.js'
		}]

	});
}

// ************************** 标签打开后运行 **************************

if(window.ExtendContent)
{
	var IECTagWindow = parent.parent.window.frames.IECTag;
	var IECParentWindow = parent.window;
	var IECRootWindow = parent.parent.window;

	// 创建子条项
	var CreateItem = function (Item)
	{
		if(!Item) return;
		var div = C('div', {'className':'item','href':'javascript:'});
		div.PlugName = C('h3', 'In', Item.ExtendId + '<i>' + Item.Version + '<font>' + Item.Sort + ' ' + Item.Date + '</font></i>');
		div.PlugAbout = C('p', 'In', Item.PlugName + ': ' + Item.PlugAbout);
		div.WebSite = C('em', 'In', Item.WebSite);
		div.WebSite.onclick = function ()
		{
			IECRootWindow.OpenWindow('Activate', Item.ExtendId, Item.PoweredBy, Item.WebSite);
		}
		div.PoweredBy = C('i', 'In', 'Powered By:' + Item.PoweredBy);

		div.button = C('a', {'id':'Deactivate', 'className':'button','href':'javascript:'});
		div.button.PlugCookie = IECRootWindow.Cookies.get('IECPluginManage').indexOf(Item.ExtendId) == -1 ? null:1;
		C(div.button, {'innerHTML': (div.button.PlugCookie == null) ? 'Deactivate' : 'Activate'});
		div.button.onclick = function ()
		{
			var exp = new Date();
			exp.setTime(exp.getTime()*1.1);
			if(this.PlugCookie == null)
			{
				this.innerHTML = 'Activate';
				this.PlugCookie = 1;
				IECRootWindow.Cookies.set('IECPluginManage', IECRootWindow.Cookies.get('IECPluginManage') + '|' + Item.ExtendId + '|', exp, '/');
			}
			else
			{
				this.innerHTML = 'Deactivate';
				this.PlugCookie = null;
				var exp = new Date();
				exp.setTime(exp.getTime()*1.1);
				IECRootWindow.Cookies.set('IECPluginManage', IECRootWindow.Cookies.get('IECPluginManage').replace('|' + Item.ExtendId + '|', '') , exp, '/');
			}
		}

		div.onmouseover = function ()
		{
			this.className = 'item_hover';
		}
		div.onmouseout = function ()
		{
			this.className = 'item';
		}

		if(Item.ExtendId == 'IECPluginManage') div.button = C('u');
		return C(div, 'In', [div.PlugName, div.PlugAbout, div.PoweredBy, div.WebSite, div.button]);
	}

	var GoShow = function ()
	{
		this.IECPlugList = C('div', {'id':'IECPlugList','className':'_c'});
		this.SumDiv = null;
		this.TempPlug = [];
		this.TempPlugItem = [];
		this.ItemSum = 0;

		for (var key in IECRootWindow.IECPluginManageTempData)
		{
			this.TempPlug[key] = [IECRootWindow.IECPluginManageTempData[key].Sort, IECRootWindow.IECPluginManageTempData[key]._ExtendInfo];	// 存临时数组
		}
		// 排序
		this.TempPlug.sort();

		for (key in this.TempPlug )
		{
			++this.ItemSum;

			var k = this.TempPlugItem.length;
			var Item = CreateItem(this.TempPlug[key][1]);
			if(Item)
			{
				this.TempPlugItem[k] = Item;
				this.IECPlugList.appendChild(this.TempPlugItem[k]);		// 增加至列表
			}
		}
		
		this.SumDiv = C('DIV', {'className':'SumDiv'});
		C(this.SumDiv, 'In', [C('font','In','总共有: '),C('B', 'In', this.ItemSum),C('font','In','个插件。<b>Notice:</b>设置后重新载入系统才生效。')]);

		document.body.innerHTML = '';
		C(document.body, 'In', [
			C('link',{'type':'text/css','rel':'stylesheet','href':'default/stylesheet/plugin.css'}),
			C('h1','In', '系统插件管理'),
			this.IECPlugList, this.SumDiv
		]);
	}

	document.body.innerHTML = '<div id="LoadingBlock">&nbsp; Loading...<div id="loading"></div></div>';
	setTimeout(
		function () {
				var GoShowObject = new GoShow();
		}, 50
	);
}