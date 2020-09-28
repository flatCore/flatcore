<?php
if(!defined('INSTALLER')) {
	header("location:../login.php");
	die("PERMISSION DENIED!");
}

$prefs_cms_domain = "http://$_SERVER[HTTP_HOST]";
$prefs_cms_ssl_domain = '';
$prefs_cms_base = dirname(dirname(htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES, "utf-8")));

?>

<div class="alert alert-info">
<?php echo $lang['msg_form']; ?>
</div><hr>

<form action="index.php" method="POST" class="form-horizontal">

	<fieldset>
		<legend>USER</legend>
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['username']; ?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="username" value="">
				</div>
			</div>
		
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['email']; ?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="mail" value="">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['password']; ?></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="psw" value="">
				</div>
			</div>
	</fieldset>
	
	<fieldset>
		<legend>Domain</legend>
	
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['prefs_cms_domain']; ?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="prefs_cms_domain" value="<?php echo"$prefs_cms_domain"; ?>">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['prefs_cms_ssl_domain']; ?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="prefs_cms_ssl_domain" value="<?php echo"$prefs_cms_ssl_domain"; ?>">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3 control-label text-right"><?php echo $lang['prefs_cms_base']; ?></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="prefs_cms_base" value="<?php echo"$prefs_cms_base"; ?>">
				</div>
			</div>
	
	</fieldset>
	
	<fieldset>
		<legend>Database</legend>
		
		
		<div class="nav nav-tabs" role="tablist">
			<div class="p-2">
				<input id="checkSQLite" checked name="set_db" value="sqlite" type="radio" data-target="#sqlite">
				<label for="checkSQLite">SQLite</label>
			</div>
			<div class="p-2">
				<input id="checkMySQL" name="set_db" value="mysql" type="radio" data-target="#mysql">
				<label for="checkMySQL">MySQL</label>
			</div>
		</div>
			
		<ul class="nav nav-pills mb-3 d-none" id="myTab" role="tablist">
		    <li class="nav-item" role="presentation">
		    	<a class="nav-link active" data-toggle="pill" id="sqlite-tab" href="#sqlite">SQLite</a>
		    </li>
		    <li class="nav-item" role="presentation">
		    	<a class="nav-link" data-toggle="pill" id="mysql-tab" href="#mysql">MySQL</a>
		    </li>
		</ul>
			
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="sqlite" role="tabpanel">
					<p class="alert alert-info"><?php echo $lang['db_sqlite_help']; ?></p>
				</div>
				<div class="tab-pane fade" id="mysql" role="tabpanel">
		
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_host']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_host" placeholder="localhost" value="<?php echo"$prefs_database_host"; ?>">
							<small class="form-text text-muted"><?php echo $lang['db_host_help']; ?></small>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_port']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_port" value="<?php echo"$prefs_database_port"; ?>">
							<small class="form-text text-muted"><?php echo $lang['db_port_help']; ?></small>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_name']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_name" value="<?php echo"$prefs_database_name"; ?>">
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_username']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_username" value="<?php echo"$prefs_database_username"; ?>">
							<small class="form-text text-muted"><?php echo $lang['db_username_help']; ?></small>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_psw']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_psw" value="<?php echo"$prefs_database_psw"; ?>">
							<small class="form-text text-muted"><?php echo $lang['db_psw_help']; ?></small>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right"><?php echo $lang['db_prefix']; ?></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="prefs_database_prefix" placeholder="fcdb_" value="<?php echo"$prefs_database_prefix"; ?>">
							<small class="form-text text-muted"><?php echo $lang['db_prefix_help']; ?></small>
						</div>
					</div>
				</div>
				
			</div>
	</fieldset>
	
	<div class="form-group row">
		<label class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
			<input type="submit" class="btn btn-success btn-block" name="step3" value="<?php echo $lang['start_install']; ?>">
		</div>
	</div>


</form>

<script>
$(document).ready(function () {
  $('input[name="set_db"]').click(function () {
      $(this).tab('show');
      $(this).removeClass('active');
  });
})
</script>