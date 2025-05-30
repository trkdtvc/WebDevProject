
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService {
    public function __construct() {
        $dao = new CategoryDao();
        parent::__construct($dao);
    }

    public function add($category) {
        return $this->dao->add($category);
    }

    public function update($category, $id) {
        return $this->dao->update($category, $id);
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
