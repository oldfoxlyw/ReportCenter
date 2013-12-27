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
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">图表</a></li>
              <li><a data-toggle="tab" href="#tab2">数据</a></li>
            </ul>
          </div>
          <div class="widget-content nopadding tab-content">
            <div id="tab1" class="tab-pane active">
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                          <div id="chartRegCount"></div>
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
	$.post("<?php echo site_url('account/modify_new_account/lists/highchart'); ?>", {
		"startTime": $("#startTime").val(),
		"endTime": $("#endTime").val()
	}, onData);
	
	$("#btnSearch").click(function() {
		dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('account/modify_new_account/lists/highchart'); ?>", {
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
					rowData.push(parseInt(json[i][j].modify_new_account));
				}
				else
				{
					rowData.push("-");
				}
			}
			for(var j in json[i])
			{
				data.push(parseInt(json[i][j].modify_new_account));
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
		credits: {
			enabled: false
		},
		title: {
			text: '新增手动注册人数变化趋势图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis
		},
		yAxis: {
			title: {
				text: '新增手动注册人数'
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
		series: series
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