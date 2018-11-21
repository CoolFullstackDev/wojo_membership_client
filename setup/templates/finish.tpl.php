<div id="inner">
  <aside>
    <nav><span>pre-installation</span> <span> license </span> <span> configuration</span><span class="active">completed</span></nav>
  </aside>
  <div class="middle"></div>
  <main>
    <h3>Installation log:</h3>
    <div class="divider"></div>
    <table class="data forms">
      <tr>
        <td>Database Installation</td>
        <td><?php if($_SESSION['msg']):?>
          <p>Error during MySQL queries execution:</p>
          <?php echo $_SESSION['msg']; ?>
          <?php else:?>
          <img src="images/yes.svg" alt="Good" class="image">
          <?php endif;?></td>
      </tr>
      <tr>
        <td>Configuration File</td>
        <td>If there was a problem creating config file, you MUST save config.inc.php file to your local PC and then upload to Membership Manager Pro <strong>/lib/</strong> directory. <a href="javascript:void(0);" onclick="if (document.getElementById('file_content').style.display=='block') { document.getElementById('file_content').style.display='none';} else {document.getElementById('file_content').style.display='block'}">Click here</a> to view the content of config.ini.php file.<br />
          <div style="margin: 10px 0; text-align: center;">
            <input type="button" onclick="document.location.href='safe_config.php?h=<?php echo $_POST['dbhost'].'&u='.$_POST['dbuser'].'&p='.$_POST['dbpwd'].'&n='.$_POST['dbname'].'&k='.sessionKey();?>';" value="Download config.ini.php">
          </div></td>
      </tr>
      <tr>
        <td colspan="2"><div style="display:none;border:0;height: 400px; background-color: #fff; padding:10px;overflow:auto;" id="file_content">
            <?php if (is_callable("highlight_string")):?>
            <?php $param = array("host" => $_POST['dbhost'], "user" => $_POST['dbuser'], "pass" => $_POST['dbpwd'], "name" => $_POST['dbname'], "key" => sessionKey());?>
            <?php highlight_string(writeConfigFile($param, true));?>
            <?php endif;?>
          </div></td>
      </tr>
      <tr>
        <td colspan="2"><div class="remove_install">Now you MUST completely remove 'setup' directory from your server. Please for security reasons chmod your /<b>lib</b>/ directory to 0755.</div></td>
      </tr>
    </table>
  </main>
</div>
<footer class="clearfix"> <small>current <b>mmp v.4.10</b></small>
  <div id="buttons">
    <button type="button" class="button" onclick="history.go(-1)';" name="back">Back</button>
    &nbsp;&nbsp;
    <button type="button" class="button" onclick="document.location.href='../admin/';" name="next" tabindex="3">Admin</button>
  </div>
</footer>