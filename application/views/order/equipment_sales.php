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
        <div class="alert alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
          <h4 class="alert-heading">警告</h4>
          由于装备销售详情统计为后期新增报表，历史记录无法获取物品品质的原因，造成按品质进行统计的报表数据不完整，且目前测试阶段只有绿钻的购买记录，故品质统计只有紫色装备，预计服务器程序下次发布时将加入金币购买装备的记录。
        </div>
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
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
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
              <li class="active"><a data-toggle="tab" href="#tab1">按等级</a></li>
              <li><a data-toggle="tab" href="#tab2">按品质</a></li>
              <li><a data-toggle="tab" href="#tab3">按适用职业</a></li>
            </ul>
          </div>
          <div id="chartContainer" class="widget-content nopadding tab-content">
            <div id="tab1" class="tab-pane active">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartRegCount"></div>
                    </div>
                    <div class="row-fluid">
                        <table class="table table-bordered data-table" id="listTable"></table>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartCount1"></div>
                    </div>
                    <div class="row-fluid">
                        <table class="table table-bordered data-table" id="listTable1"></table>
                    </div>
                </div>
            </div>
            <div id="tab3" class="tab-pane">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartCount2"></div>
                    </div>
                    <div class="row-fluid">
                        <table class="table table-bordered data-table" id="listTable2"></table>
                    </div>
                </div>
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
var dataTableHandler1;
var dataTableHandler2;
$(function() {
	$(window).resize(function() {
		$("#chartRegCount").width($("#chartContainer").width() - 30);
		$("#chartCount1").width($("#chartContainer").width() - 30);
		$("#chartCount2").width($("#chartContainer").width() - 30);
	});
    $('.datepicker').datepicker();
	
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		if(dataTableHandler1) dataTableHandler1.fnDestroy();
		$('#listTable').empty();
		
		$("#chartRegCount").width($("#chartContainer").width() - 30);
		$("#chartCount1").width($("#chartContainer").width() - 30);
		$("#chartCount2").width($("#chartContainer").width() - 30);
		
		$.post("<?php echo site_url('order/equipment_sales/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val(),
			"endTime": $("#endTime").val(),
			"equipmentName": $("#equipmentName").val()
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
	
	var column = [
	{
		"sTitle": "等级"
	},
	{
		"sTitle": "销售数量"
	}];
	var column1 = [
	{
		"sTitle": "品质"
	},
	{
		"sTitle": "销售数量"
	}];
	var column2 = [
	{
		"sTitle": "适用职业"
	},
	{
		"sTitle": "销售数量"
	}];
	var aaData = [];
	var aaData1 = [];
	var aaData2 = [];
	var series = [];
	var series1 = [];
	var series2 = [];
	
	var obj = {};
	obj.name = "销售数量";
	var data = [];
	for(var i in json.level_data.data)
	{
		var rowData = [];
		data.push(parseInt(json.level_data.data[i]));
		rowData.push(json.level_data.axis[i]);
		var spend = parseInt(json.level_data.data[i]);
		rowData.push(spend);
		aaData.push(rowData);
	}
	obj.data = data;
	series.push(obj);
	
	obj = {};
	obj.name = "销售数量";
	data = [];
	for(var i in json.value_data.data)
	{
		var rowData = [];
		data.push(parseInt(json.value_data.data[i]));
		rowData.push(json.value_data.axis[i]);
		var spend = parseInt(json.value_data.data[i]);
		rowData.push(spend);
		aaData1.push(rowData);
	}
	obj.data = data;
	series1.push(obj);
	
	$('#chartRegCount').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		credits: {
			enabled: false
		},
		title: {
			text: '装备销售量按【装备等级】统计图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			title: {
				text: '等级'
			},
			categories: json.level_data.axis
		},
		yAxis: {
			min: 0,
			title: {
				text: '销售数量'
			}
		},
		tooltip: {
			crosshairs: [false, true]
		},
		series: series
	});
	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 15,
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
	
	$('#chartCount1').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		credits: {
			enabled: false
		},
		title: {
			text: '装备销售量按【装备品质】统计图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			title: {
				text: '品质'
			},
			categories: json.value_data.axis
		},
		yAxis: {
			min: 0,
			title: {
				text: '销售数量'
			}
		},
		tooltip: {
			crosshairs: [false, true]
		},
		series: series1
	});
	dataTableHandler1 = $('#listTable1').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 10,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": aaData1,
        "aoColumns": column1,
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