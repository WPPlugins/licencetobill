<?php
if(!class_exists('WP_Plugin_Template_Settings'))
{
	class WP_Plugin_Template_Settings
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
		} // END public function __construct

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
        	// register your plugin's settings
        	register_setting('wp_plugin_template-group', 'LTB_setting_business_key');
        	register_setting('wp_plugin_template-group', 'LTB_setting_agent_key');

        	register_setting('wp_plugin_template_metatrial_group', 'LTB_setting_trial');

        	register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trialcode1');
        	register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trial1');
        	register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trialcode2');
			register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trial2');
			register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trialcode3');
			register_setting('wp_plugin_template_metatrial_advanced_group', 'LTB_setting_trial3');

			register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_company');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_fullname');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_address_line1');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_address_line2');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_zipcode');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_city');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_country');
        	register_setting('wp_plugin_template_usermeta_group', 'LTB_setting_vat_information');

        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer1_key');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer2_key');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer3_key');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer4_key');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer5_key');

        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer1_roles');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer2_roles');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer3_roles');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer4_roles');
        	register_setting('WP_RoleChanger_LicenceToBill_group', 'LTB_RoleChanger_setting_offer5_roles');

			// -------------------------------------------------------------------
			// -------------------------------------------------------------------
        	// add your settings section
        	add_settings_section(
        	    'wp_plugin_template-section',
        	    'Base Settings (mandatory)',
        	    array(&$this, 'settings_section_wp_plugin_template'),
        	    'wp_plugin_template'
        	);
			// ---------------
        	// add your setting's fields
            add_settings_field(
                'wp_plugin_template-setting_a',
                'Business Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_template',
                'wp_plugin_template-section',
                array(
                    'field' => 'LTB_setting_business_key'
                )
            );
            add_settings_field(
                'wp_plugin_template-setting_b',
                'Agent Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_template',
                'wp_plugin_template-section',
                array(
                    'field' => 'LTB_setting_agent_key'
                )
            );

			// -------------------------------------------------------------------
			// -------------------------------------------------------------------
        	// add your settings section
        	add_settings_section(
        	    'wp_plugin_template_metatrial-section',
        	    'Simple Trial Offer Setting',
        	    array(&$this, 'settings_section_wp_plugin_trial_template'),
        	    'wp_plugin_metatrial_template'
        	);

			// ---------------
            add_settings_field(
                'wp_plugin_template-setting_c',
                'Trial Offer Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_template',
                'wp_plugin_template_metatrial-section',
                array(
                    'field' => 'LTB_setting_trial'
                )
            );

			// -------------------------------------------------------------------
			// -------------------------------------------------------------------
        	// add your settings section
        	add_settings_section(
        	    'wp_plugin_template_metatrial_advanced_section',
        	    'Advanced Trial Offer Settings',
        	    array(&$this, 'settings_section_wp_plugin_metatrial_advanced_template'),
        	    'wp_plugin_metatrial_advanced_template'
        	);

			// ---------------
            add_settings_field(
                'wp_plugin_template-setting_trialcode1',
                'Trial Code 1',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trialcode1'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_trial1',
                'Trial Offer Key 1',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trial1'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_trialcode2',
                'Trial Code 2',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trialcode2'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_trial2',
                'Trial Offer Key 2',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trial2'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_trialcode3',
                'Trial Code 3',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trialcode3'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_trial3',
                'Trial Offer Key 3',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_metatrial_advanced_template',
                'wp_plugin_template_metatrial_advanced_section',
                array(
                    'field' => 'LTB_setting_trial3'
                )
            );

			// -------------------------------------------------------------------
			// -------------------------------------------------------------------

        	// add your settings section
        	add_settings_section(
        	    'wp_plugin_template_usermeta-section',
        	    'Address Settings',
        	    array(&$this, 'settings_section_wp_plugin_usermeta_template'),
        	    'wp_plugin_usermeta_template'
        	);

            add_settings_field(
                'wp_plugin_template-setting_company',
                'UserMeta Company Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_company'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_e',
                'UserMeta Fullname Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_fullname'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_f',
                'UserMeta Address Line 1 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_address_line1'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_g',
                'UserMeta Address Line 2 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_address_line2'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_h',
                'UserMeta Zipcode Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_zipcode'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_i',
                'UserMeta City Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_city'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_j',
                'UserMeta Country Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_country'
                )
            );

            add_settings_field(
                'wp_plugin_template-setting_k',
                'UserMeta VAT Key',
                array(&$this, 'settings_field_input_text'),
                'wp_plugin_usermeta_template',
                'wp_plugin_template_usermeta-section',
                array(
                    'field' => 'LTB_setting_vat_information'
                )
            );

			// -------------------------------------------------------------------
			// -------------------------------------------------------------------
        	// add your settings section
        	add_settings_section(
        	    'wp_rolechanger_template-section',
        	    'Offers & Roles Settings (optional)',
        	    array(&$this, 'settings_section_wp_rolechanger_template'),
        	    'wp_rolechanger_template'
        	);

			if ( ! isset( $wp_roles ) )
            	$wp_roles = new WP_Roles();
            $roles = $wp_roles->get_names();

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer1_key',
                'Offer1 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer1_key'
                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer1_roles',
                'Offer1 Roles',
                array(&$this, 'settings_field_input_multichecklist_roles'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer1_roles',
                    'type' => 'multicheck',
                	'options' => $roles

                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer2_key',
                'Offer2 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer2_key'
                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer2_roles',
                'Offer2 Roles',
                array(&$this, 'settings_field_input_multichecklist_roles'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer2_roles',
                    'type' => 'multicheck',
                	'options' => $roles

                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer3_key',
                'Offer3 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer3_key'
                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer3_roles',
                'Offer3 Roles',
                array(&$this, 'settings_field_input_multichecklist_roles'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer3_roles',
                    'type' => 'multicheck',
                	'options' => $roles

                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer4_key',
                'Offer4 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer4_key'
                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer4_roles',
                'Offer4 Roles',
                array(&$this, 'settings_field_input_multichecklist_roles'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer4_roles',
                    'type' => 'multicheck',
                	'options' => $roles

                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer5_key',
                'Offer5 Key',
                array(&$this, 'settings_field_input_text'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer5_key'
                )
            );

			// ---------------
            add_settings_field(
                'wp_rolechanger_template-setting_offer5_roles',
                'Offer5 Roles',
                array(&$this, 'settings_field_input_multichecklist_roles'),
                'wp_rolechanger_template',
                'wp_rolechanger_template-section',
                array(
                    'field' => 'LTB_RoleChanger_setting_offer5_roles',
                    'type' => 'multicheck',
                	'options' => $roles

                )
            );

            // Possibly do additional admin_init tasks
        } // END public static function activate

        public function settings_section_wp_plugin_template()
        {
            // Think of this as help text for the section.
            echo 'Set your Business Key and Agent Key. Find these keys in LicenceToBill Account <a href="https://secure.licencetobill.com/">https://secure.licencetobill.com/</a>.';
        }

        public function settings_section_wp_plugin_metatrial_advanced_template()
        {
            // Think of this as help text for the section.
            echo 'You need to use <a href="http://user-meta.com/">UserMeta plugin</a>. Need help <a href="http://licencetobill.com">contact us</a>';
        }

        public function settings_section_wp_plugin_usermeta_template()
        {
            // Think of this as help text for the section.
            echo 'To enable automatic user address synchronization, set the default meta keys or UserMeta keys (from the recommanded plugin UserMetaPro). Need help <a href="http://licencetobill.com">contact us</a>';
        }

        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)

        public function settings_field_input_multichecklist_roles($args)
        {

            // Get the field name from the $args array
            $field = $args['field'];

            // Get the value of this setting
            $value = get_option($field);

			$html = '';
			foreach ($args['options'] as $key => $label) {
				$checked = isset( $value[$key] ) ? $value[$key] : '0';
				$html .= sprintf( '<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%3$s"%4$s />', $args['field'], $key, $key, checked( $checked, $key, false ) );
				$html .= sprintf( '<label style="margin-right:10px;" for="%1$s[%2$s]"> %3$s |</label>', $args['field'], $key, $label );
			}
			$html .= '<hr>';
			echo $html;

            //echo sprintf(wp_dropdown_roles( 'editor' ), $field, $field, $value);
        } // END public function settings_field_input_text($args)


        /**
         * add a menu
         */
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'WP Plugin LicenceToBill Settings',
        	    'WP Plugin LicenceToBill',
        	    'manage_options',
        	    'wp_plugin_template',
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()

        /**
         * Menu Callback
         */
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}

        	// Render the settings template
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class WP_Plugin_Template_Settings
} // END if(!class_exists('WP_Plugin_Template_Settings'))
