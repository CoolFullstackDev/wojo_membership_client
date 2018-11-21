<form action="setup.php?step=2" method="post">
  <div id="inner">
    <aside>
      <nav><span>pre-installation</span> <span> license </span> <span class="active"> configuration</span><span>completed</span></nav>
    </aside>
    <div class="middle"></div>
    <main>
      <h3>1. MySQL database configuration</h3>
      <p class="info">Setting up Membership Manager Pro to run on your server involves 3 simple steps. Please enter the hostname of the server Membership Manager Pro is to be installed on. Enter the MySQL username, password and database name you wish to use with Membership Manager Pro. </p>
      <?php echo isset($_SESSION['msg']) ?  "<div class=\"error\">{$_SESSION['msg']}</div>" : '';?>
      <table class="data forms">
        <tr>
          <td style="width:40%">MySQL Hostname :</td>
          <td><input type="text" name="dbhost" value="<?php echo isset($_POST['dbhost']) ? sanitize($_POST['dbhost']) : 'localhost'; ?>" id="t1">
            <span class="err" id="err1">Please input correct MySQL hostname.</span></td>
        </tr>
        <tr>
          <td>MySQL User Name:</td>
          <td><input type="text" name="dbuser"  value="<?php echo isset($_POST['dbuser']) ? sanitize($_POST['dbuser']) : ''; ?>" id="t2">
            <span class="err" id="err2">Please input correct MySQL username.</span></td>
        </tr>
        <tr>
          <td>MySQL Password:</td>
          <td><input type="password" name="dbpwd"></td>
        </tr>
        <tr>
          <td>MySQL Database Name:</td>
          <td><input type="text" name="dbname" value="<?php echo isset($_POST['dbname']) ? sanitize($_POST['dbname']) : ''; ?>" id="t3">
            <span class="err" id="err3">Please input correct database name.</span></td>
        </tr>
      </table>
      <input type="hidden" name="db_action" id="db_action" value="1">
      <div class="divider"></div>
      <h3>2. Common configuration</h3>
      <p class="info">Configure correct paths and URLs to your Membership Manager Pro.</p>
      <table class="data forms">
        <tr>
          <td style="width:40%">Install Directory:</td>
          <td><input type="text" name="site_dir" value="<?php echo str_replace("/", "", $script_path);?>"  readonly></td>
        </tr>
        <tr>
          <td>Company Name:</td>
          <td><input type="text" name="company" value="Your Company Name"></td>
        </tr>
        <tr>
          <td>Site Email:</td>
          <td><input type="text" name="site_email" value="site@mail.com" id="t4">
            <span class="err" id="err4">Please input correct site email.</span></td>
        </tr>
      </table>
      <div class="divider"></div>
      <h3>3. Administrator configuration</h3>
      <p class="info">Please set your admin username. It will be used for loggin to your admin panel. Your temporary password is right bellow. Take a note of it, you will need to to login into your admin panel. Once logged in you can chnage it to something more secure.</p>
      <table class="data forms">
        <tr>
          <td style="width:40%">Admin Username:</td>
          <td><input type="text" name="admin_username" value="<?php echo isset($_POST['admin_username']) ? sanitize($_POST['admin_username']) : 'admin'; ?>" id="t5">
            <span class="err" id="err5">Please input correct admin username.</span></td>
        </tr>
        <tr>
          <td>Temp Password:</td>
          <td><input type="text" name="pass" value="pass1234" disabled></td>
        </tr>
      </table>
    </main>
  </div>
  <footer class="clearfix"> <small>current <b>mmp v.4.10</b></small>
    <div id="buttons">
      <button type="button" class="button" onclick="document.location.href='setup.php?step=1';" name="back">Back</button>
      &nbsp;&nbsp;
      <button type="submit" class="button" name="next" >Next</button>
    </div>
  </footer>
</form>