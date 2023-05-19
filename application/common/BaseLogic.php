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

    abstract public function prepareFields();
    abstract public function prepareOpts();
    abstract public function prepareData($id);

    public function loadFields()
    {
        $rows = $this->prepareFields();
        View::share('rows',$rows);
        View::share('fields',$this->fields);
        View::share('textFields',$this->textFields);
        View::share('optFields',$this->optFields);
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
}