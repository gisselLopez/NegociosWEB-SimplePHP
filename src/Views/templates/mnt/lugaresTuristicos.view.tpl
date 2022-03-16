<h1>lugaresTuristicos</h1>
<hr>
<table>
  <thead>
    <tr>
      <td>Codigo</td>
      <td>lugar</td>
      <td>pais</td>
      <td>estado</td>
      <td>ciudad</td>
      <td>latitud</td>
      <td>longitud</td>
      <td><a href="index.php?page=mnt.lugaresTuristicos.lugarTuristico&mode=INS&lugarid=0">Nuevo</a></td>
    </tr>
  </thead>
  <tbody>
    {{foreach lugaresTuristicos}}
      <tr>
        <td>{{lugarid}}</td>
        <td>
          <a href="index.php?page=mnt.lugaresTuristicos.lugarTuristico&mode=DSP&lugarid={{lugarid}}">{{lugar}}</a>
        </td>
         <td>{{pais}}</td>
        <td>{{estado}}</td>
        <td>{{ciudad}}</td>
        <td>{{latitud}}</td>
        <td>{{longitud}}</td>
        <td>
          <a href="index.php?page=mnt.lugaresTuristicos.lugarTuristico&mode=UPD&lugarid={{lugarid}}">Editar</a>
          &nbsp;
          <a href="index.php?page=mnt.lugaresTuristicos.lugarTuristico&mode=DEL&lugarid={{lugarid}}">Eliminar</a>
          </td>
      </tr>
    {{endfor lugaresTuristicos}}
  </tbody>
</table>
