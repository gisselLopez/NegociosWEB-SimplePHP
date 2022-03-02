<h1>Pagos</h1>
<hr>
<table class="table table-dark">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Cliente</th>
            <th scope="col">Fceha</th>
            <th scope="col">Monto</th>
            <th scope="col">fecha de Vencimiento</th>
            <th scope="col">Estado</th>
            <th scope="col"> <a href="index.php?page=mnt.pagos.pago&mode=INS&id=0">Nuevo</a></th>
        </tr>
    </thead>
    <tbody>
        {{foreach pagos}}
        <tr>
            <td>{{id}}</td>
            <td>
            <a href="index.php?page=mnt.pagos.pago&mode=DSP&id={{id}}">{{cliente}}</a>
            </td>
            <td>{{fecha}}</td>
            <td>{{monto}}</td>
            <td>{{fechaVencimiento}}</td>
            <td>{{estado}}</td>
              <td>
            <a href="index.php?page=mnt.pagos.pago&mode=UPD&id={{id}}">Editar</a>
            &nbsp;
            <a href="index.php?page=mnt.pagos.pago&mode=DEL&id={{id}}">Eliminar</a>
            </td>
        </tr>
        {{endfor pagos}}
    </tbody>
</table>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>