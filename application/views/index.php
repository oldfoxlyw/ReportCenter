<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 首页</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lb"> <a href="index.html"> <i class="icon-dashboard"></i> <span class="label label-important">20</span> My Dashboard </a> </li>
        <li class="bg_lg span3"> <a href="charts.html"> <i class="icon-signal"></i> Charts</a> </li>
        <li class="bg_ly"> <a href="widgets.html"> <i class="icon-inbox"></i><span class="label label-success">101</span> Widgets </a> </li>
        <li class="bg_lo"> <a href="tables.html"> <i class="icon-th"></i> Tables</a> </li>
        <li class="bg_ls"> <a href="grid.html"> <i class="icon-fullscreen"></i> Full width</a> </li>
        <li class="bg_lo span3"> <a href="form-common.html"> <i class="icon-th-list"></i> Forms</a> </li>
        <li class="bg_ls"> <a href="buttons.html"> <i class="icon-tint"></i> Buttons</a> </li>
        <li class="bg_lb"> <a href="interface.html"> <i class="icon-pencil"></i>Elements</a> </li>
        <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li>
        <li class="bg_lr"> <a href="error404.html"> <i class="icon-info-sign"></i> Error</a> </li>

      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>7天内注册总人数变化趋势图</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span12">
              <div id="chartRegCount" class="chart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box-->
<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>7天内改名总人数变化趋势图</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span12">
              <div id="chartModifyCount" class="chart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box-->
<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>7天内活跃人数变化趋势图</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span12">
              <div id="chartActiveCount" class="chart"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box-->
  </div>
</div>
<script src="<?php echo base_url('resources/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/matrix.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>

<script type="text/javascript">
$(function() {
	$.post("<?php echo site_url('index/lists/highchart'); ?>", {}, onData);
});

function onData(data) {
	if(!data)
	{
		return;
	}
	var json = eval("(" + data + ")");
	
	var series1 = [];
	var series2 = [];
	var series3 = [];
	for(var i in json)
	{
		if(i != "axis")
		{
			var obj1 = {};
			var obj2 = {};
			var obj3 = {};
			obj1.name = i;
			obj2.name = i;
			obj3.name = i;
			var data1 = [];
			var data2 = [];
			var data3 = [];
			
			for(var j in json[i])
			{
				data1.push(parseInt(json[i][j].reg_account));
				data2.push(parseInt(json[i][j].modify_account));
				data3.push(parseInt(json[i][j].active_account));
			}
			obj1.data = data1;
			obj2.data = data2;
			obj3.data = data3;
			
			series1.push(obj1);
			series2.push(obj2);
			series3.push(obj3);
		}
	}
	
	$('#chartRegCount').highcharts({
		credits: {
			enabled: false
		},
		title: {
			text: '7天内注册总人数变化趋势图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis
		},
		yAxis: {
			title: {
				text: '注册总人数'
			},
			plotLines: [{
				value: 0,
				width: 2,
				color: '#808080'
			}]
		},
		tooltip: {
			crosshairs: [true, true]
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 1
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				}
			}
		},
		series: series1
	});
	
	$('#chartModifyCount').highcharts({
		credits: {
			enabled: false
		},
		title: {
			text: '7天内改名总人数变化趋势图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis
		},
		yAxis: {
			title: {
				text: '改名总人数'
			},
			plotLines: [{
				value: 0,
				width: 2,
				color: '#808080'
			}]
		},
		tooltip: {
			crosshairs: [true, true]
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 1
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				}
			}
		},
		series: series2
	});
	
	$('#chartActiveCount').highcharts({
		credits: {
			enabled: false
		},
		title: {
			text: '7天内活跃用户人数变化趋势图'
		},
		subtitle: {
			text: '数据来源：数据统计平台'
		},
		xAxis: {
			categories: json.axis
		},
		yAxis: {
			title: {
				text: '活跃用户人数'
			},
			plotLines: [{
				value: 0,
				width: 2,
				color: '#808080'
			}]
		},
		tooltip: {
			crosshairs: [true, true]
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle',
			borderWidth: 1
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				}
			}
		},
		series: series3
	});
}
</script>