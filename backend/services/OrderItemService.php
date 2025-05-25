
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderItemService extends BaseService {
    public function __construct() {
        $dao = new OrderItemDao();
        parent::__construct($dao);
    }

    public function add($item) {
        return $this->dao->add($item);
    }

    public function update($item, $id) {
        return $this->dao->update($item, $id);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }

    public function get_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    public function get_all() {
        return $this->dao->get_all();
    }
}
