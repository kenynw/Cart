/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * @param Object 全部标签列表插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECAllTag',
			'PlugName':'全部标签列表插件',
			'PlugAbout':'排序统计显示您已打开的标签，方便您查看与关闭。',
			'Sort':'Menu',
			'Version':'1.4.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},

		'_IECExtendInitialConfig':function ()
		{
			if (window._IECTag)
			{
				var ShowItem = _IECTag.IECTabObject.GetMin('IECAllShow');
				ShowItem.span.onmouseover = function ()
				{
					this.id = 'ShowHover';
				}
				ShowItem.span.onmouseout = function ()
				{
					this.id = 'IECAllShow';
				}
			}
		},

		'_IECTabMinJson':[{
			'order':9,
			'id':'IECAllShow', 
			'name':'所有标签列表',
			'PlugIn':true,
			'url':'/cpanel/view/default/javascript/frame/plugin/alltag.js'
		}],

		'_IECLNIJson':[{
			'order':3,
			'id':'IECAllShow', 
			'name':'所有标签列表',
			'PlugIn':true,
			'url':'/cpanel/view/default/javascript/frame/plugin/alltag.js'
		}]

	});
}

// ************************** 标签打开后运行 **************************

if(window.ExtendContent)
{
	var IECTagWindow = parent.parent.window.frames.IECTag;
	var IECParentWindow = parent.window;

	// 创建子条项
	var CreateItem = function (Item)
	{
		var DIV = C('DIV', {'className':'item'});
		var A = C('A', {'className':'item_list', 'href':'javascript:;'});

		// 详细位置
		var TagID = '<b>' + Item.id + '</b>';
		var I = C('I', {'innerHTML':TagID + ' &nbsp; - <em>' + Item.command + '</em>'});
		
		// 标题
		var SPAN = C('SPAN', {'innerHTML':Item.text});

		A.appendChild(I);
		A.appendChild(SPAN);

		A.onclick = function ()
		{
			// 我们使用add方法激活 标签是已存在 不会再插入新标签 同时处理标签所在位置
			// IECTagWindow.IECTabObject.TagOnclick(Item);	// 也可以这样激活标签 但不会跳到当前标签位置
			Item.type = 'Activate';
			IECParentWindow.IECContentObject.LoadRefresh = false;	// 不刷新
			IECTagWindow.IECTabObject.add(Item);	// 激活标签
		}
		// *************************************


		// 关闭
		var U = C('u', {'className':'close'});
		var X = C('a', {'className':'ico2 ico_del2','title':'关闭标签', 'innerHTML':'删除'});
		X.href = 'javascript:;';
		X.onclick = function ()
		{

			var RunClick = true;	// 是否关闭时 同时执行点击事件 更新标签 
			IECTagWindow.IECTabObject.GoLocation(false, IECTagWindow.IECTabObject.LastClickItem.TagListKey);			// 位置
			IECTagWindow.IECTabObject.CloseTagFun(Item, RunClick);				// 关闭标签

			var GoShowObject = new GoShow();	// 删除后key都变了。重新来一次吧~
			
			// IECTagList.removeChild(DIV);
			// --ItemSum;
			// GoShowObject.ItemSumB.innerHTML = ItemSum;
		}
		U.appendChild(X);
		// *************************************

		DIV.appendChild(A);
		if(Item.id != IECTagWindow.IECTabObject.NumberOneId ) 
			DIV.appendChild(U);		// 第一个标签不显示关闭
		return DIV;
	}

	var GoShow = function ()
	{
		this.IECTagList = C('div', {'id':'IECTagList'});
		this.ItemSumB = null;
		this.SumDiv = null;
		this.TempTag = new Array();
		this.ItemSum = 0;

		this.IECTagList.innerHTML = '';

		for (key in IECTagWindow.IECTabObject.Item)
		{
			this.TempTag[key] = [IECTagWindow.IECTabObject.Item[key].id, key];	// 存临时数组
		}
		// 排序
		this.TempTag.sort();

		for (key in this.TempTag )
		{
			++this.ItemSum;
			// 增加至列表
			this.IECTagList.appendChild(CreateItem(IECTagWindow.IECTabObject.Item[this.TempTag[key][1]]));
		}
		
		this.SumDiv = C('DIV');
		this.ItemSumB = C('B');
		this.ItemSumB.innerHTML = this.ItemSum;

		SumText = document.createTextNode('总共有: ');
		SumText2 = document.createTextNode(' 个标签。');
		this.SumDiv.className = 'SumDiv';
		this.SumDiv.appendChild(SumText);
		this.SumDiv.appendChild(this.ItemSumB);
		this.SumDiv.appendChild(SumText2);

		this.IECTagList.appendChild(this.SumDiv);
		document.body.innerHTML = '';
		C(document.body, 'In', [
			C('link',{'type':'text/css','rel':'stylesheet','href':'default/stylesheet/alltag.css'}),
			C('h1','In', '全部标签列表'), 
			this.IECTagList]
		);
	}

	document.body.innerHTML = '<div id="LoadingBlock">&nbsp; Loading...<div id="loading"></div></div>';
	setTimeout(
		function () {
				var GoShowObject = new GoShow();
		}, 50
	);
}