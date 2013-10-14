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
                        <div data-date="<?php echo date('Y-m-d', $current_time); ?>" class="input-append date datepicker">
                            <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time); ?>"  data-date-format="yyyy-mm-dd" >
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">装备类型</label>
                    <div class="controls">
                        <select id="itemType" name="itemType">
                            <option value="0">全部</option>
                            <option value="1">武器</option>
                            <option value="2">手套</option>
                            <option value="3">戒指</option>
                            <option value="4">衣服</option>
                            <option value="5">鞋子</option>
                            <option value="6">项链</option>
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
var equipmentType = ["", "武器", "手套", "戒指", "衣服", "鞋子", "项链"];
var dataTableHandler;

$(function() {
    $('.datepicker').datepicker();
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('order/buy_equipment/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val(),
			"itemType": $("#itemType").val()
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
		"sTitle": "操作名称"
	},
	{
		"sTitle": "消耗绿钻"
	}];
	
	var type = parseInt($("#itemType").val());
	var series = [];
	if(type == 0) {
		for(var i = 1; i <= 6; i++) {
			var items = {
				name: equipmentType[i],
				data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
			};
			series.push(items);
		}
		
		for(var m in json) {
			console.log(m);
			for(var k in json[m]) {
				series[m].data[k] = parseInt(json[m][k]);
			}
		}
	} else {
		var items = {
			name: equipmentType[parseInt($("#itemType").val())],
			data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
		};
		series.push(items);
		
		for(var m in json) {
			for(var k in json[m]) {
				series[0].data[k] = parseInt(json[m][k]);
			}
		}
	}
	
	/*
	var obj = {};
	obj.name = "消耗绿钻";
	var data = [];
	var total = 0;
	for(var i in json.data)
	{
		var rowData = [];
		if(json.data[i]) {
			data.push(parseInt(json.data[i].spend_special_gold));
			rowData.push(json.data[i].action_name);
			var spend = parseInt(json.data[i].spend_special_gold);
			rowData.push(spend);
			total += spend;
		}
		aaData.push(rowData);
	}
	aaData.push(["总计", total]);
	obj.data = data;
	series.push(obj);
	*/
	$('#chartRegCount').highcharts({
		chart: {
			type: 'column',
			height: 500
		},
		title: {
			text: '购买装备详细情况统计'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: ["1", "2", "3", "4", "5", "6", "7", "8",
			"9", "10", "11", "12", "13", "14", "15", "16", "17",
			"18", "19", "20", "21", "22", "23", "24", "25", "26",
			"27", "28", "29", "30", "31", "32", "33", "34", "35",
			"36", "37", "38", "39", "40"],
			title: {
				text: "等级"
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: '人数'
			}
		},
		tooltip: {
			valueSuffix: ' 人'
		},
		credits: {
			enabled: false
		},
		series: series
	});
/*
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
*/
	$("select").select2();
}
</script>