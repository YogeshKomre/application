<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Schools extends MX_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('schools/school_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index() {
        $config = [
            'base_url' => base_url('schools'),
            'total_rows' => $this->school_model->count_schools($this->input->get('search')),
            'per_page' => 10,
            'uri_segment' => 2,
            'num_links' => 3
        ];

        $this->pagination->initialize($config);

        $data = [
            'schools' => $this->school_model->get_schools(
                $this->input->get('search'),
                $config['per_page'],
                $this->uri->segment(2)
            ),
            'pagination' => $this->pagination->create_links(),
            'search' => $this->input->get('search')
        ];

        $this->load->view('schools/list', $data);
    }

    public function add() {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('school_name', 'School Name', 'required|min_length[3]');
            $this->form_validation->set_rules('contact_person', 'Contact Person', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[schools.email]');
            $this->form_validation->set_rules('num_students', 'Number of Students', 'required|numeric');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $data = [
                    'school_name' => $this->input->post('school_name'),
                    'contact_person' => $this->input->post('contact_person'),
                    'email' => $this->input->post('email'),
                    'num_students' => $this->input->post('num_students'),
                    'status' => $this->input->post('status')
                ];

                $this->school_model->add_school($data);
                $this->session->set_flashdata('success', 'School added successfully');
                redirect('schools');
            }
        }

        $this->load->view('schools/form');
    }

    public function edit($id) {
        $school = $this->school_model->get_school($id);
        if (!$school) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('school_name', 'School Name', 'required|min_length[3]');
            $this->form_validation->set_rules('contact_person', 'Contact Person', 'required|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('num_students', 'Number of Students', 'required|numeric');
            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run()) {
                $data = [
                    'school_name' => $this->input->post('school_name'),
                    'contact_person' => $this->input->post('contact_person'),
                    'email' => $this->input->post('email'),
                    'num_students' => $this->input->post('num_students'),
                    'status' => $this->input->post('status')
                ];

                $this->school_model->update_school($id, $data);
                $this->session->set_flashdata('success', 'School updated successfully');
                redirect('schools');
            }
        }

        $data['school'] = $school;
        $this->load->view('schools/form', $data);
    }

    public function delete($id) {
        $this->school_model->delete_school($id);
        $this->session->set_flashdata('success', 'School deleted successfully');
        redirect('schools');
    }
}
