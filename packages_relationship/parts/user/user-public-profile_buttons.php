<?php if (osc_is_web_user_logged_in()) : ?>

	<?php 
	$blockedFromUserLogged = get_blocked_from_user_to_user(osc_logged_user_id(), get_user_id());
	$blockedFromUserProfile = get_blocked_from_user_to_user(get_user_id(), osc_logged_user_id());
	
	if (!$blockedFromUserLogged && !$blockedFromUserProfile) {
		$requestFromUserLogged 	= packages_relationship_request(osc_logged_user_id(), get_user_id());
		$requestFromUserProfile = packages_relationship_request(get_user_id(), osc_logged_user_id());

		$linkFromCompanyLogged 	= packages_relationship_link(osc_logged_user_id(), get_user_id());
		$linkFromCompanyProfile = packages_relationship_link(get_user_id(), osc_logged_user_id());
	}
	?>
	
	<?php // Unblock button
	if ($blockedFromUserLogged && !$blockedFromUserProfile) : ?>
	<a href="javascript:packages_relationship_action('unblock_account');"><?php _e("Unblock", 'packages_relationship'); ?></a>
	<?php endif; ?>

	<?php if (!$blockedFromUserLogged && !$blockedFromUserProfile) : ?>

		<?php // When account type Company visit de the public profile of account type User
		if (get_user_type(get_user_id()) == 0 && osc_logged_user_id() != get_user_id() && osc_logged_user_type() == 1) : ?>
			
			<?php if ($requestFromUserLogged && get_user_type($requestFromUserLogged['fk_i_from_user_id'])) : ?>
				
				<?php _e("Waiting accept", 'packages_relationship'); ?> - 
				<a href="#remove-invitation"><?php _e("Remove invitation", 'packages_relationship'); ?></a>
				<div id="remove-invitation" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want remove invitation?", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('remove_request');" onclick="location.href='#modal-close';"><?php _e("Remove invitation", 'packages_relationship'); ?></a></center></div></div></div>
			
			<?php elseif ($requestFromUserProfile && !get_user_type($requestFromUserProfile['fk_i_from_user_id'])) :?>
				
				<?php // If the 'from user' of request, belongs yet to a Company
				if (packages_relationship_link_by_user_son($requestFromUserProfile['fk_i_from_user_id'])) : ?>
				<a href="#link-notice"><?php _e("Accept request", 'packages_relationship'); ?></a>
				<div id="link-notice" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("This user still belongs to a company. Wait for to the user leave the company for you can accept the request.", 'packages_relationship'); ?></center></div></div></div>
				<?php else : ?>
				<a href="javascript:packages_relationship_action('accept_request');"><?php _e("Accept request", 'packages_relationship'); ?></a>
				<?php endif; ?>

				<a href="#remove-request"><?php _e("Remove", 'packages_relationship'); ?></a><br />
				<div id="remove-request" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want remove request?", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('remove_request');" onclick="location.href='#modal-close';"><?php _e("Remove request", 'packages_relationship'); ?></a></center></div></div></div>

				<!-- modal window for block account action -->
				<a href="#block-account"><?php _e("Block account", 'packages_relationship'); ?></a>
				<div id="block-account" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want to block account?", 'packages_relationship'); ?><br><?php _e("The user can not send you requests", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('block_account');" onclick="location.href='#modal-close';"><?php _e("Block account", 'packages_relationship'); ?></a></center></div></div></div>
			
			<?php else : ?>
				
				<?php if ($linkFromCompanyLogged) : ?>
					<a href="javascript:packages_relationship_action('delete_link');"><?php _e("Remove user", 'packages_relationship'); ?></a>
				<?php else : ?>
					<?php // Check this user wants receive requests (invitations)
					if (packages_relationship_user_requests_config(get_user_id()) == true) : ?>
					<a href="javascript:packages_relationship_action('send_request');"><?php _e("Add user", 'packages_relationship'); ?></a><br />
					<?php endif; ?>
					
					<!-- modal window for block account action -->
					<a href="#block-account"><?php _e("Block account", 'packages_relationship'); ?></a>
					<div id="block-account" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want to block account?", 'packages_relationship'); ?><br><?php _e("The user can not send you requests", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('block_account');" onclick="location.href='#modal-close';"><?php _e("Block account", 'packages_relationship'); ?></a></center></div></div></div>
				<?php endif; ?>
				
			<?php endif; ?>
			
		<?php endif;?>
	
		<?php // When account type User visit de the public profile of account type Company 
		if (get_user_type(get_user_id()) == 1 && osc_is_web_user_logged_in() && osc_logged_user_id() != get_user_id() && osc_logged_user_type() == 0) : ?>
			
			<?php if ($requestFromUserLogged && get_user_type($requestFromUserLogged['fk_i_from_user_id']) == 0) : ?>
				
				<?php _e("Awaiting approval", 'packages_relationship'); ?> -
				<a href="#remove-request"><?php _e("Remove request", 'packages_relationship'); ?></a>
				<div id="remove-request" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want remove request?", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('remove_request');" onclick="location.href='#modal-close';"><?php _e("Remove request", 'packages_relationship'); ?></a></center></div></div></div>

			<?php elseif ($requestFromUserProfile && get_user_type($requestFromUserProfile['fk_i_from_user_id'])) : ?>
								
				<?php // If the 'from user' of request, belongs yet to a Company
				if (packages_relationship_link_by_user_son($requestFromUserProfile['fk_i_to_user_id'])) : ?>
				<a href="#link-notice"><?php _e("Accept invitation", 'packages_relationship'); ?></a>
				<div id="link-notice" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Leave the current company for accept invitation from other company.", 'packages_relationship'); ?></center></div></div></div>
				<?php else : ?>
				<a href="javascript:packages_relationship_action('accept_request');"><?php _e("Accept invitation", 'packages_relationship'); ?></a>
				<?php endif; ?>

				<a href="#remove-invitation"><?php _e("Remove", 'packages_relationship'); ?></a><br />
				<div id="remove-invitation" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want remove invitation?", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('remove_request');" onclick="location.href='#modal-close';"><?php _e("Remove invitation", 'packages_relationship'); ?></a></center></div></div></div>
				
				<!-- modal window for block account action -->
				<a href="#block-account"><?php _e("Block account", 'packages_relationship'); ?></a>
				<div id="block-account" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want to block account?", 'packages_relationship'); ?><br><?php _e("The user can not send you requests", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('block_account');" onclick="location.href='#modal-close';"><?php _e("Block account", 'packages_relationship'); ?></a></center></div></div></div>
			
			<?php else : ?>
				
				<?php if ($linkFromCompanyProfile) : ?>
					<!-- modal window for leave company action -->
					<a href="#delete-link"><?php _e("Leave company", 'packages_relationship'); ?></a>
					<div id="delete-link" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want to leave the company?", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('delete_link');"><?php _e("Leave company", 'packages_relationship'); ?></a></center></div></div></div>
				<?php else : ?>
					<?php // Check this company wants receive requests
					if (packages_relationship_user_requests_config(get_user_id()) == true) : ?>						
					<a href="javascript:packages_relationship_action('send_request');"><?php _e("Join company", 'packages_relationship'); ?></a><br />
					<?php endif; ?>
					
					<!-- modal window for block account action -->
					<a href="#block-account"><?php _e("Block account", 'packages_relationship'); ?></a>
					<div id="block-account" class="modalDialog"><div class="pck-msg-40"><a href="#close" title="Close" class="close">X</a><h2><?php _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php _e("Are you sure you want to block account?", 'packages_relationship'); ?><br><?php _e("The user can not send you requests", 'packages_relationship'); ?><br><a href="javascript:packages_relationship_action('block_account');" onclick="location.href='#close';"><?php _e("Block account", 'packages_relationship'); ?></a></center></div></div></div>
				<?php endif; ?>
				
			<?php endif; ?>
			
		<?php endif; ?>

	<?php endif; ?>

<?php endif; ?>