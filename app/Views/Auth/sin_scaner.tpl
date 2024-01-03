<div id="sin_escaner_medio_alternativo" class="contenedor-docto-alternativo">
    <div id="sin_escaner_paises" class="pais">
        <select id="sin_escaner_lstpaises" class="form-select" >
            <option selected>País de Origen</option>
           {foreach key=key item=item from=$paises} 
             <option id="sin_escaner_paises_{$key}" value="{$item->getCodigo()}">{$item->getDESCRIPCION()}</option>
           {/foreach}              
        </select>
    </div>
    <div id="sin_escaner_tipo_documento" class="tipos">
        <select id="sin_escaner_TipDocto" class="form-select" >
            <option selected>T. docto. identificación</option>
           {foreach key=key item=item from=$tipDctoIdentificacion} 
             <option id="sin_escaner_paises_{$key}" value="{$item->getCodigo()}">{$item->getDESCRIPCION()}</option>
           {/foreach}              
        </select>        
    </div>
    <div id="sin_escaner_val_tipo_documento" class="valtipo">        
        <input id="sin_escaner_valor_documento" type="text" value=""">
    </div>
    <div id="sin_escaner_teclado" class="teclado">
            <div id="sin_escaner_teclado_numerico" class="contenedor-teclado">
                <div id="sin_escaner_tecla1" class="tecla1"><button type="button" class="tecla1 btn btn-light" >1</button></div>
                <div id="sin_escaner_tecla2" class="tecla2"><button type="button" class="tecla2 btn btn-light" >2</button></div>
                <div id="sin_escaner_tecla3" class="tecla3"><button type="button" class="tecla3 btn btn-light" >3</button></div>
                <div id="sin_escaner_tecla4" class="tecla4"><button type="button" class="tecla4 btn btn-light" >4</button></div>
                <div id="sin_escaner_tecla5" class="tecla5"><button type="button" class="tecla5 btn btn-light" >5</button></div>
                <div id="sin_escaner_tecla6" class="tecla6"><button type="button" class="tecla6 btn btn-light" >6</button></div>
                <div id="sin_escaner_tecla7" class="tecla7"><button type="button" class="tecla7 btn btn-light" >7</button></div>
                <div id="sin_escaner_tecla8" class="tecla8"><button type="button" class="tecla8 btn btn-light" >8</button></div>
                <div id="sin_escaner_tecla9" class="tecla9"><button type="button" class="tecla9 btn btn-light" >9</button></div>
                <div id="sin_escaner_tecla0" class="tecla0"><button type="button" class="tecla0 btn btn-light" >0</button></div>
                <div id="sin_escaner_tipteclado" class="tipteclado"><button type="button" class="tipteclado btn btn-light"><i class="bi bi-keyboard"></i></button></div>
                <div id="sin_escaner_teclaDEL" class="teclaDEL"><button type="button" class="teclaDEL btn btn-light"><i class="bi bi-eraser"></i></button></div>
            </div>
    </div>            
    <div id="sin_escaner_acciones" class="acciones">
        <button  id="sin_escanear_btn_registrar" type="button" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> REGISTRAR</button>        
    </<div>
        <input id="sin_escaner_tipo_teclado" type="hidden" value="1">
</div>
            
