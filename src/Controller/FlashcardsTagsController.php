<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Flashcards Controller
 */
    class FlashcardsTagsController extends AppController
    {
        public function beforeFilter(\Cake\Event\EventInterface $event)
        {
            parent::beforeFilter($event);
            // Permitir acesso sem autenticação (ou ajuste conforme necessidade)
            $this->Authentication->addUnauthenticatedActions(['listar', 'ver', 'criar', 'editar', 'excluir']);
        }

    /**
     * Listar method
     */
    public function listar()
    {
        $query = $this->Flashcards->find();
        $flashcards = $this->paginate($query);
        $this->set(compact('flashcards'));
    }

    /**
     * Ver method
     */
    public function ver($id = null)
    {
        $flashcard = $this->Flashcards->get($id);
        $this->set(compact('flashcard'));
    }

    /**
     * Criar method
     */
    public function criar()
    {
        $flashcard = $this->Flashcards->newEmptyEntity();
        if ($this->request->is('post')) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success('Flashcard criado com sucesso!');
                return $this->redirect(['action' => 'listar']);
            }
            $this->Flash->error('Não foi possível criar o flashcard. Tente novamente.');
        }
        $this->set(compact('flashcard'));
    }

    /**
     * Editar method
     */
    public function editar($id = null)
    {
        $flashcard = $this->Flashcards->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success('Flashcard atualizado com sucesso!');
                return $this->redirect(['action' => 'listar']);
            }
            $this->Flash->error('Não foi possível atualizar o flashcard. Tente novamente.');
        }
        $this->set(compact('flashcard'));
    }

    /**
     * Excluir method
     */
    public function excluir($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $flashcard = $this->Flashcards->get($id);
        if ($this->Flashcards->delete($flashcard)) {
            $this->Flash->success('Flashcard excluído com sucesso!');
        } else {
            $this->Flash->error('Não foi possível excluir o flashcard. Tente novamente.');
        }
        return $this->redirect(['action' => 'listar']);
    }
}