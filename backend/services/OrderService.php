
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';

class OrderService extends BaseService {
    public function __construct() {
        $dao = new OrderDao();
        parent::__construct($dao);
    }

    public function add($order) {
        return $this->dao->add($order);
    }

    public function update($order, $id) {
        return $this->dao->update($order, $id);
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
