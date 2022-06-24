<?php 
date_default_timezone_set("Asia/Jakarta");
class Model_online extends CI_Model{	

  //start login

  public function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
  }
  public function getDataLogin($table,$where){		
    $data = $this->db->get_where($table,$where);
    $hasilData = $data->row_array();
    return $hasilData;
  }
  //cari login umum
  function cariDataRow($select,$from,$where)
	{
		$this->db->select($select);
    $this->db->from($from);
    $this->db->where($where);
    $row = $this->db->get()->row_array();
    return $row;
  }
  public function hitungJumlahItem($RB_ID)
  {
    $this->db->select('*');
    $this->db->from('tr_detail_reimburse'); 
    $this->db->where('RB_ID',$RB_ID);
    $hitung = $this->db->count_all_results();
    return $hitung;
  }
  public function maxRowWhere($table,$where,$para){
    $this->db->select_max($para);
    $this->db->from($table);
    $this->db->where($where);
    return $this->db->get()->result_array();
  }
  public function someRowWhere($select,$where,$table){
    $this->db->select($select);
    $this->db->from($table); 
    $this->db->where($where);
    return $this->db->get()->result_array();
  }
  public function countRowWhere($table,$where){
    $this->db->select('*');
    $this->db->from($table); 
    $this->db->where($where);
    $hitung = $this->db->count_all_results();
    return $hitung;
  }
  
  public function cekPengajuan($RB_ID)
  {
    $this->db->select('*');
    $this->db->from('tr_reimburse'); 
    $this->db->where('RB_ID',$RB_ID);
    $this->db->where('RB_SUBMIT_DATE !=',null);
    $cek = $this->db->count_all_results();
    return $cek;
  }
  public function findLeader($where)
  {
    $this->db->select('me.EMP_FULL_NAME');
    $this->db->from('tr_approval ta');
    $this->db->join('m_employee me', 'me.EMP_ID = ta.EMP_ID'); 
    $this->db->where($where);
    $name = $this->db->get()->row_array();
    $name = isset($name['EMP_FULL_NAME']) ? $name['EMP_FULL_NAME'] : '-';
    return $name;
  }
  public function findLeaderKB($where)
  {
    $this->db->select('me.EMP_FULL_NAME');
    $this->db->from('tr_kb_approval tak');
    $this->db->join('m_employee me', 'me.EMP_ID = tak.EMP_ID'); 
    $this->db->where($where);
    $name = $this->db->get()->row_array();
    $name = isset($name['EMP_FULL_NAME']) ? $name['EMP_FULL_NAME'] : '-';
    return $name;
  }
  public function findApproval($where)
  {
    $this->db->select('*');
    $this->db->from('tr_approval ta');
    $this->db->join('m_employee me', 'me.EMP_ID = ta.EMP_ID'); 
    $this->db->where($where);
    return $this->db->get()->result_array();
  }
  public function findApprovalKB($where)
  {
    $this->db->select('*');
    $this->db->from('tr_kb_approval tak');
    $this->db->join('m_employee me', 'me.EMP_ID = tak.EMP_ID'); 
    $this->db->where($where);
    return $this->db->get()->result_array();
  }
  public function findAllDataWhere($where,$table)
  {
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where($where);
    return $this->db->get()->result_array();
  }
  public function findAllDataWhereObj($where,$table)
  {
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where($where);
    return $this->db->get()->result();
  }
  public function findSingleDataWhere($where,$table)
  {
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where($where);
    return $this->db->get()->row_array();
  }
  public function singleNama($select,$from,$where)
  {
    $this->db->select($select);
    $this->db->from($from);
    $this->db->join('m_employee me','tr.EMP_ID = me.EMP_ID'); 
    $this->db->where($where);
    return $this->db->get()->row_array();
  }
  public function dataApproval($select,$where,$table,$groupby)
  {
    $this->db->select($select);
    $this->db->from($table);
    $this->db->join('tr_reimburse tr', 'tr.RB_ID = ta.RB_ID');
    $this->db->join('m_employee me', 'tr.EMP_ID = me.EMP_ID');
    $this->db->join('m_department md', 'me.DEPART_ID = md.DEPART_ID ');
    $this->db->where($where);
    $this->db->group_by($groupby);
    return $this->db->get()->result_array();
  }

  public function dataApprovalRP($select,$where,$table,$groupby)
  {
    $this->db->select($select);
    $this->db->from($table);
    $this->db->join('tr_app_repair tar', 'tr.RP_ID = tar.RP_ID');
    $this->db->join('m_employee me', 'tr.EMP_ID = me.EMP_ID');
    $this->db->join('m_department md', 'me.DEPART_ID = md.DEPART_ID ');
    $this->db->join('m_branch mb', 'md.BRANCH_ID = mb.BRANCH_ID ');
    $this->db->where($where);
    $this->db->group_by($groupby);
    return $this->db->get()->result_array();
  }

  public function dataApprovalKB($select,$where,$table,$groupby)
  {
    $this->db->select($select);
    $this->db->from($table);
    $this->db->join('tr_kasbon tr', 'tr.KB_ID = tak.KB_ID');
    $this->db->join('m_employee me', 'tr.EMP_ID = me.EMP_ID');
    $this->db->join('m_department md', 'me.DEPART_ID = md.DEPART_ID ');
    $this->db->where($where);
    $this->db->group_by($groupby);
    return $this->db->get()->result_array();
  }
  
  public function tampilData($table,$query,$id){
    //$hasil= $this->db->get_where($table,$query);
    $this->db->select('*');
    $this->db->from($table);
    $this->db->where($query);
    $this->db->order_by($id,'DESC');
    $hasil = $this->db->get();
    return $hasil->result();
  }

  //generate kode tr_reimburse
  public function kode($textId,$totalField,$tabelnya,$kolomnya)
  {    
      $query = $this->db->query("SELECT MAX(".$kolomnya.") AS TERAKHIR FROM ".$tabelnya." WHERE " . $kolomnya . " LIKE '%" . $textId . "%' ");
      $kode = $query->row()->TERAKHIR;
      $count_textId   = strlen($textId);
      $frontId        = $count_textId;
      $backId         = (int) $totalField - $count_textId;
      $nextId         = 0;
      if ($kode) {
          //$idmax         = $process[0]['id'];
          $nextId        = (int) substr($kode, $frontId, $backId);
          $nextId++;
          $myId       = $textId . sprintf("%0" . $backId . "s", $nextId);
      } else {
          $nextId++;
          $myId       = $textId . sprintf("%0" . $backId . "s", $nextId);
      }
      return $myId;
  }
  // function untuk menginsert data
  function input($data,$table){
		$this->db->insert($table,$data);
  }
  function deleteData($tables,$kolom,$id){
    $this->db->where($kolom, $id);
    $this->db->delete($tables);
  }	
  function update($where,$data,$table){
    $this->db->where($where);
    $this->db->update($table,$data);
  }
  function direksi($where){
    $this->db->select('*');
    $this->db->from('tr_supervision ts');
    $this->db->join('m_employee me', 'ts.EMP_ID_LEADER = me.EMP_ID');
    $this->db->where($where);
    $cek = $this->db->count_all_results();
    return $cek;
  }
  function direksiNew($where){
    $this->db->select('*');
    $this->db->from('m_employee me');
    $this->db->where($where);
    $cek = $this->db->count_all_results();
    return $cek;
  }
  function direksiNewFA($where){
    $this->db->select('*');
    $this->db->from('m_employee me');
    $this->db->where($where);
    $cek = $this->db->count_all_results();
    return $cek;
  }
  //coba email
  public function insEmail($to,$subject,$message){
    $config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'mail.mapangroup.com',
        'smtp_user' => 'onlineform@mapangroup.com',  // Email gmail
        'smtp_pass'   => 'mapangroup58',  // Password gmail
        'smtp_crypto' => 'ssl',//ssl atau tls
        'smtp_port'   => 465,//port 465/587
        'crlf'    => "\r\n",
        'newline' => "\r\n"
    ];
    $this->load->library('email');
    $this->email->initialize($config);
    // Email dan nama pengirim
    $this->email->from('onlineform@mapangroup.com', 'Online Form');
    // Email penerima
    $this->email->to($to); // Ganti dengan email tujuan, atasan atau fa
    $this->email->subject($subject); // Tergantung Apakah Approval atau hanya tembusan
    $this->email->bcc('onlineform@mapangroup.com'); //bcc ke diri sendiri karena di sent-mail tidak ada
    // Isi email
    $this->email->message($message); // isi email seperti di note
    $this->email->send();
  }
}

?>