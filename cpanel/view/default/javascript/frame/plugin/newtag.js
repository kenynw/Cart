/************************************************
 *
 * IEC
 * 
 * @copyright IeCart.Net
 * @license http://www.iecart.net/license/
 * @version 1.4.1
 * 
 * @param Object 新建窗口插件
 *
 */

if(window.IECMainObject)
{
	IECMainObject.IECExtend.push({
		'_ExtendInfo':{
			'ExtendId':'IECNewTag',
			'PlugName':'新建窗口插件',
			'PlugAbout':'新建一个窗口打开网站。',
			'Sort':'Menu',
			'Version':'1.4.1',
			'Date':'2014-01-01',
			'WebSite':'http://www.iecart.net',
			'PoweredBy':'IEC'
		},
		
		'_IECLNIJson':[{
			'order':1,
			'id':'NewTag', 
			'name':'新建标签窗口', 
			'PlugIn':true,
			'action':function ()
			{
				_IECLeft.IECLNO.get('NewTag').TagId = 'New-' + parseInt(1000*Math.random());
				return true;
			},
			'url':'/cpanel/view/default/javascript/frame/plugin/newtag.js'
		}]

	});

}

if(window.ExtendContent)
{

	var IECTagWindow = parent.parent.window.frames.IECTag;
	var IECParentWindow = parent.window;


	var GoShow = function ()
	{

		this.IECNewTag = C('div', {'id':'IECNewTag'});
		this.txt = C('div', 'In', 'Input Url OR Keyword:<br />');
		this.form = C('form', {'method':'GET','action':''});
		this.inputs = C('input', {'type':'text','className':'input','value':''});
		this.submits = C('input', {'type':'submit','value':' Go ','className':'button'});

		(function (o)
		{
			o.form.onsubmit = function ()
			{
				var url = o.inputs.value;
				if(url.indexOf('http') != 0) url = 'http://www.baidu.com/s?wd='+url+'&rsp=0&oq=IEC&f=1&rsv_ers=xn1&rs_src=0';
				var NowContent = IECParentWindow.IECContentObject.LastClickItem;	// 当前内容项
				NowContent.command = url;
				NowContent.src = url;
				IECParentWindow.IECContentObject.LoadAction(NowContent, false);	// 重载入
				return false;
			}
		})(this)

		document.body.innerHTML = '';
		C(this.form, 'In', [this.txt, this.inputs, this.submits]);
		C(this.IECNewTag, 'In', this.form);
		C(document.body, 'In', [
			C('link',{'type':'text/css','rel':'stylesheet','href':'default/stylesheet/newtag.css'}),
			this.IECNewTag
		]);

		document.body.focus();	// ie6
		this.inputs.focus();
	}

	document.body.innerHTML = '<div id="LoadingBlock">&nbsp; Loading...<div id="loading"></div></div>';
	setTimeout(
		function () {
				var GoShowObject = new GoShow();
		}, 0
	);

}