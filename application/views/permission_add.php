<div id="content">
	<div id="content-header">
        <div id="breadcrumb"> <a href="#" title="首页" class="tip-bottom"><i class="icon-home"></i> 首页</a> <a href="#" class="current">权限设置</a> </div>
        <h1><?php if(empty($edit)): ?>添加<?php else: ?>修改<?php endif; ?>权限</h1>
  	</div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
			<form action="<?php echo site_url('permission/submit'); ?>" method="post" class="form-horizontal">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-align-justify"></i></span>
                        <h5>基本信息</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <input type="hidden" id="edit" name="edit" value="<?php echo $edit; ?>" />
                        <input type="hidden" id="oldPermissionId" name="oldPermissionId" value="<?php echo $old_permission_id; ?>" />
                        <div class="control-group">
                          <label class="control-label" for="permissionId">权限等级</label>
                          <div class="controls">
                            <input type="text" class="span8" id="permissionId" name="permissionId" placeholder="权限等级，纯数字，不可重复" value="<?php echo $value->permission_id; ?>" />
                          </div>
                        </div>
                        <div class="control-group">
                          <label class="control-label" for="permissionName">权限名称</label>
                          <div class="controls">
                            <input type="text" class="span8" id="permissionName" name="permissionName" placeholder="权限名称" />
                          </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><input type="checkbox" id="title-checkbox" name="title-checkbox" /></span>
                        <h5>选择权限</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped with-check">
                          <tbody>
                            <tr>
                              <td><input type="checkbox" /></td>
                              <td><strong>系统权限</strong></td>
                              <td width="20%"><input id="permission" name="permission" value="permission" type="checkbox" />查看权限</td>
                              <td width="20%"><input id="permission_add" name="permission_add" value="permission_add" type="checkbox" />添加/修改权限</td>
                              <td width="20%">&nbsp;</td>
                              <td width="20%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" /></td>
                              <td><strong>用户在线数据</strong></td>
                              <td><input id="current_online" name="current_online" value="current_online" type="checkbox" />即时在线数据</td>
                              <td><input id="max_online" name="max_online" value="max_online" type="checkbox" />最高在线数据</td>
                              <td><input id="avg_online" name="avg_online" value="avg_online" type="checkbox" />平均在线数据</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td rowspan="3"><input type="checkbox" /></td>
                              <td rowspan="3"><strong>用户数据</strong></td>
                              <td><input id="register_account" name="register_account" value="register_account" type="checkbox" />服务器注册用户数</td>
                              <td><input id="modify_account" name="modify_account" value="modify_account" type="checkbox" />改名用户数</td>
                              <td><input type="checkbox" />新增注册用户</td>
                              <td><input type="checkbox" />新改名用户数</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" />服务器活跃用户数</td>
                              <td><input type="checkbox" />服务器付费用户数</td>
                              <td><input type="checkbox" />服务器流失用户数</td>
                              <td><input type="checkbox" />服务器回流用户数</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" />服务器流失用户详情</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" /></td>
                              <td><strong>付费/消费数据</strong></td>
                              <td width="20%"><input type="checkbox" />充值记录</td>
                              <td width="20%"><input type="checkbox" />消费记录</td>
                              <td width="20%">&nbsp;</td>
                              <td width="20%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" /></td>
                              <td><strong>游戏行为监控</strong></td>
                              <td width="20%"><input type="checkbox" />职业数量分布</td>
                              <td width="20%"><input type="checkbox" />等级分布</td>
                              <td width="20%"><input type="checkbox" />角色游戏进度</td>
                              <td width="20%">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><input type="checkbox" /></td>
                              <td><strong>游戏管理员</strong></td>
                              <td width="20%"><input type="checkbox" />开/停服务器</td>
                              <td width="20%"><input type="checkbox" />发布游戏公告</td>
                              <td width="20%"><input type="checkbox" />发放游戏道具</td>
                              <td width="20%">&nbsp;</td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="form-actions">
                          <button type="submit" class="btn btn-success">保存</button>
                      </div>
                  </div>
                </div>
			</form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('resources/css/uniform.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.ui.custom.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.uniform.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script type="text/javascript">
$(function() {
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	$("select").select2();
	
	$("#title-checkbox, th input:checkbox").click(function() {
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