<?php

/**
 * list 控制器
 */
class ListController extends Controller {
  /**
   * 添加清单
   */
  public function addList() {
    $tokenInfo = $this->verifyToken();

    $list = file_get_contents('php://input');
    $list = json_decode($list, true);
    $list['pid'] = $tokenInfo['sub'];
    $list['lid'] = 'l' . time() . rand(1111, 9999);

    $listModel = new ListModel('list');
    $res['data']['msg'] = $listModel->addList($list);
    $this->response($res, 201);
  }

  /**
   * 重命名清单
   */
  public function rename() {
    $tokenInfo = $this->verifyToken();

    $list = file_get_contents('php://input');
    $list = json_decode($list, true);
    $info['set']['name'] = $list['listName'];
    $info['where']['lid'] = $list['lid'];
    $info['where']['pid'] = $tokenInfo['sub'];

    $listModel = new ListModel('list');
    $res['data']['msg'] = $listModel->rename($info);

    $this->response($res);
  }

  /**
   * 删除清单
   */
  public function remove() {
    $tokenInfo = $this->verifyToken();

    $info = file_get_contents('php://input');
    $info = json_decode($info, true);
    $partInfo['lid'] = $info['lid'];
    $partInfo['pid'] = $tokenInfo['sub'];

    $listModel = new ListModel('list');
    $res['data']['msg'] = $listModel->remove($partInfo);

    $this->response($res, 204);
  }
}