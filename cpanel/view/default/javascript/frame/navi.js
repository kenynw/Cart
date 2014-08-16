/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object  左栏下拉对象
 *
 */
var IECLNI = function (id, name, command, action)
{
	this.id = id;
	this.command = command;
	this.name = name;
	this.TagId = id;
	this.A = C('A');
	this.A.className = id;
	this.A.B = C('B', {'innerHTML': this.name});
	this.A.href = 'javascript:;';
	C(this.A, 'In', [C('I'), this.A.B]);
	(function (o)
	{
		o.A.onclick = function ()
		{
			parent._IECTag.IECTabObject.New.onclick();
			if(action)
			{
				var ReturnStatus = action();
				if(!ReturnStatus) return;
			}
			if(command) parent.OpenWindow('Activate', o.TagId, o.name, o.command);
		}
	})(this);
	return this;
}

var IECLN = function ()
{
	this.Item = new Array();			// 子项保存数组
	this.LeftNavigationDom = null;		// 左栏DOm
	this.LeftNavigationDiv = null;		// 左栏显示块的DIV

	// 增加子项
	this.add = function (Item)
	{
		if(!parent._IECContent) return;
		var order = [];
		for (var k in Item)
			order.push([Item[k].order, Item[k]]);
		order.sort();
		Item = order;
		for (var k in Item)
		{
			this.Item.push(new IECLNI(Item[k][1].id, Item[k][1].name, Item[k][1].url, Item[k][1].action));
			if (Item[k][1].PlugIn)
				parent._IECContent.IECContentObject.PlugInCommand.push(Item[k][1].url);
				
		}
	}
	// 显示子项
	this.show = function ()
	{
		var status = (this.LeftNavigationDom.style.display == 'none') ? 'block': 'none';
		this.LeftNavigationDom.style.display = status;
 		set_location_top(0);
		IECLeftList.CopyAutoHeight();
	}
	
	// 获得子项
	this.get = function (id)
	{
		for (k in this.Item)
		{
			if(this.Item[k].id == id)
				return this.Item[k];
		}
	}

	// 初始运行
	this.run = function ()
	{
		this.LeftNavigationDom = G('left_navigation');
		this.LeftNavigationDom.style.display = 'none';

		if(Item_sum == 0) return;
		this.LeftNavigationDiv = C('DIV');
		var Item_sum = this.Item.length;
		for (var i = 0; i < Item_sum; i++)
			this.LeftNavigationDiv.appendChild(this.Item[i].A);
		C(this.LeftNavigationDom, 'In', this.LeftNavigationDiv);
	}
}

