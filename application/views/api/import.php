<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form action="<?php echo site_url("api/import/equipment_config_submit"); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="500" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="50%" align="right">equipment_config</td>
      <td width="50%"><label for="equipmentConfig"></label>
      <input type="file" name="equipmentConfig" id="equipmentConfig" /></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="提交" /></td>
    </tr>
  </table>
</form>
<form action="<?php echo site_url("api/import/mission_config_submit"); ?>" method="post" enctype="multipart/form-data" name="form2" id="form2">
  <table width="500" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="50%" align="right">mission_config</td>
      <td width="50%"><label for="missionConfig"></label>
      <input type="file" name="missionConfig" id="missionConfig" /></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="提交" /></td>
    </tr>
  </table>
</form>
</body>
</html>