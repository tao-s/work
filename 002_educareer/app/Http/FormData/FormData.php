<?php namespace App\Http\FormData;

use Session;


/**
 *  DBに格納されているデータとFormから送信されたデータをまとめて、エラー時の各form要素の値のrepopulationを簡単にするために設計されたクラス
 *  現状ではFormから送信されたデータをもともとのカスタマーのデータよりも優先させて表示する。
 *
 *  （例）カスタマーのプロフィール変更画面での操作を想定する。
 *   - DBに保存されているカスタマーの名前(name) = hoge
 *   - 送信された名前(name) = fuga
 *   必須項目が入力されておらずエラーになった場合、$form_data_object->name には 'fuga' が入ってくるようにする。
 *   すると、HTMLでは <input value={{ $data->name }}> と書くだけでよくなり、テンプレートにif文が溢れるのを防ぐ効果がある。
 *
 *   このクラスでは $form_data_object->name とアクセスした時に適切な name の値を返すようにするための処理が殆どを占める。
 *   また、この抽象クラスを継承したクラスに public function name() {...} メソッドを定義しておくと、
 *   テンプレート内で、 $form_data_object->name をコールした時に上記メソッドが実行されるため、
 *   値に何らかのカスタマイズをしたい場合はこのようなメソッドを定義すると良い。
 *
 */
abstract class FormData
{
    protected $data;
    protected $request;
    protected $data_exists;
    protected $request_exists;

    abstract protected function set_data($data);

    private function configure()
    {
        $this->data_exists = false;
        if ($this->data) {
            $this->data_exists = true;
        }

        $this->request_exists = false;
        if ($old_input = Session::get('_old_input', array())) {
            $this->request_exists = true;
        }

        $this->request = $old_input ? $old_input : null;
    }

    public function load($data)
    {
        $this->set_data($data);
        $this->configure();
    }

    public function get_base_data()
    {
        $this->data;
    }

    /**
     *  $data->property をした時の挙動
     *
     *  1. $this->data がない & session._old_inputがない => null
     *  2. $this->data がない & session._old_inputがある => _old_input.property を返す
     *  3. $this->data がある & session._old_inputがない => $this->property()メソッドがあればその返り値、なければ$this->data->propertyを返す
     *  4. $this->data がある & session._old_inputがある => _old_input > data の優先順位で値を返す
     *
     */
    function __get($name)
    {
        if (!$this->data_exists && !$this->request_exists)
        {
            return null;
        }
        elseif (!$this->data_exists && $this->request_exists)
        {
            return $this->request($name);
        }
        elseif ($this->data_exists && !$this->request_exists)
        {
            if (method_exists($this, $name)) {
                return $this->$name();
            }
            return $this->data($name);
        }
        elseif ($this->data_exists && $this->request_exists)
        {
            if ($old_input = $this->request($name)) {
                return $old_input;
            }

            if (method_exists($this, $name)) {
                return $this->$name();
            }
            return $this->data($name);
        }

    }

    protected function data($key)
    {
        if (isset($this->data->$key)) {
            return $this->data->$key;
        }

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    protected function request($key)
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return null;
    }
}