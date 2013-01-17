<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	  'pi_name' => 'Ds get increment',
	  'pi_version' => '0.1',
	  'pi_author' => 'Dion Snoeijen',
	  'pi_author_url' => 'http://www.diovisuals.com/',
	  'pi_description' => 'Get highest number from number field',
	  'pi_usage' => Ds_get_increment::usage()
);

class Ds_get_increment 
{
	private $EE;
	public $return_data = '';

	public function __construct() 
	{
		$data = '';
		
		$this->EE =& get_instance();
		$increment = $this->EE->TMPL->fetch_param('increment', 0);
		$field = $this->EE->TMPL->fetch_param('field', false);

		if($field) {
			$field_id = $this->EE->db->query('SELECT field_id FROM exp_channel_fields WHERE field_name = "' . $field .'"')->result_array();

			$field_selector = 'field_id_' . $field_id[0]['field_id'];
			$field_data = $this->EE->db->query('SELECT ' . $field_selector . ' FROM exp_channel_data ORDER BY ' . $field_selector . ' DESC LIMIT 1')->result_array();

			$data = intval($field_data[0][$field_selector]) + intval($increment);
		} else {
			$data = 'Please set the field name.';
		}

		$this->return_data = $data;
	}

	private function quick_debug($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	// usage instructions
	public function usage() 
	{
  		ob_start();
?>
	-------------------
	HOW TO USE
	-------------------

	<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}	
}
