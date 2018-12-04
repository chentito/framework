
<h3>Este es mi listado de usuarios</h3>

<table>
    <tr>
        <th>Nombre</th>
        <th>Edad</th>
        <th>Estatus</th>
        <th></th>
    </tr>
{section name=usr loop=$usuarios}
    <tr>
        <td>{$usuarios[usr].nombre}</td>
        <td align="center">{$usuarios[usr].edad}</td>
        <td align="center">{$usuarios[usr].estatus}</td>
        <td><a href="/usuarios/edita/idUsuario={$usuarios[usr].id}/">Editar</a></td>
    </tr>
{/section}
</table>