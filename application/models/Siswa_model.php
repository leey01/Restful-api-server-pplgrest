<?php 

class Siswa_model extends CI_Model 
{
    public function getSiswa($id = null) {
        if ($id === null) {
            return $this->db->get('pplg1')->result_array();
        } else {
            return $this->db->get_where('pplg1', ['id' => $id])->result_array();
        }
    }

    public function deleteSiswa($id) {
        $this->db->delete('pplg1', ['id' => $id]);
        // untuk return baris yg terpengaruh di database
        return $this->db->affected_rows();
    }

    public function createSiswa($data) {
        $this->db->insert('pplg1', $data);
        return $this->db->affected_rows();
    }

    public function updateSiswa($data, $id) {
        $this->db->update('pplg1', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}