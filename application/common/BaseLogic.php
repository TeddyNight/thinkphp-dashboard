<?php
namespace app\common;

use think\Model;
use think\facade\View;
use think\facade\Request;

abstract class BaseLogic extends Model
{
    public $alias;
    protected $fields;
    protected $textFields;
    protected $optFields;
    protected $opts;

    abstract public function prepareOpts();
    abstract public function prepareData($id);
    abstract public function prepareRows();

    public function loadFields()
    {
        View::share('fields',$this->fields);
        View::share('textFields',$this->textFields);
        View::share('optFields',$this->optFields);
    }

    public function loadRows()
    {
        View::share('rows',$this->prepareRows());
    }

    public function loadOpts()
    {
        $opts = $this->prepareOpts();
        View::share('opts',$opts);
    }

    public function loadData($id) {
        $data = $this->prepareData($id);
        View::share('data',$data);
    }

    public function prepareInput() {
        
    }

    public function loadList() {
        View::share('title',$this->alias);
        $this->loadFields();
        $this->loadRows();
    }

    public function loadEdit() {
        $this->loadFields();
        $this->loadOpts();
    }

    public function doCreate() {
        $this->allowField(true)->save($_POST);
    }

    public function doUpdate() {
        $this->allowField(true)->isUpdate(true)->save($_POST);
    }

    public function doDelete() {
        $id = Request::param('id');
        $this->destroy($id);
    }
}