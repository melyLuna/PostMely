<x-layouts::app.sidebar title="Categorías">
    <flux:main>
        <div class="flex justify-between items-center mb-6">
            <div>
                <flux:heading size="xl">Categorías</flux:heading>
                <flux:subheading>Gestiona las categorías de tu sitio</flux:subheading>
            </div>
            
            <flux:button href="{{ route('admin.categories.create') }}" variant="primary" icon="plus">
                Nueva Categoría
            </flux:button>
        </div>

        @if (session('info'))
            <flux:card class="bg-green-50 border-green-200 mb-4">
                <span class="text-green-800">{{ session('info') }}</span>
            </flux:card>
        @endif

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>ID</flux:table.column>
                    <flux:table.column>Nombre</flux:table.column>
                    <flux:table.column>Slug</flux:table.column>
                    <flux:table.column align="end">Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($categories as $category)
                        <flux:table.row>
                            <flux:table.cell>{{ $category->id }}</flux:table.cell>
                            <flux:table.cell font="medium">{{ $category->name }}</flux:table.cell>
                            <flux:table.cell>{{ $category->slug }}</flux:table.cell>
                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('admin.categories.edit', $category) }}" variant="ghost" size="sm" icon="pencil-square" />
                                    
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Eliminar categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="ghost" size="sm" icon="trash" color="red" />
                                    </form>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </flux:card>
    </flux:main>
</x-layouts::app.sidebar>