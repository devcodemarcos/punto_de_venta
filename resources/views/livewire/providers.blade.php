<div>
  <div class="border-b p-3">
    <div class="font-bold uppercase flex justify-between">
      <h5 class="text-gray-600">Lista de proveedores (<span id="totalProviders">{{ $providers->total() }}</span>)</h5>
      <a href="{{ route('provider.create') }}" class="text-blue-500 hover:text-gray-400">Registro</a>
    </div>
  </div>
  <div class="p-5">

    <div class="items-center justify-between w-full flex pb-3 bg-white mb-2">
      <input wire:model="search" value="{{ $search }}" name="barcode" class="font-bold border-gray-300 uppercase rounded-full w-full pl-4 text-gray-500 bg-gray-100 leading-tight focus:outline-none outline-none focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 lg:text-sm text-xs" type="text" placeholder="Buscar en todas las columnas por palabras clave" autocomplete="off">
    </div>

    <table class="border-collapse w-full" id="tblProviders">
      <thead>
        <tr class="border-b-2 border-blue-200 bg-blue-500 text-xs font-semibold text-white">
          <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Nombre</th>
          <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Teléfono</th>
          <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Correo Electrónico</th>
          <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Comentarios</th>
          @if($providers->count() > 0)
          <th class="px-5 py-3 uppercase tracking-wider hidden lg:table-cell">Acciones</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @forelse ($providers as $provider)
        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0 text-sm">
          <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
            {{ $provider->name }}
          </td>
          <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Teléfono</span>
            {{ $provider->phone }}
          </td>
          <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Correo Electrónic</span>
            {{ $provider->email }}
          </td>
          <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Comentarios</span>
            {{ $provider->comments }}
          </td>
          @if($providers->count() > 0)
          <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
            <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Acciones</span>

            <button data-route-edit="{{ route('provider.edit', $provider) }}" class="btnEditProvider inline-block p-3 text-center text-white transition bg-blue-500 rounded-full shadow ripple hover:shadow-lg hover:bg-blue-600 focus:outline-none waves-effect">
              <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
              </svg>
            </button>

            <button data-route-delete="{{ route('provider.delete', $provider) }}" class="btnDeleteProvider inline-block p-3 text-center text-white transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none waves-effect">
              <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
            </button>

          </td>
          @endif
        </tr>
        @empty
        <tr>
          <td colspan="4" class="py-4 border text-center text-gray-600">No hay proveedores registrados</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div class="pt-5 pb-1">
      {{ $providers->links() }}
    </div>
  </div>
</div>