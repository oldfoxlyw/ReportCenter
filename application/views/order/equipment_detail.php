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
                  <label class="control-label" for="equipmentName">装备名称（附带智能提示）</label>
                  <div class="controls">
                    <input type="text" id="equipmentName" name="equipmentName" placeholder="装备名称" value="" /><span class="help-block"><strong><a id="btnGetEquipment" href="#">从列表选择装备</a></strong></span>
                    <div class="modal hide" id="modalGetEquipment">
                        <div class="modal-header">
                          <button type="button" id="modalGetEquipmentClose" class="close" data-dismiss="modal">×</button>
                          <h3>装备列表</h3>
                        </div>
                        <div class="modal-body">
							<img src="<?php echo base_url('resources/img/loading.gif'); ?>" />
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
	$("#btnGetEquipment").click(function() {
		$("#modalGetEquipment").removeClass("hide");
		$.post("<?php echo site_url('api/consume/get_equipment_name/json'); ?>", {}, onGetEquipment);
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
	
	$("#modalGetEquipment > .modal-body").empty();
	if(json) {
		for(var i in json) {
			$("#modalGetEquipment > .modal-body").append('<span class="label margin-right-5 pointer">' + json[i].equipment_name + '</span>');
		}
	} else {
		$("#modalGetEquipment > .modal-body").append('<p>没有装备信息</p>');
	}
	
	$("#modalGetEquipment > .modal-body").find("span").click(function() {
		$("#modalGetEquipment > .modal-body").find("span").removeClass("label-success");
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