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
                        <label class="control-label">玩家ID</label>
                        <div class="controls">
	                    	<input name="accountId" id="accountId" type="text" placeholder="15位数字" />
	                        <span class="help-block">玩家ID与玩家昵称不能同时为空</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">玩家昵称</label>
                        <div class="controls">
	                    	<input name="accountName" id="accountName" type="text" placeholder="15位数字" />
	                        <span class="help-block">玩家ID与玩家昵称不能同时为空</span>
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
          	<span class="icon"> <i class="icon-signal"></i> </span>
            <h5>付费用户信息</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTableRetention">
                  <thead>
                    <tr>
                      <th>服务器ID</th>
                      <th>玩家ID</th>
                      <th>玩家昵称</th>
                      <th>当前等级</th>
                      <th>注册时间</th>
                      <th>最后登录时间</th>
                      <th>首充时间</th>
                      <th>最后充值时间</th>
                      <th>首充绿钻数</th>
                      <th>首充金额</th>
                      <th>最后充值绿钻数</th>
                      <th>最后充值金额</th>
                      <th>累计充值绿钻数</th>
                      <th>累计充值金额</th>
                      <th>ArcUid</th>
                    </tr>
                  </thead>
                </table>
          </div>
        </div>
    </div>
<!--End-Chart-box-->
</div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/masked.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;

$(function() {
	$("select").select2();
	$("#accountId").mask("?999999999999999");
	
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		
		$('#listTable').empty();
		$.post("<?php echo site_url('account/pay_account_info/lists/json'); ?>", {
			"serverId": $("#serverId").val(),
			"accountId": $("#accountId").val(),
			"accountName": $("#accountName").val()
		}, onData);
	});
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	dataTableHandler = $('#listTableRetention').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
        "aaData": json,
        "aoColumns": [
			{"mData": "server_id"},
			{"mData": "GUID"},
			{"mData": "account_nickname"},
			{"mData": "account_level"},
			{"mData": "account_regtime"},
			{"mData": "account_lastlogin"},
			{
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.first_paid_time) {
            return obj.aData.first_paid_time;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.last_paid_time) {
            return obj.aData.last_paid_time;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.first_paid_count) {
            return obj.aData.first_paid_count;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.first_paid_amount) {
            return obj.aData.first_paid_amount / 100;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.last_paid_count) {
            return obj.aData.last_paid_count;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.last_paid_amount) {
            return obj.aData.last_paid_amount / 100;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.total_paid_count) {
            return obj.aData.total_paid_count;
          } else {
            return 'N/A';
          }
        }
      },
      {
        "mData": null,
        "fnRender": function(obj) {
          if(obj.aData.total_paid_amount) {
            return obj.aData.total_paid_amount / 100;
          } else {
            return 'N/A';
          }
        }
      },
      {"mData": "partner_id"}
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