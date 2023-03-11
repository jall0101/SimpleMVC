<h1>Lista de Usuarios</h1>
<section class="WWFilter">
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Correo</th>
        <th>Usuario</th>
        <th>Contraseña</th>
        <th>Estado</th>
        <th>Código User Activo</th>
        <th>Tipo User</th>

        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>

    <tbody>
      {{foreach usuarios}}
      <tr>

        <td>{{usercod}}</td>

        <td><a href="index.php?page=Mnt_Usuario&mode=DSP&usercod={{usercod}}">{{useremail}}</a></td>

        <td><a href="index.php?page=Mnt_Usuario&mode=DSP&usercod={{usercod}}">{{username}}</a></td>
        
        <td><a>{{userpaswd}}</a></td>

        <td><a>{{userest}}</a></td>

        <td><a>{{useractcod}}</a></td>

        <td><a>{{usertipo}}</a></td>


        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
                <input type="hidden" name="page" value="Mnt_Usuario"/>
                <input type="hidden" name="mode" value="UPD" />
                <input type="hidden" name="usercod" value={{usercod}} />
                <button type="submit">Editar</button>
          </form>

          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Usuario"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="usercod" value={{usercod}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>

      </tr>
      {{endfor usuarios}}
    </tbody>

  </table>
</section>

<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_usuario&mode=INS&usercod=0");
      });
    });
</script>