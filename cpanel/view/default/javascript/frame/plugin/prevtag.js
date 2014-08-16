/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object  上滑动小标签插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	var PreviousChangeStatus;
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECPreviousTag',
			'PlugName':'上滑动小标签插件',
			'PlugAbout':'点击向上滑动标签列表，属于小标签插件。',
			'Sort':'MinTag',
			'Version':'1.14.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},

		'_IECExtendInitialConfig':function ()
		{
			if (window._IECTag)
			{
				var PreviousItem = _IECTag.IECTabObject.GetMin('Previous');
				PreviousItem.span.onmouseover = function ()
				{
					if(this.id != 'PreviousLock')
						this.id = 'PreviousHover';
				}
				PreviousItem.span.onmouseout = function ()
				{
					if(this.id != 'PreviousLock')
						this.id = 'Previous';
				}

				// 改变状态
				PreviousChangeStatus = function ()
				{
					var TabListMarginLeft = parseInt(getStyle(_IECTag.IECTabObject.TabList,'margin-left').replace('px',''));
					PreviousItem.span.id = (TabListMarginLeft < 0) ? 'Previous' : 'PreviousLock';
				}

				PreviousChangeStatus();
				// 扩展中键上下滑动响应事件
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						PreviousChangeStatus();
					}, ['PreAction','NextAction']
				);

				// 增加标签也同样响应
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						PreviousChangeStatus();
					}, 'add'
				);
	 
			}
		},
		
		// 小标签项
		'_IECTabMinJson':[{
			'order':8,
			'id':'Previous', 
			'name':'向下滑动',
			'action':function ()
			{
				// 点击也改状态
				PreviousChangeStatus();
				if(window.NextChangeStatus) NextChangeStatus();
				_IECTag.IECTabObject.PreAction();
			}
		}]

	});

	

}
