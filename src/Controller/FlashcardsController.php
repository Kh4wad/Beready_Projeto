<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\FlashcardsTable;

/**
 * Flashcards Controller
 *
 * @property \App\Model\Table\FlashcardsTable $Flashcards
 */
class FlashcardsController extends AppController
{
    /**
     * Listar method (era index)
     */
    public function listar()
    {
        $query = $this->Flashcards->find()->contain(['Usuarios', 'Prompts']);
        $flashcards = $this->paginate($query);
        $this->set(compact('flashcards'));
    }

    /**
     * Ver method (era view)
     */
    public function ver($id = null)
    {
        $flashcard = $this->Flashcards->get($id, [
            'contain' => ['Usuarios', 'Prompts', 'ImagemFrentes', 'ImagemVersos', 'FlashcardTags']
        ]);
        $this->set(compact('flashcard'));
    }

    /**
     * Criar method (era add)
     */
    public function criar()
    {
        $flashcard = $this->Flashcards->newEmptyEntity();
        if ($this->request->is('post')) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(('Flashcard criado com sucesso!'));
                return $this->redirect(['action' => 'listar']);
            }
            $this->Flash->error(('Não foi possível criar o flashcard. Tente novamente.'));
        }

        // Carregar dados para os dropdowns
        $usuarios = $this->Flashcards->Usuarios->find('list', ['limit' => 200]);
        $prompts = $this->Flashcards->Prompts->find('list', ['limit' => 200]);
        $imagemFrentes = $this->Flashcards->ImagemFrentes->find('list', ['limit' => 200]);
        $imagemVersos = $this->Flashcards->ImagemVersos->find('list', ['limit' => 200]);

        $this->set(compact('flashcard', 'usuarios', 'prompts', 'imagemFrentes', 'imagemVersos'));
    }

    /**
     * Editar method (era edit)
     */
    public function editar($id = null)
    {
        $flashcard = $this->Flashcards->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $flashcard = $this->Flashcards->patchEntity($flashcard, $this->request->getData());
            if ($this->Flashcards->save($flashcard)) {
                $this->Flash->success(('Flashcard atualizado com sucesso!'));
                return $this->redirect(['action' => 'listar']);
            }
            $this->Flash->error(('Não foi possível atualizar o flashcard. Tente novamente.'));
        }

        // Carregar dados para os dropdowns
        $usuarios = $this->Flashcards->Usuarios->find('list', ['limit' => 200]);
        $prompts = $this->Flashcards->Prompts->find('list', ['limit' => 200]);
        $imagemFrentes = $this->Flashcards->ImagemFrentes->find('list', ['limit' => 200]);
        $imagemVersos = $this->Flashcards->ImagemVersos->find('list', ['limit' => 200]);

        $this->set(compact('flashcard', 'usuarios', 'prompts', 'imagemFrentes', 'imagemVersos'));
    }

    /**
     * Excluir method (era delete)
     */
    public function excluir($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        try {
            $flashcard = $this->Flashcards->get($id);
            if ($this->Flashcards->delete($flashcard)) {
                $this->Flash->success(('Flashcard excluído com sucesso!'));
            } else {
                $this->Flash->error(('Não foi possível excluir o flashcard. Tente novamente.'));
            }
        } catch (\Exception $e) {
            $this->Flash->error(('Flashcard não encontrado ou já foi excluído.'));
        }

        return $this->redirect(['action' => 'listar']);
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}