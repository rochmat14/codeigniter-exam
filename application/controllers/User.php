<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_user'); // Auto load model M_Index pada fungsi construct

		// auto load session
		// agar bisa mengakses data session ketika login dan session dibuat
		$this->load->library('session');
	}
// ================================================================================================================================
	
	public function index() //fungsi index yang dibaca secara default pada url
	{
		// memanggil library session
		$this->load->library('session');

		// jika session name tidak ada
		if (!$this->session->userdata('name')) {
			// redirect ke halaman login
			redirect('/login');
		}
		
		// menampilkan header
		$this->load->view('common/inside-home/header-inside-home');

		// menjalan view dari file /user/login
		$this->load->view('user/home');

		// menmapilkan footer
		$this->load->view('common/inside-home/footer-inside-home');
	}

// ================================================================================================================================

	public function insertRegister() // fungsi untuk registrasi 
	{
		$data = array(
			'email' => $this->input->post('email')  //set item dengan request
		);

		$cek_email = $this->Model_user->SendForgotPassword($data); //cek ketersediaan email

		
		if(empty($cek_email)){ //jika email belum digunakan kosong maka bisa registrasi

			$config['upload_path'] = "./assets/images"; //lokasi penyimpanan folder penyimpanan gambar yang di upload
			$config['allowed_types'] = 'gif|jpg|png'; //type file gambar yang dapat di upload
			$config['encrypt_name'] = TRUE; //untuk mengubah nama file menadi enkripsi

			$this->load->library('upload', $config); //memanggil library upload

			// jika berhasil upload file
			if ($this->upload->do_upload("profile_picture")) {

				$data = array('upload_data' => $this->upload->data()); //set item dengan request

				// set item email with request
				$email = array('email' => $this->input->post('email'));
				
				// array berisi set item dengan request
				$data = array(
					'email' => $this->input->post('email'),
					'name' => $this->input->post('name'),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), //password yang di enkripsi dengna password_has
					'profile_picture' => $data['upload_data']['file_name']
				);

				
				$result = $this->Model_user->InsertUser($email, $data); // mengirim variabel data yang berisi item pada funtion InsertUser pada User_model

				// echo $result;
				// jika hasil dari ekseskusi data pada fugsi Insert data 1
				// if($result == 1){
				// 	// echo json_decode($result);
					
					echo "success"; // maka mengeluarkan string succes
				// }else{
					
				// 	echo "error";// jika tidak maka string error
				// }
			}
			
		}else{  //jika email sudah digunakan kosong maka tidak bisa registrasi
			echo "email sudah digunakan";
		}
			
	}

// ================================================================================================================================
	
	public function Register()  //fungsi untuk menampilkan halaman registrasi
	{
		// menjalankan view header
		$this->load->view('common/out-home/header-out-home');

		// menjalankan view register
		$this->load->view('user/register');

		// menjalankan view footer
		$this->load->view('common/out-home/footer-out-home');
	}

// ================================================================================================================================

	public function login() //fungsi untuk menampilkan halaman login
	{
		// menampilkan header out
		$this->load->view('common/out-home/header-out-home');

		
		// menampilkan halan login
		$this->load->view('user/login');

		// menampilkan view footer
		$this->load->view('common/out-home/footer-out-home');
	}

// ================================================================================================================================
	
	public function home() //ffungsi untuk menampilkan halaman home yang terdapat informasi profile user yang login
	{
		$this->load->library('session'); //memanggil library session 

		if (!$this->session->userdata('name')) { //jika session name tidak ada
			redirect('/login'); //redirect ke halaman login
		}

		// menjalankan view header
		$this->load->view('common/inside-home/header-inside-home');


		// menjalankan view welcome
		$this->load->view('user/home');

		// menjalankan view footer
		$this->load->view('common/inside-home/footer-inside-home');
	}

// ================================================================================================================================

	public function checkLogin() // fungsi untuk login yang dikelola oleh ajax
	{
		// memanggil ibrari session
		$this->load->library('session');

		$email = $this->input->post('email'); //request email
		$password = $this->input->post('password'); //request password

		$cek = $this->Model_user->CheckLogin($email, $password); //mengirim data pada fungsi Model_user checkLogin
		
		if (!empty($cek)) { //jika mendapat timbal balik benar dari model

			foreach ($cek as $user) {  //memanggil item data dengan collection karena berupa objeck

				//looping data user
				$session_data = array(
					'id'   => $user->id,
					'email'  => $user->email,
					'name' => $user->name,
					'password' => $user->password,
					'profile_picture' => $user->profile_picture,
				);
				//buat session berdasarkan user yang login
				$this->session->set_userdata($session_data);
			}

			echo "success";  //menampilkan text success
		} else { //jika mendapat timbal balik gagal dari model

			echo "error"; //menampilkan text error
		}
	}

// ================================================================================================================================

	function sendForgotPassword() //fungsi proses mengirim email forgot password yang dikelola ajax
	{
		// memanggil ibrari session
		$this->load->library('session');

		$data = array(
			'email' => $this->input->post('email')  //set item dengan request
		);

		$user = $this->Model_user->SendForgotPassword($data); //mengirim data pada fungsi SendForgotPasswod Model_user
		
		foreach ($user as $item) { //memanggil item data dengan colldection karena berupa objeck
			// echo $item->name;

			if ($this->input->post('email') == $item->email) { //jika email yang di terdapat pada tabel database

				
				$session_forgot_password = array(
					'email_forgot'  => $item->email  //set item dengan request
				);
				
				$this->session->set_userdata($session_forgot_password); //mengimpan session berdasarkan user yang login
				
				$config = [
					'mailtype'  => 'html',
					'charset'   => 'utf-8',
					'protocol'  => 'smtp',
					'smtp_host' => 'smtp.gmail.com',
					'smtp_user' => 'alamat emai',  // Email gmail
					'smtp_pass'   => 'password email',  // Password gmail
					'smtp_crypto' => 'tls',
					'smtp_port'   => 587,
					'crlf'    => "\r\n",
					'newline' => "\r\n"
				];

				// Load library email dan konfigurasinya
				$this->load->library('email', $config);

				// Email dan nama pengirim
				$this->email->from('abdulrochmat874@gmail.com', 'Abdul Rochmat');

				// Email penerima
				$this->email->to($item->email); // Ganti dengan email tujuan

				// Lampiran email, isi dengan url/path file
				// $this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

				// Subject email
				$this->email->subject('Link Untuk Mengubah Password');

				$this->email->message("
					<h2>Silakan klik link dibawah ini</h2> <br> <p>Ini adalah link untuk mengarahkan pada halaman ubah password yang lupa</p> <br> Klik <strong><a href='http://localhost:8002/new-forgot-password' target='_blank' rel='noopener'>Link ubah Pasword yang lupa</a></strong>.
				");

				// Tampilkan pesan sukses atau error
				if ($this->email->send()) {
					echo "success";
				} else {
					echo 'Error! email tidak dapat dikirim.';
				}
			}else{ //jika data inputan tidak ada pada tabel database


				echo "error"; //menampilkan text error
			}
		}
	}

// ================================================================================================================================
	
	function forgotPassword() //fungsi untuk menampilkan halaman forgot password dengan input email
	{
		$this->load->view('common/out-home/header-out-home'); // view header out home
		$this->load->view('user/forgot-password'); // view forgot password
		$this->load->view('common/out-home/footer-out-home'); // view footer out home
	}

// ================================================================================================================================
	
	function logoutForgot() //fungsi untuk mengubah password yang link didaptkan dari email yang dikirim sekaligua menghapus session halaman ubah password forgot
	{
		$email = array(
			'email' => $this->input->post('email') //set item dengan request
		);

		$password = array(
			'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)  //set item dengan reuqest
		);

		$password = $this->Model_user->ForgotPassword($email, $password); //mengirim data pada fungsi ForgotPasswrod Model_user
		
		if($password == true){ //jika mendapatkan timbal balik benar dari model 
			echo "success"; //mencektak text success

			$this->session->sess_destroy(); //dan menghapus session email yang disimpan saat akan mengubah passwrod forgot
		
		}else{ //jika mendapat timbah balik error dari model

			echo "error";  //mencetak text error
		}

	}

// ================================================================================================================================

	function newPasswordForgot() //fungsi untuk menampikan halaman untuk mengubah password yang lupa
	{
		$this->load->library('session'); //memanggil library session

		if (!$this->session->userdata('email_forgot')) {  //jika tidak terdapat session email_forgot
			
			redirect('/login'); // redirect ke halaman login
		}

		$this->load->view('common/out-home/header-out-home');  // view header out home
		$this->load->view('user/new-password-forgot');	// menampilkan halaman forgot password new
		$this->load->view('common/out-home/footer-out-home');	// view footer out home
	}

// ================================================================================================================================

	function logout()  //fungsi untuk logout dari user yang login
	{

		$this->session->sess_destroy(); //menghapus session yang tersimpan
		
		redirect('login'); //riderect ke halaman login
	}

// ================================================================================================================================

	public function dataUser() //fungsi untuk mendapatkan data semua data user
	{
		// memanggil fungsi DataUser() pada model Model_user yang berisi menampilkan data pada tabel user
		$data = $this->Model_user->DataUser(); // Menampung value return dari fungsi getData ke variabel data
		
		echo json_encode($data); // Mengencode variabel data menjadi json format
	}

// ================================================================================================================================

	public function userView()  //fungsi untuk menampilkan  halaman data user
	{
		
		$this->load->library('session'); // memanggil library session

		
		if (!$this->session->userdata('name')) { // jika session name tidak ada
			
			redirect('/login'); // redirect ke halaman login
		}
		
		$this->load->library('session'); //memanggil library session

		$this->load->view('common/inside-home/header-inside-home'); // menampilkan header inside home user
		
		$this->load->view('user/user-view'); // menampilkan view pada file /user/tampil-user

		$this->load->view('common/inside-home/footer-inside-home'); // menampilkan footer user inside 
	}

// ================================================================================================================================
	
	public function dataUserById($id) //fungsi untuk mendapatkan data user berdasarkan id yang dikelola ajax
	{
		$id = array('id' => $id); //set id dengan request

		$user = $this->Model_user->DataUserById($id); // mengirim data pada fungsi DataUserById Model_user

		echo json_encode($user); //menerima data timbal balik dari model dan menampilkan pada bentuk json
	}

// ================================================================================================================================

	public function userEdit()  //fungsi untuk menampilkan halaman user yang login
	{
		$this->load->library('session'); // memanggil library session

		
		if (!$this->session->userdata('name')) { // jika session name tidak ada
			
			redirect('/login'); // redirect ke halaman login
		}
		
		
		$this->load->view('common/inside-home/header-inside-home'); // view header inside home
		
		
		$this->load->view('user/user-edit'); // view file user-edit

		
		$this->load->view('common/inside-home/footer-inside-home'); // view footer inside home
	}

// ================================================================================================================================

	public function editDataUser()  //fungsi untuk mengedit data user
	{
			$config['upload_path'] = "./assets/images"; //lokasi penyimpanan folder penyimpanan gambar yang di upload
			$config['allowed_types'] = 'gif|jpg|png'; //type file gambar yang dapat di upload
			$config['encrypt_name'] = TRUE; //mengubah nama file menjadi enkripsi
	
			$this->load->library('upload', $config); //memanggil library upload

			if ($this->upload->do_upload("profile_picture")) { //jika berhasi upload file
				
				$path = './assets/images/'.$this->input->post('name-picture'); //mengakses file gambar yang tersimpan saat registrasi
				
				unlink($path); //menghapus file yang ditemukan
				
				$data = array('upload_data' => $this->upload->data()); //set item dengan request
	
				$chek_password = $this->input->post('password'); //membungkus request password dengan variabel
	
				if(!($chek_password == "")) { //mengecek jika request input password barisi password baru

					$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT); //requset input password di enkripsi 
				
				}else{ //jika password baru tidak ada 

					$password = $this->input->post('password-value'); //mengambil input password value yang berisi enkripsi password yang lama
				}
				
				//array set item dengan request
				$data = array(
					'email' => $this->input->post('email'),
					'name' => $this->input->post('name'),
					'password' => $password,
					'profile_picture' => $data['upload_data']['file_name']
				);
	
				$id = array(
					'id' => $this->input->post('id') //set item dengan request
				);
	
				$result = $this->Model_user->EditDataUser($data, $id); //mengirim data pada fungsi EditDataUser Model_user
			
			}else{ //jika tidak ada file baru yang di uploat
				
				$chek_password = $this->input->post('password'); //membungkus request input dengan variabel
	
				if(!($chek_password == "")) { //mengecek jika request input password barisi password baru

					$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT); //requset input password di enkripsi 
				
				}else{ //jika password baru tidak ada 

					$password = $this->input->post('password-value'); //mengambil input password value yang berisi enkripsi password yang lamaa
				}
				
				// array set item dengan request
				$data = array(
					'email' => $this->input->post('email'),
					'name' => $this->input->post('name'),
					'password' => $password,
				);
	
				
				$id = array(
					'id' => $this->input->post('id') // array set item dengan request
				);
	
				$result = $this->Model_user->EditDataUser($data, $id); //mengirim data pada fungasi Model_user
			}

			if($result == 1){	//jika data model mendapat timbal balik angak 1
				echo "success"; //mencetak text success

			}else{ //jika tidak mendapatkan timbal balik beripa nilai 1
				echo "error"; //mencetak text error
			}
	}

// ================================================================================================================================

	public function deleteUser()  //funsi untuk menghapus data user dan foto profile
	{
		$path = './assets/images/'.$this->input->post('profile_picture'); //akses file pada folder penyimpanan
		
		unlink($path); //melakukan penghapusan file yang ditemukan
		
		$data = array(
			'id' => $this->input->post('id') //set item dengan request
		);

		$result = $this->Model_user->DeleteUser($data); //mengerim data pada fungsi Model_User
	
		if(empty($result)){ //jika data sudaj kosong

			echo "success"; //cetak text success

		}else{ //jika tidak kosong

			echo "error"; //cetak text error
		}
	}

// ================================================================================================================================

	public function userGuide()  //fungsi menampikan halaman user guide
	{
		
		$this->load->library('session'); // memanggil library session

		
		if (!$this->session->userdata('name')) { // jika session name tidak ada
			
			redirect('/login'); // redirect ke halaman login
		}
		
		
		$this->load->view('common/inside-home/header-inside-home'); // menampilkan halaman header
		
		
		$this->load->view('user/user-guide'); // menampilkan halam user guide

		
		$this->load->view('common/inside-home/footer-inside-home'); // menampilkan halaman footer
	}

// ================================================================================================================================

	public function about() //fungsi untuk menampilkan halaman about
	{
		
		$this->load->library('session'); // memanggil library session

		
		if (!$this->session->userdata('name')) { // jika session name tidak ada
			
			redirect('/login'); // redirect ke halaman login
		}
		
		
		$this->load->view('common/inside-home/header-inside-home'); // menampilkan halaman header

		$this->load->view('user/about');// menpilkan halaman about
		
		// menampilkan halaman footer
	}

	public function kirimEmail()
	{
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_user' => 'abdulrochmat874@gmail.com',  // Email gmail
			'smtp_pass'   => 'whjigeptpaoqxqfk',  // Password gmail
			'smtp_crypto' => 'tls',
			'smtp_port'   => 587,
			'crlf'    => "\r\n",
			'newline' => "\r\n"
		];

		// Load library email dan konfigurasinya
		$this->load->library('email', $config);

		// Email dan nama pengirim
		$this->email->from('abdulrochmat874@gmail.com', 'Rochmat');

		// Email penerima
		$this->email->to('abdulrochmat62@yahoo.com'); // Ganti dengan email tujuan

		// Lampiran email, isi dengan url/path file
		$this->email->attach('https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940');

		// Subject email
		$this->email->subject('Kirim Email dengan SMTP Gmail CodeIgniter | MasRud.com');

		// Set email format to HTML
		$this->email->isHTML(true);

		// Email body content
		$mailContent = "<p>Hallo <b>" . $this->input->post('nama') . "</b> berikut ini adalah komentar Anda:</p>
		<table>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td>" . $this->input->post('nama') . "</td>
			</tr>
			<tr>
				<td>Website</td>
				<td>:</td>
				<td>" . $this->input->post('website') . "</td>
			</tr>
			<tr>
				<td>Komentar</td>
				<td>:</td>
				<td>" . $this->input->post('komentar') . "</td>
			</tr>
		</table>
		<p>Terimakasih <b>" . $this->input->post('nama') . "</b> telah memberi komentar.</p>"; // isi email

		$this->mail->Body = $mailContent;

		// Isi email
		$this->email->msgHtml("
			<div style='text-align: center;'>
				<h1>Hallo <?php ?></h1>
			
				<h2>ini adalah password kamu yang baru</h2>
				<h2>jangan beritahukan kepada siapapun password ini</h2>
				
				<h1>Password : " . $this->load->view() . "</h1> 

				<h3>Silakan menuju halaman login dengan link tombol di bawah ini</h3>
				<h3>lalu login kembali dengan password yang tertera</h3>

				<a href='' style='text-decoration: none; background-color:orange; color:black; font-weight:700; padding: 5px; border-radius:5px;'>Login Kembali</a>
			</div>	
		");

		// Tampilkan pesan sukses atau error
		if ($this->email->send()) {
			echo 'Sukses! email berhasil dikirim.';
		} else {
			echo 'Error! email tidak dapat dikirim.';
		}
	}
}
