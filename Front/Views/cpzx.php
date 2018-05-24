<?php defined('SYSPATH_ZFC') or die('No direct script access.');?>
<?php  require_once('head.php') ?>
        <div class="sub_title">
                <img src="/pubilc/title_product.png"></div>
            <div class="sidebar">
    <div class="sidebarTitle">
        产品中心</div>
    <ul class="sub">
                <li><a href="javascript:void(0)" id="menuId6" class="aon">稀土产品</a>
            <ul style="display: block;">
                    <li><a href="/cpzx/15/list_1588.html?tid=15&amp;pid=6" id="cid15" class="bon">稀土精矿</a></li>    <li><a href="/cpzx/16/list_1588.html?tid=16&amp;pid=6" id="cid16" class="">稀土氧化物</a></li>    <li><a href="/cpzx/17/list_1588.html?tid=17&amp;pid=6" id="cid17" class="">稀土金属</a></li>    <li><a href="/cpzx/18/list_1588.html?tid=18&amp;pid=6" id="cid18" class="">抛光粉</a></li>    <li><a href="/cpzx/19/list_1588.html?tid=19&amp;pid=6" id="cid19" class="">陶瓷金卤灯</a></li>    <li><a href="/cpzx/20/list_1588.html?tid=20&amp;pid=6" id="cid20" class="">钕铁硼磁性材料</a></li>



            </ul>
        </li>
            <li><a href="javascript:void(0)" id="menuId7" class="">钨产品</a>
            <ul style="display: none;">
                    <li><a href="/cpzx/13/list_1588.html?tid=13&amp;pid=7" id="cid13" class="">黑钨精矿（WO3≥65%）</a></li>    <li><a href="/cpzx/21/list_1588.html?tid=21&amp;pid=7" id="cid21" class="">白钨精矿（WO3≥65%）</a></li>



            </ul>
        </li>
            <li><a href="javascript:void(0)" id="menuId8" class="">其它</a>
            <ul style="display: none;">
                    <li><a href="/cpzx/22/list_1588.html?tid=22&amp;pid=8" id="cid22" class="">铋精矿（Bi≥20%）</a></li>    <li><a href="/cpzx/23/list_1588.html?tid=23&amp;pid=8" id="cid23" class="">钼精矿（Mo≥45%）</a></li>



            </ul>
        </li>
    
    </ul>
    <a href="/zb/1611.html" class="leftContact">
        <img src="/pubilc/contactImg.jpg"></a>
</div>
<script language="javascript" type="text/javascript">
    try {
        document.getElementById("menuId" + menu).className = "aon";
    } catch (ex) { }
</script>
<script type="text/javascript">
    jQuery(".sub li").bind("click", function () {
        jQuery(".sub li").find("a").attr("class", "");
        jQuery(".sub li").find("ul").hide();
        //改变父级，子级
        jQuery(this).find("a").eq(0).attr("class", "aon");
        if (parseInt(cid) > 0) {
            jQuery("#cid" + cid).attr("class", "bon");
        } else {
            //jQuery(this).find("ul>li>a").eq(0).attr("class", "bon");
        }
        jQuery(this).find("ul").show();
    });
    jQuery("#menuId" + menu).click();
</script>

            <div class="mainContain">
                <div class="title">
                    <span>您在这里: <a href="http://www.gsysgf.com/index.html">首页</a> &gt;
                        <a href="/cpzx/15/list_1588.html?tid=15&amp;pid=6">产品中心</a>
                        &gt; <font class="nnames">稀土精矿</font></span>
                    <h3 class="nnames">稀土精矿</h3>
                </div>
                <div id="info">&nbsp;&nbsp;&nbsp; 离子吸附型稀土矿又称风化壳淋积型稀土矿，主要分布在我国江西、广东、湖南、广西、福建等地。该类型矿具有分布地面广，储量大，放射性低，开采容易，提取稀土工艺简单、成本低，产品质量好等特点，是我国优势稀土矿种。矿石多在丘陵地带，为松散的沙黏土，颜色有白色、灰色、红色、黄色。矿山产品为混合氧化稀土，其稀土配分变化很大，有轻稀土型，重稀土型和中重稀土型。公司稀土矿产品主要为中钇富铕混合稀土精矿，折氧化物大于92%。 </div>
                <ul class="productList">
                    
                    <div class="clear">
                    </div>
                </ul>
                <div class="clear">
                </div>
                <div class="Page" style="display: none;">
                    <div>目前在第<a class="Page_PageIndex">1</a>页,共有<a class="Page_PageCount">0</a>页,共有<a class="Page_Max">0</a>条记录  <input id="goText1" class="Page_Text" type="text" value="1">&nbsp;<input id="goButton1" class="Page_Button" type="button" value="" onclick="var gop=document.getElementById(&#39;goText1&#39;).value;if(gop.search(/^\d+$/) == -1){gop=1;}else if(gop&lt;1){gop=1;}else if(gop&gt;0){gop=0;} var insert=(gop==1) ? &#39;&#39;:&#39;_&#39;+gop;var htmUrl=&#39;list_1588&#39;+insert+&#39;.html&#39;;window.location=htmUrl;return false;"></div>
                </div>
                <script>
                    $(".Page").css("display", $(".productList").find("li").size() > 0 ? "" : "none");
    </script>
</div>
<?php  require_once('footer.php') ;?>