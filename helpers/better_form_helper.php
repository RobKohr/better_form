<?php
if(!function_exists('pretty')){
  function pretty($str){
    return ucwords(str_replace('_', ' ' , str_replace('___', ' - ', $str)));
  }
 }

function bf_open($path, $name, $label=NULL){
  global $current_form, $current_form_label;
  $out = '';
  $current_form = $name;
  if(!$label)
    $label = pretty($name);
  $current_form_label = $label;
  $id_part = 'id="form_'.$name.'"';
  $out.= str_replace('<form', '<form '.$id_part, form_open($path));
  $out.= bf_hidden('form_submitted', $name);
  $out.=form_fieldset($label);
  return $out;
}

function bf_close(){
  $out = form_fieldset_close();
  $out.= '</form>';
  return $out;
}
function bf_hidden($params, $value=NULL){
  if($value==NULL)
      return form_hidden($params);
  return form_hidden($params, $value);
}


function bf_dropdown($params, $options, $value=NULL){
  if(!is_array($params)){
    $params = array('name'=>$params);
  }
  $input = form_dropdown($params['name'], $options, $value, data_properties_str($params));
  $params['input'] = $input;
  return bf_field('select', $params);
}

//returns a string of data properties that should be in the input tag
function data_properties_str($params){
  $props = '';
  foreach($params as $param=>$value){
    if(is_substr('data-', $param)){
      $prop = $param.'="'.$value.'" ';
      $props.=$prop;
    }
  }  
  return $props;
}

function bf_checkbox($name, $label, $checked=FALSE){
  $input = form_checkbox($name, 1);
  return bf_field('checkbox', array('name'=>$name, 'label'=>$label, 'input'=>$input));
}

function bf_email($params, $value=NULL){
  $type = str_replace('bf_', '', __FUNCTION__);
  return str_replace('type="text"', 'type="email"', 
		     bf_field('input', $params, $value));
}

function bf_input($params, $value=NULL){
  $type = str_replace('bf_', '', __FUNCTION__);
  return bf_field($type, $params, $value);
}
function bf_password($params, $value=NULL){
  $type = str_replace('bf_', '', __FUNCTION__);
  return bf_field($type, $params, $value);
}

function bf_submit($label=NULL){
  global $current_form_label;
  if($label==NULL)
    $label = $current_form_label;
  return form_submit(ugly($label), $label);
}

function bf_field($type, $params, $value=NULL){
  if(is_array($params)){
    $name = $params['name'];    
    if(!empty($params['label']))
      $label = $params['label'];
  }else{
    $name = $params;
  }
  if(empty($label))
    $label = pretty($name);
  $out = form_label($label, $name);
  $fun = 'form_'.$type;

  if($value == NULL){
    if(!empty($_POST[$name]))
      $value = $_POST[$name];
  }

  if( (empty($params['input'])) || (!is_array($params)) ) {
    if($value!=NULL)
      $out.=$fun($params, $value);
    else
      $out.=$fun($params);
  }else{
    $out.=$params['input'];
  }
  $out = '<p>'.$out.'</p>';
  return $out;
}
