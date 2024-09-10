<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\Client\CreateRequest;
use App\Http\Requests\Admin\Project\Client\UpdateRequest;
use App\Http\Resources\Api\Admin\Project\ClientResource;
use App\Models\Client;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()->latest()->paginate(limit($request->limit));
        return apiResponse(true, 200, [
            'clients' => ClientResource::collection($clients),
            'pagination' => pagination($clients)
        ]);
    }

    public function create(CreateRequest $request)
    {
        $client = new Client();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->company_name = $request->company_name;
        $client->save();

        return apiResponse(true, 201, __('words.Successfully created'));
    }

    public function show(Client $client)
    {
        return apiResponse(true, 200, $client);
    }

    public function update(UpdateRequest $request, Client $client)
    {
        try {

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'email' => 'unique:clients,email,' . $client->id,
                'phone' => 'unique:clients,phone,' . $client->id,
            ]);

            if ($validator->fails()) {
                return apiResponse(false, 422, $validator->messages()->all());
            }

            $client->name = $request->name;
            $client->email = $request->email;
            $client->phone = $request->phone;
            $client->company_name = $request->company_name;
            $client->save();

            return apiResponse(true, 200, __('words.Successfully updated'));
        } catch (Validator $validator) {
            $response = apiResponse(false, 422, $validator->messages()->all());

            throw new ValidationException($validator, $response);
        }
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return apiResponse(true, 200, __('words.Successfully deleted'));
    }
}
