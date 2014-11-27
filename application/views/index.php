<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb">
        <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span>
    	<a href="<?php echo site_url('index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a>
    </div>
    <h1>总览 - 7天内服务器概况（数据测试中）</h1>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>搜索</h5>
          </div>
          <div class="widget-content nopadding">
              <form action="" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">选择服务器</label>
                    <div class="controls">
                        <select id="serverId" name="serverId">
                        <?php foreach($server_result as $server): ?>
                            <option value="<?php echo $server->account_server_id; ?>"><?php echo $server->server_name; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <div class="span6">
                        <label class="control-label">开始时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <label class="control-label">结束时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">选择渠道</label>
                    <div class="controls">
                        <select id="partnerKey" name="partnerKey">
                            <option value="" selected="selected">全部</option>
                        <?php foreach($partner_result as $partner): ?>
                            <option value="<?php echo $partner->partner_key; ?>"><?php echo $partner->partner_key; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                  <button id="btnSearch" type="button" class="btn btn-success">提交</button>
                </div>
              </form>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title">
          	<span class="icon"> <i class="icon-signal"></i> </span>
            <h5>总览</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTableOverview">
                  <thead>
                    <tr>
                      <th>时间</th>
                      <th>总注册角色数<a class="th-tips" href="#" data-content="所有已建立角色的帐号数量" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>当天登录角色数<a class="th-tips" href="#" data-content="当日23:59:59前登录的角色总数，同一玩家一天内多次登录仅计算一次" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>当天注册的角色数<a class="th-tips" href="#" data-content="当日23:59:59前新注册的角色数量" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <!--<th>当天注册的有效角色数<a class="th-tips" href="#" data-content="当日23:59:59前等级大于1级的角色数量" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>-->
                      <th>DAU<a class="th-tips" href="#" data-content="当天有效登录数减去当天注册角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>当天订单数<a class="th-tips" href="#" data-content="超过一周未登录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>当天订单总额<a class="th-tips" href="#" data-content="当日23:59:59前充值的总金额（元）" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>充值率<a class="th-tips" href="#" data-content="当日充值人数（去重）与当日DAU的比值" data-placement="left" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>ARPPU<a class="th-tips" href="#" data-content="平均付费金额（当日订单总额/当日付费人数）" data-placement="left" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>当天首次付费人数<a class="th-tips" href="#" data-content="当天首次付费总人数" data-placement="left" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                      <th>累计付费人数<a class="th-tips" href="#" data-content="开服至今付费总人数" data-placement="left" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url('resources/img/question.png'); ?>" /></a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="10">载入中...</td>
                    </tr>
                  </tbody>
                </table>
          </div>
        </div>
    </div>
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
                      <td colspan="15">载入中...</td>
                    </tr>
                  </tbody>
                </table>
          </div>
        </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>DAU曲线</h5>
          </div>
          <div class="widget-content">
            <div id="chartRegCount"></div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>有效用户曲线（角色等级大于1级）</h5>
          </div>
          <div class="widget-content">
            <div id="chartValidCount"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>当天登录用户数曲线</h5>
          </div>
          <div class="widget-content">
            <div id="chartLoginCount"></div>
          </div>
        </div>
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>次日留存率曲线</h5>
          </div>
          <div class="widget-content">
            <div id="chartNextRetentionCount"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/datepicker.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.popover.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>

<script type="text/javascript">
var overviewTableHandler, retentionTableHandler;
$(function() {
	$("table.data-table th > a").popover();
	
	$("#indexNavTab > li:first").addClass("active");
	$("#indexTab > div:first").addClass("active");
	$("#btnSearch").attr('disabled', 'disabled');
	$("#btnSearch").click(function() {
		$(this).attr('disabled', 'disabled');
		var serverId = $("#serverId").val();
		var startTime = $("#startTime").val();
		var endTime = $("#endTime").val();
		var partnerKey = $("#partnerKey").val();
		retrieveTableData(serverId, startTime, endTime, partnerKey);
		retrieveChartData(serverId, startTime, endTime, partnerKey);
	});
	
	retrieveTableData("<?php echo $server_result[0]->account_server_id; ?>");
	retrieveChartData("<?php echo $server_result[0]->account_server_id; ?>");
	
	$('select').select2();
    $('.datepicker').datepicker();
});

function retrieveTableData(serverId, start, end, partner) {
	if(overviewTableHandler) {
		overviewTableHandler.fnDestroy();
	}
	if(retentionTableHandler) {
		retentionTableHandler.fnDestroy();
	}
	start = start ? start : '';
	end = end ? end : '';
	partner = partner ? partner : '';
	overviewTableHandler = $('#listTableOverview').dataTable({
		"bAutoWidth": false,
		"bFilter": false,
		"bLengthChange": false,
		"bPaginate": false,
		"bJQueryUI": false,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('index/lists/overview'); ?>?server_id=" + serverId + "&start=" + start + "&end=" + end + "&partner=" + partner,
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "log_date", "bSortable": false},
			{"mData": "valid_account"},
			{"mData": "login_account"},
			{"mData": "valid_new_account"},
			//{"mData": "level_account"},
			{"mData": "dau"},
/*			{
				"mData": "at",
				"fnRender": function(obj) {
					var hour, minutes, second;
					var time = parseInt(obj.aData.at);
					if(time > 0) {
						second = time % 60;
						time = parseInt(time / 60);
						if(time > 60) {
							minutes = time % 60;
							time = parseInt(time / 60);
							if(time > 60) {
								hour = time % 60;
							} else {
								hour = 0;
							}
						} else {
							minutes = time;
							hour = 0;
						}
						var hourText, minutesText, secondText;
						hourText = hour < 10 ? "0" + hour : hour;
						minutesText = minutes < 10 ? "0" + minutes : minutes;
						secondText = second < 10 ? "0" + second : second;
						return hourText + ":" + minutesText + ":" + secondText;
					} else {
						return "-";
					}
				}
			},*/
			{"mData": "order_count"},
			{
				"mData": "orders_current_sum",
				"fnRender": function(obj) {
					return obj.aData.orders_current_sum / 100;
				}
			},
			{
				"mData": "arpu",
				"fnRender": function(obj) {
					if(obj.aData.arpu == 0) {
						return "-";
					} else {
						return obj.aData.arpu + "%";
					}
				}
			},
      {
        "mData": "arppu",
        "fnRender": function(obj) {
          if(obj.aData.arppu == 0) {
            return "-";
          }
          return obj.aData.arppu;
        }
      },
      {"mData": "first_recharge_account"},
      {"mData": "recharge_account_sum"}
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
	
	retentionTableHandler = $('#listTableRetention').dataTable({
		"bAutoWidth": false,
		"bFilter": false,
		"bLengthChange": false,
		"bPaginate": false,
		"bJQueryUI": false,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('index/lists/retention'); ?>?server_id=" + serverId + "&start=" + start + "&end=" + end + "&partner=" + partner,
		"sServerMethod": "POST",
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

function retrieveChartData(serverId, start, end, partner) {
	start = start ? start : '';
	end = end ? end : '';
	partner = partner ? partner : '';
	var parameter = {
		"server_id": serverId,
		"start": start,
		"end": end,
		"partner": partner
	};
	$.post("<?php echo site_url('index/charts/highchart'); ?>", parameter, onData);
}

function onData(data) {
	$("#btnSearch").removeAttr('disabled');
	if(data) {
		for(var i in data.dau_result) {
			data.dau_result[i] = parseInt(data.dau_result[i]);
		}
		for(var i in data.valid_result) {
			data.valid_result[i] = parseInt(data.valid_result[i]);
		}
		for(var i in data.login_result) {
			data.login_result[i] = parseInt(data.login_result[i]);
		}
		for(var i in data.next_retention_result) {
			data.next_retention_result[i] = parseInt(data.next_retention_result[i]);
		}
		$('#chartRegCount').highcharts({
			chart: {
				height: 300
			},
			credits: {
				enabled: false
			},
			title: {
				text: 'DAU曲线'
			},
			subtitle: {
				text: '数据来源：数据统计平台'
			},
			xAxis: {
				categories: data.axis,
				labels: {
					rotation: -20,
					align: 'right'
				}
			},
			yAxis: {
				title: {
					text: 'DAU'
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: '#808080'
				}]
			},
			tooltip: {
				crosshairs: [true, true]
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					}
				}
			},
			series: [
			{
				name: "DAU",
				data: data.dau_result
			}]
		});
		
		$('#chartValidCount').highcharts({
			chart: {
				height: 300
			},
			credits: {
				enabled: false
			},
			title: {
				text: '有效用户（角色等级大于1级）数量曲线'
			},
			subtitle: {
				text: '数据来源：数据统计平台'
			},
			xAxis: {
				categories: data.axis,
				labels: {
					rotation: -20,
					align: 'right'
				}
			},
			yAxis: {
				title: {
					text: '有效用户数'
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: '#808080'
				}]
			},
			tooltip: {
				crosshairs: [true, true]
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					}
				}
			},
			series: [
			{
				name: "有效玩家",
				data: data.valid_result
			}]
		});
		
		$('#chartLoginCount').highcharts({
			chart: {
				height: 300
			},
			credits: {
				enabled: false
			},
			title: {
				text: '当天登录用户数量曲线'
			},
			subtitle: {
				text: '数据来源：数据统计平台'
			},
			xAxis: {
				categories: data.axis,
				labels: {
					rotation: -20,
					align: 'right'
				}
			},
			yAxis: {
				title: {
					text: '登录用户数'
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: '#808080'
				}]
			},
			tooltip: {
				crosshairs: [true, true]
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					}
				}
			},
			series: [
			{
				name: "登录玩家",
				data: data.login_result
			}]
		});
		
		$('#chartNextRetentionCount').highcharts({
			chart: {
				height: 300
			},
			credits: {
				enabled: false
			},
			title: {
				text: '次日留存率曲线'
			},
			subtitle: {
				text: '数据来源：数据统计平台'
			},
			xAxis: {
				categories: data.axis,
				labels: {
					rotation: -20,
					align: 'right'
				}
			},
			yAxis: {
				title: {
					text: '次日留存率'
				},
				plotLines: [{
					value: 0,
					width: 2,
					color: '#808080'
				}]
			},
			tooltip: {
				crosshairs: [true, true],
				formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.y / 100 +'%';
                }
			},
			plotOptions: {
				line: {
					dataLabels: {
						enabled: true,
						formatter: function() {
							return this.y / 100 + '%';
						}
					}
				}
			},
			series: [
			{
				name: "留存率",
				data: data.next_retention_result
			}]
		});
	}
}
</script>