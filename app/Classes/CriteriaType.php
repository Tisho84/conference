<?php

namespace app\Classes;

use App\Criteria;
use Illuminate\Support\Facades\Input;

class CriteriaType
{
    private $types = [
        1 => [
            'id' => 1,
            'title' => 'Text',
            'option' => false
        ],
        2 => [
            'id' => 2,
            'title' => 'Checkbox',
            'option' => false
        ],
        3 => [
            'id' => 3,
            'title' => 'Option',
            'option' => true
        ]
    ];
    private $criteria;

    public function __construct(Criteria $criteria = null)
    {
        $this->criteria = $criteria;
    }

    public function getTypes()
    {
        $types = [];
        foreach ($this->types as $type) {
            $types[$type['id']] = $type['title'];
        }
        return ['' => trans('static.select')] + $types;
    }

    public function getType($id)
    {
        return $this->types[$id];
    }

    public function build()
    {
        $return = '';
        $value = '';
        if (isset($this->criteria->papers->first()->pivot->value)) {
            $value = $this->criteria->papers->first()->pivot->value;
        }

        switch ($this->criteria->type_id) {
            case 1:
                $return = $this->buildText($value);
                break;
            case 2:
                $return = $this->buildCheckBox($value);
                break;
            case 3:
                $return = $this->buildOption($value);
                break;
        }
        return $return;
    }

    private function buildText($value)
    {
        return '<textarea name="' . $this->criteria->id . '" class="form-control" id="id' . $this->criteria->id . '">' . $value . '</textarea>';
    }

    private function buildCheckBox($value)
    {
        $checked = '';
        if ($value) {
            $checked = 'checked';
        }
        return '<div class="checkbox"><label><input ' . $checked . ' type="checkbox" name="' . $this->criteria->id . '" value="1" id="id' . $this->criteria->id . '"/></label></div>';
    }

    private function buildOption($value)
    {
        $return = '<select name="' . $this->criteria->id . '" class="form-control" id="id' . $this->criteria->id . '">';
        foreach ($this->criteria->options as $option) {
            $selected = '';
            if ($option->id == $value) {
                $selected = 'selected="selected"';
            }
            $return .= '<option ' . $selected . ' value="'. $option->id . '">' . $option->langs->first()->title . '</option>';
        }
        $return .= '</select>';
        return $return;
    }
}