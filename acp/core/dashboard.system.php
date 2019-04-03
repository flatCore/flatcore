<?php

//prohibit unauthorized access
require 'core/access.php';


echo '<hr class="shadow">';

echo '<div class="row">';

echo '<div class="col-md-4">';

echo '<div class="card mb-1">';

echo '<div class="card-header">'.$icon['cogs'].' Config</div>';
echo '<div class="card-body">';
echo '<table class="table table-sm">';
echo '<tr><td>Server:</td><td>' . $_SERVER['SERVER_NAME'] . ' (PHP '.phpversion().')</td></tr>';
echo '<tr><td>'.$lang['prefs_cms_domain'].'</td><td>' . $prefs_cms_domain . '</td></tr>';
echo '<tr><td>'.$lang['prefs_cms_ssl_domain'].'</td><td>' . $prefs_cms_ssl_domain . '</td></tr>';
echo '<tr><td>'.$lang['prefs_cms_base'].'</td><td>' . $prefs_cms_base . '</td></tr>';
if($prefs_mailer_adr != '') {
	echo '<tr><td>System E-Mails:</td><td>' . $prefs_mailer_adr . '</td></tr>';
} else {
	echo '<tr><td>System E-Mails:</td><td><span class="text-danger">'.$lang['missing_value'].'</span></td></tr>';
}
if($prefs_mailer_name != '') {
	echo '<tr><td>E-Mail Name:</td><td>' . $prefs_mailer_name . '</td></tr>';
} else {
	echo '<tr><td>E-Mail Name:</td><td><span class="text-danger">'.$lang['missing_value'].'</span></td></tr>';
}
echo '</table>';

echo '</div>';
echo '</div>';


echo '<div class="card">';
echo '<div class="card-header">' . $lang['f_user_drm'] . '</div>';
echo '<div class="card-body">';

echo '<p>'.$icon['user'].' '.$_SESSION['user_firstname'].' '.$_SESSION['user_lastname'].' ('.$_SESSION['user_nick'].')</p>';

$list_str = '<ul class="list-unstyled" style="padding-left:16px;">';

if($_SESSION['acp_pages'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_pages'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_pages'].'</li>';
}

if($_SESSION['acp_editpages'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_editpages'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_editpages'].'</li>';
}

if($_SESSION['acp_editownpages'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_editownpages'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_editownpages'].'</li>';
}

if($_SESSION['acp_files'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_files'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_files'].'</li>';
}

if($_SESSION['acp_user'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_user'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_user'].'</li>';
}

if($_SESSION['acp_system'] == "allowed") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_system'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_files'].'</li>';
}

if($_SESSION['drm_can_publish'] == "true") {
	$list_str .= '<li>'.$icon['check'].' '. $lang['drm_user_can_publish'].'</li>';
} else {
	$list_str .= '<li>'.$icon['ban'].' '. $lang['drm_user_can_publish'].'</li>';
}


$list_str .= "</ul>";

echo $list_str;

echo '</div>';

echo '</div>';
echo '</div>';


echo '<div class="col-md-8">';

echo '<div class="card">';
echo '<div class="card-header">';

echo '<ul class="nav nav-tabs card-header-tabs" id="bsTabs" role="tablist">';
echo '<li class="nav-item"><a class="nav-link active" href="#" data-target="#chat" data-toggle="tab">'.$icon['comments'].' Chat</a></li>';
echo '<li class="nav-item"><a class="nav-link" href="#" data-target="#log" data-toggle="tab">'.$icon['file_alt'].' Logfile</a></li>';
echo '<li class="nav-item"><a class="nav-link" href="#" data-target="#sitemap" data-toggle="tab">'.$icon['sitemap'].' sitemap.xml</a></li>';
echo '<li class="nav-item"><a class="nav-link" href="#" data-target="#deleted_resources" data-toggle="tab">'.$icon['trash_alt'].' '.$lang['label_deleted_resources'].'</a></li>';
echo '</ul>';

echo '</div>';
echo '<div class="card-body">';

echo '<div class="tab-content">';

echo '<div class="tab-pane fade show active" id="chat">';

$chat_form = file_get_contents('templates/comment-form.tpl');

$e_comment_text = '';
$e_comment_id = '';

if(isset($_GET['dcid'])) {
	$delete_comment_id = (int) $_GET['dcid'];

	$dbh = new PDO("sqlite:".CONTENT_DB);
	$query = "DELETE FROM fc_comments WHERE comment_id = :comment_id";
	$sth = $dbh -> prepare($query);
	$sth -> bindParam(':comment_id', $delete_comment_id, PDO::PARAM_STR);
	$sth->execute();
	$dbh = null;
}

if(isset($_GET['cid'])) {
	$get_comment = fc_get_comment($_GET['cid']);
	$e_comment_text = $get_comment['comment_text'];
	$e_comment_id = $get_comment['comment_id'];
	if($_SESSION['user_nick'] != $get_comment['comment_author']) {
		//you can't edit others entries
		unset($e_comment_text,$e_comment_id);
	}
}



$chat_form = str_replace('{form_action}', "acp.php?tn=dashboard", $chat_form);
$chat_form = str_replace('{value_textarea}', "$e_comment_text", $chat_form);
$chat_form = str_replace('{value_send_btn}', $lang['save'], $chat_form);
$chat_form = str_replace('{value_hidden_id}', "$e_comment_id", $chat_form);
$chat_form = str_replace('{token}', $_SESSION['token'], $chat_form);
$chat_form = str_replace('{form_legend}', $lang['label_comment'], $chat_form);

$comment_entry_tpl = file_get_contents('templates/comment-entry.tpl');

echo '<div class="scroll-container" id="inlineComments">';

echo $chat_form;

if(isset($_POST['comment'])) {
	if(is_numeric($_POST['id'])) {
		fc_write_comment($_SESSION['user_nick'], $_POST['comment'], "c", $_POST['id']);
	} else {
		fc_write_comment($_SESSION['user_nick'], $_POST['comment'], "c");
	}
}

$comments = fc_get_comments('c');
$cnt_comment = count($comments);

for($i=0;$i<$cnt_comment;$i++) {

	$comment_time = date("d.m.Y H:i:s", $comments[$i]['comment_time']);
	$comment_author = $comments[$i]['comment_author'];
	$comment_text = nl2br($comments[$i]['comment_text']);
	$comment_id = $comments[$i]['comment_id'];
	
	$author_avatar_path = '../'. FC_CONTENT_DIR . '/avatars/' . md5($comment_author) . '.png';
	$author_avatar = '<img src="images/avatar.png" class="img-circle avatar" width="64" height="64">';
	if(is_file("$author_avatar_path")) {
		$author_avatar = '<img src="'.$author_avatar_path.'" class="img-circle avatar" width="64" height="64">';
	}
	
	unset($show_entry);
	
	if($_SESSION['user_nick'] == $comment_author) {
		$show_entry = str_replace('{entry_edit_btn}', '<a class="btn btn-dark btn-sm text-success" href="acp.php?tn=dashboard&cid='.$comment_id.'">'.$lang['edit'].'</a>', $comment_entry_tpl);
		$show_entry = str_replace('{entry_delete_btn}', '<a class="btn btn-dark btn-sm text-danger" href="acp.php?tn=dashboard&dcid='.$comment_id.'">'.$icon['trash_alt'].'</a>', $show_entry);
	} else {
		$show_entry = str_replace('{entry_edit_btn}', '', $comment_entry_tpl);
		$show_entry = str_replace('{entry_delete_btn}', '', $show_entry);
	}
	$show_entry = str_replace('{comment_avatar}', $author_avatar, $show_entry);
	$show_entry = str_replace('{comment_author}', $comment_author, $show_entry);
	$show_entry = str_replace('{comment_time}', $comment_time, $show_entry);
	$show_entry = str_replace('{comment_text}', $comment_text, $show_entry);
	
	echo $show_entry;
}

echo'</div>';

echo'</div>'; // #chat
echo'<div class="tab-pane fade" id="log">';

echo '<div class="scroll-container">';
show_log(10);
echo'</div>';
echo'</div>'; // #log

echo '<div class="tab-pane fade" id="sitemap">';
$sitemap = file_get_contents('../sitemap.xml');
//echo '<pre class="form-control" style="height:400px;overflow:auto;">'.htmlentities($sitemap,ENT_QUOTES,"UTF-8").'</pre>';
echo '<textarea name="my-xml-editor" data-editor="xml" rows="15">'.htmlentities($sitemap,ENT_QUOTES,"UTF-8").'</textarea>';
echo '</div>'; // #sitemap


echo '<div class="tab-pane fade" id="deleted_resources">';
echo '<div class="scroll-container">';
$deleted_resources = explode(PHP_EOL, $prefs_deleted_resources);
echo '<ul>';
foreach($deleted_resources as $resource) {
	echo '<li>'.$resource.'</li>';
}

echo '<li><a href="acp.php?tn=system">'.$lang['system_preferences'].'</a></li>';

echo '</ul>';
echo '</div>';
echo '</div>'; // #deleted resources


echo '</div>'; // .tab-content
echo '</div>'; // .card-body
echo '</div>'; // .card

echo '</div>';


echo '</div>';







?>