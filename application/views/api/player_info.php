<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var guidArray = [];
var current = 0;
var timer = "";
$(function() {
	$.post("<?php echo site_url('api/player_info/get_invalid_player'); ?>", {}, onData);
	
	$("#button").click(function() {
		timer = setInterval(send, 2000);
	});
});

function onData(data) {
	if(data) {
		for(var i in data) {
			$("#container").append(data[i].GUID + ",");
			guidArray.push(data[i].GUID);
		}
	}
}

function send() {
	if(current < guidArray.length) {
		var guid = guidArray[current];
		$.post("<?php echo site_url('api/player_info/get_info_by_guid'); ?>", {"guid": guid}, onSend);
		current++;
	} else {
		clearInterval(timer);
	}
}

function onSend(data) {
	$("#console").append(data + "<br>");
}
</script>
</head>

<body>
<div id="container"></div>
<div>
    <input type="button" name="button" id="button" value="按钮" />
</div>
<div id="console"></div>
</body>
</html>