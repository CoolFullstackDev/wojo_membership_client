<?php
  /**
   * Help
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: help.tpl.php, v1.00 2016-05-05 10:12:05 gewa Exp $
   */
  if (!defined("_WOJO"))
      die('Direct access to this location is not allowed.');
?>
<h3><?php echo Lang::$word->HP_TITLE;?></h3>
<p class="wojo small text"><?php echo Lang::$word->HP_INFO;?></p>
<div class="wojo big space divider"></div>
<ul class="wojo tabs">
  <li class="active"><a data-tab="#login"><?php echo Lang::$word->HP_SUB1;?></a></li>
  <li><a data-tab="#redirect"> <?php echo Lang::$word->HP_SUB2;?></a></li>
  <li><a data-tab="#form"><?php echo Lang::$word->HP_SUB3;?></a></li>
  <li><a data-tab="#membership"><?php echo Lang::$word->HP_SUB4;?></a></li>
  <li><a data-tab="#cron"><?php echo Lang::$word->HP_SUB5;?></a></li>
  <li><a data-tab="#builder" class="last"><?php echo Lang::$word->HP_SUB6;?></a></li>
</ul>
<div class="wojo attached tabbed segment"> 
  <!-- login -->
  <div id="login" class="wojo tab item">
    <h4>Protecting pages based on user login</h4>
    <p class="wojo small text">First start by creating a new php page that you want to give access to all of your registered users. Let's call this page for the purpose of this tutorial <strong>reg_only_users.php</strong>. At the very beginning of the page start by adding following php code.</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);
<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Make sure that init.php point to correct directory. For example, If your <strong>reg_only_users.php</strong> page is in the same directory as main script, than no changes are necessary, otherwise you need to enter correct path to your init.php page. Depending where <strong>you placed reg_only_users.php </strong>page, below or above root directory init.php becomes <strong>../init.php</strong> if below the root or <strong>otherdir/init.php</strong> if above the root. Now let's add some protection</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);
  
  <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #666666">!</span>App<span style="color: #666666">::</span><span style="color: #7D9029">Auth</span>()<span style="color: #666666">-&gt;</span><span style="color: #7D9029">is_User</span>())
     Url<span style="color: #666666">::</span><span style="color: #7D9029">redirect</span>(SITEURL <span style="color: #666666">.</span> <span style="color: #BA2121">&#39;/&#39;</span>);
<span style="color: #BC7A00">?&gt;</span> 
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">The two new lines of code do login verification. First line checks if user is not logged in, the second one redirects user to login page <strong><?php echo SITEURL;?>/login/</strong>. Now you can continue to add the usual html or php code to your page. In this example we protected single page using login verification process. If user is not logged in we redirect to login page, otherwise, we let the user view the page.</p>
  </div>
  <!-- redirect -->
  <div id="redirect" class="wojo tab item">
    <h4>Redirecting user on successful login</h4>
    <p class="wojo small text">By default when user logs in, it will be redirected to profile page. You can change this behavior by redirecting user to any page of your choice. First start by creating a new php page that you want to redirect user on successful login. Let's call this page for the purpose of this tutorial redirect_page.php. Open up <strong>view/front/index.tpl.php</strong> page in root directory and look for:</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%">
<span style="color: #008000; font-weight: bold">if</span> (<span style="color: #008000">isset</span>(<span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;submit&#39;</span>]))<span style="color: #666666">:</span>
  <span style="color: #008000; font-weight: bold">if</span> (App<span style="color: #666666">::</span><span style="color: #7D9029">Auth</span>()<span style="color: #666666">-&gt;</span><span style="color: #7D9029">login</span>(<span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;username&#39;</span>], <span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;password&#39;</span>]))<span style="color: #666666">:</span>
      Url<span style="color: #666666">::</span><span style="color: #7D9029">redirect</span>(SITEURL <span style="color: #666666">.</span> <span style="color: #BA2121">&#39;/dashboard/&#39;</span>);
  <span style="color: #008000; font-weight: bold">endif</span>;
<span style="color: #008000; font-weight: bold">endif</span>;
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Replace <strong>dashboard</strong> with your new redirect page <strong>redirect_page.php</strong> Make sure that <strong>redirect_page.php</strong> point to correct directory. Now you can continue to add the usual html or php code to your page. If you need to protect this page using valid membership, follow instructions from Help Section. In this example on successful login, we redirected user to our custom page. </p>
  </div>
  
  <!-- form -->
  <div id="form" class="wojo tab item">
    <h4>Login Form Integration</h4>
    <p class="wojo small text">Use one of your existing pages just make sure that file extension is php. Let's call this page for the purpose of this tutorial <strong>login.php</strong>. At the very beginning of the page start by adding following php code.</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);
<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Make sure that <strong>init.php</strong> point to correct directory. For example, If your <strong>login.php</strong> page is in the same directory as main script, than no changes are necessary, otherwise you need to enter correct path to your init.php page. Depending where you placed login.php page, below or above root directory <strong>init.php</strong> becomes <strong>../init.php</strong> if below the root or <strong>otherdir/init.php</strong> if above the root.</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);

  <span style="color: #008000; font-weight: bold">if</span> (App<span style="color: #666666">::</span><span style="color: #7D9029">Auth</span>()<span style="color: #666666">-&gt;</span><span style="color: #7D9029">is_User</span>())
      Url<span style="color: #666666">::</span><span style="color: #7D9029">redirect</span>(SITEURL <span style="color: #666666">.</span> <span style="color: #BA2121">&#39;/dashboard/&#39;</span>);

  <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #008000">isset</span>(<span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;login&#39;</span>]))<span style="color: #666666">:</span>
      <span style="color: #008000; font-weight: bold">if</span> (App<span style="color: #666666">::</span><span style="color: #7D9029">Auth</span>()<span style="color: #666666">-&gt;</span><span style="color: #7D9029">login</span>(<span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;username&#39;</span>], <span style="color: #19177C">$_POST</span>[<span style="color: #BA2121">&#39;password&#39;</span>]))<span style="color: #666666">:</span>
	  Url<span style="color: #666666">::</span><span style="color: #7D9029">redirect</span>(SITEURL <span style="color: #666666">.</span> <span style="color: #BA2121">&#39;/dashboard/&#39;</span>);
      <span style="color: #008000; font-weight: bold">endif</span>;
  <span style="color: #008000; font-weight: bold">endif</span>;
<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">In the above we have two redirects depending on user login state. The first one Url::redirect() checks if user is already logged in. If it is, redirect to default <strong>/dashboard/</strong> page. Second Url::redirect() will redirect user to <strong>/dashboard/</strong> page if login is successful. Just make sure that <strong>SITEURL . "/dashboard/"</strong> points to default account.php page. You can replace SITEURL with actual url like "<strong>http://yourdomain.com/mmp_directory/account.php</strong>"</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #008000; font-weight: bold">&lt;form</span> <span style="color: #7D9029">method=</span><span style="color: #BA2121">&quot;post&quot;</span> <span style="color: #7D9029">id=</span><span style="color: #BA2121">&quot;login_form&quot;</span> <span style="color: #7D9029">name=</span><span style="color: #BA2121">&quot;login_form&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;div</span> <span style="color: #7D9029">class=</span><span style="color: #BA2121">&quot;field&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
    <span style="color: #008000; font-weight: bold">&lt;input</span> <span style="color: #7D9029">name=</span><span style="color: #BA2121">&quot;username&quot;</span> <span style="color: #7D9029">placeholder=</span><span style="color: #BA2121">&quot;Username&quot;</span> <span style="color: #7D9029">type=</span><span style="color: #BA2121">&quot;text&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;/div&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;div</span> <span style="color: #7D9029">class=</span><span style="color: #BA2121">&quot;field&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
    <span style="color: #008000; font-weight: bold">&lt;input</span> <span style="color: #7D9029">name=</span><span style="color: #BA2121">&quot;password&quot;</span> <span style="color: #7D9029">placeholder=</span><span style="color: #BA2121">&quot;Password&quot;</span> <span style="color: #7D9029">type=</span><span style="color: #BA2121">&quot;password&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;/div&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;div</span> <span style="color: #7D9029">class=</span><span style="color: #BA2121">&quot;clearfix&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>
    <span style="color: #008000; font-weight: bold">&lt;button</span> <span style="color: #7D9029">name=</span><span style="color: #BA2121">&quot;login&quot;</span> <span style="color: #7D9029">type=</span><span style="color: #BA2121">&quot;submit&quot;</span> <span style="color: #7D9029">class=</span><span style="color: #BA2121">&quot;wojo button&quot;</span><span style="color: #008000; font-weight: bold">&gt;</span>Login<span style="color: #008000; font-weight: bold">&lt;/button&gt;</span>
  <span style="color: #008000; font-weight: bold">&lt;/div&gt;</span>
<span style="color: #008000; font-weight: bold">&lt;/form&gt;</span>
<span style="color: #BC7A00">&lt;?php</span> <span style="color: #008000; font-weight: bold">print</span> Message<span style="color: #666666">::</span><span style="color: #19177C">$showMsg</span>;<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">The last piece is the actual login form. Nothing fancy, just username/password and submit button. You can modify login form in any way you want just make sure that input field/button names are exactly the same.</p>
  </div>
  <!-- membership -->
  <div id="membership" class="wojo tab item">
    <h4>Protecting pages based on user membership</h4>
    <p class="wojo small text">You can also use an automated page builder from here Page Builder. First start by creating a new php page that you want to give access to all of your registered users. Let's call this page for the purpose of this tutorial <strong>members_only.php</strong>. At the very beginning of the page start by adding following php code:</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);
<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Make sure that <strong>init.php</strong> point to correct directory. For example, If your members_only.php page is in the same directory as main script, than no changes are necessary, otherwise you need to enter correct path to your init.php page. Depending where you placed <strong>members_only.php</strong> page, below or above root directory init.php becomes <strong>../init.php</strong> if below the root or <strong>otherdir/init.php</strong> if above the root. Now let's add some protection</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span>
  <span style="color: #008000">define</span>(<span style="color: #BA2121">&quot;_WOJO&quot;</span>, <span style="color: #008000; font-weight: bold">true</span>);
  <span style="color: #008000; font-weight: bold">require_once</span>(<span style="color: #BA2121">&quot;init.php&quot;</span>);
  
  <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #666666">!</span>Membership<span style="color: #666666">::</span><span style="color: #7D9029">is_valid</span>(<span style="color: #BA2121">[3,4]</span>))
      Url<span style="color: #666666">::</span><span style="color: #7D9029">redirect</span>(SITEURL);
<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">The two new lines of code do membership verification. First line checks if user belongs to memberships 3 or 4, the second one redirects user to login page <strong>index.php</strong>. Note you can find out membership id from Manage Memberships very first column on the left.</p>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Now you can continue to add the usual html or php code to your page. In this example we protected single page using membership verification process. If user does not have valid membership in this case 3 or 4 we redirect to login page, otherwise, we let the user view the page.</p>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Another example would be to show customized error message if user does not have valid membership.</p>
    <div class="wojo space divider"></div>
    <pre style="margin: 0; line-height: 125%"><span style="color: #BC7A00">&lt;?php</span> <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #666666">!</span><span style="color: #19177C">Membership</span><span style="color: #666666">::</span><span style="color: #7D9029">is_valid</span>(<span style="color: #BA2121">[3,4]</span>)) <span style="color: #666666">:</span> <span style="color: #BC7A00">?&gt;</span>

Your custom error message goes here, such as Sorry you do not have valid membership!!!

<span style="color: #BC7A00">&lt;?php</span> <span style="color: #008000; font-weight: bold">else</span><span style="color: #666666">:</span> <span style="color: #BC7A00">?&gt;</span>

In this section here you would place your content that users with valid membership will be able to see.

<span style="color: #BC7A00">&lt;?php</span> <span style="color: #008000; font-weight: bold">endif</span>;<span style="color: #BC7A00">?&gt;</span>
</pre>
    <div class="wojo space divider"></div>
    <p class="wojo small text">We only used two memberships in this case 3 and 4. You can add multiple memberships separated by coma such as <span style="color: #7D9029">Membership::is_valid([2,3,4,5])</span>.
      Or just single user membership <span style="color: #7D9029">Membership::is_valid([3])</span></p>
  </div>
  
  <!-- cron -->
  <div id="cron" class="wojo tab item">
    <h4>Setting up cron jobs</h4>
    <p class="wojo small text">Membership Manager Pro is equipped with cron job utility. By default there are two files inside /cron/ directory cron.php will automatically send emails to all users whose membership had expired at the present day, and also to all users whose membership is about to expire within 7 days. Cron file is used in recurring payments for Stripe gateway.</p>
    <div class="wojo space divider"></div>
    <p class="wojo small text">Membership Manager Pro is equipped with cron job utility. By default there are two files inside /cron/ directory cron.php will automatically send emails to all users whose membership had expired at the present day, and also to all users whose membership is about to expire within 7 days. Cron file is used in recurring payments for Stripe gateway.</p>
    <p class="wojo small text"> Each hosting company might have different way of setting cron jobs. Here will give you few examples:</p>
    <ul class="wojo small text">
      <li>For CPanel - http://www.siteground.com/tutorials/cpanel/cron_jobs.htm</li>
      <li>For Plesk Pnel - http://www.hosting.com/support/plesk/crontab</li>
    </ul>
    <p class="wojo small text"> If your hosting panel it's not covered here you can always ask your hosting provider.</p>
    <p class="wojo small text"> cron.php file should be set up to run every day at midnight</p>
    <p class="wojo small text">Don't forget to modify template files for sending reminders. Membership Reminder </p>
  </div>
  
  <!-- builder -->
  <div id="builder" class="wojo tab form item">
    <form method="post" id="wojo_form" name="wojo_form">
      <div class="wojo fields">
        <div class="field five wide">
          <label><?php echo Lang::$word->HP_PNAME;?> <i class="icon asterisk"></i></label>
          <input type="text" placeholder="<?php echo Lang::$word->HP_PNAME;?>" name="pagename">
        </div>
        <div class="field five wide">
          <label><?php echo Lang::$word->HP_SUB7;?></label>
          <div class="wojo inline fields">
            <div class="wojo checkbox small radio slider field">
              <input name="header" type="radio" value="1" checked="checked">
              <label><?php echo Lang::$word->YES;?></label>
            </div>
            <div class="wojo checkbox small radio slider field">
              <input name="header" type="radio" value="0">
              <label><?php echo Lang::$word->NO;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="wojo fields">
        <div class="field five wide">
          <label><?php echo Lang::$word->ADM_MEMBS;?> <i class="icon asterisk"></i></label>
          <select name="membership_id[]" class="wojo fluid dropdown selection" multiple>
            <?php echo Utility::loopOptions($this->mlist, "id", "title");?>
          </select>
        </div>
        <div class="field five wide">
          <p class="wojo small text"><?php echo Lang::$word->HP_INFO;?></p>
        </div>
      </div>
      <div class="content-center">
        <button type="button" data-action="pageBuilder" name="dosubmit" class="wojo secondary button"><?php echo Lang::$word->HP_PBUILD;?></button>
      </div>
    </form>
  </div>
</div>