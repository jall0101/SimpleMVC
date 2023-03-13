<h1>Lista de Funciones</h1>
<section class="WWFilter">
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Función</th>
        <th>Estado</th>
        <th>Tipo</th>

        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>

    <tbody>
      {{foreach funciones}}
      <tr>

        <td>{{fncod}}</td>

        <td><a href="index.php?page=Mnt_Funcion&mode=DSP&fncod={{fncod}}">{{fndsc}}</a></td>

        <td><a>{{fnest}}</a></td>

        <td><a>{{fntyp}}</a></td>


        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
                <input type="hidden" name="page" value="Mnt_Funcion"/>
                <input type="hidden" name="mode" value="UPD" />
                <input type="hidden" name="fncod" value={{fncod}} />
                <button type="submit">Editar</button>
          </form>

          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Funcion"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="fncod" value={{fncod}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>

      </tr>
      {{endfor funciones}}
    </tbody>

  </table>
</section>

<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_funcion&mode=INS&fncod=0");
      });
    });
</script>