<?php

/**
 * 文件上传类
 */
class UploadController extends Controller {
  /**
   * 头像上传方法
   * @access public
   */
  public function avatar() {
    $tokenInfo = $this->verifyToken();

    // $this->response(['data' => ['imgURL' => '']]);

    $allowedExts = ["jpeg", "jpg", "png"];
    $allowedType = ["image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"];
    $temp = explode(".", $_FILES['file']['name']);
    $extension = strtolower(end($temp));    // 获取后缀
    // 对 utf-8 进行转码，以保证兼容性
    $fileName = iconv('UTF-8', 'GBK', "{$tokenInfo['sub']}.$extension");

    if (
      in_array($_FILES['file']['type'], $allowedType)
      && in_array($extension, $allowedExts)
      && $_FILES['file']['size'] / 1024 / 1024 <= 2
      ) {
      if ($_FILES['file']['error'] > 0) {
        $this->response(['data' => ['imageUrl' => ""]], 400, "错误：{$_FILES['file']['error']}");
      } elseif (move_uploaded_file($_FILES['file']['tmp_name'], TEMP . $fileName)) {
        $res['data']['imageURL'] = "http://localhost/todo/application/user/temp/{$tokenInfo['sub']}.$extension";
        $res['data']['temp_path'] = "/todo/application/user/temp/{$tokenInfo['sub']}.$extension";
        $this->response($res);
      }
    } else {
      $this->response(['data' => ['imageURL' => ""]], 400, "非法的文件格式");
    }
  }
}