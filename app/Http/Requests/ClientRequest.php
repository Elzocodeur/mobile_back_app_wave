<?php

namespace App\Http\Requests;

use App\Enums\StatusResponseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\RestResponseTrait;


class ClientRequest extends FormRequest
{
    use RestResponseTrait;


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'surname' => ['required', 'string', 'unique:clients,surname'],
        'role_id' => ['required', 'exists:roles,id'],
        'user' => ['required', 'array'],
        'user.telephone' => ['required', 'string', 'unique:users,telephone'],
        'user.email' => ['required', 'email', 'unique:users,email'],
        'user.password' => ['required', 'string', 'min:6'],
        'user.cni' => ['required', 'string', 'unique:users,cni'],
        'user.date_naissance' => ['required', 'date', 'before:today'],
        'user.nom' => ['required', 'string'],
        'user.prenom' => ['required', 'string'],
    ];
}


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'surname.required' => 'Le surnom est requis',
            'surname.unique' => 'Ce surnom est déjà utilisé',
            'role_id.required' => 'Le rôle est requis',
            'user.telephone.required' => 'Le numéro de téléphone est requis',
            'user.telephone.unique' => 'Ce numéro de téléphone est déjà utilisé',
            'user.email.required' => 'L\'email est requis',
            'user.email.email' => 'L\'email doit être une adresse email valide',
            'user.email.unique' => 'Cet email est déjà utilisé',
            'user.password.required' => 'Le mot de passe est requis',
            'user.password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'user.cni.required' => 'Le numéro CNI est requis',
            'user.cni.unique' => 'Ce numéro CNI est déjà utilisé',
            'user.date_naissance.required' => 'La date de naissance est requise',
            'user.date_naissance.date' => 'La date de naissance doit être une date valide',
            'user.date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'user.nom.required' => 'Le nom est requis',
            'user.prenom.required' => 'Le prénom est requis',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->telephone) {
            $this->merge([
                'user.telephone' => preg_replace('/[^0-9]/', '', $this->telephone)
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->sendResponse($validator->errors(), StatusResponseEnum::ECHEC, 404));
    }
}
