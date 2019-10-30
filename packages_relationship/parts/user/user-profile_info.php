<?php
$packageInherited 	= PackagesRelationship::newInstance()->getInherited(osc_logged_user_id());
$link 				= PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());

if ($packageInherited && $link && $link['b_inherited'] == true && $link['b_use_package'] == true) {
	$packageItemsInherited       	= get_package_free_items($packageInherited['fk_i_package_id']);
	$publishedItemsInherited      	= Packages::newInstance()->getTotalItemsByAssignment($packageInherited['pk_i_id']);
	$freeItemsInherited 	= $packageItemsInherited-$publishedItemsInherited;

	// Descending count, example: 3/5 (from five to three)
	if ($freeItemsInherited < 0) $freeItemsInherited = 0;

	// Ascending count, example: 2/5 (from two to five)
	$publishedItemsInherited = ($publishedItemsInherited-1 < 0) ? 0 : $publishedItemsInherited-1;
}
?>

<?php if ($packageInherited && $link && $link['b_inherited'] && $link['b_use_package']) : ?>
<h3><?php _e("Company's Package", 'packages'); ?></h3>
<div class="packages-profile-info">
	<h2><small>Used </small><?php echo $publishedItemsInherited; ?>/<?php echo $packageItemsInherited; ?><sup><small>Total</small></sup></h2>
</div>
<?php endif; ?>