<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            PAPELERA
        </h2>
    </x-slot>

    <div class="container py-12">
        <x-table-responsive>
            <div class="px-6 py-4">
                <x-jet-input wire:model="search" type="text" class="w-full"
                             placeholder="Escriba algo para filtrar"/>
            </div>

            @if (count($users))
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Eliminar permanentemente</th>
                        <th>Recuperar</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles->count() ? 'Admin' : 'No tiene rol' }}</td>
                            <td>
                                <form>
                                    <button type="submit"></button>
                                </form>
                                <a href="#" class="bg-red-200" wire:submit="eliminarPermanente({{ $user->id }})">
                                    Eliminar permanentemente
                                </a>
                            </td>
                            <td>
                                <a href="#" class="RECUPERAR bg-green-200"
                                   wire:click="restaurar({{ $user->id }})">
                                    Restaurar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay usuarios eliminados en la papelera.</p>
            @endif


            @if ($users->hasPages())
                <div class="px-6 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </x-table-responsive>
    </div>
</div>
