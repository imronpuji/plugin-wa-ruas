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
	    add_submenu_page( 'wa-ruas', 'wa-ruas-setting', 'Template Pesan', 'manage_options', 'template-pesan', 'test_init');
	    add_submenu_page( 'wa-ruas', 'wa-ruas-setting', 'Reminder Pending Payment', 'manage_options', 'pending-payment', 'pending_payment');
	    add_submenu_page( 'wa-ruas', 'wa-ruas-setting', 'Reminder OnHold Payment', 'manage_options', 'on-hold-payment', 'on_hold_payment');
		add_submenu_page( '', 'Pending Payment', 'Pending Payment', 'manage_options', 'create-pending-payment', 'pending_payment' );
		add_submenu_page( '', 'OnHold Payment', 'OnHold Payment', 'manage_options', 'create-on-hold-payment', 'on_hold_payment' );

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
			        <textarea required style='white-space: pre-wrap;' name='wc-pending'>$data->wc_pending</textarea> <br>
			        <h3>On Hold</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-on-hold'>$data->wc_on_hold</textarea> <br>
			        <h3>Processing</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-processing'>$data->wc_processing</textarea> <br>
			        <h3>Completed</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-completed'>$data->wc_completed</textarea> <br>
			        <h3>Cancelled</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-cancelled'>$data->wc_cancelled</textarea> <br>
			        <h3>Refund</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-refund'>$data->wc_refund</textarea> <br>
			        <h3>Failed</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-failed'>$data->wc_failed</textarea> <br>
			        
			      
			        
			        <input type='hidden' name='id' value='$data->id'/> <br>
			        <input type='hidden' name='update' value='update'/>

			        <button  type='submit'>ubah</button>
			    </form>
			    <div id='wa-ruas-form' style='width:40%'>
			    	<h3>Shortcode :</h3> 
			    	<h5>@first_name : nama depan pembeli</h5> 
			    	<h5>@last_name : nama belakang pembeli</h5> 
			    	<h5>@invoice : nomor invoice pesanan</h5> 
			    	<h5>@phone : nomor hp pembeli</h5> 
			    	<h5>@payment : jenis pembayaran yang dipilih</h5> 
			    	<h5>@total : total pesanan</h5> 
			    	<h5>@product : nama produk</h5> 
			    	<h5>@domain : nama domain</h5> 

			    </div>
			</div>
			";
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
					width:100%;
					height:10vh
				}
			</style>
			<div style='display:flex; width:100%'>
			    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:60%'>
			        <input type='hidden' name='action' value='init_plugin_form'/>
			        <input type='hidden' name='custom_nonce' value=' <?php echo $custom_form_nonce ?>'/>

			        <h3>Pending Payment</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-pending'></textarea> <br>

			        <h3>On Hold</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-on-hold'></textarea> <br>

			        <h3>Processing</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-processing'></textarea> <br>

			        <h3>Completed</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-completed'></textarea> <br>

			        <h3>Cancelled</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-cancelled'></textarea> <br>

			        <h3>Refund</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-refund'></textarea> <br>
			        <h3>Failed</h3>
			        <textarea required style='white-space: pre-wrap;' name='wc-failed'></textarea> <br>

			        <input type='hidden' name='update' value='false'/>
	        
			        <button  type='submit'>simpan</button>
			    </form>
			    <div id='wa-ruas-form' style='width:40%'>
			    	<h3>Shortcode :</h3> 
			    	<h5>@first_name : nama depan pembeli</h5> 
			    	<h5>@last_name : nama belakang pembeli</h5> 
			    	<h5>@invoice : nomor invoice pesanan</h5> 
			    	<h5>@phone : nomor hp pembeli</h5> 
			    	<h5>@payment : jenis pembayaran yang dipilih</h5> 
			    	<h5>@total : total pesanan</h5> 
			    	<h5>@product : nama produk</h5>
			    	<h5>@domain : nama domain</h5> 

			    </div>
		    </div>
		    
		    ";
		}
		// jquery cdn add field dinamycally
		// echo "
		// 	<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
		// 	<script>
		// 		jQuery(document).ready(function(){
		// 			jQuery('#button').click(function(){
		// 				jQuery('#wa-ruas').append('<textarea style=\"white-space: pre-wrap;\" name=\"wc-pending\"></textarea> <br><br>');
		// 			});
		// 			jQuery('#button1').click(function(){
		// 				jQuery('#wa-ruas-hold').append('<textarea style=\"white-space: pre-wrap;\" name=\"wc-pending\"></textarea> <br><br>');
		// 			});
		// 		});
		// 	</script>
		// ";
		
		
	}
	
	function pending_payment(){
		$page = $_GET['page'];
		// add link to page create-pending-payment to admin
		
		if($page == 'create-pending-payment'){
			echo "
			<style>
				#wa-ruas-form {
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
			    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:50%'>
			        <input type='hidden' name='action' value='init_plugin_reminder'/>
			        <h3>Pesan</h3>
			        <textarea style='white-space: pre-wrap;' name='message'></textarea> <br>
			        <h3>Hari ke</h3>
			        <input type='number' name='day' placehoder='Hari'/> 
			        <input type='hidden' name='type' value='pending-payment'/> 
			        <input type='hidden' name='update' value='false'/> 
			        <br>
			        <br>
			        
			        <button  type='submit'>Simpan</button>
			        <br>
			    </form>
			</div>
		";
		}
		if($page == 'pending-payment'  && !isset($_GET['update'])){
		
			function get_pending_payment(){
				global $wpdb;
				$table_name = $wpdb->prefix . 'wa_reminder';
				$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE type = 'pending-payment' ORDER BY id DESC" );
				return $results;
			}
			$data = get_pending_payment();
			echo "
				<style>
					#container {
						padding: 10px;
						background: #fff;
						border: 1px solid #eee;
						margin: 10px;
					}
					#table-pending {
						border-collapse: collapse;
						width: 100%;
					}
					td, th {
						border: 1px solid #dddddd;
						text-align: left;
						padding: 8px;
					}
					tr:nth-child(even) {
						background-color: #dddddd;
					}e-pending
				</style>
				<div id='container'>
				<a href='admin.php?page=create-pending-payment'>
					<button>Buat Pengingat</button>						
				</a>
				
				<table id='table-pending'>
					<tr>
						<th>ID</th>
						<th>Pesan</th>
						<th>Hari ke</th>
						<th>Aksi</th>
					</tr>
				";
				foreach ( $data as $row ) {
					echo "
					<tr>
						<td>$row->id</td>
						<td>$row->message</td>
						<td>$row->day</td>
						<td>
							<a href='admin.php?page=pending-payment&delete=$row->id'>
								<button>Delete</button>
							</a>
							<a href='admin.php?page=pending-payment&update=$row->id'>
								<button>Edit</button>
							</a>
						</td>
					</tr>
					";
				}
				echo "
				</table>
				</div>
			";
			
			function remove_reminder(){
				global $wpdb;
				$table_name = $wpdb->prefix . 'wa_reminder';
				$id = $_GET['delete'];
				$page = $_GET['page'];
				var_dump($page);
				$wpdb->delete( $table_name, array( 'id' => $id ) );
				// how to make wp redirect back
				wp_redirect("admin.php?page=$page");

			}
			if(isset($_GET['delete'])){
				remove_reminder();
			}
					
		}
		
		if($page == 'pending-payment' && isset($_GET['update'])){
			global $wpdb;
			$table_name = $wpdb->prefix . 'wa_reminder';
			$id = $_GET['update'];
			$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = $id" );
			echo "
				<style>
					#wa-ruas-form {
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
				    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:50%'>
				        <input type='hidden' name='action' value='init_plugin_form' />
				        <input type='hidden' name='update' value='update'/>
				        <input type='hidden' name='id' value='$id'/>
				        <label>Pesan</label>
				        <textarea name='message'>$data->message</textarea>
				        <label>Hari ke</label>
				        <input type='number' name='day' value='$data->day'/>
				        <input type='hidden' name='type' value='$data->type'/>
				        <br>
				        <br>
				        
				        <button  type='submit'>Simpan</button>
				        <br>
				";
		}
		
		

		// jquery cdn add field dinamycally
		// echo "
		// 	<script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
		// 	<script>
		// 		jQuery(document).ready(function(){
		// 			jQuery('#button').click(function(){
		// 				jQuery('#wa-ruas').append('<textarea style=\"white-space: pre-wrap;\" name=\"wc-pending\"></textarea> <br><br>');
		// 			});
		// 			jQuery('#button1').click(function(){
		// 				jQuery('#wa-ruas-hold').append('<textarea style=\"white-space: pre-wrap;\" name=\"wc-pending\"></textarea> <br><br>');
		// 			});
		// 		});
		// 	</script>
		// ";
		
		
	}
	
	
	function on_hold_payment(){
		$page = $_GET['page'];
		// add link to page create-pending-payment to admin
		
		if($page == 'create-on-hold-payment'){
			echo "
			<style>
				#wa-ruas-form {
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
			    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:50%'>
			        <input type='hidden' name='action' value='init_plugin_reminder'/>
			        <h3>Pesan</h3>
			        <textarea style='white-space: pre-wrap;' name='message'></textarea> <br>
			        <h3>Hari ke</h3>
			        <input type='number' name='day' placehoder='Hari'/> 
			        <input type='hidden' name='type' value='on-hold-payment'/> 
			        <input type='hidden' name='update' value='false'/> 
			        <br>
			        <br>
			        
			        <button  type='submit'>Simpan</button>
			        <br>
			    </form>
			</div>
		";
		}
		if($page == 'on-hold-payment'  && !isset($_GET['update'])){
		
			function get_on_hold_payment(){
				global $wpdb;
				$table_name = $wpdb->prefix . 'wa_reminder';
				$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE type = 'on-hold-payment' ORDER BY id DESC" );
				return $results;
			}
			$data = get_on_hold_payment();
			echo "
				<style>
					#container {
						padding: 10px;
						background: #fff;
						border: 1px solid #eee;
						margin: 10px;
					}
					#table-pending {
						border-collapse: collapse;
						width: 100%;
					}
					td, th {
						border: 1px solid #dddddd;
						text-align: left;
						padding: 8px;
					}
					tr:nth-child(even) {
						background-color: #dddddd;
					}e-pending
				</style>
				<div id='container'>
				<a href='admin.php?page=create-on-hold-payment'>
					<button>Buat Pengingat</button>						
				</a>
				
				<table id='table-pending'>
					<tr>
						<th>ID</th>
						<th>Pesan</th>
						<th>Hari ke</th>
						<th>Aksi</th>
					</tr>
				";
				foreach ( $data as $row ) {
					echo "
					<tr>
						<td>$row->id</td>
						<td>$row->message</td>
						<td>$row->day</td>
						<td>
							<a href='admin.php?page=on-hold-payment&delete=$row->id'>
								<button>Delete</button>
							</a>
							<a href='admin.php?page=on-hold-payment&update=$row->id'>
								<button>Edit</button>
							</a>
						</td>
					</tr>
					";
				}
				echo "
				</table>
				</div>
			";
			
			function remove_reminder(){
				global $wpdb;
				$table_name = $wpdb->prefix . 'wa_reminder';
				$id = $_GET['delete'];
				$page = $_GET['page'];
				$wpdb->delete( $table_name, array( 'id' => $id ) );
				wp_redirect(admin_url("admin.php?page=$page"));

			}
			if(isset($_GET['delete'])){
				remove_reminder();
			}
			
			function update_reminder(){
				global $wpdb;
				$table_name = $wpdb->prefix . 'wa_reminder';
				$id = $_GET['update'];
				$message = $_POST['message'];
				$day = $_POST['day'];
				$wpdb->update( $table_name, array( 'message' => $message, 'day' => $day ), array( 'id' => $id ) );
				wp_redirect(admin_url('admin.php?page=pending-payment'));
			}
			
			
		}
		
		if($page == 'on-hold-payment' && isset($_GET['update'])){
			global $wpdb;
			$table_name = $wpdb->prefix . 'wa_reminder';
			$id = $_GET['update'];
			$data = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = $id" );
			echo "
				<style>
					#wa-ruas-form {
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
				    <form action='admin-post.php' method='post' id='wa-ruas-form' style='width:50%'>
				        <input type='hidden' name='action' value='init_plugin_form' />
				        <input type='hidden' name='update' value='update'/>
				        <input type='hidden' name='id' value='$id'/>
				        <label>Pesan</label>
				        <textarea name='message'>$data->message</textarea>
				        <label>Hari ke</label>
				        <input type='number' name='day' value='$data->day'/>
				        <input type='hidden' name='type' value='$data->type'/>
				        <br>
				        <br>
				        
				        <button  type='submit'>Simpan</button>
				        <br>
				";
		}
		
	}
	
	function init_plugin_form(){
		
		if(!isset($_POST['message'])){
			$wc_pending = sanitize_textarea_field($_POST['wc-pending']);
			$wc_processing = sanitize_textarea_field($_POST['wc-processing']);
			$wc_on_hold = sanitize_textarea_field($_POST['wc-on-hold']);
			$wc_completed = sanitize_textarea_field($_POST['wc-completed']);
			$wc_cancelled = sanitize_textarea_field($_POST['wc-cancelled']);
			$wc_refund = sanitize_textarea_field($_POST['wc-refund']);
			$wc_failed = sanitize_textarea_field($_POST['wc-failed']);
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
					'wc_cancelled' => $wc_cancelled,
					'wc_refund' => $wc_refund,
					'wc_failed' => $wc_failed,
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
					'wc_cancelled' => $wc_cancelled,
					'wc_refund' => $wc_refund,
					'wc_failed' => $wc_failed
				];
		
				insert_into_db($table, $data);
			}
		}
		
		if(isset($_POST['message'])){
		
			$type = sanitize_text_field($_POST['type']);
			$day = sanitize_text_field($_POST['day']);
			$message = sanitize_text_field($_POST['message']);
			$id = sanitize_text_field($_POST['id']);
			$update = sanitize_text_field($_POST['update']);
			global $wpdb;
			$table = $wpdb->prefix . 'wa_reminder';
			$data = [
				'type' => $type,
				'day' => $day,
				'message' => $message
			];
			if($update == 'update'){
				global $wpdb;
				$wpdb->update($table, $data, array('id' => $id));
				if($type == 'pending-payment'){
					wp_redirect(admin_url('admin.php?page=pending-payment'));
				} else {
					wp_redirect(admin_url('admin.php?page=on-hold-payment'));	
				}
			}
			if($update == 'false'){
				global $wpdb;
				$wpdb->insert($table, $data);
				if($type == 'pending-payment'){
					wp_redirect(admin_url('admin.php?page=pending-payment'));
				} else {
					wp_redirect(admin_url('admin.php?page=on-hold-payment'));	
				}
			}
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
		$sql .= "wc_refund text NULL,";
		$sql .= "wc_failed text NULL,";
		$sql .= "PRIMARY KEY (id)";
		$sql .= ")";
		$sql .= $charset_collate;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	register_activation_hook(__FILE__, 'create_table_wa_ruas');

	function create_table_wa_reminder(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wa_reminder';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE ";
		$sql .= "TABLE ";
		$sql .= "IF NOT EXISTS ";
		$sql .= $table_name;
		$sql .= "(";
		$sql .= "id mediumint(9) NOT NULL AUTO_INCREMENT,";
		$sql .= "message text NULL,";
		$sql .= "type varchar(20) NULL,";
		$sql .= "day varchar(20) NULL,";
		$sql .= "PRIMARY KEY (id)";
		$sql .= ")";
		$sql .= $charset_collate;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
	}
	register_activation_hook(__FILE__, 'create_table_wa_reminder');
	
	function rest_route_wa_ruas(){
		register_rest_route('wa-ruas/v1', '/ruas', array(
			'methods' => 'GET',
			'callback' => 'get_data_wa_ruas'
		));
	}
	add_action('rest_api_init', 'rest_route_wa_ruas');
	
	function get_data_reminder(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wa_reminder';
		$data = $wpdb->get_results("SELECT * FROM $table_name");
		return $data;
	}
	function get_data_wa_ruas(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'wa_ruas';
		$data = $wpdb->get_results("SELECT * FROM $table_name");
		$data['reminder'] = get_data_reminder();
		$data['price_thousan_sep'] = get_option('woocommerce_price_thousand_sep');
	
	
		return $data;
	}
	function insert_data_wa_ruas(){
		function get_db_wa_ruas($table_name){
			global $wpdb;
			$table_name = $wpdb->prefix . $table_name;
			$sql = "SELECT * FROM {$table_name}";
			$data = $wpdb->get_results($sql);

			return $data;
		}	
		$data = get_db_wa_ruas('wa_ruas');
		if(count($data) == 0){
			global $wpdb;
			$table_name = $wpdb->prefix . 'wa_ruas';
			$data = [
				'wc_pending' => 'Halo @first_name @last_name,

Terimakasih atas pesanan Anda di @domain.
No. tagihan: *@invoice*
Produk: 
@product
Jumlah Tagihan: *@total*
Pilihan pembayaran: *@payment*

Terimakasih.

=== english ===

Hello @first_name @last_name,

Thank you for your order at @domain.
Invoice number: *@invoice*

Product: 
@product

Total: *@total*
Payment method: *@payment*

Thank you.
				
',
				'wc_processing' => 'Halo @first_name @last_name,

Terimakasih atas pembayaran pesanan no. *@invoice* sejumlah *@total*, pesanan Anda akan *diproses*.

Mohon ditunggu.

Terimakasih
@domain

=== english ===
Hello @first_name @last_name,

Thank you, we have received your payment *@total*.
Your order will be *processed*.

Best regards,
@domain
				
',
				'wc_on_hold' => 'Halo @first_name @last_name,

Terimakasih atas pesanan Anda di @domain.
No. tagihan: *@invoice*
Produk: 
@product
Jumlah Tagihan: *@total*
Pilihan pembayaran: *@payment*

Terimakasih.

=== english ===

Hello @first_name @last_name,

Thank you for your order at @domain.
Invoice number: *@invoice*

Product: 
@product

Total: *@total*
Payment method: *@payment*

Thank you.',
				'wc_completed' => 'Halo @first_name @last_name,
				
Terimakasih telah bertransaksi dengan kami.

Salam hangat,
@domain

===english===
Hello @first_name @last_name,

Thank you for transacting with us.

Best regards,
@domain
				',
				'wc_cancelled' => 'Halo @first_name @last_name,

Pesanan Anda no. @invoice telah *dibatalkan*.
Anda dapat melakukan pemesanan ulang di @domain.

Terimakasih,
@domain

===english===

Hello @first_name @last_name,

Your order no. @invoice has been *canceled*.
You can reorder at @domain

Best regards,
@domain',
				'wc_refund' => 'Halo @first_name @last_name,

Pesanan Anda no. @invoice telah dilakukan *pengembalian dana*.

Terimakasih,
@domain

===english===
Hello @first_name @last_name,

Your order no. @invoice has been *refunded*.

Best regards,
@domain',
				'wc_failed' => 'Halo @first_name @last_name,

Pesanan Anda no. @invoice *gagal*.
Anda dapat melakukan pemesanan ulang di @domain.

Terimakasih,
@domain

===english===

Hello @first_name @last_name,

Your order no. @invoice is just *failed*.
You can reorder at @domain.

Best regards,
@domain'
			];
			$wpdb->insert($table_name, $data);
		}
		
	}
	register_activation_hook(__FILE__, 'insert_data_wa_ruas');
	
