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
            <h5>广告点击列表，总数 <span id="click_count"></span></h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="listTable">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>平台</th>
                  <th>ClickId</th>
                  <th>时间</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeA">
                  <td colspan="4"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>转化列表，总数 <span id="valid_click_count"></span></h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="zhuanhuaTable">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>平台</th>
                </tr>
              </thead>
              <tbody>
                <tr class="gradeA">
                  <td colspan="2"></td>
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
var zhuanhuaTableHandler;

$(function() {
	$.post("<?php echo site_url('channel/zhuanhua/get_count'); ?>", {}, function(data) {
		if(data) {
			var json = eval("(" + data + ")");
			$("#click_count").text(json.click_count);
			$("#valid_click_count").text(json.valid_click_count);
		}
	});
	dataTableHandler = $('#listTable').dataTable({
		"bInfo": true,
		"bAutoWidth": false,
		"bFilter": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('channel/zhuanhua/lists'); ?>",
		"sServerMethod": "POST",
		"fnServerData": function(sSource, aoData, fnCallback) {
			$.ajax({
				"dataType": 'json',
				"type": "POST",
				"url": sSource,
				"data": aoData,
				"success": fnCallback
			});
		},
		"aoColumns": [
			{"mData": "ip"},
			{
				"mData": "agent",
				"fnRender": function(obj) {
					var sub = "CPU iPhone OS";
					var index = obj.aData.agent.indexOf(sub);
					var version = "";
					if(index > -1)
					{
						version = obj.aData.agent.substring(index + sub.length + 1, index + sub.length + 6);
						return "iPhone, " + version;
					}
					else
					{
						return "Other";
					}
				}
			},
			{"mData": "clickid"},
			{"mData": "time"}
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

	zhuanhuaTableHandler = $('#zhuanhuaTable').dataTable({
		"bAutoWidth": false,
		"bFilter": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('channel/zhuanhua/zhuanhua_list'); ?>",
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "ip"},
			{
				"mData": "agent",
				"fnRender": function(obj) {
					var sub = "CPU iPhone OS";
					var index = obj.aData.agent.indexOf(sub);
					var version = "";
					if(index > -1)
					{
						version = obj.aData.agent.substring(index + sub.length + 1, index + sub.length + 6);
						return "iPhone, " + version;
					}
					else
					{
						return "Other";
					}
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
});
</script>