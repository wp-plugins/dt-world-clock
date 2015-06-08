<?php
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
	/*
		Plugin Name: DT World Clock
		Plugin URI: http://www.deligence.com 
		Author: Deligence Technologies
		Author URI: http://www.deligence.com 
		Version: 1.0.0
		Description: its a plugin to show world clocks
	*/
	
	/* Copyright 2015-16 Deligence Technologies (email : saurabh@deligence.com)
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License as
	published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	108 The WordPress Anthology This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public
	License along with this program; if not, write to the Free Software
	Foundation, Inc.,
	*/	
	
	
	/* to register plugin */
	function dt_register()
	{
		 //code here
	}
	register_activation_hook( __FILE__ ,'dt_register');
	
	function dt_uninstall()
	{
		delete_option('dt_format' );
		delete_option('dt_layout' );		
		delete_option('dt_settings_group', 'dt_align'  );
		delete_option('dt_settings_group', 'dt_sec'    );
		delete_option('dt_zeros'  );
		delete_option('dt_date'   );
		/*------------------Advance------------------------*/
		delete_option('dt_clock1_show');
		delete_option('dt_clock1_timezone');
		delete_option('dt_clock2_show');
		delete_option('dt_clock2_timezone');
		delete_option('dt_clock3_show');
		delete_option('dt_clock3_timezone');
		delete_option('dt_clock4_show');
		delete_option('dt_clock4_timezone');
	}
	
	register_uninstall_hook( __FILE__ ,'dt_uninstall');
	
	function dt_global_vars()
	{
		global $date_formats;
		$date_formats=array("%Y-%m-%d"=>"YYYY-MM-DD","%d-%m-%Y"=>"DD-MM-YYY","%m-%d-%Y"=>"MM-DD-YYYY");
								
	}
	
	add_action( 'parse_query', 'dt_global_vars' );
	
	/* to create plugin menu in admin area */
	function my_scripts() {
	wp_enqueue_script( 'tabcontent-js', plugins_url( 'dt-world-clock/js/tabcontent.js' , dirname(__FILE__) ) );
	wp_enqueue_style('tabcontent-css', plugins_url( 'dt-world-clock/css/tabcontent.css' , dirname(__FILE__) ) );
	}		
	
	function dt_create_menu()
	{
		$menu=add_menu_page( 'DT-World-Clock', 'DTW Clock', 'manage_options', 'dt-world-clock/settings.php', '', plugins_url( 'dt-world-clock/dtw_clock.png' ), 6 );	
		add_action('admin_enqueue_scripts', 'my_scripts');	
		add_action( 'admin_init', 'dt_register_settings' );			
	}
	
	add_action('admin_menu','dt_create_menu');
	
		
	/* to save settings of our plugin */
	function dt_register_settings()
	{
		register_setting( 'dt_settings_group', 'dt_format' );
		register_setting( 'dt_settings_group', 'dt_layout' );		
		register_setting( 'dt_settings_group', 'dt_align'  );
		register_setting( 'dt_settings_group', 'dt_sec'    );
		register_setting( 'dt_settings_group', 'dt_zeros'  );
		register_setting( 'dt_settings_group', 'dt_date'   );
		/*------------------Advance------------------------*/
		register_setting( 'dt_settings_group', 'dt_clock1_show');
		register_setting( 'dt_settings_group', 'dt_clock1_timezone');
		register_setting( 'dt_settings_group', 'dt_clock2_show');
		register_setting( 'dt_settings_group', 'dt_clock2_timezone');
		register_setting( 'dt_settings_group', 'dt_clock3_show');
		register_setting( 'dt_settings_group', 'dt_clock3_timezone');
		register_setting( 'dt_settings_group', 'dt_clock4_show');
		register_setting( 'dt_settings_group', 'dt_clock4_timezone');
	}
	
	/* widget */
	class Dtw_Clock_Widget extends WP_Widget
	{		
	   
		//* Widget setup */
		function __construct()
		{
			// actual widget code that contains the function logic
			$widget_ops = array('classname' => 'Dtw_Clock_Widget', 'description' =>__( 'Show DT World Clock on FrontEnd') );
			// The actual widget code goes here
			parent::WP_Widget( false, 'DT World Clock', $widget_ops );
		}
		
		function widget($args, $instance) {
				
			// display the widget on website
			//get widget arguments
			$format=get_option('dt_format');
			$layout=get_option('dt_layout');			
			$align=get_option('dt_align');
			$sec=get_option( 'dt_sec' );
			$zeros=get_option( 'dt_zeros' );
			$date=get_option( 'dt_date' );
			$clock1_show=get_option( 'dt_clock1_show' );
			$clock2_show=get_option( 'dt_clock2_show' );
			$clock3_show=get_option( 'dt_clock3_show' );
			$clock4_show=get_option( 'dt_clock4_show' );
			global $date_formats;
			$title = apply_filters('widget_title', $instance['title']);		
			echo $args['before_widget'];					
			?>			
			
			<style>
				.dt_clocks{
					list-style:none;
					margin:0;
					
				}
				.dt_clocks li
				{
					/* vertical */
					<?php if($layout==2){?>display:inline-block;<?php }?>	
					padding:2px;				
				}
				.digits
				{
					font-size:18px;
				}
			</style>
            <script>						
			function checkTime(i) {
				if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
				return i;
			}
			
			function DisplayCityTime(div_id,offset) {
	
				// Date object for current location
				var adate = new Date();
			
				// UTC time in msec
				var utc = adate.getTime() + (adate.getTimezoneOffset() * 60000);
			
				// Date object for the requested city
				var today = new Date(utc + (3600000*offset));			
				
			
				// time as a string
				
				var h=today.getHours()<?php if($format==2){ ?>  % 12 || 12  <?php } ?>;
				var m=today.getMinutes();
				var s=today.getSeconds();
				<?php if($zeros<3){ ?>
				<?php if($zeros==1){?>
				h = checkTime(h);
				<?php } ?>
				m = checkTime(m);
				s = checkTime(s);
				<?php } ?>
				document.getElementById(div_id).innerHTML = h+":"+m <?php if($sec){ ?>+":"+s <?php } ?>;
				
				//------------------date logic-------------------
				id=div_id.split("_");
				var month=today.getMonth() + 1;
				var day=today.getDate();
				var year=today.getFullYear();
				<?php if($date){ ?>
				document.getElementById('date_'+id[1]).innerHTML = today.toLocaleFormat('<?php echo $date; ?>');
				<?php } ?>
				
			}
			
			</script>
           
		   <?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
			}?>
        
			<ul class="dt_clocks">
            <!------------clocks-------->
            <?php for($i=1;$i<=4;$i++){?>	
         		<?php if(get_option( 'dt_clock'.$i.'_show' )){$tz=explode("_", get_option('dt_clock'.$i.'_timezone'));?>
				<li><div id="dt_clock_<?php echo $i; ?>">
                <?php if($align<=2){ if($align==1){?>
                <div><?php echo $tz[1]; ?></div>
                <?php }}else {if($align==3){ ?>
                <?php echo $tz[1]; ?>
                <?php }} ?>
                <span id="clock_<?php echo $i; ?>" class="digits"></span>
                <?php if($align<=2){if($align==2){?>
                <div><?php echo $tz[1]; ?></div>
                <?php }}else {if($align==4){ ?>
                <?php echo $tz[1]; ?>
                <?php }} ?>
                <?php if($date){?>
                <div class="dt_date" id="date_<?php echo $i; ?>">                
                </div>
                <?php }?>
                <script>
				var t1 = setInterval(function(){DisplayCityTime('clock_<?php echo $i; ?>','<?php echo $tz[0]; ?>')},500);
				</script>
                </div></li>	
                <?php } ?>
            <?php }//end of for loop ?>
            <!------------clocks--------> 
			
            </ul>			
			
            <?php echo $args['after_widget']; ?>
		<?php }		
		
		function update($new_instance, $old_instance) {
		// save widget options
			$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
		}
		function form($instance) {
		// form to display widget settings in WordPress admin
			$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
		}
	}//end of class Dtw_Clock_Widget
	
	function dt_clock_register_widget()
	{
		register_widget( 'Dtw_Clock_Widget' );
	}
	/* Load the widget */
	add_action( 'widgets_init', 'dt_clock_register_widget' );		
	
?>