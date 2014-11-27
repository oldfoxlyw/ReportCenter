<div id="content">
<!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="<?php echo site_url('index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
    </div>
    <!--End-breadcrumbs-->
    
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
                            <select id="serverId" name="serverId" >
                            	<option value="0">全部</option>
                            <?php foreach($server as $row): ?>
                            	<option value="<?php echo $row->account_server_id; ?>"><?php echo $row->server_name; ?></option>
                            <?php endforeach; ?>
                            </select>
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
	$.post("<?php echo site_url('behavior/level/lists/highchart'); ?>", {
			"server_id": $("#serverId").val()
		}, onData);
	
	$("#btnSearch").click(function() {
		dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('behavior/level/lists/highchart'); ?>", {
			"server_id": $("#serverId").val()
		}, onData);
	});
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	var total = 0;
	for(var i = 0; i < json.data.length; i++)
	{
		json.data[i] = parseInt(json.data[i]);
		total += json.data[i];
	}
	
	$('#chartRegCount').highcharts({
		chart: {
			type: 'bar',
			height: 1000
		},
		title: {
			text: '人物等级分布图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: [{
			categories: json.category,
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
			data: json.data
		}],
		tooltip: {
			formatter: function() {
				return '<strong>' + this.x + '级</strong><br/><strong>人数: </strong>' + this.y + ' 人<br/><strong>总数: </strong>' + total + ' 人<br/><strong>比例: </strong>' + parseInt((this.y / total) * 10000) / 100 + '%'
			}
		}
	});
	
	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": true,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": json.result,
        "aoColumns": [{
			'sTitle': '等级'
		},{
			'sTitle': '人数'
		}],
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