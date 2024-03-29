<?php

class Mahasiswa extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model');
        $this->load->library('form_validation');


    }
    
    public function index()
    {
        
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->getAllMahasiswa();
        if( $this->input->post('keyword') ) {
            $data['mahasiswa'] = $this->Mahasiswa_model->findDataMahasiswa();
        }
        $this->load->view('templates/header',$data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['judul'] = 'Form Add Data Mahasiswa';

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('matricNo', 'Matric No', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if( $this->form_validation->run() == FALSE ) {
            $this->load->view('templates/header', $data);
            $this->load->view('mahasiswa/add');
            $this->load->view('templates/footer');
        } else {
            $this->Mahasiswa_model->addDataMahasiswa();
            $this->session->set_flashdata('flash', 'Added');
            redirect('mahasiswa');
        }

    }

    public function delete($studentID)
    {
        $this->Mahasiswa_model->deleteDataMahasiswa($studentID);
        $this->session->set_flashdata('flash', 'Deleted');
        redirect('mahasiswa');
    }

    public function detail($studentID)
    {
        $data['judul'] = 'Detail Data Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->getMahasiswaById($studentID);
        $this->load->view('templates/header', $data);
        $this->load->view('mahasiswa/detail', $data);
        $this->load->view('templates/footer');
    }

    public function edit($studentID)
    {
        $data['judul'] = 'Form Edit Data Mahasiswa';
        $data['mahasiswa'] = $this->Mahasiswa_model->getMahasiswaById($studentID);
        $data['course'] = ['Software Engineering', 'Artificial Intelligence', 'Information System', 'Networking', 'Data Science'];

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('matricNo', 'Matric No', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if( $this->form_validation->run() == FALSE ) {
            $this->load->view('templates/header', $data);
            $this->load->view('mahasiswa/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Mahasiswa_model->editDataMahasiswa();
            $this->session->set_flashdata('flash', 'Edited');
            redirect('mahasiswa');
        }

    }
}