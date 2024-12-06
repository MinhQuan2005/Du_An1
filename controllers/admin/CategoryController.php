<?php
require_once "../client/models/categoryModel.php";

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function index() {
        $categories = $this->model->getAllCategories();
        require_once "views/categories/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->model->createCategory($name);
            header('Location: index.php');
        } else {
            require_once "views/categories/create.php";
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $this->model->updateCategory($id, $name);
            header('Location: index.php');
        } else {
            $category = $this->model->getCategoryById($id);
            require_once "views/categories/edit.php";
        }
    }

    public function delete($id) {
        $this->model->deleteCategory($id);
        header('Location: index.php');
    }
}
