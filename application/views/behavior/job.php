<div id="content">
<!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
    </div>
    <!--End-breadcrumbs-->
    
    <div class="container-fluid">
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
                            <div class="span9">
                              <div id="chartRegCount"></div>
                            </div>
                            <div class="span3">
                              <ul class="site-stats">
                                <li class="bg_lh"><i class="icon-user"></i> <strong>2540</strong> <small>Total Users</small></li>
                                <li class="bg_lh"><i class="icon-plus"></i> <strong>120</strong> <small>New Users </small></li>
                                <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong>656</strong> <small>Total Shop</small></li>
                                <li class="bg_lh"><i class="icon-tag"></i> <strong>9540</strong> <small>Total Orders</small></li>
                                <li class="bg_lh"><i class="icon-repeat"></i> <strong>10</strong> <small>Pending Orders</small></li>
                                <li class="bg_lh"><i class="icon-globe"></i> <strong>8540</strong> <small>Online Orders</small></li>
                              </ul>
                            </div>
                          </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                	<table class="table table-bordered data-table" id="listTable"></table>
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
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script> 
<script type="text/javascript">
var dataTableHandler;

$(function() {
    $('.datepicker').datepicker();
	$.post("<?php echo site_url('account/modify_account/lists/highchart'); ?>", {
		"startTime": $("#startTime").val(),
		"endTime": $("#endTime").val()
	}, onData);
	
	$("#btnSearch").click(function() {
		dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('account/modify_account/lists/highchart'); ?>", {
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
	
	var column = [];
	var aaData = [];
	var series = [];
	column.push({
		"sTitle": "服务器名"
	});
	for(var i in json.axis)
	{
		column.push({
			"sTitle": json.axis[i]
		});
	}
	for(var i in json)
	{
		if(i != "axis")
		{
			var obj = {};
			obj.name = i;
			var data = [];
			var rowData = [];
			
			rowData.push(i);
			for(var j = 0; j < column.length; j++)
			{
				if(json[i][j])
				{
					rowData.push(parseInt(json[i][j].modify_account));
				}
				else
				{
					rowData.push("-");
				}
			}
			for(var j in json[i])
			{
				data.push(parseInt(json[i][j].modify_account));
			}
			aaData.push(rowData);
			obj.data = data;
			
			series.push(obj);
		}
	}
	
	$('#chartRegCount').highcharts({
		chart: {
			height: 500
		},
		title: {
			text: '改名总人数变化趋势图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					color: '#000000',
					connectorColor: '#000000',
					format: '<b>{point.name}</b>: {point.percentage:.1f}%'
				}
			}
		},
		series: [{
			type: 'pie',
			name: '职业人数分布',
			data: [
				['的萨芬', 45.0],
				['交通工具', 45.0],
				['儿童', 10.0]
			]
		}]
	});
	
	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
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