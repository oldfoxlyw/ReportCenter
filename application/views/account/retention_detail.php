<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
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
                  	<div class="span6">
                        <div class="control-group">
                            <label class="control-label">开始时间(yyyy-mm-dd)</label>
                            <div class="controls">
                                <div data-date="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>" class="input-append date datepicker">
                                    <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                  	<div class="span6">
                        <div class="control-group">
                            <label class="control-label">结束时间(yyyy-mm-dd)</label>
                            <div class="controls">
                                <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                    <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                    <div class="form-actions">
                      <button id="btnSearch" type="button" class="btn btn-success">搜索</button>
                    </div>
                  </form>
              </div>
            </div>
        </div>
<!--Chart-box-->    
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title">
          	<span class="icon"> <i class="icon-signal"></i> </span>
            <h5>留存率</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTableRetention">
                  <thead>
                    <tr>
                      <th>时间</th>
                      <th>当天注册的有效用户<a class="th-tips" href="#" data-content="当日23:59:59前等级大于1级的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>次日登录<a class="th-tips" href="#" data-content="第一天注册，并在第二天登录的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>次日留存率<a class="th-tips" href="#" data-content="次日登录与昨日注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>点三日登录<a class="th-tips" href="#" data-content="第一天注册，并在第三天登录的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>点三日留存率<a class="th-tips" href="#" data-content="点三日登录与三天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>连续三日登录<a class="th-tips" href="#" data-content="第一天注册，并在第二、三天都登录的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>连续三日留存率<a class="th-tips" href="#" data-content="连续三日登录与三天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>点七日登录<a class="th-tips" href="#" data-content="第一天注册，并在第二天登录且第七天登录的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>点七日留存率<a class="th-tips" href="#" data-content="点七日登录与七天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>小区间七日登录<a class="th-tips" href="#" data-content="第一天注册，并在第二天登录且第三至第七天登录过的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>小区间七日留存率<a class="th-tips" href="#" data-content="小区间七日登录与七天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>大区间七日登录<a class="th-tips" href="#" data-content="第一天注册，并在第二至第七天登录过的玩家数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>大区间七日留存率<a class="th-tips" href="#" data-content="大区间七日登录与七天前注册的有效用户的比值" data-placement="left" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="14">载入中...</td>
                    </tr>
                  </tbody>
                </table>
          </div>
        </div>
    </div>
<!--End-Chart-box-->
</div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/datepicker.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;

$(function() {
    $('.datepicker').datepicker();
	$.post("<?php echo site_url('account/retention_detail/lists/datatable'); ?>", {
		"startTime": $("#startTime").val(),
		"endTime": $("#endTime").val()
	}, onData);
	
	$("#btnSearch").click(function() {
		dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('account/retention_detail/lists/datatable'); ?>", {
			"startTime": $("#startTime").val(),
			"endTime": $("#endTime").val()
		}, onData);
	});
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	dataTableHandler = $('#listTableRetention').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": json.aaData,
        "aoColumns": [
			{"mData": "log_date", "bSortable": false},
			{"mData": "level_account"},
			{"mData": "next_current_login"},
			{
				"mData": "next_retention",
				"fnRender": function(obj) {
					if(obj.aData.next_retention==0) {
						return "-";
					} else {
						return obj.aData.next_retention / 100 + "%";
					}
				}
			},
			{"mData": "third_current_login"},
			{
				"mData": "third_retention",
				"fnRender": function(obj) {
					if(obj.aData.third_retention==0) {
						return "-";
					} else {
						return obj.aData.third_retention / 100 + "%";
					}
				}
			},
			{"mData": "third_current_login_range"},
			{
				"mData": "third_retention_range",
				"fnRender": function(obj) {
					if(obj.aData.third_retention_range==0) {
						return "-";
					} else {
						return obj.aData.third_retention_range / 100 + "%";
					}
				}
			},
			{"mData": "seven_current_login"},
			{
				"mData": "seven_retention",
				"fnRender": function(obj) {
					if(obj.aData.seven_retention==0) {
						return "-";
					} else {
						return obj.aData.seven_retention / 100 + "%";
					}
				}
			},
			{"mData": "seven_current_login_range"},
			{
				"mData": "seven_retention_range",
				"fnRender": function(obj) {
					if(obj.aData.seven_retention_range==0) {
						return "-";
					} else {
						return obj.aData.seven_retention_range / 100 + "%";
					}
				}
			},
			{"mData": "seven_current_login_huge"},
			{
				"mData": "seven_retention_huge",
				"fnRender": function(obj) {
					if(obj.aData.seven_retention_huge==0) {
						return "-";
					} else {
						return obj.aData.seven_retention_huge / 100 + "%";
					}
				}
			}
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
}
</script>