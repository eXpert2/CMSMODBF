$.subscribe('list-view/list-item/click', function(role_id) {
	$('#content').load('<?php echo site_url(SITE_AREA .'/myuser/roles/edit') ?>/'+ role_id);
});