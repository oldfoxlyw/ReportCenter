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
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <label class="control-label">结束时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">选择渠道</label>
                    <div class="controls">
                        <select id="partnerKey" name="partnerKey">
                            <option value="" selected="selected">全部</option>
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
              <li class="active"><a data-toggle="tab" href="#tab1">数据</a></li>
            </ul>
          </div>
          <div class="widget-content nopadding tab-content">
            <div id="tab1" class="tab-pane active">
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
<script src="<?php echo base_url('resources/js/matrix.popover.js'); ?>"></script>
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
		$.post("<?php echo site_url('order/lifetime/lists/json'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val(),
			"endTime": $("#endTime").val(),
			"partnerKey": $("#partnerKey").val()
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
		"sTitle": '日期'
	},
	{
		"sTitle": "服务器ID"
	},
	{
		"sTitle": "渠道"
	},
	{
    	"sTitle": '当天注册角色数<a class="th-tips" href="#" data-content="当天23:59:59前注册的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
	},
    {
        "sTitle": '当天付费人数<a class="th-tips" href="#" data-content="当天注册并付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '当天付费率<a class="th-tips" href="#" data-content="当天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '当天收入<a class="th-tips" href="#" data-content="当天总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '2天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第2天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '2天付费率<a class="th-tips" href="#" data-content="2天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '2天收入<a class="th-tips" href="#" data-content="到第2天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '3天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第3天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '3天付费率<a class="th-tips" href="#" data-content="3天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '3天收入<a class="th-tips" href="#" data-content="到第3天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '4天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第4天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '4天付费率<a class="th-tips" href="#" data-content="4天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '4天收入<a class="th-tips" href="#" data-content="到第4天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '5天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第5天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '5天付费率<a class="th-tips" href="#" data-content="5天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '5天收入<a class="th-tips" href="#" data-content="到第5天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '6天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第6天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '6天付费率<a class="th-tips" href="#" data-content="6天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '6天收入<a class="th-tips" href="#" data-content="到第6天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '7天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第7天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '7天付费率<a class="th-tips" href="#" data-content="7天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '7天收入<a class="th-tips" href="#" data-content="到第7天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '14天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第14天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '14天付费率<a class="th-tips" href="#" data-content="14天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '14天收入<a class="th-tips" href="#" data-content="到第14天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '30天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第30天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '30天付费率<a class="th-tips" href="#" data-content="30天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '30天收入<a class="th-tips" href="#" data-content="到第30天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '60天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第60天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '60天付费率<a class="th-tips" href="#" data-content="60天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '60天收入<a class="th-tips" href="#" data-content="到第60天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '90天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第90天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '90天付费率<a class="th-tips" href="#" data-content="90天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '90天收入<a class="th-tips" href="#" data-content="到第90天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '180天付费人数<a class="th-tips" href="#" data-content="当天注册的角色中到第180天为止付费的角色数" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '180天付费率<a class="th-tips" href="#" data-content="180天付费人数与当天注册角色数的比值" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },
    {
        "sTitle": '180天收入<a class="th-tips" href="#" data-content="到第180天为止的总收入" data-placement="top" data-toggle="popover" data-original-title="Tips"><img src="<?php echo base_url("resources/img/question.png"); ?>" /></a>'
    },];

	var aaData = [];
	for(var i in json) {
		var row = [
            json[i].date,
            json[i].server_id,
            json[i].partner_key,
            json[i].register_count,
            json[i].paid_count_1,
            json[i].paid_rate_1 / 100 + '%',
            json[i].recharge_amount_1 / 100,
            json[i].paid_count_2,
            json[i].paid_rate_2 / 100 + '%',
            json[i].recharge_amount_2 / 100,
            json[i].paid_count_3,
            json[i].paid_rate_3 / 100 + '%',
            json[i].recharge_amount_3 / 100,
            json[i].paid_count_4,
            json[i].paid_rate_4 / 100 + '%',
            json[i].recharge_amount_4 / 100,
            json[i].paid_count_5,
            json[i].paid_rate_5 / 100 + '%',
            json[i].recharge_amount_5 / 100,
            json[i].paid_count_6,
            json[i].paid_rate_6 / 100 + '%',
            json[i].recharge_amount_6 / 100,
            json[i].paid_count_7,
            json[i].paid_rate_7 / 100 + '%',
            json[i].recharge_amount_7 / 100,
            json[i].paid_count_14,
            json[i].paid_rate_14 / 100 + '%',
            json[i].recharge_amount_14 / 100,
            json[i].paid_count_30,
            json[i].paid_rate_30 / 100 + '%',
            json[i].recharge_amount_30 / 100,
            json[i].paid_count_60,
            json[i].paid_rate_60 / 100 + '%',
            json[i].recharge_amount_60 / 100,
            json[i].paid_count_90,
            json[i].paid_rate_90 / 100 + '%',
            json[i].recharge_amount_90 / 100,
            json[i].paid_count_180,
            json[i].paid_rate_180 / 100 + '%',
            json[i].recharge_amount_180 / 100,
        ];
		aaData.push(row);
	}

	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": true,
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 20,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": aaData,
        "aoColumns": column,
        "aaSorting": [
            [ 4, "desc" ]
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
	$("select").select2();
    $("#listTable th a").popover();
}
</script>