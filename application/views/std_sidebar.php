<!--sidebar-menu-->
<?php
$permissionArray = explode(',', $admin->permission_list);
?>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li<?php if($page_name == 'index'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('index'); ?>"><i class="icon icon-home"></i><span>总览</span></a></li>
    <?php if(in_array('permission', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'permission'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('permission'); ?>"><i class="icon icon-inbox"></i><span>权限设置</span></a> </li><?php endif; ?>
    <?php if(in_array('administrators', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'administrators'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('administrators'); ?>"><i class="icon icon-signal"></i><span>管理员设置</span></a></li><?php endif; ?>
    <!--<?php if(in_array('order/recharge', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge'); ?>"><i class="icon icon-star"></i><span>充值记录</span></a></li><?php endif; ?>-->
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>用户在线数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <?php if(in_array('account/current_online', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/current_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/current_online'); ?>">即时在线数据</a></li><?php endif; ?>
        <?php if(in_array('account/max_online', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/max_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/max_online'); ?>">最高在线数据</a></li><?php endif; ?>
        <?php if(in_array('account/avg_online', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/avg_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/avg_online'); ?>">平均在线数据</a></li><?php endif; ?>
      </ul>
    </li>
    <li class="submenu"><a href="#"><i class="icon icon-file"></i><span>用户数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <?php if(in_array('account/register_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/register_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_account'); ?>">注册用户总数</a></li><?php endif; ?>
        <!--<?php if(in_array('account/modify_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/modify_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/modify_account'); ?>">手动注册用户数</a></li><?php endif; ?>-->
        <?php if(in_array('account/register_new_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/register_new_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_new_account'); ?>">新增注册用户</a></li><?php endif; ?>
        <!--<?php if(in_array('account/modify_new_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/modify_new_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/modify_new_account'); ?>">新增手动注册用户数</a></li><?php endif; ?>-->
        <?php if(in_array('account/active_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/active_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/active_account'); ?>">服务器活跃用户数</a></li><?php endif; ?>
        <?php if(in_array('account/pay_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/pay_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/pay_account'); ?>">服务器付费用户数</a></li><?php endif; ?>
        <?php if(in_array('account/flowover_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/flowover_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/flowover_account'); ?>">服务器流失用户数</a></li><?php endif; ?>
        <?php if(in_array('account/reflow_account', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/reflow_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/reflow_account'); ?>">服务器回流用户数</a></li><?php endif; ?>
        <?php if(in_array('account/flowover_account_detail', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/flowover_account_detail'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/flowover_account_detail'); ?>">服务器流失用户详情</a></li><?php endif; ?>
        <?php if(in_array('account/retention_detail', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/retention_detail'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/retention_detail'); ?>">留存率统计</a></li><?php endif; ?>
        <?php if(in_array('account/pay_account_info', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'account/pay_account_info'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/pay_account_info'); ?>">付费用户信息</a></li><?php endif; ?>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-heart"></i><span>充值数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <?php if(in_array('order/recharge', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge'); ?>">充值总览</a></li><?php endif; ?>
        <?php if(in_array('order/recharge_daily', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge_daily'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge_daily'); ?>">每日充值概况</a></li><?php endif; ?>
        <?php if(in_array('order/recharge_mvp', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge_mvp'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge_mvp'); ?>">玩家充值总额查询统计</a></li><?php endif; ?>
        <?php if(in_array('order/recharge_top30', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge_top30'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge_top30'); ?>">每日Top30累充查询</a></li><?php endif; ?>
        <?php if(in_array('order/recharge_top50', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge_top50'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge_top50'); ?>">历史Top50累充查询</a></li><?php endif; ?>
        <?php if(in_array('order/recharge_flow', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/recharge_flow'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/recharge_flow'); ?>">玩家充值流水查询</a></li><?php endif; ?>
        <?php if(in_array('order/lifetime', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/lifetime'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/lifetime'); ?>">玩家生命周期报表</a></li><?php endif; ?>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-heart"></i><span>消费数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <?php if(in_array('order/consume', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/consume'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/consume'); ?>">消费总体统计</a></li><?php endif; ?>
        <?php if(in_array('order/buy_equipment', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/buy_equipment'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/buy_equipment'); ?>">购买装备消费统计</a></li><?php endif; ?>
        <?php if(in_array('order/equipment_sales', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/equipment_sales'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/equipment_sales'); ?>">装备销量统计</a></li><?php endif; ?>
        <?php if(in_array('order/consume_mvp', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/consume_mvp'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/consume_mvp'); ?>">玩家消耗绿钻总额查询</a></li><?php endif; ?>
        <?php if(in_array('order/consume_detail', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'order/consume_detail'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('order/consume_detail'); ?>">玩家消耗详单查询</a></li><?php endif; ?>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i><span>游戏行为监控</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <?php if(in_array('behavior/job', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'behavior/job'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/job'); ?>">职业数量分布</a></li><?php endif; ?>
        <?php if(in_array('behavior/level', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'behavior/level'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/level'); ?>">等级分布</a></li><?php endif; ?>
        <?php if(in_array('behavior/progress', $permissionArray) || in_array('All', $permissionArray)): ?><li<?php if($page_name == 'behavior/progress'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/progress'); ?>">角色游戏进度</a></li><?php endif; ?>
      </ul>
    </li>
    <!--
    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
    -->
  </ul>
</div>
<!--sidebar-menu-->