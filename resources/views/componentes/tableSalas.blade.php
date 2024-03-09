<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->aforo}}</td>
    <td class="px-6 py-3 text-center">
        <a class="py-2.5 text-sm my-0 mx-0.5 px-4 rounded-lg text-dark-blue" href="/editarSala/{{$item->id}}" title="Editar Sala">
            <i class="fa-solid fa-pencil"></i>
        </a>
        <a class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue " href="/eliminarSala/{{$item->id}}" title="Eliminar Sala">
            <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>

