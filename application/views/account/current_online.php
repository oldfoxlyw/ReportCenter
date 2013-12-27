<div id="content">
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <span id="btnSwitchSidebar" class="badge margin-left-5 pointer" title="Close Sidebar"><i class="icon-chevron-left"></i><span> 关闭侧边栏</span></span><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
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
                        <select id="serverIp" name="serverIp">
                        <?php foreach($server_result as $server): ?>
                            <option value="http://<?php echo $server->server_ip; ?>"><?php echo $server->server_name; ?></option>
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
          <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span>
            <h5>即时在线人数</h5>
          </div>
          <div class="widget-content nopadding tab-content">
            <div class="widget-content">
                <div class="row-fluid">
                      <div id="chartRegCount"></div>
                </div>
            </div>
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
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/select2.min.js'); ?>"></script>

<script type="text/javascript">
$(function() {
	Highcharts.setOptions({
		global: {
			useUTC: false
		}
	});
	
	$("#btnSearch").click(function() {
		var options = {
				chart: {
					type: 'spline',
					animation: Highcharts.svg, // don't animate in old IE
					marginRight: 10,
					events: {
						load: function() {
		
							// set up the updating of the chart each second
							var series = this.series[0];
							setInterval(function() {
								$.post("<?php echo site_url('account/current_online/lists'); ?>", {
									"serverIp": $("#serverIp").val()
								}, function(data) {
									if(data) {
										var json = eval("(" + data + ")");
										
										var x = (new Date()).getTime(), // current time
											y = json.online_count;
										series.addPoint([x, y], true, true);
									}
								});
							}, 5000);
						}
					}
				},
				title: {
					text: '即时在线数据'
				},
				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150
				},
				yAxis: {
					title: {
						text: '在线人数'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					formatter: function() {
							return '<b>'+ this.series.name +'</b><br/>'+
							Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
							Highcharts.numberFormat(this.y, 0) + "人";
					}
				},
				legend: {
					enabled: false
				},
				exporting: {
					enabled: false
				},
				series: [{
					name: '当前在线人数',
					data: (function() {
						// generate an array of random data
						var data = [],
							time = (new Date()).getTime(),
							i;
		
						for (i = -19; i <= 0; i++) {
							data.push({
								x: time + i * 1000,
								y: null
							});
						}
						return data;
					})()
				}]
			};
		$('#chartRegCount').highcharts(options);
	});
	$("select").select2();
});
</script>