<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li<?php if($page_name == 'index'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('index'); ?>"><i class="icon icon-home"></i><span>总览</span></a></li>
    <li<?php if($page_name == 'permission'): ?> class="active"<?php endif; ?>><a href="widgets.html"><i class="icon icon-inbox"></i><span>权限设置</span></a> </li>
    <li<?php if($page_name == 'administrators'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('administrators'); ?>"><i class="icon icon-signal"></i><span>管理员设置</span></a></li>
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>用户在线数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li<?php if($page_name == 'account/current_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/current_online'); ?>">即时在线数据</a></li>
        <li<?php if($page_name == 'account/max_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/max_online'); ?>">最高在线数据</a></li>
        <li<?php if($page_name == 'account/avg_online'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/avg_online'); ?>">平均在线数据</a></li>
      </ul>
    </li>
    <li class="submenu"><a href="#"><i class="icon icon-file"></i><span>用户数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li<?php if($page_name == 'account/register_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_account'); ?>">服务器注册用户数</a></li>
        <li<?php if($page_name == 'account/modify_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/modify_account'); ?>">改名用户数</a></li>
        <li<?php if($page_name == 'account/register_new_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_new_account'); ?>">新增注册用户</a></li>
        <li<?php if($page_name == 'account/modify_new_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/modify_new_account'); ?>">新改名用户数</a></li>
        <li<?php if($page_name == 'account/active_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/active_account'); ?>">服务器活跃用户数</a></li>
        <li<?php if($page_name == 'account/pay_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/pay_account'); ?>">服务器付费用户数</a></li>
        <li<?php if($page_name == 'account/flowover_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/flowover_account'); ?>">服务器流失用户数</a></li>
        <li<?php if($page_name == 'account/reflow_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/reflow_account'); ?>">服务器回流用户数</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i><span>付费/消费数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li><a href="error403.html">充值记录</a></li>
        <li><a href="error404.html">消费记录</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i><span>游戏行为监控</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li<?php if($page_name == 'behavior/job'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/job'); ?>">职业数量分布</a></li>
        <li<?php if($page_name == 'behavior/level'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/level'); ?>">等级分布</a></li>
        <li<?php if($page_name == 'behavior/progress'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('behavior/progress'); ?>">角色游戏进度</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i><span>游戏管理员</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li<?php if($page_name == 'master/server'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('master/server'); ?>">开/停服务器</a></li>
        <li<?php if($page_name == 'master/send_message'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('master/send_message'); ?>">发布游戏公告</a></li>
        <li<?php if($page_name == 'master/grant'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('master/grant'); ?>">发放游戏道具</a></li>
      </ul>
    </li>
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
  </ul>
</div>
<!--sidebar-menu-->