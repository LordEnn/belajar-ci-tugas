<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Redirect implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Hanya redirect setelah login pertama kali
        $session = session();

        if ($session->get('isLoggedIn') && $session->get('firstLogin') === true) {
            // Reset flag agar tidak terus-terusan redirect
            $session->set('firstLogin', false);
            return redirect()->to('/produk');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // opsional
    }
}
