<?php

namespace App\Controllers;

class KeranjangController extends BaseController
{
    protected $cart;

    public function __construct()
    {
        helper(['form', 'number']);
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $data = [
            'items' => $this->cart->contents(),
            'total' => $this->cart->total(),
        ];
        return view('v_keranjang', $data);
    }

    public function add()
    {
        $this->cart->insert([
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $this->request->getPost('harga'),
            'name'    => $this->request->getPost('nama'),
            'options' => [
                'foto' => $this->request->getPost('foto')
            ]
        ]);
        return redirect()->to(base_url('keranjang'))->with('success', 'Produk berhasil ditambahkan.');
    }

    public function delete($rowid)
    {
        $this->cart->remove($rowid);
        return redirect()->to(base_url('keranjang'))->with('success', 'Item berhasil dihapus.');
    }

    public function clear()
    {
        $this->cart->destroy();
        return redirect()->to(base_url('keranjang'))->with('success', 'Keranjang dikosongkan.');
    }

    public function edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $item) {
            $rowid = $this->request->getPost('rowid' . $i);
            $qty   = $this->request->getPost('qty' . $i);
            $this->cart->update([
                'rowid' => $rowid,
                'qty'   => $qty,
            ]);
            $i++;
        }
        return redirect()->to(base_url('keranjang'))->with('success', 'Keranjang diperbarui.');
    }
}
