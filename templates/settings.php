<div class="wrap">
    <h2>LicenceToBill</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('wp_plugin_template-group'); ?>
        <?php @do_settings_fields('wp_plugin_template-group'); ?>

        <?php do_settings_sections('wp_plugin_template'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
<div class="wrap">
    <h2>Trial Offer Settings (optional)</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('wp_plugin_template_metatrial_group'); ?>
        <?php @do_settings_fields('wp_plugin_template_metatrial_group'); ?>

        <?php do_settings_sections('wp_plugin_metatrial_template'); ?>

        <?php @submit_button(); ?>
    </form>
    <form method="post" action="options.php">
		<?php @settings_fields('wp_plugin_template_metatrial_advanced_group'); ?>
		<?php @do_settings_fields('wp_plugin_template_metatrial_advanced_group'); ?>

		<?php do_settings_sections('wp_plugin_metatrial_advanced_template'); ?>

		<?php @submit_button(); ?>
    </form>
</div>
<div class="wrap">
    <h2>User Data Synchronization (optional)</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('wp_plugin_template_usermeta_group'); ?>
        <?php @do_settings_fields('wp_plugin_template_usermeta_group'); ?>

        <?php do_settings_sections('wp_plugin_usermeta_template'); ?>

        <?php @submit_button(); ?>
    </form>
</div>
<div class="wrap">
    <h2>Offers & Roles</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('WP_RoleChanger_LicenceToBill_group'); ?>
        <?php @do_settings_fields('WP_RoleChanger_LicenceToBill_group'); ?>

        <?php do_settings_sections('wp_rolechanger_template'); ?>

        <?php @submit_button(); ?>
    </form>
</div>