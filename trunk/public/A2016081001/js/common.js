/**
 * 公共函数
 */
//判断是否为空
var layer_load = null;
function isEmptyVal(B) {
    switch (typeof B) {
        case "undefined":
            return true;
        case "string":
            if (B.replace(/(^[ \t\n\r]*)|([ \t\n\r]*$)/g, "").length == 0) {
                return true
            }
            break;
        case "boolean":
            if (!B) {
                return true
            }
            break;
        case "number":
            if (isNaN(B)) {
                return true
            }
            break;
        case "object":
            if (null === B || B.length === 0) {
                return true
            }
            for (var A in B) {
                return false
            }
            return true
    }
    return false
}
function loading(){  
	layer_load = parent.layer.load(1, {time:0,shade:[0.3,'#000',true]});
}
function unloading(){
    layer.close(layer_load);
}
//icon　0警告，１成功，２错误
function msg_show(txt,icon,url,top){
	if(typeof icon=="undefined")icon=0;
	if(typeof url=="undefined")url='';
	if(typeof top=="undefined")top=false;
	layer.msg(txt,{icon:icon,time:2000,shade:[0.3,'#000',true]},function(){
		if(isEmptyVal(url)==false){
			if(top==true){
				window.top.location.href = url;
			}else{
				location.href = url;
			}
		}
	});
}