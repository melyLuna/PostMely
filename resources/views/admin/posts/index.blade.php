<x-layouts::app title="Posts">
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl" level="1">Posts</flux:heading>
            <flux:subheading>Gestiona las publicaciones de tu blog</flux:subheading>
        </div>

        <flux:button href="{{ route('admin.posts.create') }}" variant="primary" icon="plus" wire:navigate>
            Nuevo Post
        </flux:button>
    </div>

    @if (session('info') || session('success'))
        <div x-data x-init="() => { 
            const showModal = () => {
                const modal = document.querySelector('[name=\'success-modal\']');
                if (window.$flux && modal) {
                    $flux.modal('success-modal').show();
                } else {
                    setTimeout(showModal, 100);
                }
            };
            showModal();
        }">
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
                <flux:table.column>Título</flux:table.column>
                <flux:table.column>Imagen</flux:table.column>
                <flux:table.column>Categoría</flux:table.column>
                <flux:table.column>Estado</flux:table.column>
                <flux:table.column>Fecha</flux:table.column>
                <flux:table.column align="end">Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($posts as $post)
                    <flux:table.row :key="$post->id">
                        <flux:table.cell font="medium">{{ $post->title }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($post->img_path)
                                <img src="{{ Storage::url($post->img_path) }}"
                                    class="h-10 w-16 object-cover rounded">
                            @else
                                <span class="text-zinc-400 text-xs">Sin imagen</span>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>{{ $post->category->name ?? 'N/A' }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$post->is_published ? 'green' : 'zinc'" inset="top bottom">
                                {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $post->published_at?->format('d/m/Y') ?? 'Sin fecha' }}
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-2">
                                <flux:button href="{{ route('admin.posts.show', $post) }}" variant="ghost"
                                    size="sm" icon="eye" wire:navigate />
                                <flux:button href="{{ route('admin.posts.edit', $post) }}" variant="ghost"
                                    size="sm" icon="pencil-square" wire:navigate />

                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar post?')">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" variant="ghost" size="sm" icon="trash"
                                        color="red" />
                                </form>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>

        @if ($posts->hasPages())
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif
    </flux:card>
</x-layouts::app>

