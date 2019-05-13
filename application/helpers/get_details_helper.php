<?php

$data['admin'] = $this->Admin_model->get_admin_detail();
$this->load->view($this->config->item('admin_folder').'/header_menu', $data);