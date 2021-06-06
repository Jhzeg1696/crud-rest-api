<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PersonModel;

class Person extends ResourceController
{
    use ResponseTrait;

    // Get all persons
    public function index()
    {
        $model = new PersonModel();
        $data = $model->orderBy('id', 'ASC')->findAll();
        return $this->respond($data);
    }

    // Get single person
    public function show($id = null)
    {
        $model = new PersonModel();

        $data = $model->getWhere(['id' => $id])->getResult();

        if($data)
        {
            return $this->respond($data);
        }
        else
        {
            return $this->failNotFound('No person found');
        }
    }

    // Create person
    public function create()
    {
        $model = new PersonModel();

        $data = json_decode($this->request->getBody());

        $person = [
            'name' => $data->name,
            'last_name' => $data->last_name
        ];

        $model->insert($person);

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => 
            [
                'success' => "Person created successfully"
            ]
        ];

        return $this->respondCreated($response);
    }

    // Update person
    public function update($id = null)
    {
        $model = new PersonModel();

        $data = json_decode($this->request->getBody());

        $person = 
        [
            'name' => $data->name,
            'last_name' => $data->last_name
        ];

        $model->update($id, $person);
        
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => 
            [
                'success' => 'Person updated succesfully'
            ]
        ];

        return $this->respond($response);
    }

    // Delete person
    public function delete($id = null)
    {
        $model = new PersonModel();
        
        $data = $model->find($id);

        if($data)
        {
            $model->delete($id);
            

            $response = [
                'status' => 200,
                'error' => null,
                'messages' =>
                [
                    'success' => 'Person deleted successfully'
                ] 
            ];

            return $this->respondDeleted($response);
        }

        else
        {
            return $this->failNotFound('No person found with id: ' . $id);
        }
    }
}