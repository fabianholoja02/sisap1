<!--Ingresar Tabs en la parte superior-->

<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Datos personales</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil de usuario</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Información adicional</a></li>    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">Ingrese la información que solicita</div>
    <div role="tabpanel" class="tab-pane" id="profile">La siguiente información es muy relevante para avilitar el acceso al sistema.</div>
    <div role="tabpanel" class="tab-pane" id="messages">Información adicional que facilitará tener mejor información del médico</div>    
  </div>

</div>

<!--Fin de tabs-->
<!--Fecha:-->

<?php
        echo $form->labelEx($model, "[$key]fecha");
 
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => "[$key]fecha",
            'options' => array(
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));
        echo $form->error($model, "[$key]fecha");
        ?>







<!--
http://getbootstrap.com/javascript/
-->


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

