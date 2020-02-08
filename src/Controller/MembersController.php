<?php
namespace App\Controller;

use App\Controller\AppController;

class MembersController extends AppController
{
    public function index()
    {
        $this->set('members', $this->paginate($this->Members));
        $this->set('_serialize', ['members']);
    }

    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Messages']
        ]);
        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }

    public function add()
    {
        $member = $this->Members->newEmptyEntity();
        if ($this->request->is('post')) {
            $member = $this->Members->patchEntity($member, $this->request->getData());
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The member could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('member'));
        $this->set('_serialize', ['member']);
    }

    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Members->patchEntity($member,
                $this->request->getData());
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(
                    __('The member could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('member'));
        $this->set('_serialize', ['member']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
