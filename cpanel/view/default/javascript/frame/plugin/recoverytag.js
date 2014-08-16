/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * @param Object IECRecoveryTag 恢复窗口插件
 *
 */

// ************************** 预设函数与配置 **************************

if(window.IECMainObject)
{
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECRecoveryTag',
			'PlugName':'恢复窗口插件',
			'PlugAbout':'恢复您最后关闭的标签。',
			'Sort':'Menu',
			'Version':'1.4.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},

		'_IECExtendInitialConfig':function ()
		{
			if(window._IECLeft && window._IECTag)
			{
				_IECLeft.IECLNO.get('RecoveryTag').A.B.style.color = '#D2D2D2';	// 默认链接是灰色
					
				// 扩展关闭标签函数，关闭时连接恢复原颜色
				_IECTag.IECTabObject.extend(
					function ()
					{	
						if(_IECTag.IECTabObject.CloseTagItem.id != 'RecoveryTag')
							_IECLeft.IECLNO.get('RecoveryTag').A.B.style.color = '';
					}, 'CloseTagFun'
				);
			}
		},

			// 配置参数
		'_IECLNIJson':[{
			'order':2,
			'id':'RecoveryTag',
			'name':'恢复关闭的窗口', 
			'PlugIn':true,
			'action':function ()
			{
				if(!_IECTag.IECTabObject.CloseTagItem.id || _IECTag.IECTabObject.CloseTagItem.id == 'RecoveryTag') // 没有关闭标签就返回
				{
					_IECLeft.IECLNO.LeftNavigationDom.style.display = 'block';	// 不关闭下拉菜单
					_IECTag.IECTabObject.New.id = 'NewUp';
					return false;
				}
				return true;
			},
			'url':'/cpanel/view/default/javascript/frame/plugin/recoverytag.js'
		}]

	});

}


// ************************** 标签打开后运行 **************************
if(window.ExtendContent)
{
	var IECTagWindow = parent.parent.window.frames.IECTag;
	var IECLeftWindow = parent.parent.window.frames.IECLeft;
	var IECRootWindow = parent.parent.window;

	var GoShow = function ()
	{
		var CloseTag = IECTagWindow.IECTabObject.CloseTagItem;								// 最后关闭标签项
		var NowTag = IECTagWindow.IECTabObject.LastClickItem;									// 当前标签项

		IECLeftWindow.IECLNO.get('RecoveryTag').A.B.style.color = '#D2D2D2';					// 连接变灰色
		if(CloseTag.id)
			IECRootWindow.OpenWindow('Activate', CloseTag.id, CloseTag.text, CloseTag.command);	// 打开之前关闭的标签
		IECTagWindow.IECTabObject.CloseTagFun(NowTag, true);									// 关闭当前标签

		return;
	}

	document.body.innerHTML = '<div id="LoadingBlock">&nbsp; Loading...<div id="loading"></div></div>';
	setTimeout(
		function () {
				var GoShowObject = new GoShow();
		}, 0
	);
}