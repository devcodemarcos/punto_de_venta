<div>
    <div class="border-b p-3">
        <div class="font-bold uppercase flex justify-between">
            <h5 class="text-gray-600">Lista de productos (<span id="totalProducts">{{ $products->total() }}</span>)</h5>
            <a href="{{ route('product.create') }}" class="text-blue-500 hover:text-gray-400">Registro</a>
        </div>
    </div>
    <div class="p-5">
        <div class="items-center justify-between w-full flex pb-3 bg-white mb-2">
            <input wire:model="search" value="{{ $search }}" name="barcode" class="font-bold border-gray-300 uppercase rounded-full w-full pl-4 text-gray-500 bg-gray-100 leading-tight focus:outline-none outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 lg:text-sm text-xs" type="text" placeholder="Buscar en todas las columnas por palabras clave" autocomplete="off">
        </div>
        <table class="border-collapse w-full" id="tblProducts">
            <thead>
                <tr class="border-b-2 border-blue-200 bg-blue-500 text-xs font-semibold text-white">
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Código</th>
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Nombre del producto</th>
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Stock</th>
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Stock mínimo</th>
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Precio de compra</th>
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Precio de venta</th>
                    @if($products->count() > 0)
                    <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Código de barras</span>
                        {{ $product->barcode }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-left block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre del producto</span>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="{{ asset('/storage/' . $product->photo) }}" alt="{{ $product->photo }}">
                            </div>
                            <div class="ml-4 text-left">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $product->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $product->description }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Stock</span>
                        <div class="flex justify-center" role="group">
                            <button wire:click="decrement({{ $product }})" class="bg-white text-gray-500 hover:bg-red-500 hover:text-white border rounded-l-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" name="quantity" value="{{ $product->stock }}" class="px-3 py-2 text-gray-700 relative bg-white text-sm w-16 text-center border-gray-200 outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly />
                            <button wire:click="increment({{ $product }})" class="bg-white text-gray-500 hover:bg-blue-500 hover:text-white border rounded-r-lg px-4 py-2 mx-0 outline-none focus:outline-none">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Stock mínimo</span>
                        {{ $product->minimum_stock }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Precio de compra</span>
                        ${{ number_format($product->purchase_price, 2) }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Precio de venta</span>
                        ${{ number_format($product->sale_price, 2) }}
                    </td>
                    @if($products->count() > 0)
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>

                        <button data-route-edit="{{ route('product.edit', $product) }}" class="btnEditProduct inline-block p-3 text-center text-white transition bg-blue-700 rounded-full shadow ripple hover:shadow-lg hover:bg-blue-800 focus:outline-none waves-effect">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <button data-route-delete="{{ route('product.delete', $product) }}" class="btnDeleteProduct inline-block p-3 text-center text-white transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none waves-effect">
                            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>

                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 border text-center text-gray-600">No hay productos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-end">
        <div class="px-5 pt-1 pb-5">
            {{ $products->links() }}
        </div>
    </div>
</div>