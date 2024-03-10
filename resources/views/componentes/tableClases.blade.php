<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->nombre}}</td>
    <td class="px-6 py-3 text-left">{{$item->descripcion}}</td>
    <td class="px-6 py-3 text-center">
        <a class="py-2.5 text-sm my-0 mx-0.5 px-4 rounded-lg text-dark-blue" href="/editarClase/{{$item->id}}" title="Editar Clase">
            <i class="fa-solid fa-pencil"></i>
        </a>
        <a class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue " href="/eliminarClase/{{$item->id}}" title="Eliminar Clase">
            <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>
