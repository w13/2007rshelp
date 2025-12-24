<?php
$oldclan = $_POST['oldclan'];

<?php echo $oldclan; ?><br />


/* 
class Clan extends CI_Controller {


public function result ()
{
$data['d'] = 'd';
$this->load->model('clan_model');
$current_names = $this->clan_model->get();
$old_names = $this->input->post('names');
$old_names = str_replace(array('-'), ' ', $old_names);
$old_names = preg_replace('/ {2,}/', ' ',$old_names);
$old_names = str_replace(array(' ' . PHP_EOL, PHP_EOL . ' '), PHP_EOL, $old_names);
$old_names = explode(PHP_EOL, $old_names);
$ra = array_diff($current_names, $old_names);
natsort($ra);
$rr = array_diff($old_names, $current_names);
natsort($rr);
$data['recently_added'] = implode('<br />', $ra);
$data['recently_removed'] = implode('<br />', $rr);
$this->load->view('clan/output', $data);
}

}