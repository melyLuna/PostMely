<x-layouts::app title="Etiquetas">
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl">Etiquetas</flux:heading>
            <flux:subheading>Gestiona las etiquetas de tus posts</flux:subheading>
        </div>
        
        <flux:button href="{{ route('admin.tags.create') }}" variant="primary" icon="plus">
            Nueva Etiqueta
        </flux:button>
    </div>

    @if (session('info') || session('success'))
        <div x-data="{ open: true }" x-init="setTimeout(() => { $flux.modal('success-modal').show() }, 100)">
            <flux:modal name="success-modal" class="md:w-[400px]">
                <div class="text-center space-y-4">
                    <div class="flex justify-center">
                        <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-full">
                            <flux:icon icon="check-circle" class="h-10 w-10 text-green-600 dark:text-green-400" variant="outline" />
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <flux:heading size="lg">¡Operación Exitosa!</flux:heading>
                        <flux:subheading>{{ session('info') ?? session('success') }}</flux:subheading>
                    </div>

                    <div class="flex justify-center pt-2">
                        <flux:button x-on:click="$flux.modal('success-modal').close()" variant="primary">Continuar</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
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
                @foreach ($tags as $tag)
                    <flux:table.row>
                        <flux:table.cell>{{ $tag->id }}</flux:table.cell>
                        <flux:table.cell font="medium">
                            <flux:badge size="sm" inset="top bottom">{{ $tag->name }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $tag->slug }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-2">
                                <flux:button href="{{ route('admin.tags.edit', $tag) }}" variant="ghost" size="sm" icon="pencil-square" />
                                
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" onsubmit="return confirm('¿Eliminar etiqueta?')">
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
            {{ $tags->links() }}
        </div>
    </flux:card>
</x-layouts::app>
