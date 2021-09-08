<?php
/**
 * BuddyBoss - Groups Header item-actions.
 *
 * @since BuddyPress 3.0.0
 * @version 3.1.0
 */
?>
<div id="item-actions" class="group-item-actions">

 <h4 class="bp-title">Organisateurs</h4> 

		<dl class="moderators-lists">
			<dt class="moderators-title"><?php esc_html_e( 'Organized by', 'buddyboss-theme' ); ?></dt>
			<dd class="user-list admins"><?php bp_group_list_admins(); ?>
				<?php bp_nouveau_group_hook( 'after', 'menu_admins' ); ?>
			</dd>
		</dl>   

<h4 class="bp-title">Superviseurs</h4> 

		<dl class="moderators-lists">
			<dt class="moderators-title"><?php esc_html_e( 'Organized by', 'buddyboss-theme' ); ?></dt>
			<dd class="user-list admins"><?php bp_group_list_mods(); ?>
				<?php bp_nouveau_group_hook( 'after', 'menu_admins' ); ?>
			</dd>
		</dl>
</div><!-- .item-actions -->
