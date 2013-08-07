<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li<?php if($page_name == 'index'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('index'); ?>"><i class="icon icon-home"></i><span>总览</span></a></li>
    <li<?php if($page_name == 'permission'): ?> class="active"<?php endif; ?>><a href="widgets.html"><i class="icon icon-inbox"></i><span>权限设置</span></a> </li>
    <li<?php if($page_name == 'administrators'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('administrators'); ?>"><i class="icon icon-signal"></i><span>管理员设置</span></a></li>
    <li class="submenu"><a href="#"><i class="icon icon-th-list"></i><span>用户在线数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li><a href="form-common.html">即时在线数据</a></li>
        <li><a href="form-validation.html">最高在线数据</a></li>
        <li><a href="form-wizard.html">平均在线数据</a></li>
      </ul>
    </li>
    <li class="submenu"><a href="#"><i class="icon icon-file"></i><span>用户数据</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li<?php if($page_name == 'account/register_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_account'); ?>">服务器注册用户数</a></li>
        <li><a href="gallery.html">创建角色数</a></li>
        <li<?php if($page_name == 'account/register_new_account'): ?> class="active"<?php endif; ?>><a href="<?php echo site_url('account/register_new_account'); ?>">新增注册用户</a></li>
        <li><a href="invoice.html">新创建角色数</a></li>
        <li><a href="<?php echo site_url('account/active_account'); ?>">服务器活跃用户数</a></li>
        <li><a href="<?php echo site_url('account/pay_account'); ?>">服务器付费用户数</a></li>
        <li><a href="<?php echo site_url('account/flowover_account'); ?>">服务器流失用户数</a></li>
        <li><a href="<?php echo site_url('account/reflow_account'); ?>">服务器回流用户数</a></li>
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
        <li><a href="error403.html">职业数量分布</a></li>
        <li><a href="error404.html">等级分布</a></li>
        <li><a href="error404.html">角色游戏进度</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i><span>游戏管理员</span><span class="label label-important"><i class="icon icon-arrow-down"></i></span></a>
      <ul>
        <li><a href="error403.html">开/停服务器</a></li>
        <li><a href="error404.html">发布游戏公告</a></li>
        <li><a href="error404.html">发放游戏道具</a></li>
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