<?php

class SiteOrigin_Installer_GitHub_Updater {
	private $file;
	const UPDATES_BRANCH = 'master';

	public function __construct( $file ) {
		$this->file = $file;

		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_for_update' ), 15 );
		add_filter( 'plugins_api', array( $this, 'plugin_api_call' ), 10, 3 );

		// This line forces an updates call
		// set_site_transient( 'update_plugins', null );
	}

	public function check_for_update( $transient ) {
		$all_headers = $this->get_plugin_headers();
		$plugin_path = $this->get_plugin_path();

		if ( version_compare( SITEORIGIN_INSTALLER_VERSION, $all_headers['Version'], '<' ) ) {
			// There is a newer version available on Github
			$update = new stdClass();
			$update->slug = $plugin_path;
			$update->new_version = $all_headers['Version'];
			$update->url = $all_headers['PluginURI'];
			$update->package = 'https://github.com/siteorigin/siteorigin-installer/archive/' . self::UPDATES_BRANCH . '.zip';

			$transient->response[ $plugin_path ] = $update;
		}

		return $transient;
	}

	public function get_plugin_path() {
		preg_match( '#/([a-zA-Z\-]+/[a-zA-Z\-]+\.php)$#', $this->file, $matches );

		return !empty( $matches[1] ) ? $matches[1] : false;
	}

	public function get_plugin_headers() {
		static $all_headers = array();

		if ( !empty( $all_headers ) ) {
			return $all_headers;
		}

		$response = wp_remote_get( 'https://raw.githubusercontent.com/siteorigin/siteorigin-installer/' . self::UPDATES_BRANCH . '/siteorigin-installer.php' );

		if ( is_wp_error( $response ) || empty( $response['body'] ) ) {
			return false;
		}

		$file_data = $response['body'];
		$all_headers = array(
			'Name'        => 'Plugin Name',
			'PluginURI'   => 'Plugin URI',
			'Version'     => 'Version',
			'Description' => 'Description',
			'Author'      => 'Author',
			'AuthorURI'   => 'Author URI',
		);

		foreach ( $all_headers as $field => $regex ) {
			if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ) {
				$all_headers[ $field ] = _cleanup_header_comment( $match[1] );
			} else {
				$all_headers[ $field ] = '';
			}
		}

		return $all_headers;
	}

	/**
	 * Get and parse a markdown file from Github
	 *
	 * @param string $file
	 *
	 * @return bool|string
	 */
	public function get_github_markdown( $file = 'readme.md' ) {
		$response = wp_remote_get( 'https://raw.githubusercontent.com/siteorigin/siteorigin-installer/' . self::UPDATES_BRANCH . '/' . urlencode( $file ) );

		if ( is_wp_error( $response ) || empty( $response['body'] ) ) {
			return false;
		}

		if ( !class_exists( 'Parsedown' ) ) {
			require_once plugin_dir_path( __FILE__ ) . '/Parsedown/Parsedown.php';
		}

		$parsedown = new Parsedown();

		return $parsedown->parse( $response['body'] );
	}

	/**
	 * Add all the plugin details to the Plugin API call
	 *
	 * @return stdClass
	 */
	public function plugin_api_call( $def, $action, $args ) {
		if ( isset( $args->slug ) && $args->slug == $this->get_plugin_path() && $action == 'plugin_information' ) {
			$headers = $this->get_plugin_headers();
			$response = new stdClass();
			$response->slug = $this->get_plugin_path();
			$response->plugin_name = $headers['Name'];
			$response->name = $headers['Name'];
			$response->version = $headers['Version'];
			$response->author = $headers['Author'];
			$response->homepage = $headers['PluginURI'];
			$response->download_link = 'https://github.com/siteorigin/siteorigin-installer/archive/' . self::UPDATES_BRANCH . '.zip';
			$response->sections = array(
				'description' => $this->get_github_markdown( 'readme.md' ),
				'changelog' => $this->get_github_markdown( 'changelog.md' ),
			);

			return $response;
		} else {
			return $def;
		}
	}
}
