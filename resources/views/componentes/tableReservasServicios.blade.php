<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="hidden">{{$item->franja_horaria_id}}</td>
    <td class="px-6 py-3 text-center">{{$item->usuario_dni}}</td>
    <td class="px-6 py-3 text-center">{{$item->usuario_nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->role_nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->profesional_nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->fecha}}</td>
    <td class="px-6 py-3 text-center">{{$item->franja_horaria_nombre}}</td>
    <td class="px-6 py-3 text-center">
        @if ($item->pasada)
            <span class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-gray-400" title="Eliminar Reserva">
                <i class="fa-solid fa-trash"></i>
            </span>
        @else
            <a class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue reserva-item-list" style="cursor:pointer;" data-id="{{$item->id}}" data-type="servicios">
                <i class="fa-solid fa-trash"></i>
            </a>
        @endif
    </td>
</tr>

