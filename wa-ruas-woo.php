<?php 
	/**
* Plugin Name: Ruas Digital - WooCommerce
* Plugin URI: https://www.Ruasdigital.id/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Muhamad Imron
* Author URI: http://yourwebsiteurl.com/
**/

add_action('admin_menu', 'test_plugin_setup_menu');
 
	function test_plugin_setup_menu(){
	    add_menu_page( 'WaRuas', 'WaRuas', 'manage_options', 'wa-ruas', 'test_init' );
	}
	 
	function test_init(){
	
	
		function get_db_data($table_name){
			global $wpdb;
			$table_name = $wpdb->prefix . $table_name;
			$sql = "SELECT * FROM {$table_name}";
			$data = $wpdb->get_results($sql);

			return $data;
		}
		
		$data = get_db_data('wa_ruas');
		$data = $data[0];


		function get_db_webhook($table_name){
			global $wpdb;
			$table_name = $wpdb->prefix . $table_name;
			$sql = "SELECT * FROM {$table_name}";
			$data = $wpdb->get_results($sql);

			return $data;
		}	
		$webhook = get_db_webhook('wc_webhooks');

		echo '<h1>WaRuas</h1>';
		if(count($webhook) > 0){
			echo "<p>Sudah Terkoneksi Dengan WaRuas</p>";
		} else {
			echo "<p>Belum Terkoneksi Dengan WaRuas</p>";

		}
		echo '<p>Setting notifikasi Woocommerce</p>';
	    
	    if(!empty($data->wc_pending)){
		
		    echo "
		    <style>
				#wa-ruas-form{
					padding: 10px;
					background: #fff;
					border: 1px solid #eee;
					margin: 10px;
				}
				textarea {
					width:100%;
					height:10vh;
				}
			</style>
			<div style='display:flex; width:100%'>
			    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:60%;'>
			        <input type='hidden' name='action' value='init_plugin_form'/>
			        <input type='hidden' name='custom_nonce' value=' <?php echo $custom_form_nonce ?>'/>
			        <h3>Pending Payment</h3>
			        <textarea name='wc-pending'>$data->wc_pending</textarea> <br>
			        <h3>On Hold</h3>
			        <textarea name='wc-on-hold'>$data->wc_on_hold</textarea> <br>
			        <h3>Processing</h3>
			        <textarea name='wc-processing'>$data->wc_processing</textarea> <br>
			        <h3>Completed</h3>
			        <textarea name='wc-completed'>$data->wc_completed</textarea> <br>
			        <h3>Cancelled</h3>
			        <textarea name='wc-cancelled'>$data->wc_cancelled</textarea> <br>
			      
			        
			        <input type='hidden' name='id' value='$data->id'/> <br>
			        <input type='hidden' name='update' value='update'/>

			        <button  type='submit'>ubah</button>
			    </form>
			    <div id='wa-ruas-form' style='width:40%'>
			    	<h3>Sortcode :</h3> 
			    	<h5>@first_name : nama depan pembeli</h5> 
			    	<h5>@last_name : nama belakang pembeli</h5> 
			    	<h5>@invoice : nomor invoice pesanan</h5> 
			    	<h5>@phone : nomor hp pembeli</h5> 
			    	<h5>@payment : jenis pembayaran yang dipilih</h5> 
			    	<h5>@qty : jumlah produk</h5>
			    	<h5>@total : total pesanan</h5> 
			    	<h5>@product : nama produk</h5> 

			    </div>
			</div>";
		} else {
			echo "
		    <style>
				#wa-ruas-form{
					padding: 10px;
					background: #fff;
					border: 1px solid #eee;
					margin: 10px;
				}
				textarea {
					width:50%;
					height:10vh
				}
			</style>
			<div style='display:flex; width:100%'>
			    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:60%'>
			        <input type='hidden' name='action' value='init_plugin_form'/>
			        <input type='hidden' name='custom_nonce' value=' <?php echo $custom_form_nonce ?>'/>

			        <h3>Pending Payment</h3>
			        <textarea name='wc-pending'></textarea> <br>

			        <h3>Processing</h3>
			        <textarea name='wc-processing'></textarea> <br>

			        <h3>Completed</h3>
			        <textarea name='wc-completed'></textarea> <br>

			        <h3>Cancelled</h3>
			        <textarea name='wc-cancelled'></textarea> <br>

			        <h3>On Hold</h3>
			        <textarea name='wc-on-hold'></textarea> <br>
			        <input type='hidden' name='update' value='false'/>
	        
			        <button  type='submit'>simpan</button>
			    </form>
			    <div id='wa-ruas-form' style='width:40%'>
			    	<h3>Sortcode :</h3> 
			    	<h5>@first_name : nama depan pembeli</h5> 
			    	<h5>@last_name : nama belakang pembeli</h5> 
			    	<h5>@invoice : nomor invoice pesanan</h5> 
			    	<h5>@phone : nomor hp pembeli</h5> 
			    	<h5>@payment : jenis pembayaran yang dipilih</h5> 
			    	<h5>@qty : jumlah produk</h5>
			    	<h5>@total : total pesanan</h5> 
			    	<h5>@product : nama produk</h5>
			    </div>
		    </div>
		    ";
		}
	}
	
	function init_plugin_form(){
		
		$wc_pending = sanitize_text_field($_POST['wc-pending']);
		$wc_processing = sanitize_text_field($_POST['wc-processing']);
		$wc_on_hold = sanitize_text_field($_POST['wc-on-hold']);
		$wc_completed = sanitize_text_field($_POST['wc-completed']);
		$wc_cancelled = sanitize_text_field($_POST['wc-cancelled']);
		$update = sanitize_text_field($_POST['update']);
		$id = sanitize_text_field($_POST['id']);

		function update_db_data($wc_pending, $wc_processing, $wc_on_hold, $wc_completed, $wc_cancelled, $id){
			global $wpdb;
			$table_name = $wpdb->prefix . 'wa_ruas';
			$wpdb->update( $table_name, array(
				'wc_pending' => $wc_pending,
				'wc_processing' => $wc_processing,
				'wc_on_hold' => $wc_on_hold,
				'wc_completed' => $wc_completed,
				'wc_cancelled' => $wc_cancelled
			), array( 'id' => $id ), array( '%s', '%s', '%s', '%s', '%s' ), array( '%d' ) );
			wp_redirect(admin_url('admin.php?page=wa-ruas'));
		}
		

		if($update == 'update'){
			update_db_data($wc_pending, $wc_processing, $wc_on_hold, $wc_completed, $wc_cancelled, $id);		
		}


		if($update == 'false'){
			function insert_into_db($table, $data){
				global $wpdb;
				$wpdb->insert($table, $data);
				wp_redirect(admin_url('admin.php?page=wa-ruas'));
			}
			global $wpdb;
			
			$table = $wpdb->prefix . 'wa_ruas';
			$data = [
				'wc_pending' => $wc_pending,
				'wc_processing' => $wc_processing,
				'wc_on_hold' => $wc_on_hold,
				'wc_completed' => $wc_completed,
				'wc_cancelled' => $wc_cancelled
			];
	
			insert_into_db($table, $data);
		}
		
		
	}
	add_action('admin_init', 'init_plugin_form');
	
	
	function create_table_wa_ruas(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wa_ruas';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE ";
		$sql .= "TABLE ";
		$sql .= "IF NOT EXISTS ";
		$sql .= $table_name;
		$sql .= "(";
		$sql .= "id mediumint(9) NOT NULL AUTO_INCREMENT,";
		$sql .= "wc_pending text NULL,";
		$sql .= "wc_processing text NULL,";
		$sql .= "wc_on_hold text NULL,";
		$sql .= "wc_completed text NULL,";
		$sql .= "wc_cancelled text NULL,";
		$sql .= "PRIMARY KEY (id)";
		$sql .= ")";
		$sql .= $charset_collate;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	register_activation_hook(__FILE__, 'create_table_wa_ruas');
	
	function rest_route_wa_ruas(){
		register_rest_route('wa-ruas/v1', '/ruas', array(
			'methods' => 'GET',
			'callback' => 'get_data_wa_ruas'
		));
	}
	add_action('rest_api_init', 'rest_route_wa_ruas');
	
	function get_data_wa_ruas(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wa_ruas';
		$data = $wpdb->get_results("SELECT * FROM $table_name");
		return $data;
	}