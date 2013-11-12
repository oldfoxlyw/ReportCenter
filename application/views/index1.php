<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs" id="indexNavTab">
            	<?php foreach($server as $s): ?>
              	<li><a data-toggle="tab" href="#tab_<?php echo $s->account_server_id; ?>"><?php echo $s->server_name ?></a></li>
              	<?php endforeach; ?>
            </ul>
          </div>
          <div class="widget-content nopadding tab-content" id="indexTab">
          	<?php foreach($server as $s): ?>
            <div id="tab_<?php echo $s->account_server_id; ?>" class="tab-pane">
                <table class="table table-bordered data-table" id="listTable_<?php echo $s->account_server_id; ?>">
                  <thead>
                    <tr>
                      <th>时间</th>
                      <th>总注册用户</th>
                      <th>当天新注册用户</th>
                      <th>当天登录用户</th>
                      <th>次日登录</th>
                      <th>三日登录</th>
                      <th>活跃用户<br />（三天内有登录）</th>
                      <th>流失用户数<br />（超过一周未登录）</th>
                      <th>次日留存率</th>
                      <th>三日留存率</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="10">载入中...</td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <?php endforeach; ?>
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
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script> 

<script type="text/javascript">
$(function() {
	$("#indexNavTab > li:first").addClass("active");
	$("#indexTab > div:first").addClass("active");
	
	<?php foreach($server as $s): ?>
	$('#listTable_<?php echo $s->account_server_id; ?>').dataTable({
		"bAutoWidth": false,
		"bFilter": false,
		"bLengthChange": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('index1/lists/highchart'); ?>?server_id=<?php echo $s->account_server_id; ?>",
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "log_date"},
			{"mData": "reg_account"},
			{"mData": "reg_new_account"},
			{"mData": "login_account"},
			{"mData": "prev_current_login"},
			{"mData": "third_current_login"},
			{"mData": "active_account"},
			{"mData": "flowover_account"},
			{
				"mData": "next_retention",
				"fnRender": function(obj) {
					return obj.aData.next_retention / 100 + "%";
				}
			},
			{"mData": "third_retention"}
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
    <?php endforeach; ?>
	
	$('select').select2();
});
</script>