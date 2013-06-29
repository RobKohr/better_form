better_form
===========

A collection of functions that make creating forms in codeigniter faster. 


==How it works==


echo bf_input('hello')

will create in your view

<p><label for="hello">Hello</label><input type="text" name="hello" value=""  /></p>


==Examples==


bf_dropdown('color', array('red', 'green', 'blue'));

bf_input(array('name'=>'hello', 'label'=>'Some crazy label', 'value'=>'some default value');
