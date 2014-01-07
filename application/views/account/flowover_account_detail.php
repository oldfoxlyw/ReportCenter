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
                        <label class="control-label">日期(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
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
                        <div id="chartRegCount1"></div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartRegCount2"></div>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div id="chartRegCount3"></div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane">
                <div class="widget-content">
                    <div class="row-fluid">
                		<table class="table table-bordered data-table" id="listTable1"></table>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                		<table class="table table-bordered data-table" id="listTable2"></table>
                    </div>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                		<table class="table table-bordered data-table" id="listTable3"></table>
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
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler1;
var dataTableHandler2;
var dataTableHandler3;

$(function() {
    $('.datepicker').datepicker();
	$("select").select2();
	
	$("#btnSearch").click(function() {
		if(dataTableHandler1) {
			dataTableHandler1.fnDestroy();
		}
		if(dataTableHandler2) {
			dataTableHandler2.fnDestroy();
		}
		if(dataTableHandler3) {
			dataTableHandler3.fnDestroy();
		}
		$('#listTable1').empty();
		$('#listTable2').empty();
		$('#listTable3').empty();
		$.post("<?php echo site_url('account/flowover_account_detail/lists/highchart'); ?>", {
			"startTime": $("#startTime").val(),
			"serverId": $("#serverId").val(),
			"partnerKey": $("#partnerKey").val()
		}, onData);
	});
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	var jobColumn = [{"sTitle":"职业"}, {"sTitle":"人数"}];
	var jobaaData = [];
	var jobCategory = [];
	var jobData = [];
	var levelColumn = [{"sTitle":"等级"}, {"sTitle":"人数"}];
	var levelaaData = [];
	var levelCategory = [];
	var levelData = [];
	var missionColumn = [{"sTitle":"任务"}, {"sTitle":"人数"}];
	var missionaaData = [];
	var missionCategory = [];
	var missionData = [];
	if(json.job) {
		for(var i in json.job) {
			jobCategory.push(json.job[i][0]);
			jobData.push(parseInt(json.job[i][1]));
			jobaaData.push(json.job[i]);
		}
	}
	if(json.level) {
		for(var i in json.level) {
			levelCategory.push(json.level[i][0]);
			levelData.push(parseInt(json.level[i][1]));
			levelaaData.push(json.level[i]);
		}
	}
	if(json.mission) {
		for(var i in json.mission) {
			missionCategory.push(json.mission[i][0]);
			missionData.push(parseInt(json.mission[i][1]));
			missionaaData.push(json.mission[i]);
		}
	}
	
	$('#chartRegCount1').highcharts({
		chart: {
			type: 'bar',
			height: 600
		},
		title: {
			text: '玩家流失分布图（职业）'
		},
		subtitle: {
			text: '职业为空值时，包含所有建立了帐号但是未建立角色的玩家'
		},
		xAxis: [{
			categories: jobCategory,
			reversed: false
		}],
		yAxis: {
			title: {
				text: null
			},
			min: 0
		},
		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},
		series: [{
			name: $("#serverId").find("option:selected").text(),
			data: jobData
		}]
	});
	$('#chartRegCount2').highcharts({
		chart: {
			type: 'bar',
			height: 600
		},
		title: {
			text: '玩家流失分布图（等级）'
		},
		subtitle: {
			text: '等级为0时，包含所有建立了帐号但是未建立角色的玩家'
		},
		xAxis: [{
			categories: levelCategory,
			reversed: false
		}],
		yAxis: {
			title: {
				text: null
			},
			min: 0
		},
		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},
		series: [{
			name: $("#serverId").find("option:selected").text(),
			data: levelData
		}]
	});
	$('#chartRegCount3').highcharts({
		chart: {
			type: 'bar',
			height: 1500
		},
		title: {
			text: '玩家流失分布图（任务）'
		},
		subtitle: {
			text: '任务为0时，包含所有创建帐号但未创建角色，或者建立了角色但是没有完成第一个任务的玩家'
		},
		xAxis: [{
			categories: missionCategory,
			reversed: false
		}],
		yAxis: {
			title: {
				text: null
			},
			min: 0
		},
		plotOptions: {
			series: {
				stacking: 'normal'
			}
		},
		series: [{
			name: $("#serverId").find("option:selected").text(),
			data: missionData
		}]
	});
	
	dataTableHandler1 = $('#listTable1').dataTable({
		"bAutoWidth": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": jobaaData,
        "aoColumns": jobColumn,
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
	dataTableHandler2 = $('#listTable2').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": levelaaData,
        "aoColumns": levelColumn,
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
	dataTableHandler3 = $('#listTable3').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": missionaaData,
        "aoColumns": missionColumn,
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