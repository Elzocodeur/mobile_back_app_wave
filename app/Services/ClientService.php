<?php



// namespace App\Services;

// use App\Repositories\UserRepository;
// use App\Repositories\ClientRepository;
// use App\Repositories\RoleRepository;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Str;
// use BaconQrCode\Renderer\Image\Png;
// use BaconQrCode\Renderer\RendererStyle\RendererStyle;
// use BaconQrCode\Writer;
// use Exception;

// use BaconQrCode\Renderer\ImageRenderer;

// use BaconQrCode\Renderer\Image\PngImageBackEnd;
// class ClientService
// {
//     protected $userRepository;
//     protected $clientRepository;
//     protected $roleRepository;

//     public function __construct(
//         UserRepository $userRepository,
//         ClientRepository $clientRepository,
//         RoleRepository $roleRepository
//     ) {
//         $this->userRepository = $userRepository;
//         $this->clientRepository = $clientRepository;
//         $this->roleRepository = $roleRepository;
//     }

//     public function registerClient(array $data): array
//     {

//         if (!isset($data['user'])) {
//             return [
//                 'status' => 400,
//                 'data' => ['message' => 'Erreur lors de l\'enregistrement du client', 'error' => 'Clé "user" manquante dans les données'],
//             ];
//         }

//         DB::beginTransaction();

//         try {
//             // Création de l'utilisateur
//             $user = $this->userRepository->createUser($data['user']);


//             // Création ou récupération du rôle
//             $role = $this->roleRepository->getOrCreateRole($data['role_id']);

//             // Création du client avec l'ID utilisateur et rôle
//             $client = $this->clientRepository->createClient([
//                 'user_id' => $user->id,
//                 'role_id' => $role->id,
//                 'surname' => $data['surname'],
//             ]);

//             // Génération du QR code
//             $qrCodePath = $this->generateQrCode($user);

//             // Envoi de l'email d'inscription avec le QR code
//             $this->sendRegistrationEmail($user, $qrCodePath);

//             DB::commit();

//             return ['status' => 201, 'data' => ['message' => 'Client enregistré avec succès']];
//         } catch (Exception $e) {
//             DB::rollBack();

//             return ['status' => 500, 'data' => ['message' => 'Erreur lors de l\'enregistrement du client', 'error' => $e->getMessage()]];
//         }
//     }

//     protected function generateQrCode($user)
//     {
//         $qrCodeDir = storage_path('app/qrcodes');
//         if (!file_exists($qrCodeDir)) {
//             mkdir($qrCodeDir, 0777, true);
//         }

//         $renderer = new ImageRenderer(
//             new RendererStyle(400),
//             new PngImageBackEnd()
//         );
//         $writer = new Writer($renderer);

//         $qrCodeData = json_encode([
//             'telephone' => $user->telephone,
//             'nom' => $user->nom,
//             'prenom' => $user->prenom,
//         ]);

//         $qrCodePath = 'qrcodes/' . Str::random(8) . '.png';
//         $writer->writeFile($qrCodeData, storage_path('app/' . $qrCodePath));

//         return $qrCodePath;
//     }

//     protected function sendRegistrationEmail($user, $qrCodePath)
//     {
//         $mailData = [
//             'email' => $user->email,
//             'qr_code' => storage_path('app/' . $qrCodePath),
//             'lien_auth' => route('login'),
//         ];

//         // Utilisation d'une job d'envoi d'email pour la gestion asynchrone
//         \App\Jobs\SendMailJob::dispatch($mailData);
//     }
// }



namespace App\Services;

use App\Repositories\ClientRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use App\Jobs\SendMailJob;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    // public function registerClient(array $data)
    // {
    //     // Générer et hasher le mot de passe
    //     $data['user']['password'] = Hash::make($data['user']['password']);

    //     // Génération du QR code pour le client
    //     $data['user']['qr_code'] = $this->generateQrCode($data['user']);

    //     // Création de l'utilisateur dans la base de données
    //     $user = $this->clientRepository->createUser($data['user']);

    //     // Création du rôle si inexistant
    //     $role = $this->clientRepository->findOrCreateRole($data['role_id']);

    //     // Création de l'enregistrement client avec user_id et role_id
    //     $this->clientRepository->createClient([
    //         'user_id' => $user->id,
    //         'role_id' => $role->id,
    //         'surname' => $data['surname']
    //     ]);

    //     // Envoi de l'email d'inscription
    //     $this->sendRegistrationEmail($user);

    //     return $user;
    // }


    public function registerClient(array $data)
{
    // Générer et hasher le mot de passe
    $data['user']['password'] = Hash::make($data['user']['password']);

    // Génération du QR code pour le client
    $data['user']['qr_code'] = $this->generateQrCode($data['user']);

    // Création de l'utilisateur dans la base de données
    $user = $this->clientRepository->createUser($data['user']);

    // Création du rôle si inexistant
    $role = $this->clientRepository->findOrCreateRole($data['role_id']);

    // Création de l'enregistrement client avec user_id, role_id, et surname
    $this->clientRepository->createClient([
        'user_id' => $user->id,
        'role_id' => $role->id,
        'surname' => $data['surname'] ?? null  // Assurez-vous que 'surname' est fourni ou définissez une valeur par défaut
    ]);

    // Envoi de l'email d'inscription
    $this->sendRegistrationEmail($user);

    return $user;
}


    protected function generateQrCode($userData)
    {
        $qrCodeDir = storage_path('app/qrcodes');
        if (!file_exists($qrCodeDir)) {
            mkdir($qrCodeDir, 0777, true);
        }

        $renderer = new ImageRenderer(new RendererStyle(400), new SvgImageBackEnd());
        $writer = new Writer($renderer);

        $qrCodeData = json_encode([
            'telephone' => $userData['telephone'],
            'prenom' => $userData['prenom'],
            'nom' => $userData['nom']
        ]);

        $qrCodePath = 'qrcodes/' . Str::random(10) . '.png';
        $writer->writeFile($qrCodeData, storage_path('app/' . $qrCodePath));

        return $qrCodePath;
    }

    protected function sendRegistrationEmail($user)
    {
        $mailData = [
            'email' => $user->email,
            'login' => $user->email,
            'qr_code' => storage_path('app/' . $user->qr_code)
        ];

        SendMailJob::dispatch($mailData);
    }
}
