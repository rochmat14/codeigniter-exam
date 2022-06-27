<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user extends CI_Model
{
    function DataUser()  //menampilkan data semua user
    {
        $this->db->order_by('id', 'DESC'); // melakukan order DESCENDING

        return $this->db->from('user')->get()->result(); // select tabel user
    }

    function InsertUser($email, $data) //insert data user / registrasi
    {
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where($email);
        $query = $this->db->get();
        $user = $query->row();
        if(!empty($user)){
            return "exits";
        }else{
            $this->db->insert('user', $data); //isert request ke tabel user

            // return $result; //menjalakan response
            return "success";
        }



    }

    function CheckLogin($email, $password) //login user
    {
        // mencari user berdasarkan email
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where("email", $email);
        $query = $this->db->get();

        
        $user = $query->row(); //mendapatkan jumlah data

        /**
         * Check password
         */
        if (!empty($user)) { //jika jumlah data user tidak kosong

            if (password_verify($password, $user->password)) { //perifikasi password

                return $query->result(); //menampilkan hasil response

            } else { //jika gagal verifikasi

                return FALSE; //menampilkan kondisi salah
            }
        } else {  //data yang di cari kosong

            return FALSE; //menampilkan konsid false
        }
    }

    function SendForgotPassword($data) //untuk menampilkan data yang ingin di forgor passwort
    {
        // mencari data berdasarkan email
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($data);

        $query = $this->db->get(); //mendapatkan hasil response

        return $query->result(); //menjalankan data yang telah si temukan
    }

    function dataUserById($data) //menampilkan data user berdasarkan id untuk menampilkan pada form edit data
    {
        // mencari data berdasarkan id
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($data);

        $query = $this->db->get(); //mendapatkan data

        return $query->result(); //menjalankan hasil yang di dapat
    }

    function EditDataUser($data, $id) //edit data user berdasarkan id
    {
        $this->db->where($id); // where no induk
        $result = $this->db->update('user', $data); //melakukan updare data yang ditemukan

        return $result; //mendapatka hasil response
    }

    function DeleteUser($data)  //mengapus data user
    {
        // melakukan penghapusan data berdasarkan id
        $this->db->where($data);
        $this->db->delete('user');
        
        // menampilkan data berdasarkan id yang di hapus
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($data);

        $query = $this->db->get(); //mendapatkan hasil data yang dicari

        return $query->result(); //menjalakna hasil data yang di dapat
    }

    function ForgotPassword($email, $password)  //mengubah password yang lupa
    {
        $this->db->where($email); //mencari data berdasarkan email
        $result = $this->db->update('user', $password); //updata password yang ditemukan datanya berdasakan email

        return $result; //menjalakan hasil dari perintah update
    }
}
