<h1>Candidatos</h1>
<hr>
<table>
  <thead>
    <tr>
      <td>Código</td>
      <td>Identidad</td>
      <td>Nombre</td>
      <td>Edad</td>
      <td><a href="index.php?page=mnt.candidatos.candidato&mode=INS&id=0">Nuevo</a></td>
    </tr>
  </thead>
  <tbody>
    {{foreach candidatos}}
      <tr>
        <td>{{id}}</td>
        <td>
          <a href="index.php?page=mnt.candidatos.candidato&mode=DSP&id={{id}}">{{identidad}}</a>
        </td>
        <td>{{nombre}}</td>
         <td>{{edad}}</td>
        <td>
          <a href="index.php?page=mnt.candidatos.candidato&mode=UPD&id={{id}}">Editar</a>
          &nbsp;
          <a href="index.php?page=mnt.candidatos.candidato&mode=DEL&id={{id}}">Eliminar</a>
          </td>
      </tr>
    {{endfor candidatos}}
  </tbody>
</table>