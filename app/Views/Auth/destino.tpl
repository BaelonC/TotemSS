<div id="destino_destinos" class="contenedor-destinos">    
    <div id="destino_nacionalidad" class="nacionalidad">{$nacionalidad}</div>
    <div id="destino_codigo_pais" class="codigo_pais">{$codigo_pais}</div>                
    <div id="destino_lbl_establecimiento" class="lbl_NEstablecimiento">Establecimiento</div>
    <div id="destino_establecimiento" class="nombre_establecimiento">{$Establecimiento}</div>
    <div id="destino_lbl_rut" class="lbl_rut">{$TipoDocumento}</div>
    <div id="destino_rut_visita" class="Rut">{$RutPersona}</div>
    <div id="destino_lbl_nombre_visita" class="lbl_persona">Nombre</div>
    <div id="destino_nombre_visita" class="nombre">{$NombrePersona}</div>        
    <div id="destino_apellido_p" class="apellido_p">{$apellido_p}</div>
    <div id="destino_apellido_m" class="apellido_m">{$apellido_m}</div>
    <div id="destino_tabs" class="Destinos">
      <ul>
         {foreach key=key item=item from=$Destinos} 
             <li><a href="#destino_tabs-{$key+1}">Piso {$key+1}</a></li>
         {/foreach}  
      </ul>

        {foreach name=outer key=key item=Destino from=$Destinos}  

          <div id="destino_tabs-{$key+1}">      
                <div id="destino_widget-{$key+1}" class="widget">               
                   {foreach name=inner key=key2 item=DatosSala from=$Destino}
                       <input type="button" id="destino_P_{$key+1}_{$DatosSala.id_sala}" value="{$DatosSala.sala}">  
                   {/foreach}  
                </div>
          </div>
        {/foreach}  
    </div>
</div>