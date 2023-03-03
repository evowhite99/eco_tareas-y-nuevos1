<div>
    <x-slot name="header">

        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Lista de productos
            </h2>

            <x-button-link class="ml-auto" href="{{route('admin.products.create')}}">
                Agregar producto
            </x-button-link>
        </div>
    </x-slot>

    <x-table-responsive>
        <div class="px-6 py-4">
            <x-jet-input class="w-full"
                         wire:model="search"
                         type="text"
                         placeholder="Introduzca el nombre del producto a buscar" id="buscador"/>
        </div>

        <div class="form-group">
            <label for="category">Categoría:</label>
            <select wire:model="selectedCategory" id="category" class="form-control">
                <option value="">Todas las categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }} ">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="brand">Marca:</label>
            <select wire:model="selectedBrand" id="brand" class="form-control">
                <option value="">Todas las categorías</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="price">Precio:</label>
            <select wire:model="selectedPrice" id="price" class="form-control">
                <option value="">Todos los precios</option>
                <option value="19.99" dusk="filtrarPrecio1">19.99</option>
                <option value="49.99" dusk="filtrarPrecio2">49.99</option>
                <option value="99.99" dusk="filtrarPrecio3">99.99</option>
            </select>
        </div>
        <div class="form-group">
            <label for="selectedDate">Fecha de Creación:</label>
            <input type="date" wire:model="selectedDate" id="selectedDate" class="form-control">
        </div>


        <div class="font-bold">
            ORDENAR
        </div>
        <th scope="col">
            <button type="button" class="bg-green-200 font-bold">
                <a href="#" wire:click="sortBy('name')" dusk="ordenarNombre">Nombre</a>
            </button>
        </th>
        <th scope="col">
            <button type="button" class="bg-green-200 font-bold">

                <a href="#" wire:click="sortBy('price')" dusk="ordenarPrecio">Precio</a>
            </button>

        </th>
        <th scope="col">
            <button type="button" class="bg-green-200 font-bold">

                <a href="#" wire:click="sortBy('subcategory.category.name')" dusk="ordenarCategoria">Categoría</a>
            </button>

        </th>
        <th scope="col">
            <button type="button" class="bg-green-200 font-bold">

                <a href="#" wire:click="sortBy('brand_id.name')" dusk="ordenarMarca">Marca</a>
            </button>

        </th>


        <div class="mt-7 font-bold">
            APARECER/DESAPARECER
        </div>
        <table>
            <tr>
                <th>
                    <label for="showName">Nombre:</label>
                    <select id="showName" wire:model="showName">
                        <option value=1 dusk="showName1">Mostrar</option>
                        <option value=0 dusk="showName0">Ocultar</option>
                    </select>
                </th>
                <th>
                    <label for="showCategory">Categorias:</label>
                    <select id="showCategory" wire:model="showCategory">
                        <option value=1 dusk="showCategory1">Mostrar</option>
                        <option value=0 dusk="showCategory0">Ocultar</option>
                    </select>
                </th>
                <th>
                    <label for="showStatus">Estado:</label>
                    <select id="showStatus" wire:model="showStatus">
                        <option value=1 dusk="showStatus1">Mostrar</option>
                        <option value=0 dusk="showStatus0">Ocultar</option>
                    </select>
                </th>
                <th>
                    <label for="showPrice">Precio:</label>
                    <select id="showPrice" wire:model="showPrice">
                        <option value=1 dusk="showPrice1">Mostrar</option>
                        <option value=0 dusk="showPrice0">Ocultar</option>
                    </select>
                </th>
            </tr>
            <tr>
                <th>
                    <label for="showEdit">Editar:</label>
                    <select id="showEdit" wire:model="showEdit">
                        <option value=1 dusk="showEdit1">Mostrar</option>
                        <option value=0 dusk="showEdit0">Ocultar</option>
                    </select>
                </th>

                <th>
                    <label for="showBrand">Marca:</label>
                    <select id="showBrand" wire:model="showBrand">
                        <option value=1 dusk="showBrand1">Mostrar</option>
                        <option value=0 dusk="showBrand0">Ocultar</option>
                    </select>
                </th>

                <th>
                    <label for="showSold">Vendidos:</label>
                    <select id="showSold" wire:model="showSold">
                        <option value=1 dusk="showSold1">Mostrar</option>
                        <option value=0 dusk="showSold0">Ocultar</option>
                    </select>
                </th>
                <th>
                    <label for="showStock">Stock:</label>
                    <select id="showStock" wire:model="showStock">
                        <option value=1 dusk="showStock1">Mostrar</option>
                        <option value=0 dusk="showStock0">Ocultar</option>
                    </select>
                </th>
                <th>
                    <label for="showCreated">Fecha:</label>
                    <select id="showCreated" wire:model="showCreated">
                        <option value=1 dusk="showCreated1">Mostrar</option>
                        <option value=0 dusk="showCreated0">Ocultar</option>
                    </select>
                </th>
            </tr>
        </table>
        @if($products->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @if($showName)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                            Nombre
                        </th>
                    @endif
                    @if($showCategory)
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categoría
                        </th>
                    @endif
                    @if($showStatus)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                    @endif
                    @if($showPrice)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>
                    @endif

                    @if($showEdit)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Editar
                        </th>
                    @endif

                    @if($showBrand)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Marca
                        </th>
                    @endif
                    @if($showSold)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vendidos
                        </th>
                    @endif
                    @if($showStock)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stock
                        </th>
                    @endif
                    @if($showCreated)

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                    @endif
                    @if($showEdit)

                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Editar</span>
                        </th>
                    @endif

                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>                                        @if($showName)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">

                                    <div class="flex-shrink-0 h-10 w-10 object-cover">
                                        <img class="h-10 w-10 rounded-full"
                                             src="{{ $product->images->count() ? Storage::url($product->images->first()->url) : 'img/default.jpg'  }}"
                                             alt="">


                                    </div>

                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">

                                            {{ $product->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                        @endif
                        @if($showCategory)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->subcategory->category->name }}</div>
                                <div class="text-sm text-gray-500">{{ $product->subcategory->name }}</div>
                            </td>
                        @endif
                        @if($showStatus)

                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $product->status == 1 ? 'red' : 'green'
                            }}-100 text-{{ $product->status == 1 ? 'red' : 'green' }}-800">
                                {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}
                            </span>
                            </td>
                        @endif
                        @if($showPrice)

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->price }} &euro;
                            </td>
                        @endif
                        @if($showEdit)

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            </td>
                        @endif
                        @if($showBrand)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>{{ $product->brand->name }}</div>
                            </td>
                        @endif
                        @if($showSold)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>{{ $product->sold }}</div>
                            </td>
                        @endif
                        @if($showStock)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>{{ $product->quantity }}</div>
                            </td>
                        @endif
                        @if($showCreated)

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>{{ $product->created_at}}</div>
                            </td>
                        @endif

                    </tr>
                @endforeach
                </tbody>
            </table>
            <label for="pagination">Mostrar:</label>
            <select name="pagination" id="pagination" class="form-control" wire:model="pagination">
                <option value="5" dusk="paginas5">5</option>
                <option value="10" dusk="paginas10">10</option>
                <option value="15" dusk="paginas15">15</option>
                <option value="25" dusk="paginas25">25</option>
                <option value="50" dusk="paginas50">50</option>
                <option value="100" dusk="paginas100">100</option>
            </select>

        @else
            <div class="px-6 py-4">
                No existen productos coincidentes
            </div>
        @endif


        @if($products->hasPages())
            <div class="px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </x-table-responsive>

</div>
