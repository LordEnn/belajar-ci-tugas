<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategori; 
    protected $validation;

    function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $kategori = $this->kategori->findAll();
        $data['kategori'] = $kategori;

        return view('v_kategori', $data);
    }

    public function create()
    {
        $dataForm = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'is_active' => 1,
            'created_at' => date("Y-m-d H:i:s")
        ];

        $this->kategori->insert($dataForm);

        return redirect('kategori')->with('success', 'Data Berhasil Ditambah');
    } 

    public function edit($id)
    {
        $dataForm = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->kategori->update($id, $dataForm);

        return redirect('kategori')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $this->kategori->delete($id);

        return redirect('kategori')->with('success', 'Data Berhasil Dihapus');
    }
}