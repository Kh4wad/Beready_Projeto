<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Flashcards Controller
 *
 */
class FlashcardsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Flashcards->find();
        $flashcards = $this->paginate($query);

        $this->set(compact('flashcards'));
    }

    /**
     * View method
     *
     * @param string|null $id Flashcard id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $flashcard = $this->Flashcards->get($id, contain: []);
        $this->set(compact('flashcard'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $flashcard = $this->Flashcards->newEmptyEntity();
        if ($this->request->is('post')) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(__('The flashcard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The flashcard could not be saved. Please, try again.'));
        }
        $this->set(compact('flashcard'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Flashcard id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $flashcard = $this->Flashcards->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(__('The flashcard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The flashcard could not be saved. Please, try again.'));
        }
        $this->set(compact('flashcard'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Flashcard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $flashcard = $this->Flashcards->get($id);
        if ($this->Flashcards->delete($flashcard)) {
            $this->Flash->success(__('The flashcard has been deleted.'));
        } else {
            $this->Flash->error(__('The flashcard could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
