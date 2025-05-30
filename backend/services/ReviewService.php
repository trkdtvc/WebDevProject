
<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService {
    public function __construct() {
        $dao = new ReviewDao();
        parent::__construct($dao);
    }

    public function add($review) {
        return $this->dao->add($review);
    }

    public function update($review, $id) {
        return $this->dao->update($review, $id);
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
