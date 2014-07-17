<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
    <h1>帐号管理</h1>
</div>
<!--End-breadcrumbs-->

<!--Action boxes-->
<div class="container-fluid">
<!--End-Action boxes-->

    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>搜索</h5>
          </div>
          <div class="widget-content nopadding">
             <form action="" method="post" class="form-horizontal">
                <div class="control-group">
                    <div class="span6">
                        <label class="control-label">开始时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <label class="control-label">结束时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                  <button id="btnSearch" type="button" class="btn btn-success">提交</button>
                  <button id="btnPrev" type="button" class="btn btn-success">前一天</button>
                  <button id="btnNext" type="button" class="btn btn-success">后一天</button>
                </div>
             </form>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>统计结果</h5>
          </div>
          <div class="widget-content nopadding">
             <form action="" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">广告点击次数</label>
                    <div class="controls">
                        <span id="click_count"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">转化人数</label>
                    <div class="controls">
                        <span id="valid_click_count"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">转化率</label>
                    <div class="controls">
                        <span id="valid_click_rate"></span>
                    </div>
                </div>
             </form>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>广告点击列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTable">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>平台</th>
                  <th>ClickId</th>
                  <th>时间</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeA">
                  <td colspan="4"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="alert alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
          <h4 class="alert-heading">注意</h4>
          <ul>
          <li>当天的转化数据第二天才能看到</li>
          </ul>
        </div>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>转化列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="zhuanhuaTable">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>平台</th>
                  <th>时间</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeA">
                  <td colspan="3"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
</div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/datepicker.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;
var zhuanhuaTableHandler;

$(function() {
    $('.datepicker').datepicker();
    $("#btnSearch").click(function() {
    	reload();
    });
    $("#btnPrev").click(function() {
    	var startDate = $("#startTime").val() + " 00:00:00";
    	var endDate = $("#endTime").val() + " 00:00:00";
    	var startTime = timeTodate(startDate) - 86400;
    	var endTime = timeTodate(endDate) - 86400;
    	startDate = dateTotime(startTime);
    	endDate = dateTotime(endTime);

    	var index = startDate.indexOf(" ");
    	if(index >= 0) {
    		startDate = startDate.substr(0, index);
    		$("#startTime").val(startDate);
    	}
    	index = endDate.indexOf(" ");
    	if(index >= 0) {
    		endDate = endDate.substr(0, index);
    		$("#endTime").val(endDate);
    	}
    	reload();
    	$("#btnPrev").attr("disabled", "true");
    	$("#btnNext").attr("disabled", "true");
    	$("#btnSearch").attr("disabled", "true");
    });
    $("#btnNext").click(function() {
    	var startDate = $("#startTime").val() + " 00:00:00";
    	var endDate = $("#endTime").val() + " 00:00:00";
    	var startTime = timeTodate(startDate) + 86400;
    	var endTime = timeTodate(endDate) + 86400;
    	startDate = dateTotime(startTime);
    	endDate = dateTotime(endTime);

    	var index = startDate.indexOf(" ");
    	if(index >= 0) {
    		startDate = startDate.substr(0, index);
    		$("#startTime").val(startDate);
    	}
    	index = endDate.indexOf(" ");
    	if(index >= 0) {
    		endDate = endDate.substr(0, index);
    		$("#endTime").val(endDate);
    	}
    	reload();
    	$("#btnPrev").attr("disabled", "true");
    	$("#btnNext").attr("disabled", "true");
    	$("#btnSearch").attr("disabled", "true");
    });
	$.post("<?php echo site_url('channel/zhuanhua/get_count'); ?>", {
		"starttime": $("#startTime").val(),
		"endtime": $("#endTime").val()
	}, onData);
	dataTableHandler = $('#listTable').dataTable({
		"bInfo": true,
		"bAutoWidth": false,
		"bFilter": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('channel/zhuanhua/lists'); ?>",
		"sServerMethod": "POST",
		"fnServerData": function(sSource, aoData, fnCallback) {
			aoData.push({
				"name": "starttime",
				"value": $("#startTime").val()
			});
			aoData.push({
				"name": "endtime",
				"value": $("#endTime").val()
			});
			$.ajax({
				"dataType": 'json',
				"type": "POST",
				"url": sSource,
				"data": aoData,
				"success": fnCallback
			});
		},
		"aoColumns": [
			{"mData": "ip"},
			{
				"mData": "agent",
				"fnRender": function(obj) {
					var sub = "CPU iPhone OS";
					var index = obj.aData.agent.indexOf(sub);
					var version = "";
					if(index > -1)
					{
						version = obj.aData.agent.substring(index + sub.length + 1, index + sub.length + 6);
						return "iPhone, " + version;
					}
					else
					{
						return "Other";
					}
				}
			},
			{"mData": "clickid"},
			{"mData": "time"}
		],
		"oLanguage": {  
			"sProcessing":   "处理中...",
			"sLengthMenu":   "显示 _MENU_ 项结果",
			"sZeroRecords":  "没有匹配结果",
			"sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
			"sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
			"sInfoFiltered": "(由 _MAX_ 项结果过滤)",
			"sInfoPostFix":  "",
			"sSearch":       "搜索:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "首页",
				"sPrevious": "上页",
				"sNext":     "下页",
				"sLast":     "末页"
			}
		}
	});

	zhuanhuaTableHandler = $('#zhuanhuaTable').dataTable({
		"bAutoWidth": false,
		"bFilter": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('channel/zhuanhua/zhuanhua_list'); ?>",
		"fnServerData": function(sSource, aoData, fnCallback) {
			aoData.push({
				"name": "starttime",
				"value": $("#startTime").val()
			});
			aoData.push({
				"name": "endtime",
				"value": $("#endTime").val()
			});
			$.ajax({
				"dataType": 'json',
				"type": "POST",
				"url": sSource,
				"data": aoData,
				"success": fnCallback
			});
		},
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "ip"},
			{
				"mData": "agent",
				"fnRender": function(obj) {
					var sub = "CPU iPhone OS";
					var index = obj.aData.agent.indexOf(sub);
					var version = "";
					if(index > -1)
					{
						version = obj.aData.agent.substring(index + sub.length + 1, index + sub.length + 6);
						return "iPhone, " + version;
					}
					else
					{
						return "Other";
					}
				}
			},
			{"mData": "date"}
		],
		"oLanguage": {  
			"sProcessing":   "处理中...",
			"sLengthMenu":   "显示 _MENU_ 项结果",
			"sZeroRecords":  "没有匹配结果",
			"sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
			"sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
			"sInfoFiltered": "(由 _MAX_ 项结果过滤)",
			"sInfoPostFix":  "",
			"sSearch":       "搜索:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "首页",
				"sPrevious": "上页",
				"sNext":     "下页",
				"sLast":     "末页"
			}
		}
	});
});
function reload() {
	if(dataTableHandler) {
		dataTableHandler.fnClearTable(0);
		dataTableHandler.fnDraw();
	}
	if(zhuanhuaTableHandler) {
		zhuanhuaTableHandler.fnClearTable(0);
		zhuanhuaTableHandler.fnDraw();
	}
	$("#click_count").text("");
	$("#valid_click_count").text("");
	$("#valid_click_rate").text("");
	$.post("<?php echo site_url('channel/zhuanhua/get_count'); ?>", {
		"starttime": $("#startTime").val(),
		"endtime": $("#endTime").val()
	}, onData);
}
function onData(data) {
	if(data) {
		var json = eval("(" + data + ")");
		$("#click_count").text(json.click_count);
		$("#valid_click_count").text(json.valid_click_count);
		var rate = (json.valid_click_count / json.click_count) * 100;
		rate = Math.round(rate * 100) / 100;
		$("#valid_click_rate").text(rate + "%");
	}
    $("#btnPrev").removeAttr("disabled");
    $("#btnNext").removeAttr("disabled");
    $("#btnSearch").removeAttr("disabled");
}
function timeTodate(date) {
    var new_str = date.replace(/:/g,'-');
    new_str = new_str.replace(/ /g,'-');
    var arr = new_str.split("-");
    var datum = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
    return strtotime = datum.getTime()/1000;
}
function dateTotime(date_time)
{
    var timestr = new Date(parseInt(date_time) * 1000);
    var datetime = timestr.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
    return datetime;
}
</script>