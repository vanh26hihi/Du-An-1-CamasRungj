<?php
class QuanLyTourController
{
    public function index()
    {
        // TODO: Implement tour list view
        // For now, redirect to home
        header("Location: " . BASE_URL_ADMIN);
        exit();
    }

    public function addForm()
    {
        // TODO: Implement add tour form
        header("Location: " . BASE_URL_ADMIN);
        exit();
    }

    public function add()
    {
        // TODO: Implement add tour logic
        header("Location: ?act=danh-sach-tour");
        exit();
    }

    public function editForm()
    {
        // TODO: Implement edit tour form
        header("Location: " . BASE_URL_ADMIN);
        exit();
    }

    public function update()
    {
        // TODO: Implement update tour logic
        header("Location: ?act=danh-sach-tour");
        exit();
    }

    public function delete()
    {
        // TODO: Implement delete tour logic
        header("Location: ?act=danh-sach-tour");
        exit();
    }
}
