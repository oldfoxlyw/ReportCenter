<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="<?php echo site_url('index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
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
                    <label class="control-label">选择服务器</label>
                    <div class="controls">
                        <select id="serverId" name="serverId">
                        	<option value="0" selected="selected">全服</option>
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
                            <div data-date="<?php echo date('Y-m-d', $current_time - 6 * 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 6 * 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <label class="control-label">结束时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time); ?>" class="input-append date datepicker">
                                <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">选择渠道</label>
                    <div class="controls">
                        <select id="partnerKey" name="partnerKey">
                            <option value="">全部</option>
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
<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">图表</a></li>
              <li><a data-toggle="tab" href="#tab2">数据</a></li>
            </ul>
          </div>
          <div class="widget-content nopadding tab-content">
          	<div class="row-fluid" style="margin-left:15px;">总计金额：<span id="amount" class="badge badge-important"></span></div>
            <div id="tab1" class="tab-pane active">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartRegCount"></div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane">
                <table class="table table-bordered data-table" id="listTable"></table>
            </div>
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
<script src="<?php echo base_url('resources/js/masked.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;

$(function() {
    $('.datepicker').datepicker();
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('order/recharge/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"partnerKey": $("#partnerKey").val(),
			"startTime": $("#startTime").val(),
			"endTime": $("#endTime").val()
		}, onData);
	});
	$("select").select2();
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	var column = [];
	var aaData = [];
	var series = [];
	
	column = [
	{
		"sTitle": "编号"
	},
	{
		"sTitle": "日期"
	},
	{
		"sTitle": "订单总额（元）"
	}];
	
	var sum = 0;
	var series = [];
	var items = {
		name: "订单总额（元）",
		data: []
	};
	for(var i = 0; i<json.axis.length; i++) {
		items.data.push(0);
	}
	series.push(items);
	
	for(var i = 0; i<json.axis.length; i++) {
		var rowData = [i+1, json.axis[i], 0];
		aaData.push(rowData);
	}
	
	for(var m in json.result) {
		series[0].data[json.axis.indexOf(json.result[m].date)] = parseInt(json.result[m].amount) / 100;
		aaData[json.axis.indexOf(json.result[m].date)][2] = parseInt(json.result[m].amount) / 100;
		sum += (parseInt(json.result[m].amount) / 100);
	}

	$("#amount").text(sum);
	
	$('#chartRegCount').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		title: {
			text: '每日充值总额统计'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis,
			labels: {
				rotation: -20,
				align: 'right'
			},
			title: {
				text: "日期"
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: '订单总额（元）'
			}
		},
		tooltip: {
			valueSuffix: ' 元'
		},
		credits: {
			enabled: false
		},
		series: series
	});

	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 20,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": aaData,
        "aoColumns": column,
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
	
	$("select").select2();
}
</script>