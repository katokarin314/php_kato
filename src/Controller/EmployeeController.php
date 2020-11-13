<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Employee Controller
 *
 * @property \App\Model\Table\EmployeeTable $Employee
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employee');
        $this->loadModel('PositionName');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('employee');
        $employee = $this->Employee
            ->find('all')
            ->contain('PositionName');
        if($this->request->is('post')){    
            $name = $this->request->data['name'];
            $employee = $this->Employee->find()
                ->where(["name like"=> '%' . $name . '%'])
                ->contain('PositionName');
        }
        $this->set('Employee', $employee);
    
       
        $this->render($this->request->action);
    }
}
