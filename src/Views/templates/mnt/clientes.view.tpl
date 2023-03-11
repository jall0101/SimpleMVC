<h1>Adminsitración de Clientes</h1>
<section class="WWFilter">
</section>

<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Cliente</th>
        <th>Género</th>
        <th>Teléfono #1</th>
        <th>Teléfono #2</th>
        <th>Correo</th>
        <th>Estado</th>

        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>

    <tbody>
      {{foreach clientes}}
      <tr>
        <td>
            {{clientid}}
        </td>

        <td>
            <a href="index.php?page=Mnt_Cliente&mode=DSP&clientid={{clientid}}">{{clientname}}</a>
        </td>
        
        <td>
            <a>{{clientgender}}</a>
        </td>

        <td>
            <a>{{clientphone1}}</a>
        </td>

        <td>
            <a>{{clientphone2}}</a>
        </td>

        <td>
            <a>{{clientemail}}</a>
        </td>

        <td>
            {{clientstatus}}
        </td>

        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Cliente"/>
              <input type="hidden" name="mode" value="UPD" />
              <input type="hidden" name="clientid" value={{clientid}} />
              <button type="submit">Editar</button>
          </form>

          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Cliente"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="clientid" value={{clientid}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>

      </tr>
      {{endfor clientes}}
    </tbody>

  </table>
</section>

<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_cliente&mode=INS&clientid=0");
      });
    });
</script>