<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class ForgotPass extends CI_Controller {



		public function index()

		{

			$this->load->view('forgotPass');

        }		

        public function Action(){

            //cari employee dengan email yg terdaftar
            $email = $this->input->post("insEmail");
            if (strpos($email, '@mapangroup.com') === FALSE) {
                $this->session->set_flashdata("resetfailed","Harap Masukkan Email Yang Terdaftar, <p>Contoh : contoh@mapangroup.com</p>");
                redirect(base_url("ForgotPass"));
            }else{
                $where = array(
                    'EMP_EMAIL' => $email,
                );
                $dataEMP = $this->Model_online->findSingleDataWhere($where,'m_employee');
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                $randomPass = substr(str_shuffle($permitted_chars), 0, 10);
                //update data berdasarkan id yg diambil dari email yg terdaftar
                // update passwordnya dari generated random char
                $data = array(
                    'EMP_PASS' => $randomPass,
                    'EMP_STATUS' => '99'
                    );
                $wheredat = array(
                    'EMP_ID' => $dataEMP['EMP_ID'],
                );
                $this->Model_online->update($wheredat,$data,"m_employee");
                //kirim email bahwa passwordnya adalah itu
                // BAGIAN EMAIL
                    //  ============================================================== set value untuk email
                        //pembuatan bagian isi email
                    $to = $email;
                    $subject = 'Reset Password - Password Baru'; 
                    $message = '<p>Reset Password Online Form</p>
                    <p>Password Baru Anda Adalah : <strong>'.$randomPass.'</strong> </p>
                    <p>Silahkan Masukkan Password Baru Anda Dihalaman login, Jangan Lupa Diganti Ya Nanti ;) </p>';
                    // aksi input update email
                    $this->Model_online->insEmail($to,$subject,$message);
                    //set flash data untuk alert
                    $this->session->set_flashdata("pass-send","Password Baru Telah Dikirim ke Email Anda");
                redirect(base_url("Login"));
            }
        }	

}

