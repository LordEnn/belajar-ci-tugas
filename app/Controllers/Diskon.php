<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class Diskon extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
        helper(['form']);
    }

    public function index()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $data['diskon'] = $this->diskonModel->findAll();
        return view('v_diskon', $data); // Hanya untuk tabel
    }

    public function create()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        return view('v_diskon', ['mode' => 'tambah']);
    }

    public function store()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'tanggal' => 'required|is_unique[diskon.tanggal]',
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->diskonModel->save([
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $data = [
            'mode' => 'edit',
            'diskon' => $this->diskonModel->find($id)
        ];
        return view('v_diskon', $data);
    }

    public function update($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $rules = [
            'nominal' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getPost('nominal'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/diskon')->with('success', 'Diskon berhasil diupdate.');
    }

    public function delete($id)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/');
        }

        $this->diskonModel->delete($id);
        return redirect()->to('/diskon')->with('success', 'Diskon berhasil dihapus.');
    }
}
