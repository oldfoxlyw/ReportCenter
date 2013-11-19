<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
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
                                <input type="text" id="startTime" name="startTime" value="<?php echo date('Y-m-d', $current_time - 7 * 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <label class="control-label">结束时间(yyyy-mm-dd)</label>
                        <div class="controls">
                            <div data-date="<?php echo date('Y-m-d', $current_time - 86400); ?>" class="input-append date datepicker">
                                <input type="text" id="endTime" name="endTime" value="<?php echo date('Y-m-d', $current_time - 86400); ?>"  data-date-format="yyyy-mm-dd" class="span11" >
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                  <label class="control-label" for="equipmentName">装备名称</label>
                  <div class="controls">
                    <input type="text" id="equipmentName" name="equipmentName" placeholder="装备名称" value="" /><span class="help-block"><strong><a id="btnGetEquipment" href="#">从列表选择装备</a></strong></span>
                    <div class="modal hide" id="modalGetEquipment">
                        <div class="modal-header">
                          <button type="button" id="modalGetEquipmentClose" class="close" data-dismiss="modal">×</button>
                          <h3>装备列表</h3>
                        </div>
                        <div class="modal-body">
                        	<div class="widget-box collapsible" id="equipmentList">
                              <div class="widget-title"><a href="#collapse1" data-toggle="collapse" type="1"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>武器</h5>
                                </a></div>
                              <div class="collapse" id="collapse1">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                              <div class="widget-title"> <a href="#collapse2" data-toggle="collapse" type="2"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>手套</h5>
                                </a> </div>
                              <div class="collapse" id="collapse2">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                              <div class="widget-title"> <a href="#collapse3" data-toggle="collapse" type="3"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>戒指</h5>
                                </a> </div>
                              <div class="collapse" id="collapse3">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                              <div class="widget-title"> <a href="#collapse4" data-toggle="collapse" type="4"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>衣服</h5>
                                </a> </div>
                              <div class="collapse" id="collapse4">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                              <div class="widget-title"> <a href="#collapse5" data-toggle="collapse" type="5"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>鞋子</h5>
                                </a> </div>
                              <div class="collapse" id="collapse5">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                              <div class="widget-title"> <a href="#collapse6" data-toggle="collapse" type="6"> <span class="icon"><i class="icon-arrow-down"></i></span>
                                <h5>项链</h5>
                                </a> </div>
                              <div class="collapse" id="collapse6">
                                <div class="widget-content"><img src="<?php echo base_url('resources/img/loading.gif'); ?>" /></div>
                              </div>
                            </div>
                        </div>
                        <div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal" id="modalGetEquipmentCancel">取消</a> <a href="#" id="modalGetEquipmentSubmit" class="btn btn-primary">确定并关闭</a> </div>
                      </div>
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
<!--End-Chart-box-->
</div>
</div>
<link rel="stylesheet" href="<?php echo base_url('resources/css/datepicker.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('resources/css/select2.css'); ?>" />
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/masked.js'); ?>"></script> 
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap-datepicker.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/jquery.dataTables.min.js'); ?>"></script>

<script type="text/javascript">
$(function() {
    $('.datepicker').datepicker();
	$("#equipmentList > div.widget-title > a").click(function() {
		if(!$(this).parent().next().hasClass("in")) {
			var type = parseInt($(this).attr("type"));
			$.post("<?php echo site_url('api/consume/get_equipment_name/json'); ?>", {"type": type}, onGetEquipment);
			$(this).after("<input type=\"text\" name=\"searcher\" placeholder=\"输入名称以筛选\" value=\"\" style=\"margin-top:3px;\" />");
			$("#equipmentList > div.widget-title > input").keyup(function() {
				var value = $(this).val();
				if(value) {
					$(this).parent().next().find(".widget-content").find("span.label").each(function() {
						var text = $(this).text();
						if(text.indexOf(value) >= 0) {
							$(this).show();
						} else {
							$(this).hide();
						}
					});
				} else {
					$(this).parent().next().find(".widget-content").find("span.label").show();
				}
			});
		} else {
			$(this).next().remove();
		}
	});
	$("#btnGetEquipment").click(function() {
		$("#modalGetEquipment").removeClass("hide");
		return false;
	});
	$("#modalGetEquipmentClose").click(function() {
		$("#modalGetEquipment").addClass("hide");
	});
	$("#modalGetEquipmentCancel").click(function() {
		$("#modalGetEquipment").addClass("hide");
	});
	$("#modalGetEquipmentSubmit").click(function() {
		var selected = $("#modalGetEquipment > .modal-body").find("span.label-success");
		if(selected.length > 0) {
			$("#equipmentName").val(selected.text());
			$("#modalGetEquipment").addClass("hide");
		}
	});
	$("#btnSearch").click(function() {
		if(dataTableHandler) dataTableHandler.fnDestroy();
		$('#listTable').empty();
		$.post("<?php echo site_url('order/buy_equipment/lists/highchart'); ?>", {
			"serverId": $("#serverId").val(),
			"startTime": $("#startTime").val(),
			"itemType": $("#itemType").val()
		}, onData);
	});
	$("select").select2();
});

function onGetEquipment(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	var container = $("#collapse" + json.type + " > div.widget-content");
	container.empty();
	if(json.result) {
		for(var i in json.result) {
			container.append('<span class="label margin-right-5 pointer">' + json.result[i].equipment_name + '</span>');
		}
	} else {
		container.append('<p>没有装备信息</p>');
	}
	
	container.find("span").click(function() {
		$("#equipmentList > .collapse > .widget-content").find("span").removeClass("label-success");
		$(this).addClass("label-success");
	});
}

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	$("select").select2();
}
</script>