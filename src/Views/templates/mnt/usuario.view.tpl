<h1>Administración de Usuarios</h1>
<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Usuario&mode={{mode}}&usercod={{usercod}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
        <label for="usercod" class="col-4">Código</label>
        <input type="hidden" id="usercod" name="usercod" value="{{usercod}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="hidden"  name="xssToken" value="{{xssToken}}"/>
        <input type="text" readonly name="usercoddummy" value="{{usercod}}"/>
    </section>

    <section class="row">
      <label for="username" class="col-4">Usuario</label>
      <input type="text" {{readonly}} name="username" value="{{username}}" maxlength="45" placeholder="Nombre de Usuario"/>
      {{if username}}
        <span class="error col-12">{{username}}</span>
      {{endif username}}
    </section>

    <section class="row">
      <label for="userpaswd" class="col-4">Contraseña</label>
      <input type="text" {{readonly}} name="userpaswd" value="{{userpaswd}}" maxlength="45" placeholder="Contraseña"/>
      {{if userpaswd_error}}
        <span class="error col-12">{{userpaswd_error}}</span>
      {{endif userpaswd_error}}
    </section>


    <section class="row">
      <label for="userest" class="col-4">Estado</label>
      <select id="userest" name="userest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{userest_ACT}}>ACTIVO</option>
        <option value="INA" {{userest_INA}}>INACTIVO</option>
      </select>
    </section>

    <section class="row">
      <label for="useractcod" class="col-4">COD USUARIO ACTIVO</label>
      <input type="text" {{readonly}} name="useractcod" value="{{useractcod}}" maxlength="45" placeholder="Usuario Activo"/>
      {{if useractcod_error}}
        <span class="error col-12">{{useractcod_error}}</span>
      {{endif useractcod_error}}
    </section>


    <section class="row">
      <label for="usertipo" class="col-4">Estado</label>
      <select id="usertipo" name="usertipo" {{if readonly}}disabled{{endif readonly}}>
        <option value="NRM" {{usertipo_NRM}}>NORMAL</option>
        <option value="CON" {{usertipo_CON}}>CONSULTOR</option>
        <option value="CLI" {{usertipo_CLI}}>CLIENTE</option>
      </select>
    </section>


    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}

  
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Usuarios");
      });
  });
</script>