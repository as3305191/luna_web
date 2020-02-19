<?php
class Images extends MY_Base_Controller {
	var $mime_map = array(
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'image/gif' => 'gif'
		);

	function __construct() {
		parent::__construct();
		$this -> load -> model('Images_dao', 'dao');
	}


	public function index() {
		echo "index";
		$i = new Imagick(realpath("./img/mybg.png"));
	}


	//upload
	public function upload_android_test() {
		//android
		$res['success'] = TRUE;
		$info = '';

		$image_name = $this -> get_post('image_name');
		$mime = $this -> get_post('mime');
		$image_base64 = $this -> get_post('image');

		if (!($mime == 'image/jpeg'|| $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif')) {
			$info = "非支援上傳格式(jpeg/jpg/png/gif)";
			$success = FALSE;
		}

		// open up the file and extract the data/content from it
		$i_data['image_name'] = $image_name;
		$i_data['mime'] = $mime;
		$i_data['image_path'] = "";
		$last_id = $this -> dao -> insert_image_data($i_data);

		$ext = $this -> get_ext($mime);
		$img_name = $last_id . '.' . $ext;

		// save file
		$m_dir =  "./img/upload/";
		if(!file_exists($m_dir)) {
			mkdir($m_dir);
		}
		// $img_path = $m_dir. $img_name;
		// file_put_contents($img_name,base64_decode($image_base64));
		$img_content = base64_decode($image_base64);
		//
		// $res['img_path'] = $img_path;
		// update image info
		$this -> dao -> update(array(
			'img' => $img_content
		), $last_id);

		$binary = base64_decode(explode(",", $image_base64)[1]);
		$data = getimagesizefromstring($binary);
		$res['range'] = $data;

		// resize
		$img_content = $this -> resizeBlob($img_content, 300, 300);
		//
		// $res['image_id'] = $last_id;
		//
		// $img_content = file_get_contents($img_path);
		$this -> dao -> update(array(
			'img_thumb' => $img_content
		), $last_id);

		$res['last_id'] = $last_id;
		$this -> to_json($res);
	}


	public function upload_base64($image_path) {
		$res = array('success' => TRUE);
		$info = '';

		// $image_name = $this -> get_post('image_name');
		$image_base64 = $this -> get_post('image_base64');
		$mime = "image/png";

		// open up the file and extract the data/content from it
		// $i_data['image_name'] = $image_name;
		$i_data['mime'] = $mime;
		$i_data['image_path'] = $image_path;
		$last_id = $this -> dao -> insert($i_data);

		$this -> dao -> update(array(
			'img' => base64_decode(explode(",", $image_base64)[1]),
			'image_name' => $last_id . ".png"
		), $last_id);

		$res['image_id'] = $last_id;
		$this -> to_json($res);
	}

	public function do_sms() {
		echo "sms123";
		$m_acc = "0970632144";
		$m_pwd = "aaa123";
		$mobile = "0925815921";
		$msg = "test";

		$n_res = $this -> curl -> simple_get("http://smexpress.mitake.com.tw/SmSendGet.asp"
				. "?username=$m_acc&password=$m_pwd&dstaddr=$mobile&DestName=SteveYeh&dlvtime=&vldtime=&smbody=$msg");

				$txt = iconv("big5","UTF-8", $n_res);
				echo $txt;
	}

	public function test() {

		$msg = "您好，歡迎使用本系統";
		$email = "test@gmail.com";
		$config = array(
		        'crlf'          => "\r\n",
		        'newline'       => "\r\n",
		        'charset'       => 'utf-8',
		        'protocol'      => 'smtp',
		        'mailtype'      => 'html',
		        'smtp_host'     => 'localhost',
		        'smtp_port'     => '25',
		        'smtp_user'     => 'root',
		        'smtp_pass'     => 'qweq9999'
		);

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('service@king88.tw');
		$this->email->to($email);

		$this->email->subject('歡迎使用本系統');
		$this->email->message($msg);

		if($this->email->send()){
		    $res = "ok";
		}else{
		    $res = "faild";
		}

		echo $res;
	}

	public function get($id, $is_thumb = '') {
		$data = array();
		if (!empty($id)) {
			$obj = $this -> dao -> find_by_id($id);
			if(!empty($obj)) {
				$img = (empty($is_thumb) ? $obj -> img : $obj -> img_thumb);
				// $download_file_name = IMG_DIR . $img_path;
				// header("Content-Disposition: attachment; filename=" . $obj -> image_name);
				header("Content-type: " . $obj -> mine);
				header("Content-Length: " . strlen($img));

				ob_clean();
				flush();
				echo $img;
				exit ;
			}
		}
		show_404();
	}

	function get_ext($mime) {
		if(array_key_exists($mime, $this -> mime_map)) {
			$val = $this -> mime_map[$mime];
			return $val;
		}
		return 'jpg';
	}


	//upload
	public function upload_android() {
		//android
		$res['success'] = TRUE;
		$info = '';

		$image_name = $this -> get_post('image_name');
		$mime = $this -> get_post('mime');
		$image_base64 = $this -> get_post('image');

		if (!($mime == 'image/jpeg'|| $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif')) {
			$info = "非支援上傳格式(jpeg/jpg/png/gif)";
			$success = FALSE;
		}

		// open up the file and extract the data/content from it
		$i_data['image_name'] = $image_name;
		$i_data['mime'] = $mime;
		$i_data['image_path'] = "";
		$last_id = $this -> dao -> insert_image_data($i_data);

		$ext = $this -> get_ext($mime);
		$img_name = $last_id . '.' . $ext;

		// save file
		$m_dir =  "./img/upload/";
		if(!file_exists($m_dir)) {
			mkdir($m_dir);
		}
		// $img_path = $m_dir. $img_name;
		// file_put_contents($img_name,base64_decode($image_base64));
		$img_content = base64_decode($image_base64);
		//
		// $res['img_path'] = $img_path;
		// update image info
		$this -> dao -> update(array(
			'img' => $img_content
		), $last_id);

		// resize
		// $img_content = $this -> resizeBlob($img_content, 300, 300);

		$res['image_id'] = $last_id;

		$img_content = file_get_contents($img_path);
		$this -> dao -> update(array(
			'img_thumb' => $img_content
		), $last_id);

		$res['last_id'] = $last_id;
		$this -> to_json($res);
	}

	public function upload_ios() {
		$res = array('success' => TRUE);
		$info = '';

		$name = $_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
		$type = $_FILES['file']['type'];
		$size = $_FILES['file']['size'];

		if (!($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif' || $type =='image/jpg')) {
			$res['error_msg'] = "非支援上傳格式(jpeg/jpg/png/gif)";
		}

		// open up the file and extract the data/content from it
		$i_data['image_name'] = $name;
		$i_data['mime'] = $type;
		$i_data['image_path'] = "";
		$i_data['image_size'] = $size;

		$img_content = file_get_contents($tmp_name);

		$image_info = getimagesize($tmp_name);
		$image_width = $image_info[0];
		$image_height = $image_info[1];
		$i_data['width'] = $image_width;
		$i_data['height'] = $image_height;
		$i_data['img'] = $img_content;
		$last_id = $this -> dao -> insert_image_data($i_data);
		if (!empty($last_id)) {
			$res['last_id'] = $last_id;
			// resize
			// $this -> resize($tmp_name, 300, 300);

			$img_content = file_get_contents($tmp_name);
			$this -> dao -> update(array(
				'img_thumb' => $img_content
			), $last_id);
		}
		$this -> to_json($res);
	}

	public function resize($img_path, $width = 400, $height = 400) {
		// load an image
		$i = new Imagick(realpath($img_path));
		// get the current image dimensions
		$geo = $i->getImageGeometry();

		// crop the image
		if(($geo['width']/$width) < ($geo['height']/$height))
		{
		    $i->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
		}
		else
		{
		    $i->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
		}


    $i->thumbnailImage($width, $height, true);
		$i->writeImage(realpath($img_path));
	}

	public function resizeBlob($image, $width = 400, $height = 400) {
		// load an image
		$i = new Imagick();
		$i -> readImageBlob($image);

		// get the current image dimensions
		$geo = $i->getImageGeometry();

		// crop the image
		if(($geo['width']/$width) < ($geo['height']/$height))
		{
		    $i->cropImage($geo['width'], floor($height*$geo['width']/$width), 0, (($geo['height']-($height*$geo['width']/$width))/2));
		}
		else
		{
		    $i->cropImage(ceil($width*$geo['height']/$height), $geo['height'], (($geo['width']-($width*$geo['height']/$height))/2), 0);
		}


    $i->thumbnailImage($width, $height, true);
		return $i->getImagesBlob();
		// $i->writeImage(realpath($img_path));
	}
}
?>
