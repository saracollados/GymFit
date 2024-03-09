<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->usuario_dni}}</td>
    <td class="px-6 py-3 text-center">{{$item->usuario_nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->clase_nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->fecha}}</td>
    <td class="px-6 py-3 text-center">{{$item->franja_horaria_nombre}}</td>
    <td class="px-6 py-3 text-center">
        <a class="py-2.5 text-sm my-0 mx-0.5 px-4 rounded-lg text-dark-blue" href="/verReserva/{{$item->id}}" title="Ver Reserva">
            <i class="fa-solid fa-eye"></i>
        </a>
        <a class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue " href="/eliminarReserva/{{$item->id}}" title="Eliminar Reserva">
            <i class="fa-solid fa-trash"></i>
        </a>
    </td>
</tr>

