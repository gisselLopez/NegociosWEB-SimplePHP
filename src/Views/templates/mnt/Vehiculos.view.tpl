<h1>Vehiculo</h1>
<hr>
<table>
  <thead>
    <tr>
      <td>Código</td>
      <td>Marca</td>
      <td>Modelo</td>
      <td>Color</td>
      <td>Estado</td>
      <td><a href="index.php?page=mnt.vehiculos.vehiculo&mode=INS&id=0">Nuevo</a></td>
    </tr>
  </thead>
  <tbody>
    {{foreach vehiculos}}
      <tr>
        <td>{{id}}</td>
        <td>
          <a href="index.php?page=mnt.vehiculos.vehiculo&mode=DSP&id={{id}}">{{marca}}</a>
        </td>
         
         <td>{{modelo}}</td>
         <td>{{color}}</td>
        <td>{{estado}}</td>
        <td>
          <a href="index.php?page=mnt.vehiculos.vehiculo&mode=UPD&id={{id}}">Editar</a>
          &nbsp;
          <a href="index.php?page=mnt.vehiculos.vehiculo&mode=DEL&id={{id}}">Eliminar</a>
          </td>
      </tr>
    {{endfor vehiculos}}
  </tbody>
</table>