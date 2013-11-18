<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
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
                        <?php foreach($server_result as $server): ?>
                            <option value="<?php echo $server->account_server_id; ?>"><?php echo $server->server_name; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">时间(yyyy-mm-dd)</label>
                    <div class="controls">
                        <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                            <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
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
		$.post("<?php echo site_url('order/recharge_daily/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val()
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
		"sTitle": "序号"
	},
	{
		"sTitle": "时间段"
	},
	{
		"sTitle": "订单总额（元）"
	}];
	
	var series = [];
	var items = {
		name: "订单总额（元）",
		data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
	};
	series.push(items);
	
	for(var i = 0; i<24; i++) {
		var rowData = [i+1, i + "时-" + (i+1) + "时", 0];
		aaData.push(rowData);
	}
	
	for(var m in json) {
		series[0].data[parseInt(json[m].hour)] = parseInt(json[m].amount) / 100;
		aaData[parseInt(json[m].hour)][2] = parseInt(json[m].amount) / 100;
	}
	
	$('#chartRegCount').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		title: {
			text: '每日每小时充值总额统计'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: ["0时-1时", "1时-2时", "2时-3时", "3时-4时", "4时-5时", "5时-6时", "6时-7时", "7时-8时", "8时-9时",
			"9时-10时", "10时-11时", "11时-12时", "12时-13时", "13时-14时", "14时-15时", "15时-16时", "16时-17时", "17时-18时",
			"18时-19时", "19时-20时", "20时-21时", "21时-22时", "22时-23时", "23时-24时"],
			title: {
				text: "时间段"
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