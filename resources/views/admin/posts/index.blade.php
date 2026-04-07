<x-layouts::app.sidebar title="Posts">
    <flux:main>
        <div class="flex justify-between items-center mb-6">
            <div>
                <flux:heading size="xl" level="1">Posts</flux:heading>
                <flux:subheading>Gestiona las publicaciones de tu blog</flux:subheading>
            </div>
            
            <flux:button href="{{ route('admin.posts.create') }}" variant="primary" icon="plus" wire:navigate>
                Nuevo Post
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
                    <flux:table.column>Título</flux:table.column>
                    <flux:table.column>Categoría</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column>Fecha</flux:table.column>
                    <flux:table.column align="end">Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($posts as $post)
                        <flux:table.row :key="$post->id">
                            <flux:table.cell font="medium">{{ $post->title }}</flux:table.cell>
                            <flux:table.cell>{{ $post->category->name ?? 'N/A' }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge :color="$post->is_published ? 'green' : 'zinc'" inset="top bottom">
                                    {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>{{ $post->published_at?->format('d/m/Y') ?? 'Sin fecha' }}</flux:table.cell>
                            
                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    <flux:button href="{{ route('admin.posts.edit', $post) }}" variant="ghost" size="sm" icon="pencil-square" wire:navigate />
                                    
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Eliminar post?')">
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

            @if ($posts->hasPages())
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </flux:card>
    </flux:main>
</x-layouts::app.sidebar>