function getQueryString(key) {

    var value = "";

    //获取当前文档的URL,为后面分析它做准备

    var sURL = window.document.URL;



    //URL中是否包含查询字符串

    if (sURL.indexOf("?") > 0) {

        //分解URL,第二的元素为完整的查询字符串

        //即arrayParams[1]的值为【first=1&second=2】

        var arrayParams = sURL.split("?");



        //分解查询字符串

        //arrayURLParams[0]的值为【first=1 】

        //arrayURLParams[2]的值为【second=2】

        var arrayURLParams = arrayParams[1].split("&");



        //遍历分解后的键值对

        for (var i = 0; i < arrayURLParams.length; i++) {

            //分解一个键值对

            var sParam = arrayURLParams[i].split("=");



            if ((sParam[0] == key) && (sParam[1] != "")) {

                //找到匹配的的键,且值不为空

                value = sParam[1];

                break;

            }

        }

    }



    return value;

}