<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\RequestTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Firebase\JWT\JWT;


class AuthFilter implements FilterInterface{
   use RequestTrait;
    
    public function before(RequestInterface $request, $arguments = null){
       
        //$key        = Services::getSecretKey();
		//$authHeader = $request->getServer('HTTP_AUTHORIZATION');
		//$arr        = explode(' ', $authHeader);
		//$token      = $arr[1];

        $key        = Services::getSecretKey();
		$token = $request->getServer('HTTP_AUTHORIZATION');

		try
		{
			JWT::decode($token, $key, ['HS256']);
		}
		catch (\Exception $e)
		{
			return Services::response()
				->setJSON(['mensaje' => 'Token caducado']);
		}
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }


}
