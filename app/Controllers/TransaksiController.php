<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use GuzzleHttp\Client;

class TransaksiController extends BaseController
{
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper(['number', 'form']);
        $this->client = new Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['items'] = $cart;
        $data['total'] = $total;
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $cart = session()->get('cart') ?? [];

        $id = $this->request->getPost('id');
        $item = [
            'id'    => $id,
            'qty'   => 1,
            'price' => $this->request->getPost('harga'),
            'name'  => $this->request->getPost('nama'),
            'foto'  => $this->request->getPost('foto'),
        ];

        // Cek apakah produk sudah ada di cart
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = $item;
        }

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url('keranjang') . '">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        session()->remove('cart');
        session()->setFlashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $cart = session()->get('cart') ?? [];
        $i = 1;
        foreach ($cart as $id => $item) {
            $qty = $this->request->getPost('qty' . $i++);
            if ($qty > 0) {
                $cart[$id]['qty'] = $qty;
            } else {
                unset($cart[$id]);
            }
        }

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($id)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$id]);

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Produk berhasil dihapus dari keranjang');
        return redirect()->to(base_url('keranjang'));
    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['items'] = $cart;
        $data['total'] = $total;

        return view('v_checkout', $data);
    }

    public function getLocation()
    {
        $search = $this->request->getGet('search');

        $response = $this->client->request('GET', 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50', [
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    {
        $destination = $this->request->getGet('destination');

        $response = $this->client->request('POST', 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'multipart' => [
                ['name' => 'origin', 'contents' => '64999'],
                ['name' => 'destination', 'contents' => $destination],
                ['name' => 'weight', 'contents' => '1000'],
                ['name' => 'courier', 'contents' => 'jne']
            ],
            'headers' => [
                'accept' => 'application/json',
                'key' => $this->apiKey,
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function buy()
    {
        if ($this->request->getPost()) {
            $diskon = session()->get('diskon') ?? 0;
            $cart = session()->get('cart') ?? [];

            $totalCart = 0;
            foreach ($cart as $item) {
                $totalCart += $item['price'] * $item['qty'];
            }

            $dataForm = [
                'username'     => $this->request->getPost('username'),
                'total_harga'  => $this->request->getPost('total_harga'),
                'alamat'       => $this->request->getPost('alamat'),
                'ongkir'       => $this->request->getPost('ongkir'),
                'diskon'       => $diskon,
                'status'       => 0,
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s")
            ];

            $this->transaction->insert($dataForm);
            $last_insert_id = $this->transaction->getInsertID();

            foreach ($cart as $value) {
                $itemSubtotal = $value['qty'] * $value['price'];
                $itemDiskon = ($itemSubtotal / $totalCart) * $diskon;

                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id'     => $value['id'],
                    'jumlah'         => $value['qty'],
                    'diskon'         => round($itemDiskon),
                    'subtotal_harga' => $itemSubtotal - round($itemDiskon),
                    'created_at'     => date("Y-m-d H:i:s"),
                    'updated_at'     => date("Y-m-d H:i:s")
                ];

                $this->transaction_detail->insert($dataFormDetail);
            }

            session()->remove('cart');
            return redirect()->to(base_url())->with('success', 'Transaksi berhasil!');
        }
    }
}
