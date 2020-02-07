<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Validation\Validator;

class PersonsController extends AppController
{
    public $paginate = [
        'limit' => 5,
        'order' => [
            'Persons.name' => 'asc'
        ]
    ];

    public function index()
    {
        $this->set('persons', $this->paginate());
    }

    public function edit($id = null)
    {
        $person = $this->Persons->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $person = $this->Persons->patchEntity($person, $this->request->getData());
            if ($this->Persons->save($person)) {
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->set('person', $person);
        }
    }

    public function add()
    {
        $person = $this->Persons->newEmptyEntity();
        $this->set('person', $person);
        if ($this->request->is('post')) {
            $validator = new Validator();
            $validator->add(
                'age','comparison',['rule' =>['comparison','>',20]]
            );
            $errors = $validator->errors($this->request->getData());
            if (!empty($errors)){
                $this->Flash->error('comparison error');
            } else {
                $person = $this->Persons->newEntity($this->request->getData());
                if ($this->Persons->save($person)) {
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }


    public function delete($id = null)
    {
        $person = $this->Persons->get($id);
        if ($this->request->is(['post', 'put'])) {
            if ($this->Persons->delete($person)) {
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->set('person', $person);
        }
    }

    public function find()
    {
        $this->set('msg', null);
        $persons = [];
        if ($this->request->is('post')) {
            $find = $this->request->getData('find');
            $persons = $this->Persons->find()
                                     ->where(
                                         [
                                             'OR' => [
                                                 ["name like " => '%' . $find . '%'],
                                                 ["mail like" => '%' . $find . '%']]
                                         ]);
        }
        $this->set('persons', $persons);
    }
}

