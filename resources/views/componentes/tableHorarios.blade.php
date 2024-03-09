<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->nombre}}</td>
    <td class="px-6 py-3 text-center">
        <a class="py-2 text-sm my-0 mx-0.5 px-3 text-dark-blue " href="/verHorario/{{$item->id}}" title="Ver Horario">
            <i class="fa-solid fa-eye"></i>
        </a>
        <button  type="button" class="duplicar-horario py-2.5 text-sm my-0 mx-0.5 px-4 text-dark-blue" title="Duplicar Horario" data-object="horario" data-id="{{$item->id}}" data>
            <i class="fa-solid fa-copy"></i>
        </button>
        <a class="link-btn eliminar-horario py-2 text-sm my-0 mx-0.5 px-3 text-dark-blue" data-id="{{$item->id}}" title="Eliminar Horario">
            <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>