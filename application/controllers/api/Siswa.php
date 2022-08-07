<?php 

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Siswa extends REST_Controller 
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Siswa_model', 'siswa');

        // limit
        $this->methods['index_get']['limit'] = 100;
    }

    public function index_get() {
        $id = $this->get('id'); // fungsi get untuk mengecek apakah ada id dikirim

        if ($id === null) {
            $siswa = $this->siswa->getSiswa();
        } else {
            $siswa = $this->siswa->getSiswa($id);
        }

        if ($siswa) {
            $this->response([
                'status' => true,
                'data' => $siswa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete() {
        $id = $this->delete('id');

        if ($id === NULL) {
            $this->response([
                // id null
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else if ($id <= 0) {
            // id not valid
            $this->response([
                'status' => false,
                'message' => 'id not valid!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->siswa->deleteSiswa($id) > 1) {  
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted.'
                ], REST_Controller::HTTP_OK);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post() {
        $data = [
            'absen' => $this->post('absen'),
            'nama' => $this->post('nama'),
            'nama_panjang' => $this->post('nama_panjang'),
            'asal' => $this->post('asal')
        ];

        if ($this->siswa->createSiswa($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new data siswa has been created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data siswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put() {
        $id = $this->put('id');

        $data = [
            'absen' => $this->put('absen'),
            'nama' => $this->put('nama'),
            'nama_panjang' => $this->put('nama_panjang'),
            'asal' => $this->put('asal')
        ];

        if ($this->siswa->updateSiswa($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data siswa has been updated'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update data siswa'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}