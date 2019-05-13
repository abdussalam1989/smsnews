<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Astute_Controller
 *
 * This class handles Backend_Controller management related functionality
 *
 * @package		Admin
 * Author: Arumugam
 * 		  sixfacedeveloper@gmail.com
 *         @sixface
 * @link		http://astutesixface.com
 */
class Astute_Controller extends CI_Controller {

    protected $data = Array();
    protected $controller_name;
    protected $action_name;
    protected $previous_controller_name;
    protected $previous_action_name;
    protected $save_previous_url = false;
    protected $page_title;

    public function __construct() {
        parent::__construct();
     
        $this->cms = $this->load->database('orginal', TRUE);
        //set the current controller and action name
        $this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
        $this->data['controller_name'] = $this->controller_name;
        $this->action_name = $this->router->fetch_method();

        $this->uriSegment = str_replace('/index', '', $this->controller_name . '/' . $this->action_name);

        $this->controller_name = str_replace('admin/', '', $this->controller_name);
        if ($this->action_name != 'index') {
            $this->data['page_name'] = $this->controller_name . ' ' . $this->action_name;
        } else {
            $this->data['page_name'] = $this->controller_name;
        }
        $this->data['menu_name'] = $this->controller_name;



        $user_id = $this->session->userdata('user_id');

        $user_type = $this->session->userdata('group');




        $exception_uris = array();


        // Login check
        if (!in_array($this->uriSegment, $exception_uris) && $user_type != 1) {
            // redirect('admin');
        }


        $this->data['content'] = 'No content please contact admn';
        $this->data['description'] = '';
        $this->data['author'] = '';
        $this->data['keywords'] = '';
        $this->data['revisit_after'] = '';
        $this->data['css'] = '';
        $this->data['headhtml'] = '';
        $this->data['footerhtml'] = '';
        $this->data['system_name'] = '';
    }

    protected function render($_view = false, $content_only = FALSE, $template = 'backend') {

        if ($_view != false) {
            $this->action_name = $_view;
        }

        if ($template == NULL) {
            $template = 'backend';
        }

        //save the controller and action names in session
        if ($this->save_previous_url) {
            $this->session->set_flashdata('previous_controller_name', $this->previous_controller_name);
            $this->session->set_flashdata('previous_action_name', $this->previous_action_name);
        } else {
            $this->session->set_flashdata('previous_controller_name', $this->controller_name);
            $this->session->set_flashdata('previous_action_name', $this->action_name);
        }
        $view_path = 'pages/' . $template . '/' . $this->controller_name . '/' . $this->action_name . '.php'; //set the path off the view
        $head_path = 'pages/' . $template . '/' . $this->controller_name . '/head/' . $this->action_name . '.php'; //set the path off the view
        $footer_path = 'pages/' . $template . '/' . $this->controller_name . '/footer/' . $this->action_name . '.php'; //set the path off the view
        if (file_exists(APPPATH . 'views/' . $view_path)) {
            if (file_exists(APPPATH . 'views/' . $head_path)) {
                $this->data['headhtml'] .= $this->load->view($head_path, $this->data, true);
            }

            if (file_exists(APPPATH . 'views/' . $footer_path)) {
                $this->data['footerhtml'] .= $this->load->view($footer_path, $this->data, true);
            }

            $this->data['content'] = $this->load->view($view_path, $this->data, true);  //load the view
        }
        // Do NOT update an existing session on AJAX calls.
        if ($this->input->is_ajax_request() || $content_only == true) {
            $this->load->view($view_path, $this->data);
            $this->load->view('pages/backend/extra_ajax_js', $this->data);
        } else {
            $this->load->view("layouts/$template.tpl.php", $this->data);  //load the template
        }
    }

    protected function add_title() {
        $this->load->model('page_model');

        //the default page title will be whats set in the controller
        //but if there is an entry in the db override the controller's title with the title from the db
        $page_title = $this->page_model->get_title($this->controller_name, $this->action_name);
        if ($page_title) {
            $this->data['title'] = $page_title;
        }
    }

    protected function save_url() {
        $this->save_previous_url = true;
    }

}
