<tr class="bg-white">
    <td class="hidden">{{$item->id}}</td>
    <td class="px-6 py-3 text-center">{{$item->dni}}</td>
    <td class="px-6 py-3 text-center">{{$item->nombre}}</td>
    <td class="px-6 py-3 text-center">{{$item->role}}</td>
    <td class="px-6 py-3 text-center">{{$item->email}}</td>

    <td class="px-6 py-3 flex flex-row justify-center">
        <form action="{{route('editarPerfilPersonal')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$item->id}}">
            <input type="hidden" name="page" value="personal">

            <button type="submit" class="py-2.5 text-sm my-0 mx-0.5 px-4 rounded-lg text-dark-blue">
                <i class="fa-solid fa-pencil"></i>
            </button>
        </form>

        <button class="py-2 text-sm my-0 mx-0.5 px-3 rounded-lg text-dark-blue eliminar-usuario" title="Eliminar Personal" data-id={{$item->id}} data-page='personal'>
            <i class="fa-solid fa-trash"></i>
        </button>
    </td>
</tr>

