<?php
namespace app\common;

use think\Model;
use think\facade\View;

abstract class BaseLogic extends Model
{
    public $name;
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
        $this->loadFields();
        $this->loadRows();
    }

    public function loadEdit() {
        $this->loadFields();
        $this->loadOpts();
    }
}