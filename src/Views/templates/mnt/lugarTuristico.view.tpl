<h1>{{modeDsc}}</h1>
<hr>
<section class="container-m">
  <form action="index.php?page=mnt.lugaresTuristicos.lugarTuristico&mode={{mode}}&lugarid={{lugarid}}" method="post" >
    <input type="hidden" name="crsxToken" value="{{crsxToken}}" />
    {{ifnot isInsert}}
    <fieldset class="row flex-center align-center">
        <label for="lugarid" class="col-5">Codigo</label>
        <input class="col-7" id="lugarid" name="lugarid" value="{{lugarid}}" placeholder="" type="text">
    </fieldset>
    {{endifnot isInsert}}
    <fieldset class="row flex-center align-center">
        <label class="col-5" for="lugar">lugar</label>
        <input class="col-7" id="lugar" name="lugar" value="{{lugar}}" placeholder="" type="text">
    </fieldset>
    <fieldset class="row flex-center align-center">
        <label class="col-5" for="pais">pais</label>
        <input class="col-7" id="pais" name="pais" value="{{pais}}" placeholder="" type="text">
    </fieldset>
  
    
    <fieldset class="row flex-center align-center">
        <label class="col-5" for="estado">Estado</label>
        <select class="col-7" name="estado" id="estado">
          {{foreach catestOptions}}
          <option value="{{value}}" {{selected}}>{{text}}</option>
          {{endfor catestOptions}}
        </select>
    </fieldset class="row flex-center align-center">

    <fieldset class="row flex-center align-center">
        <label class="col-5" for="ciudad">ciudad</label>
        <input class="col-7" id="ciudad" name="ciudad" value="{{ciudad}}" placeholder="" type="text">
    </fieldset>

    <fieldset class="row flex-center align-center">
        <label class="col-5" for="latitud">latitud</label>
        <input class="col-7" id="latitud" name="latitud" value="{{latitud}}" placeholder="" type="text">
    </fieldset>

    <fieldset class="row flex-center align-center">
        <label class="col-5" for="longitud">longitud</label>
        <input class="col-7" id="longitud" name="longitud" value="{{longitud}}" placeholder="" type="text">
    </fieldset>

    <fieldset class="row flex-end align-center">
        <button type="submit" name="btnConfirmar" class="btn primary">Confirmar</button>
        &nbsp;<button type="button" id="btnCancelar" class="btn secondary">Cancelar</button>
        &nbsp;
    </fieldset>
  </form>
</section>
<script>
  /* */
  document.addEventListener("DOMContentLoaded", (e)=>{
    document.getElementById("btnCancelar").addEventListener('click', (e)=>{
      e.preventDefault();
      e.stopPropagation();
      location.assign("index.php?page=mnt.lugaresTuristicos.lugaresTuristicos");
    })
  });
</script>
