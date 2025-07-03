<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class ProdukKategoriController extends BaseController
{
    protected $product_category; 

    function __construct()
    {
        $this->product_category = new ProductCategoryModel();
    }

    public function index()
    {
        $product_category = $this->product_category->findAll();
        $data['product_category'] = $product_category;

        return view('v_produkkategori', $data);
    }

    public function create()
{
    $dataForm = [
        'nama' => $this->request->getPost('nama'),
        'created_at' => date("Y-m-d H:i:s")
    ];

    $this->product_category->insert($dataForm);

    return redirect('produkkategori')->with('success', 'Data Berhasil Ditambah');
} 
public function edit($id)
{
    $dataProdukKategori = $this->product_category->find($id);

    $dataForm = [
        'nama' => $this->request->getPost('nama'),
        'updated_at' => date("Y-m-d H:i:s")
    ];

    $this->product_category->update($id, $dataForm);

    return redirect('produkkategori')->with('success', 'Data Berhasil Diubah');
}

public function delete($id)
{
    $dataProdukKategori = $this->product_category->find($id);

    $this->product_category->delete($id);

    return redirect('produkkategori')->with('success', 'Data Berhasil Dihapus');
}
}