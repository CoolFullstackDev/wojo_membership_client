<div id="inner">
  <aside>
    <nav><span class="active">pre-installation</span> <span> license </span> <span> configuration</span><span>completed</span></nav>
  </aside>
  <div class="middle"></div>
  <main>
    <h3>1. Server Configuration</h3>
    <p class="info">If any of these items are highlighted in red then please take actions to correct them. Failure to do so could lead to your installation not functioning correctly. </p>
    <table class="data">
      <thead>
        <tr>
          <th>PHP Settings</th>
          <th>Current Settings</th>
          <th>Required Settings</th>
          <th>Status</th>
        </tr>
      </thead>
      <tr>
        <td>PHP Version:</td>
        <td><?php echo phpversion(); ?></td>
        <td>5.6+</td>
        <td><?php echo (phpversion() >= '5.6') ? '<img src="images/yes.svg" alt="Good" class="image" />' : '<img src="images/no.svg" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Register Globals:</td>
        <td><?php echo (ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
        <td>Off</td>
        <td><?php echo (!ini_get('register_globals')) ? '<img src="images/yes.svg" alt="Good" class="image" />' : '<img src="images/no.svg" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Magic Quotes GPC:</td>
        <td><?php echo (ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
        <td>Off</td>
        <td><?php echo (!ini_get('magic_quotes_gpc')) ? '<img src="images/yes.svg" alt="Good" class="image" />' : '<img src="images/no.svg" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>File Uploads:</td>
        <td><?php echo (ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo (ini_get('file_uploads')) ? '<img src="images/yes.svg" alt="Good" class="image" />' : '<img src="images/no.svg" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Session Auto Start:</td>
        <td><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
        <td>Off</td>
        <td><?php echo (!ini_get('session_auto_start')) ? '<img src="images/yes.svg" alt="Good" class="image" />' : '<img src="images/no.svg" class="image" alt="Bad" />'; ?></td>
      </tr>
    </table>
    <div class="divider"></div>
    <h3>2. Server Extensions</h3>
    <p class="info">These settings are recommended for PHP in order to ensure full compatibility with Membership Manager Pro.
      However, Membership Manager Pro will still operate if your settings do not quite match the recommended.</p>
    <table class="data">
      <thead>
        <tr>
          <th>Extension</th>
          <th>Current Settings</th>
          <th>Required Settings</th>
          <th>Status</th>
        </tr>
      </thead>
      <tr>
        <td>PDO:</td>
        <td><?php echo extension_loaded('PDO') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('PDO') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>GD:</td>
        <td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('gd') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Mb String:</td>
        <td><?php echo extension_loaded('mbstring') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('mbstring') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Intl:</td>
        <td><?php echo extension_loaded('intl') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('intl') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>Zlib:</td>
        <td><?php echo function_exists('gzcompress') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo function_exists('gzcompress') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>cURL:</td>
        <td><?php echo extension_loaded('curl') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('curl') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
      <tr>
        <td>ZIP:</td>
        <td><?php echo extension_loaded('zlib') ? 'On' : 'Off'; ?></td>
        <td>On</td>
        <td><?php echo extension_loaded('zlib') ? '<img src="images/yes.svg" class="image" alt="Good" />' : '<img src="images/no.png" class="image" alt="Bad" />'; ?></td>
      </tr>
    </table>
    <div class="divider"></div>
    <h3>3. Directory &amp; File Permissions</h3>
    <p class="info">In order for Membership Manager Pro to function correctly it needs to be able to access or write to certain files or directories. If you see "Unwriteable" you need to change the permissions on the file or directory to allow Membership Manager Pro to write to it. </p>
    <div class="divider"></div>
    <table class="data">
      <?php getWritableCell('lib');?>
      <?php getWritableCell('uploads');?>
      <?php getWritableCell('view'.CMS_DS.'admin'.CMS_DS.'cache');?>
      <?php getWritableCell('view'.CMS_DS.'front'.CMS_DS.'cache');?>
    </table>
  </main>
</div>
<footer class="clearfix"> <small>current <b>mmp v.4.10</b></small>
  <div id="buttons">
    <button type="button" class="button" onclick="document.location.href='setup.php';" name="check">Check</button>
    &nbsp;&nbsp;
    <button type="button" class="button" onclick="document.location.href='setup.php?step=1';" name="next" tabindex="3" >Next</button>
  </div>
</footer>