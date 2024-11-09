<?php

// namespace App\Http\Controllers;

// use App\Http\Requests\ClientRequest;
// use App\Services\ClientService;
// use Illuminate\Http\JsonResponse;

// class ClientController extends Controller
// {
//     protected $clientService;

//     public function __construct(ClientService $clientService)
//     {
//         $this->clientService = $clientService;
//     }


//                 public function inscrire(ClientRequest $request): JsonResponse
//             {
//                 $data = [
//                     'surname' => $request->input('surname'),
//                     'role_id' => $request->input('role_id'),
//                     'user' => $request->only(['telephone', 'email', 'password', 'cni', 'date_naissance', 'nom', 'prenom']),
//                 ];

//                 // Vérification de la structure des données

//                 $result = $this->clientService->registerClient($data);

//                 return response()->json($result['data'], $result['status']);
//             }

// }




namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function inscrire(ClientRequest $request): JsonResponse
    {
        try {
            $client = $this->clientService->registerClient($request->validated());
            return response()->json([
                'message' => 'Client inscrit avec succès',
                'data' => $client
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Échec de l\'inscription du client',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
