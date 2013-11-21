<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
    <h1>总览 - 7天内服务器概况（数据测试中）</h1>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
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
                      <th><a href="#" data-content="所有已注册的帐号，包括试玩帐号" data-placement="top" data-toggle="popover" data-original-title="Tips">总注册用户</a></th>
                      <th><a href="#" data-content="当日23:59:59前登录的总数，同一玩家一天内多次登录仅计算一次" data-placement="top" data-toggle="popover" data-original-title="Tips">当天登录用户</a></th>
                      <th><a href="#" data-content="当日23:59:59前等级大于1级的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">当天注册的有效用户</a></th>
                      <th><a href="#" data-content="三日前至今有过登录记录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">活跃用户</a></th>
                      <th><a href="#" data-content="超过一周未登录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">流失用户数</a></th>
                      <th><a href="#" data-content="当日23:59:59前充值的总金额（元）" data-placement="top" data-toggle="popover" data-original-title="Tips">当天订单总额</a></th>
                      <th><a href="#" data-content="当日充值人数（去重）与当日活跃人数的比值" data-placement="left" data-toggle="popover" data-original-title="Tips">充值率</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="8">载入中...</td>
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
                      <th><a href="#" data-content="当日23:59:59前等级大于1级的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">当天注册的有效用户</a></th>
                      <th><a href="#" data-content="昨日23:59:59前注册的有效玩家中在今日登录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">次日登录</a></th>
                      <th><a href="#" data-content="次日登录与昨日注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips">次日留存率</a></th>
                      <th><a href="#" data-content="三日前注册的有效玩家中在今日登录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">点三日登录</a></th>
                      <th><a href="#" data-content="三日登录与三天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips">点三日留存率</a></th>
                      <th><a href="#" data-content="七日前注册的有效玩家中在今日登录的玩家数量" data-placement="top" data-toggle="popover" data-original-title="Tips">点七日登录</a></th>
                      <th><a href="#" data-content="七日登录与七天前注册的有效用户的比值" data-placement="top" data-toggle="popover" data-original-title="Tips">点七日留存率</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="7">载入中...</td>
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
            <h5>新注册用户数（包括试玩）曲线</h5>
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
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.popover.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>

<script type="text/javascript">
$(function() {
	$("table.data-table th > a").popover();
	
	$("#indexNavTab > li:first").addClass("active");
	$("#indexTab > div:first").addClass("active");
	
	$('#listTableOverview').dataTable({
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
		"sAjaxSource": "<?php echo site_url('index/lists/overview'); ?>?server_id=A",
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "log_date"},
			{"mData": "reg_account"},
			{"mData": "login_account"},
			{"mData": "level_account"},
			{"mData": "active_account"},
			{"mData": "flowover_account"},
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
						return obj.aData.arpu / 100 + "%";
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
	
	$('#listTableRetention').dataTable({
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
		"sAjaxSource": "<?php echo site_url('index/lists/retention'); ?>?server_id=A",
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "log_date"},
			{"mData": "level_account"},
			{"mData": "prev_current_login"},
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
	
	var serverId = $("#indexNavTab > li.active").attr("server_id");
	var parameter = {
		"server_id": serverId
	};
	$.post("<?php echo site_url('index/charts/highchart'); ?>", parameter, onData);
	
	$('select').select2();
});

function onData(data) {
	if(data) {
		for(var i in data.register_result) {
			data.register_result[i] = parseInt(data.register_result[i]);
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
				text: '每日新注册人数曲线'
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
					text: '每日新注册人数'
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
				name: "注册人数",
				data: data.register_result
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