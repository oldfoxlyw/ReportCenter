<div id="content">
	<div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">管理员管理</a> </div>
        <h1>管理员管理</h1>
  	</div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
              <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>管理员列表</h5>
              </div>
              <div class="widget-content nopadding">
                <table class="table table-bordered data-table" id="listTable">
                  <thead>
                    <tr>
                      <th>GUID</th>
                      <th>用户名</th>
                      <th>角色权限</th>
                      <th>帐号状态</th>
                      <th>-</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="gradeA">
                      <td colspan="5">载入中...</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/jquery.ui.custom.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script> 
<script type="text/javascript">
$(function() {
	$('#listTable').dataTable({
		"bAutoWidth": false,
		"bJQueryUI": true,
		"bStateSave": true,
		"sPaginationType": "full_numbers",
		"sDom": '<"H"lr>t<"F"fp>',
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "<?php echo site_url('administrators/lists'); ?>",
		"sServerMethod": "POST",
		"aoColumns": [
			{"mData": "GUID", "width": 300, "bSortable": false},
			{"mData": "user_name"},
			{"mData": "permission_name"},
			{
				"mData": "user_freezed",
				"fnRender": function(obj) {
					if(obj.aData.user_freezed == "1") {
						return "<span class=\"label label-important\">冻结</span>"
					} else {
						return "<span class=\"label label-success\">正常</span>"
					}
				}
			},
			{
				"mData": null,
				"fnRender": function(obj) {
					return "<div class=\"btn-group\"><button onclick=\"location.href='<?php echo site_url('administrators/edit') ?>/" + obj.aData.GUID + "'\" class=\"btn btn-info\">编辑</button><button data-toggle=\"dropdown\" class=\"btn btn-info dropdown-toggle\"><span class=\"caret\"></span></button><ul class=\"dropdown-menu\"><li><a href=\"<?php echo site_url('administrators/edit') ?>/" + obj.aData.GUID + "\">编辑</a></li><li><a href=\"#\">冻结</a></li><li class=\"divider\"></li><li><a href=\"#\">删除</a></li></ul></div>";
				}
			}
		]
	});
	
	$('select').select2();
	
	$("span.icon input:checkbox, th input:checkbox").click(function() {
		var checkedStatus = this.checked;
		var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');		
		checkbox.each(function() {
			this.checked = checkedStatus;
			if (checkedStatus == this.checked) {
				$(this).closest('.checker > span').removeClass('checked');
			}
			if (this.checked) {
				$(this).closest('.checker > span').addClass('checked');
			}
		});
	});
});
</script>