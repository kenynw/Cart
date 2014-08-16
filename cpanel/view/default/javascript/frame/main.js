/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param  系统主进程
 * 
 * ------------------------------- 
 * IECMain控制整个系统的运行流程
 * 系统加载完成后执行IECRun开启进程，总体运行步骤如下：
 * 
 * 1) IECExtendControllerConfigRun:	首要执行，为总控制器，可控制系统所有的运行模块。
 * 2) IECPluginRun:					加载用户自定义插件数据。
 * 3) IECContentRun:					系统内容模块运行。
 * 4) IECTagRun:						系统标签模块运行。
 * 5) IECLeftRun:					系统左栏模块运行。
 * 6) IECExtendInitialConfigRun:		扩展运行，执行到这一步所有模块都运行完成了。用于扩展各模块初始化事件。
 *
 */

var IECMain = function ()
{
	this.IECExtend = [];				// 所有扩展数据
	this.IECLoadComplete = false;

	// 总运行进程
	this.IECRun = function ()
	{
		if(!_IECContent || !_IECTag || !_IECLeft) return;

		this.IECExtendControllerConfigRun();
		this.IECPluginRun();
		this.IECContentRun();
		this.IECTagRun();
		this.IECLeftRun();
		this.IECExtendInitialConfigRun();
		this.IECLoadComplete = true;
	}

	// 系统总控制器配置运行
	this.IECExtendControllerConfigRun = function ()
	{
		for (var k in this.IECExtend )
		{
			if(this.IECExtend[k]._IECExtendControllerConfig)
				this.IECExtend[k]._IECExtendControllerConfig();
		}
	}

	// 插件分析加载
	this.IECPluginRun = function ()
	{
		for (var k in this.IECExtend )
		{
			// 小标签插件加载
			if(this.IECExtend[k]._IECTabMinJson)
			{
				for (var m in this.IECExtend[k]._IECTabMinJson)
					_IECTabMinJson.push(this.IECExtend[k]._IECTabMinJson[m]);
			}
			// 左栏菜单插件加载
			if(this.IECExtend[k]._IECLNIJson)
			{
				for (var m in this.IECExtend[k]._IECLNIJson)
					_IECLNIJson.push(this.IECExtend[k]._IECLNIJson[m]);
			}
		}
	}

	// 内容运行
	this.IECContentRun = function ()
	{
		_IECContent.IECContentObject.run();
	}

	// 标签运行
	this.IECTagRun = function ()
	{
		_IECTag.IECTabObject.adds(_IECTabJson);
		_IECTag.IECTabObject.AddMins(_IECTabMinJson);
		_IECTag.IECTabObject.run();
	}

	// 左栏运行
	this.IECLeftRun = function ()
	{
		_IECLeft.IECLNO.add(_IECLNIJson);
		_IECLeft.IECLNO.run();

		_IECLeft.IECLeftList.add(_IECLeftListJson);
		_IECLeft.IECLeftList.run();
	}

	// 扩展配置运行
	this.IECExtendInitialConfigRun = function ()
	{
		// 清空配置重新加载
		_IECContent.IECContentObjectExtendObject = [];
		_IECTag.IECTabObject.ExtendObject = [];
		_IECLeft.IECLeftList.ExtendObject = [];

		for (var k in this.IECExtend )
		{
			if(this.IECExtend[k]._IECExtendInitialConfig)
				this.IECExtend[k]._IECExtendInitialConfig();
		}
	}
}

var IECMainObject = new IECMain();
