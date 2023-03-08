<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Categorias 2
            </h2>


        </div>
    </x-slot>

    <x-table-responsive>
        <div>
            Filtrar por Nombre
        </div>
        <div class="px-6 py-4">
            <x-jet-input class="buscador w-full"
                         wire:model="search"
                         type="text"
                         placeholder="Introduzca el nombre del producto a buscar"/>
        </div>
        <div>
            Filtrar por ID
        </div>
        <div class="form-group">
            <label for="category">Categoría:</label>
            <select wire:model="filterCat" id="category" class="form-control">
                <option value="">Todas las categorías</option>
                @foreach($categories as $catego)
                    <option value="{{ $catego->id }}">{{ $catego->id }}</option>
                @endforeach
            </select>
        </div>
        @if($categories->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        NOMBRE
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        IMAGEN
                    </th>

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $catego)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $catego->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $catego->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <img class="h-10 w-10 rounded-full"

                                 src="{{ asset('storage/'. $catego->image) }}"
                                 alt="">
                        </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-4">
                No existen categorias coincidentes
            </div>
        @endif


    </x-table-responsive>
</div>
