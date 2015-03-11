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
                    <label class="control-label">玩家昵称</label>
                    <div class="controls">
                        <input type="text" id="nickname" name="nickname" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">帐号ID</label>
                    <div class="controls">
                        <input type="text" id="accountId" name="accountId" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">角色ID</label>
                    <div class="controls">
                        <input type="text" id="roleId" name="roleId" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">只取最近100条记录</label>
                    <div class="controls">
                        <input type="checkbox" id="limit" name="limit" value="100" checked="checked" />
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
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;

$(function() {
    $('.datepicker').datepicker();
	$("#btnSearch").click(function() {
		if(dataTableHandler) {
            dataTableHandler.fnDestroy();
            dataTableHandler = null;
        }
		$('#listTable').empty();
		$.post("<?php echo site_url('logs/item_log/lists'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val(),
			"endTime": $("#endTime").val(),
			"nickname": $("#nickname").val(),
            "accountId": $("#accountId").val(),
            "roleId": $("#roleId").val(),
            "limit": $("#limit").is(":checked") ? $("#limit").val() : 0
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

    if(json.code == '-1') {
        alert('无法找到对应角色');
        return;
    }

	var column = [
    {
        "sTitle": "服务器ID(server_id)",
    },
    {
        "sTitle": "帐号ID(guid)",
    },
    {
        "sTitle": "角色ID(role_id)"
    },
    {
        "sTitle": "操作名称(action_name)"
    },
    {
        "sTitle": "现有总数(total_count)"
    },
	{
		"sTitle": "变化数(spend_count)"
	},
    {
        "sTitle": "物品ID(item_const_id)"
    },
    {
        "sTitle": "操作时间(time)"
    },
    {
        "sTitle": "额外信息(desc)"
    }];
	var aaData = [];
	for(var i in json.data) {
		var row = [json.data[i].server_id, json.data[i].guid, json.data[i].role_id, json.data[i].action_name, json.data[i].total_count, json.data[i].spend_count, json.data[i].item_const_id, json.data[i].time, json.data[i].desc];
		aaData.push(row);
	}

	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": false,
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
}
</script>