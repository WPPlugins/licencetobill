<?php
/*
Plugin Name: LicenceToBill For Wordpress
Plugin URI: https://wordpress.org/plugins/licencetobill/
Description: A simple wordpress plugin LicenceToBill
Version: 2.1.3
Author: Sebastien Rousset
Author URI: http://licencetobill.com
License: GPL2
*/
/*
Copyright 2013-2014  Sebastien Rousset  (email : sebastien.rousset@licencetobill.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once(sprintf("%s/licencetobill.php", dirname(__FILE__)));

/******************************************/
/* LTBaccess_shortcode			  */
/******************************************/
function LTBaccess_shortcode( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'keyfeature' => '',
			'display_text_if_noaccess' => '',
			'text_if_noaccess' => '',
			'display_text_if_noregistered' => '',
			'text_if_noregistered' => '',
			'key_offer1' => '',
			'key_offer2' => '',
			'key_offer3' => '',
		), $atts )
	);
	$current_user = '';
	$answer_content = '';
	// Code
	if ( is_user_logged_in() )
	{
		// Retrieve info of the current user
		$current_user = wp_get_current_user();
		$WP_LicenceToBill = new LicenceToBill($current_user->ID);

		// Retrieve feature info for the current user
		$result = $WP_LicenceToBill->features($current_user->ID, $keyfeature);
		if(isset($result->status))
			$answer_content = 'Please contact the administrator.<br />Status:'.$result->status.'<br />StatusCode:'.$result->status_code.'<br />Message:'.$result->message;
		else
		{
			if(isset($result->limitation))
			{
				switch ($result->limitation) {
					case 0:
						if($display_text_if_noaccess=='yes')
							if($text_if_noaccess == NULL || $text_if_noaccess =='')
								$answer_content = 'A content is protected. Please <a href="'.$result->url_choose_offer.'">upgrade</a>.';
							else
							{
								$answer_content = preg_replace ('{{link_upgrade}}',$result->url_choose_offer, $text_if_noaccess);
								if( $key_offer1 != '' )
									$answer_content = preg_replace ('{{link_offer1}}',GetOfferURL( $current_user->ID, $key_offer1 ), $answer_content);
								if( $key_offer2 != '' )
									$answer_content = preg_replace ('{{link_offer2}}',GetOfferURL( $current_user->ID, $key_offer2 ), $answer_content);
								if( $key_offer3 != '' )
									$answer_content = preg_replace ('{{link_offer3}}',GetOfferURL( $current_user->ID, $key_offer3 ), $answer_content);
							}
						else
							$answer_content = '';
						break;
					default:
						$answer_content = $content;
						break;
					}
			}
			else // no limit
			{
				$answer_content = $content;
			}
		}
	}
	else
	{
		//$answer_content = 'Ce contenu est prot&eacute;g&eacute;. Merci de vous <strong>connecter</strong> ou de <strong>cr&eacute;er un compte</strong>.';

		if($display_text_if_noregistered=='yes')
			if($text_if_noregistered == NULL || $text_if_noregistered =='')
				$answer_content = 'Ce contenu est prot&eacute;g&eacute;. Merci de vous <strong>connecter</strong> ou de <strong>cr&eacute;er un compte</strong>.';
			else
				$answer_content = $text_if_noregistered;
		else
			$answer_content = '';
	}
	return $answer_content;
}
add_shortcode( 'LTBaccess', 'LTBaccess_shortcode' );

/******************************************/
/* ltb_create_user						  */
/******************************************/

function ltb_create_user($user_id)
{
	$info = get_userdata( $user_id );

	$args = array(
			'ID' => $user_id,
			'show_admin_bar_front' => 'False'
	);
	wp_update_user( $args );

	//$WP_LicenceToBill = new LicenceToBill($user_id, $info->user_email, 12, False);

}
add_action('user_register', 'ltb_create_user');

/******************************************/
/* class WP_Plugin_LicenceToBill		  */
/******************************************/

if(!class_exists('WP_Plugin_LicenceToBill'))
{
	class WP_Plugin_LicenceToBill
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
        	// Initialize Settings
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            $WP_Plugin_Template_Settings = new WP_Plugin_Template_Settings();

		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate
	} // END class WP_Plugin_LicenceToBill
} // END if(!class_exists('WP_Plugin_LicenceToBill'))

if(class_exists('WP_Plugin_LicenceToBill'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Plugin_LicenceToBill', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Plugin_LicenceToBill', 'deactivate'));

	// instantiate the plugin class
	$wp_plugin_licencetobill = new WP_Plugin_LicenceToBill();

    // Add a link to the settings page onto the plugin page
    if(isset($wp_plugin_licencetobill))
    {
        // Add the settings link to the plugins page
        function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=wp_plugin_licencetobill">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
    }
}
/******************************************/
/* LTBoffers_shortcode				      */
/******************************************/

function LTBoffers_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'text_if_anonymous' => '',
			'text_if_not_anonymous' => '',
			'keyoffer' => '',
		), $atts )
	);
	$current_user = '';
	$answer_content = '';

	// Code
	if ( is_user_logged_in() )
	{
		// Retrieve info of the current user
		$current_user = wp_get_current_user();
		$WP_LicenceToBill = new LicenceToBill($current_user->ID);

		if(!isset($WP_LicenceToBill))
			$answer_content = 'Please contact the administrator.<br />Status:'.$result->status.'<br />StatusCode:'.$result->status_code.'<br />Message:'.$result->message;
		else
		{
			if(isset($keyoffer) && $keyoffer != '')
			{
				$urloffer ='';
				$offers = $WP_LicenceToBill->offers($current_user->ID);

				foreach($offers as $offer)
				{
					if (strcasecmp($offer->key_offer,$keyoffer) == 0)
					{

						$urloffer = $offer->url_choose_payment;
						break;
					}
				}
				if(isset($text_if_not_anonymous) && $text_if_not_anonymous != '')
				{
					$answer_content = preg_replace ('{{link_offer}}',$urloffer, $text_if_not_anonymous);
					$answer_content = preg_replace ('{{link_offers}}',$WP_LicenceToBill->url_choose_offer, $answer_content);
				}
			}
			else
			{

				if(isset($text_if_not_anonymous) && $text_if_not_anonymous != '')
					if(stristr($text_if_not_anonymous, '{{link_offers}}'))
						$answer_content = preg_replace ('{{link_offers}}',$WP_LicenceToBill->url_choose_offer, $text_if_not_anonymous);
					else
						$answer_content = '<a href="'.$WP_LicenceToBill->url_choose_offer.'">'.$text_if_not_anonymous.'</a>';
			}
		}
	}
	else
	{
		if(isset($text_if_anonymous) && $text_if_anonymous != '')
			$answer_content = $text_if_anonymous;
			//else
			//	$answer_content = '\\';

	}
	return $answer_content;
}
add_shortcode( 'LTBoffers', 'LTBoffers_shortcode' );

/******************************************/
/* LTBinvoices_shortcode				  */
/******************************************/

function LTBinvoices_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'default_link_invoices' => '',
			'link_text' => '',
		), $atts )
	);
	$current_user = '';
	$answer_content = '';
	// Code
	if ( is_user_logged_in() )
	{
		// Retrieve info of the current user
		$current_user = wp_get_current_user();
		$WP_LicenceToBill = new LicenceToBill($current_user->ID);

		if(!isset($WP_LicenceToBill))
			$answer_content = 'Please contact the administrator.<br />Status:'.$result->status.'<br />StatusCode:'.$result->status_code.'<br />Message:'.$result->message;
		else
		{
			if(isset($link_text) && $link_text != '')
				$answer_content = '<a href="'.$WP_LicenceToBill->url_invoices.'">'.$link_text.'</a>';
			else
				$answer_content = $WP_LicenceToBill->url_invoices;
		}
	}
	else
	{
		if(isset($default_link_invoices) && $default_link_invoices != '')
			$answer_content = $default_link_invoices;
			else
				$answer_content = '\\';

	}
	return $answer_content;
}
add_shortcode( 'LTBinvoices', 'LTBinvoices_shortcode' );

/******************************************/
/* LTBdeals_shortcode					  */
/******************************************/
function LTBdeals_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'default_link_deals' => '',
			'link_text' => '',
		), $atts )
	);
	$current_user = '';
	$answer_content = '';
	// Code
	if ( is_user_logged_in() )
	{
		// Retrieve info of the current user
		$current_user = wp_get_current_user();
		$WP_LicenceToBill = new LicenceToBill($current_user->ID);

		if(!isset($WP_LicenceToBill))
			$answer_content = 'Please contact the administrator.<br />Status:'.$result->status.'<br />StatusCode:'.$result->status_code.'<br />Message:'.$result->message;
		else
		{
			if(isset($link_text) && $link_text != '')
				$answer_content = '<a href="'.$WP_LicenceToBill->url_deals.'">'.$link_text.'</a>';
			else
				$answer_content = $WP_LicenceToBill->url_deals;
		}
	}
	else
	{
		if(isset($default_link_deals) && $default_link_deals != '')
			$answer_content = $default_link_deals;
			else
				$answer_content = '\\';

	}
	return $answer_content;
}
add_shortcode( 'LTBdeals', 'LTBdeals_shortcode' );


/**
 * Hook to implement shortcode logic inside WordPress nav menu items
 * Shortcode code can be added using WordPress menu admin menu in description field
 */
function shortcode_menu( $item_output, $item ) {

    if ( !empty($item->description)) {
         $output = do_shortcode($item->description);

         if ( $output != $item->description )
               $item_output = $output;

        }

    return $item_output;

}

add_filter("walker_nav_menu_start_el", "shortcode_menu" , 10 , 2);


add_action( 'user_meta_after_user_update', 'user_meta_after_user_update_function' );
function user_meta_after_user_update_function( $response ){

	$company = get_option('LTB_setting_company');
	$fullname = get_option('LTB_setting_fullname');
	$address_line1 = get_option('LTB_setting_address_line1');
	$address_line2 = get_option('LTB_setting_address_line2');
	$zipcode = get_option('LTB_setting_zipcode');
	$city = get_option('LTB_setting_city');
	$country = get_option('LTB_setting_country');
	$vat_information = get_option('LTB_setting_vat_information');

	//if(!isset($trialoffer) || trim($trialoffer) == '')

	// Retrieve info of the current user
	$current_user = wp_get_current_user();
	$WP_LicenceToBill = new LicenceToBill($current_user->ID);

	if ($company!= NULL) $company = get_user_meta($current_user->ID, $company, TRUE);
	if ($fullname!= NULL) $fullname = get_user_meta($current_user->ID, $fullname, true);
	if ($address_line1!= NULL) $address_line1 = get_user_meta($current_user->ID, $address_line1, true);
	if ($address_line2!= NULL) $address_line2 = get_user_meta($current_user->ID, $address_line2, true);
	if ($zipcode!= NULL) $zipcode = get_user_meta($current_user->ID, $zipcode, true);
	if ($city!= NULL) $city = get_user_meta($current_user->ID, $city, true);
	if ($country!= NULL) $country = get_user_meta($current_user->ID, $country, true);
	if ($vat_information!= NULL) $vat_information = get_user_meta($current_user->ID, $vat_information, true);
	echo $company." ".$fullname." ".$address_line1." ".$address_line2;
	$result = $WP_LicenceToBill->address($current_user->ID, $company, $fullname, $address_line1, $address_line2, $zipcode, $city, NULL, $country, NULL, $vat_information);

}

add_action( 'user_meta_after_user_register', 'user_meta_after_user_register_function' );
function user_meta_after_user_register_function( $response ){

	$free_key_offer = NULL;

	if ($response->metaltb_trial != NULL) {
		if (strcasecmp($response->metaltb_trial, get_option('LTB_setting_trialcode1')) == 0) {
			$free_key_offer = get_option('LTB_setting_trial1');
		} elseif (strcasecmp($response->metaltb_trial, get_option('LTB_setting_trialcode2')) == 0) {
			$free_key_offer = get_option('LTB_setting_trial2');
		} elseif (strcasecmp($response->metaltb_trial, get_option('LTB_setting_trialcode3')) == 0) {
			$free_key_offer = get_option('LTB_setting_trial3');
		}
	}

	if ( $free_key_offer == NULL )
		$free_key_offer = get_option('LTB_setting_trial');

	$WP_LicenceToBill = new LicenceToBill($response->ID);
	$result = $WP_LicenceToBill->Trial($response->ID, $response->first_name.' '.$response->last_name ,12,$free_key_offer );

	$company = get_option('LTB_setting_company');
	$fullname = get_option('LTB_setting_fullname');
	$address_line1 = get_option('LTB_setting_address_line1');
	$address_line2 = get_option('LTB_setting_address_line2');
	$zipcode = get_option('LTB_setting_zipcode');
	$city = get_option('LTB_setting_city');
	$country = get_option('LTB_setting_country');
	$vat_information = get_option('LTB_setting_vat_information');

	if ($company!= NULL) $company = get_user_meta($response->ID, $company, TRUE);
	if ($fullname!= NULL) $fullname = get_user_meta($response->ID, $fullname, true);
	if ($address_line1!= NULL) $address_line1 = get_user_meta($response->ID, $address_line1, true);
	if ($address_line2!= NULL) $address_line2 = get_user_meta($response->ID, $address_line2, true);
	if ($zipcode!= NULL) $zipcode = get_user_meta($response->ID, $zipcode, true);
	if ($city!= NULL) $city = get_user_meta($response->ID, $city, true);
	if ($country!= NULL) $country = get_user_meta($response->ID, $country, true);
	if ($vat_information!= NULL) $vat_information = get_user_meta($response->ID, $vat_information, true);

	$result = $WP_LicenceToBill->address($response->ID, $company, $fullname, $address_line1, $address_line2, $zipcode, $city, NULL, $country, NULL, $vat_information);

	// Modifier les roles
	$user = get_user_by('id',$response->ID);

	if($user != false)
		CheckAndModifyRoles($user);
}

/************************************************/
/* GetOfferURL									*/
/************************************************/
function GetOfferURL( $iduser, $keyoffer )
{
	$urloffer = '';

	if(isset($iduser) && $iduser != '')
	{
		$WP_LicenceToBill = new LicenceToBill($iduser);

		if(isset($WP_LicenceToBill))
		{
			if(isset($keyoffer) && $keyoffer != '')
			{
				$offers = $WP_LicenceToBill->offers($iduser);
				foreach($offers as $offer)
				{
					if (strcasecmp($offer->key_offer,$keyoffer) == 0)
					{
						$urloffer = $offer->url_choose_payment;
						break;
					}
				}
			}
		}
	}
	return $urloffer;
}

/******************************************/
/* LTBroles_shortcode					  */
/******************************************/
function LTBroles_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'default_role' => '',
		), $atts )
	);
	$answer_content = '';

	if ( is_user_logged_in() )
	{
		// Retrieve info of the current user
		$current_user = wp_get_current_user();
		CheckAndModifyRoles($current_user);
	}

	return $answer_content;
}
add_shortcode( 'LTBroles', 'LTBroles_shortcode' );

/******************************************/
/* rolechanger_login					  */
/******************************************/

function rolechanger_login($user_login, $user)
{
	if (isset($user))
	{
		CheckAndModifyRoles($user);
	}
}
add_action('wp_login', 'rolechanger_login', 100, 2);

/******************************************/
/* CheckAndModifyRoles					  */
/******************************************/

function CheckAndModifyRoles($user)
{
	$offers_roles = '';
	$offer1_key = '';
	$offer2_key = '';
	$offer3_key = '';
	$offer4_key = '';
	$offer5_key = '';

	$current_user = $user;

	$WP_LicenceToBill = new LicenceToBill();
	$result = $WP_LicenceToBill->users($current_user->ID);

	// Status 404 retourné par LTB signifie 404 User Not Found
	if($result->Status != 404)
	{
		// Récupération des deals de l utilisateur
		$deals = $WP_LicenceToBill->deal($current_user->ID);

		// Recuperation des clés des offres pour lequel il y aura un changement de roles à faire.
		$offer1_key = get_option('LTB_RoleChanger_setting_offer1_key');
		$offer2_key = get_option('LTB_RoleChanger_setting_offer2_key');
		$offer3_key = get_option('LTB_RoleChanger_setting_offer3_key');
		$offer4_key = get_option('LTB_RoleChanger_setting_offer4_key');
		$offer5_key = get_option('LTB_RoleChanger_setting_offer5_key');

		// Si aucune configuration d'offres alors ne pas remettre à zéro les rôles de l'utilisateur
		if (!(($offer1_key == '') && ($offer2_key == '') && ($offer3_key == '') && ($offer4_key == '') && ($offer5_key == '')))
		{
			// Remise à zéro de ses rôles
			if($current_user->has_cap('administrator'))
				$current_user->set_role('administrator');
			else
				$current_user->set_role('none');

			// Traiter chacun des deals de l utilisateur
			foreach($deals as $deal)
			{
				// Détecter les deals en status 'Running'
				if (strcasecmp($deal->status,'Running') == 0)
				{
					$offer_roles = NULL;

					// Vérification à quelle offre se rattache le deal en traitement
					// et récupérer les roles associées à l'offre du deal.

					if (strcasecmp($deal->key_offer, $offer1_key) == 0)
						$offer_roles = get_option('LTB_RoleChanger_setting_offer1_roles');

					if (strcasecmp($deal->key_offer, $offer2_key) == 0)
						$offer_roles = get_option('LTB_RoleChanger_setting_offer2_roles');

					if (strcasecmp($deal->key_offer, $offer3_key) == 0)
						$offer_roles = get_option('LTB_RoleChanger_setting_offer3_roles');

					if (strcasecmp($deal->key_offer, $offer4_key) == 0)
						$offer_roles = get_option('LTB_RoleChanger_setting_offer4_roles');

					if (strcasecmp($deal->key_offer, $offer5_key) == 0)
						$offer_roles = get_option('LTB_RoleChanger_setting_offer5_roles');

					// Ajout des rôles
					foreach($offer_roles as $offer_role)
						$current_user->add_role($offer_role);
				}
			}
		}
	}
}