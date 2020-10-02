<?php
// 基本Controller类
class Controller {
  public function redirect($url) {
    header("Location: $url");
  }
}