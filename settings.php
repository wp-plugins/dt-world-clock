<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<div style="width: 500px; margin: 0 auto; padding: 50px 0 40px;">
        <ul class="tabs" data-persist="true">
            <li><a href="#view1">General</a></li>
            <li><a href="#view2">Advanced</a></li>
            
        </ul>
        <form id="dt_form" method="post" action="options.php">
<?php settings_fields( 'dt_settings_group' ); ?>
        <div class="tabcontents">
            <div id="view1">
                
<h4>DT World Clock Settings</h4>
<table>
<tr><td>Choose Time Format</td><td><select name="dt_format">
<option value="1" <?php if(get_option( 'dt_format' )==1){ ?> selected <?php }?>>24 H</option>
<option value="2" <?php if(get_option( 'dt_format' )==2){ ?> selected <?php }?>>12 H</option>
</select></td></tr>
<tr><td>Clock Layout</td><td><select name="dt_layout">
<option value="1" <?php if(get_option( 'dt_layout' )==1){ ?> selected <?php }?>>Vertical</option>
<option value="2" <?php if(get_option( 'dt_layout' )==2){ ?> selected <?php }?>>Horizontal</option>
</select></td></tr>
<!--<tr><td>Display City/Country Name</td><td><select name="dt_city">
<option value="1" <?php //if(get_option( 'dt_city' )==1){ ?> selected <?php //}?>>Yes</option>
<option value="2" <?php //if(get_option( 'dt_city' )==2){ ?> selected <?php //}?>>No</option>
</select></td></tr>-->
<tr><td>Allignment of City/Country Name</td><td><select name="dt_align">
<option value="1" <?php if(get_option( 'dt_align' )==1){ ?> selected <?php }?>>Top</option>
<option value="2" <?php if(get_option( 'dt_align' )==2){ ?> selected <?php }?>>Bottom</option>
<option value="3" <?php if(get_option( 'dt_align' )==3){ ?> selected <?php }?>>Left</option>
<option value="4" <?php if(get_option( 'dt_align' )==4){ ?> selected <?php }?>>Right</option>
</select></td></tr>
<tr><td>Display Seconds</td><td><select name="dt_sec">
<option value="1" <?php if(get_option( 'dt_sec' )==1){ ?> selected <?php }?>>Yes</option>
<option value="0" <?php if(get_option( 'dt_sec' )==0){ ?> selected <?php }?>>No</option>
</select></td></tr>
<tr><td>Use Leading Zeors</td><td><select name="dt_zeros">
<option value="1" <?php if(get_option( 'dt_zeros' )==1){ ?> selected <?php }?>>Yes</option>
<option value="2" <?php if(get_option( 'dt_zeros' )==2){ ?> selected <?php }?>>Not for hours</option>
<option value="3" <?php if(get_option( 'dt_zeros' )==3){ ?> selected <?php }?>>Not at all</option>
</select></td></tr>
<tr><td>Dispay Date</td><td><select name="dt_date">
<option value="0">No, don't dispaly</option>
<?php foreach($date_formats as $key=>$format){ ?>
	<option value="<?php echo $key; ?>" <?php if($key==get_option( 'dt_date' )){?> selected <?php }?>><?php echo $format; ?></option>
<?php } ?>
</select></td></tr>
</table>


                
            </div>            
            <div id="view2">
                <h4>DT World Clock Settings</h4>
                <table>
                <?php
					$timezones = 
array ('Africa'=>array('0_Casablanca/Monrovia'=>'Casablanca/Monrovia','1_West Central Africa'=>'West Central Africa','2_Cairo/Harare/Pretoria'=>'Cairo/Harare/Pretoria','3_Nairobi'=>'Nairobi'),

	   'America'=>array('-9_Anchorage'=>'Anchorage','-8_Los_Angeles'=>'Los_Angeles','-7_Phoenix'=>'Phoenix','-7_Chihuahua'=>'Chihuahua','-7_Denver'=>'Denver','-6_Managua'=>'Managua','-6_Chicago'=>'Chicago','-6_Mexico_City'=>'Mexico_City','-6_Regina'=>'Regina','-5_Bogota'=>'Bogota','-5_New_York'=>'New_York','-5_Indiana/Indianapolis'=>'Indiana/Indianapolis','-4_Halifax'=>'Halifax','-4_Caracas'=>'Caracas','-4_Santiago'=>'Santiago','-3.5_St_Johns'=>'St_Johns','-3_Sao_Paulo'=>'Sao_Paulo','-3_Argentina/Buenos_Aires'=>'Argentina/Buenos_Aires','-3_Godthab'=>'Godthab','-2_Noronha'=>'Noronha'),
	   
	   'Asia'=>array('2_Jerusalem'=>'Jerusalem','3_Baghdad/Kuwait/Riyadh'=>'Baghdad/Kuwait/Riyadh','3.5_Tehran'=>'Tehran','4_Abu Dhabi/Muscat/Yerevan'=>'Abu Dhabi/Muscat/Yerevan','4.5_Kabul'=>'Kabul','5_Ekaterinburg/Islamabad/Karachi'=>'Ekaterinburg/Islamabad/Karachi','5.5_New Delhi/Kolkata/Mumbai'=>'New Delhi/Kolkata/Mumbai','5.75_Kathmandu'=>'Kathmandu','6_Almaty/Astana/Dhaka'=>'Almaty/Astana/Dhaka','6_Novosibirsk/Sri Jayawardenepura'=>'Novosibirsk/Sri Jayawardenepura','6.5_Rangoon'=>'Rangoon','7_Bangkok/Hanoi/Jakarta'=>'Bangkok/Hanoi/Jakarta','7_Krasnoyarsk'=>'Krasnoyarsk','8_Beijing/Hong Kong/Chongqing'=>'Beijing/Hong Kong/Chongqing','8_Irkutsk/Kuala Lumpur'=>'Irkutsk/Kuala Lumpur','8_Singapore/Taipei/Urumqi'=>'Singapore/Taipei/Urumqi','9_Osaka/Tokyo/Yakutsk'=>'Osaka/Tokyo/Yakutsk','10_Vladivostok'=>'Vladivostok','11_Magadan/New Caledonia/Solomon Is.'=>'Magadan/New Caledonia/Solomon Is.'),
	   
	   'Atlantic'=>array('-1_Azores/Cape_Verde'=>'Azores/Cape_Verde'),
	   
	   'Australia'=>array('8_Perth'=>'Perth','9.5_Adelaide/Darwin'=>'Adelaide/Darwin','10_Brisbane/Canberra/Hobart'=>'Brisbane/Canberra/Hobart'),
	   
	   'Europe'=>array('0_London/Lisbon/Dublin'=>'London/Lisbon/Dublin','1_Amsterdam/Belgrade/Bratislava'=>'Amsterdam/Belgrade/Bratislava','1_Paris/Madrid/Vienna'=>'Paris/Madrid/Vienna','1_Berlin/Rome'=>'Berlin/Rome','2_Athens/Helsinki/Istanbul'=>'Athens/Helsinki/Istanbul','3_Moscow/St. Petersburg/Volgograd'=>'Moscow/St. Petersburg/Volgograd'),
	   
	   'Pacific'=>array('-12_Wake'=>'Wake','-11_Apia'=>'Apia','-10_Honolulu'=>'Honolulu','10_Guam/Port Moresby'=>'Guam/Port Moresby','12_Auckland/Fiji/Kamchatka'=>'Auckland/Fiji/Kamchatka','12_Marshall Is./Wellington/Nuku'=>'Marshall Is./Wellington/Nuku') );
	   		
			for($i=1;$i<=4;$i++){?>
                	<tr><td colspan="2"><b>Clock <?php echo $i; ?></b></td></tr>
                    <tr><td>Show Clock</td><td><select name="dt_clock<?php echo $i; ?>_show"><option value='1'>Yes</option><option value='0' <?php if(!get_option('dt_clock'.$i.'_show')){?> selected <?php } ?> >No</option></select></td></tr>
                    <tr><td> Timezone</td><td><select name="dt_clock<?php echo $i; ?>_timezone">
                    <?php foreach($timezones as $continent=>$contries){?>
                    <optgroup label="<?php echo $continent; ?>">
                    <?php foreach($contries as $key=>$value){?>
                    <option <?php $tz=explode('_',get_option('dt_clock'.$i.'_timezone')); if($tz[1]==$value){ ?>selected<?php } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php }?>
                    </optgroup>
                    <?php }?>
                    </select></td></tr>
                         
            <?php } ?> 
                </table>
            </div>
            <?php submit_button(); ?>
        </div>
        </form>
    </div>
