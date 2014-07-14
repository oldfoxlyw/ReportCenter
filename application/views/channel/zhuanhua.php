<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
    <h1>帐号管理</h1>
</div>
<!--End-breadcrumbs-->

<!--Action boxes-->
<div class="container-fluid">
<!--End-Action boxes-->
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>账号列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTable">
              <thead>
                <tr>
                  <th>GUID</th>
                  <th>用户名</th>
                  <th>角色昵称</th>
                  <th>帐号状态</th>
                  <th>服务器编号</th>
                  <th>渠道编号</th>
                  <th>-</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeA">
                  <td colspan="6"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
var dataTableHandler;

$(function() {
    $("#btnSubmit").click(function() {
		if($("#guid").val() == "" && $("#accountName").val() == "" && $("#nickname").val() == "") {
			alert("请至少填写一个条件");
			return false;
		}
		if(dataTableHandler) {
			dataTableHandler.fnDestroy();
		}
		$.post("<?php echo site_url('master/account_manage/lists'); ?>", {
			"serverId": $("#serverId").val(),
			"guid": $("#guid").val(),
			"accountName": $("#accountName").val(),
			"nickname": $("#nickname").val()
		}, onData);
	});
});

function onData(data) {
	if(!data) {
		return;
	}
	
	var json = eval("(" + data + ")");
	dataTableHandler = $('#listTable').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"aaData": json,
		"aoColumns": [
			{"mData": "GUID"},
			{"mData": "account_name"},
			{"mData": "account_nickname"},
			{"mData": "account_status"},
			{"mData": "server_id"},
			{"mData": "partner_key"},
			{
				"mData": null,
				"fnRender": function(obj) {
					var freezed = "";
					if(obj.aData.account_status != '-1') {
						freezed = "<button class=\"btn btn-info btnFreeze\" href=\"#\">封停</button>";
					} else {
						freezed = "<button class=\"btn btn-info btnUnfreeze\" href=\"#\">解封</button>";
					}
					return "<div class=\"btn-group\"><button class=\"btn btn-info btnResetPassword\">重置密码</button>" + freezed + "</div>";
					//return "<div class=\"btn-group\"><button class=\"btn btn-info btnResetPassword\">重置密码</button>" + freezed + "<button url=\"<?php echo site_url('master/account_manage/delete') ?>/" + obj.aData.GUID + "\" class=\"btn btn-info btnDelete\">删除</button></div>";
					//return "<div class=\"btn-group\"><button onclick=\"location.href='<?php echo site_url('master/account_manage/reset_password') ?>/" + obj.aData.GUID + "'\" class=\"btn btn-info\">重置密码</button><button onclick=\"location.href='<?php echo site_url('master/account_manage/edit') ?>/" + obj.aData.GUID + "'\" class=\"btn btn-info\">编辑</button><button data-toggle=\"dropdown\" class=\"btn btn-info dropdown-toggle\"><span class=\"caret\"></span></button><ul class=\"dropdown-menu\">" + freezed + "<li class=\"divider\"></li><li><a href=\"<?php echo site_url('master/account_manage/delete') ?>/" + obj.aData.GUID + "\">删除</a></li></ul></div>";
				}
			}
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
}
</script>