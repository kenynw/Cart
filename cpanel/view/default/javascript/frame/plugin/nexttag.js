/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object 下滑动小标签插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	var NextChangeStatus;
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECNextTag',
			'PlugName':'下滑动小标签插件',
			'PlugAbout':'点击向下滑动标签列表，属于小标签插件。',
			'Sort':'MinTag',
			'Version':'1.4.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},
		
		'_IECExtendInitialConfig':function ()
		{
			if (window._IECTag)
			{
				var NextItem = _IECTag.IECTabObject.GetMin('Next');
				NextItem.span.onmouseover = function ()
				{
					if(this.id != 'NextLock')
						this.id = 'NextHover';
				}
				NextItem.span.onmouseout = function ()
				{
					if(this.id != 'NextLock')
						this.id = 'Next';
				}

				// 改变状态
				NextChangeStatus = function ()
				{
					var TabListMarginLeft = parseInt(getStyle(_IECTag.IECTabObject.TabList,'margin-left').replace('px',''));
					if ((TabListMarginLeft - _IECTag.IECTabObject.TagUndulateValue*3) * -1 < _IECTag.IECTabObject.AllTagWidthSum && _IECTag.IECTabObject.AllTagWidthSum > _IECTag.IECTabObject.ShowBlockWidth - _IECTag.IECTabObject.ShowBlockWidthDiffer)
						NextItem.span.id = 'Next';
					else
						NextItem.span.id = 'NextLock';
				}

				NextChangeStatus();
				// 扩展中键上下滑动响应事件
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						NextChangeStatus();
					}, ['PreAction','NextAction']
				);

				// 增加标签也同样响应
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						NextChangeStatus();
					}, 'add'
				);
			}
		},
		
		// 小标签项
		'_IECTabMinJson':[{
			'order':7,
			'id':'Next', 
			'name':'向下滑动',
			'action':function ()
			{
				// 点击也改状态
				NextChangeStatus();
				if(window.PreviousChangeStatus) PreviousChangeStatus();
				_IECTag.IECTabObject.NextAction();
			}
		}]

	});

	

}
