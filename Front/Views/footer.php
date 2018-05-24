<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>

       <div class="clear">
</div>
<div class="links">
    <select class="linksSelect1 linkDown">
        <option value="">母公司</option>
               <option value="http://www.gdrising.com.cn/"> 广东省广晟资产经营有限公司</option>
    
    </select>
    <select class="linksSelect2 linkDown">
        <option value="">子公司</option>
                <option value="http://www.cnieg.com/">广东广晟有色金属进出口有限公司</option>
            <option value="http://">平远县华企稀土实业有限公司</option>
            <option value="http://">大埔县新诚基工贸有限公司</option>
            <option value="http://">广东富远稀土新材料股份有限公司</option>
            <option value="http://">广东广晟智威稀土新材料有限公司</option>
            <option value="http://">龙南县和利稀土冶炼有限公司</option>
            <option value="http://">江西广晟稀土有限责任公司</option>
            <option value="http://">河源市广晟稀土高新材料有限公司</option>
            <option value="http://">河源市广晟矿业贸易有限公司</option>
            <option value="http://">新丰广晟稀土开发有限公司</option>
            <option value="http://">新丰县广晟稀土高新材料有限公司</option>
            <option value="http://">韶关棉土窝矿业有限公司</option>
            <option value="http://">韶关石人嶂矿业有限责任公司</option>
            <option value="http://">韶关梅子窝矿业有限责任公司</option>
            <option value="http://">广东韶关瑶岭矿业有限公司</option>
            <option value="http://">翁源红岭矿业有限责任公司</option>
            <option value="http://">广州晟晖财务咨询有限公司</option>
            <option value="http://">清远市嘉禾稀有金属有限公司</option>
            <option value="http://">德庆兴邦稀土新材料有限公司</option>
            <option value="http://">广东省南方稀土储备供应链管理有限公司</option>
    
    </select>
    <select class="linksSelect3 linkDown">
        <option value="">稀土行业</option>
                <option value="http://www.cre.net/ ">中国稀土网</option>
            <option value="http://www.cre-ol.com/">中国稀土在线</option>
            <option value="http://www.cnmn.com.cn/">中国有色网</option>
            <option value="http://www.cre.net/xtcxlm/index.htm">稀土产业技术创新战略联盟</option>
    
    </select>
    <select class="linksSelect4 linkDown">
        <option value="">政策监管</option>
                <option value="http://www.gdlr.gov.cn/ ">广东省国土资源厅</option>
            <option value="http://www.sasac.gov.cn/n1180/index.html">国务院国资委</option>
            <option value="http://www.csrc.gov.cn/pub/newsite/">中国证券监督管理委员会</option>
            <option value="http://www.sse.com.cn/sseportal/ps/zhs/home.html">上海证券交易所</option>
    
    </select>
</div>

<script type="text/javascript">
    $(".linkDown").change(function() {
        var url = $(this).val();
        if (url != "")
            window.open(url);
    });
</script>


        <div class="bottom">
    <div class="bottomNav">
        <script src="./pubilc/stat.php" language="JavaScript"></script><script src="./pubilc/core.php" charset="utf-8" type="text/javascript"></script><a href="http://www.cnzz.com/stat/website.php?web_id=4636764" target="_blank" title="站长统计">站长统计</a>|<a href="/wzdt/1614.html">网站地图</a>
        |<a href="/flsm/1615.html">法律申明</a>|<a href="/yqlj/list_1616.html">友情连接</a>|
        <a href="/zb/1611.html">联系我们</a>
    </div>
    <p class="copyright">
        版权所有 <font>©</font> 2012 广晟有色金属股份有限公司&nbsp;&nbsp;保留所有权利&nbsp;&nbsp;&nbsp;&nbsp;琼ICP备12002900号</p>
    <p class="design">
        Designed by <a href="http://www.wanhu.com.cn/">Wanhu</a>.<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1253041749'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/z_stat.php%3Fid%3D1253041749%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script><span id="cnzz_stat_icon_1253041749"><a href="http://www.cnzz.com/stat/website.php?web_id=1253041749" target="_blank" title="站长统计"><img border="0" hspace="0" vspace="0" src="./pubilc/pic.gif"></a></span><script src="./pubilc/z_stat.php" type="text/javascript"></script><script src="./pubilc/core.php(1)" charset="utf-8" type="text/javascript"></script></p>
        
</div>

<script type="text/javascript">
    $.each($("img"), function(i, n) { $(n).error(function() { n.src = 'images/nopic.gif'; }); n.src = n.src; })
</script>
</div>
<script type="text/javascript">

var xPos = 0;var yPos = 0; var step = 1;var delay = 30;var height = 0; var Hoffset = 0;var Woffset = 0; var yon = 0;var xon = 0; var xon = 0; var interval;
var imgWindow = document.getElementById('img');
img.style.top = 0;
var interval;
function changePos(){
	width = document.body.clientWidth;
	height = document.documentElement.clientHeight;
	Hoffset = imgWindow.offsetHeight;
	Woffset = imgWindow.offsetWidth;
	imgWindow.style.left = xPos + document.body.scrollLeft + "px";
	imgWindow.style.top = yPos + document.body.scrollTop + "px";
	if (yon) {
		yPos = yPos + step;
	
	}else {
		yPos = yPos - step;
	}
	if (yPos < 0) {
		yon = 1;
		yPos = 0;
	}
	if (yPos >= (height - Hoffset)) {
	yon = 0;
	yPos = (height - Hoffset);
	}
	if (xon) {
	xPos = xPos + step;
	}
	else {
	xPos = xPos - step;
	}
	if (xPos < 0) {
	xon = 1;
	xPos = 0;
	}
	if (xPos >= (width - Woffset)) {
	xon = 0;
	xPos = (width - Woffset);
	}
}
function start() {
imgWindow.visibility = 'visible';
interval = setInterval('changePos()', delay);
}
function mystop()
{
	clearInterval(interval);
}
function closead(){
	clearInterval(interval);
	imgWindow.style.display = "none";
	return false;
}
start();

</script>  


        <div class="clear"></div>
    </div>
</div>


<script type="text/javascript" src="./pubilc/jquery.global.view.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
	  $("#float>p").floatView();	
  });
</script>
<div style="position: static; width: 0px; height: 0px; border: none; padding: 0px; margin: 0px;"><div id="trans-tooltip"><div id="tip-left-top" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-left-top.png&quot;);"></div><div id="tip-top" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-top.png&quot;) repeat-x;"></div><div id="tip-right-top" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-right-top.png&quot;);"></div><div id="tip-right" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-right.png&quot;) repeat-y;"></div><div id="tip-right-bottom" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-right-bottom.png&quot;);"></div><div id="tip-bottom" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-bottom.png&quot;) repeat-x;"></div><div id="tip-left-bottom" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-left-bottom.png&quot;);"></div><div id="tip-left" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-left.png&quot;);"></div><div id="trans-content"></div></div><div id="tip-arrow-bottom" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-arrow-bottom.png&quot;);"></div><div id="tip-arrow-top" style="background: url(&quot;chrome-extension://ikkepelhgbcgmhhmcmpfkjmchccjblkd/imgs/map/tip-arrow-top.png&quot;);"></div></div></body></html>