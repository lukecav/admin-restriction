<?php

class AR_Hooks {

	private static $instance = null;

	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function hide_plugin_controls( $actions ) {
		global $current_user;
		get_currentuserinfo();

		if ( $current_user->ID != 1 ) {
			if ( isset( $actions['activate'] ) ) {
				unset( $actions['activate'] );
			}
			if ( isset( $actions['edit'] ) ) {
				unset( $actions['edit'] );
			}
			if ( isset( $actions['deactivate'] ) ) {
				unset( $actions['deactivate'] );
			}
		}

		return $actions;
	}

	public function catch_plugin_cap( $allcaps, $caps, $args ) {
		global $current_user, $action;
		get_currentuserinfo();
		if ( $current_user->ID == 1 ) {
			return $allcaps;
		}
		if ( isset( $action ) && ( $action == 'activate' || $action == 'deactivate' ) ) {
			$allcaps['activate_plugins'] = 0;
		}

		return $allcaps;
	}

	public function disallow_core_update( $param ) {
		global $current_user;
		get_currentuserinfo();
		if ( $current_user->ID != 1 ) {
			return null;
		}

		return $param;
	}

}
