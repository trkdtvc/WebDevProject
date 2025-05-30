
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookDao.php';

class BookService extends BaseService {
    public function __construct() {
        $dao = new BookDao();
        parent::__construct($dao);
    }

    public function add($book) {
        return $this->dao->add($book);
    }

    public function update($book, $id) {
        return $this->dao->update($book, $id);
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
