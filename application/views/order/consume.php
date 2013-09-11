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
                    <label class="control-label">玩家GUID</label>
                    <div class="controls">
                    	<input name="playerId" id="playerId" type="text" placeholder="15位数字" />
                        <span class="help-block">如果此处留空，则按照操作名称进行统计</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">单位</label>
                    <div class="controls">
                        <select id="type" name="type">
                            <option value="1">天</option>
                            <option value="2">周</option>
                            <option value="3">月</option>
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
	$("#playerId").mask("999999999999999");
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('order/consume/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"playerId": $("#playerId").val(),
			"type": $("#type").val()
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
	
	if(json.type == '0') {
		column = [
		{
			"sTitle": "操作名称"
		},
		{
			"sTitle": "消耗绿钻"
		}];
		
		var obj = {};
		obj.name = "消耗绿钻";
		var data = [];
		for(var i in json.data)
		{
			var rowData = [];
			if(json.data[i]) {
				data.push(parseInt(json.data[i].spend_special_gold));
				rowData.push(json.data[i].action_name);
				rowData.push(parseInt(json.data[i].spend_special_gold));
			}
			aaData.push(rowData);
		}
		obj.data = data;
		series.push(obj);
	} else {
		column.push({
			"sTitle": "消耗绿钻"
		});
	}
	$('#chartRegCount').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		credits: {
			enabled: false
		},
		title: {
			text: '消耗绿钻统计图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis
		},
		yAxis: {
			min: 0,
			title: {
				text: '消耗绿钻'
			}
		},
		tooltip: {
			crosshairs: [true, true]
		},
//		plotOptions: {
//			column: {
//				pointPadding: .2,
//				borderWidth: 0
//			}
//		},
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