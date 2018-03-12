<?php

/**
 * Build a select menu options from an array.
 * @param $items
 * @param null $selected
 * @return string
 */
function selectOptions($items, $selected = null) {
    $output = '';
    foreach ($items as $key => $value) {
        if(is_array($value)) {
            $output .= '<optgroup label="'.$key.'">';
            $output .= selectOptions($value, $selected);
            $output .= '</optgroup>';
        }
        else
        {
            if(is_array($selected)) {
                $isSelected = in_array($key, $selected) ? ' selected' : '';
                $output .= '<option value="'.$key.'"'.$isSelected.'>'.$value.'</option>';
            }
            else
            {
                $isSelected = strlen($selected) && $key == $selected ? ' selected' : '';
                $output .= '<option value="'.$key.'"'.$isSelected.'>'.$value.'</option>';
            }
        }
    }
    return $output;
}

function articleSelect($selected)
{
    $items = \App\Article::pluck('title','id');
    return selectOptions($items, $selected);
}