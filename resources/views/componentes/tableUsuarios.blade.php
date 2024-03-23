<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->dni}}</td>
    <td class="px-6 py-3 text-center">{{$item->nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->fecha_nacimiento}}</td>
    <td class="px-6 py-3 text-center">{{$item->genero}}</td>
    <td class="px-6 py-3 text-center">{{$item->email}}</td>
    <td class="px-6 py-3 text-center">
        <a class="py-2.5 text-sm my-0 mx-0.5 px-4 rounded-lg text-dark-blue" href="/editarUsuario/{{$item->id}}" title="Editar Usuario">
            <i class="fa-solid fa-pencil"></i>
        </a>
        <button class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue eliminar-usuario" title="Eliminar Usuario" data-id={{$item->id}}>
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

