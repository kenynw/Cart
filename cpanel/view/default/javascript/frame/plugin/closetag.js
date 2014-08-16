/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object  关闭小标签插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECCloseTag',
			'PlugName':'关闭小标签插件',
			'PlugAbout':'点击关闭当前打开的标签，属于小标签插件。',
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
				var CloseItem = _IECTag.IECTabObject.GetMin('Close');
				CloseItem.span.onmouseover = function ()
				{
					if(this.id != 'CloseLock')
						this.id = 'CloseHover';
				}
				CloseItem.span.onmouseout = function ()
				{
					if(this.id != 'CloseLock')
						this.id = 'Close';
				}
				
				// 改变状态
				var CloseChangeStatus = function ()
				{
					CloseItem.span.id = (_IECTag.IECTabObject.NumberOneId == _IECTag.IECTabObject.LastClickItem.id) ? 'CloseLock' : 'Close';
				}

				CloseChangeStatus();
				// 扩展标签点击响应事件
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						CloseChangeStatus();
					}, 'TagOnclick'
				);

				// 增加标签也同样响应
				_IECTag.IECTabObject.extend(
					function ()
					{	 
						CloseChangeStatus();
					}, 'add'
				);
	 
			}
		},
			
		// 小标签项
		'_IECTabMinJson':[{
			'order':6,
			'id':'Close', 
			'name':'关闭标签',
			'action':function ()
			{
				_IECTag.IECTabObject.GoLocation(false, _IECTag.IECTabObject.LastClickItem.TagListKey - 1);		// 跳到标签位置
				_IECTag.IECTabObject.CloseTagFun(_IECTag.IECTabObject.Item[_IECTag.IECTabObject.LastClickItem.TagListKey], true);		// 关闭标签
			}
		}]

	});
}
