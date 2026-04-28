<x-layouts::app title="Ver Post">
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
                        <flux:button x-on:click="$flux.modal('success-modal').close()" variant="primary">Genial</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
    @endif
    <div class="mb-6 flex justify-between items-start">
        <div>
            <flux:heading size="xl" level="1">{{ $post->title }}</flux:heading>
            <flux:subheading>
                En <span class="font-medium text-zinc-800 dark:text-zinc-200">{{ $post->category->name ?? 'Sin categoría' }}</span> 
                • Publicado el {{ $post->published_at?->format('d/m/Y') ?? 'Borrador' }}
            </flux:subheading>
        </div>
        <div class="flex gap-2">
            <flux:button href="{{ route('admin.posts.edit', $post) }}" icon="pencil-square" variant="ghost" wire:navigate>
                Editar
            </flux:button>
            <flux:button href="{{ route('admin.posts.index') }}" variant="ghost" wire:navigate>
                Volver
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if ($post->img_path)
                <flux:card class="p-0 overflow-hidden">
                    <img src="{{ Storage::url($post->img_path) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover max-h-[400px]">
                </flux:card>
            @endif

            <flux:card>
                <div class="prose prose-zinc dark:prose-invert max-w-none">
                    {!! $post->content !!}
                </div>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <flux:heading size="lg" class="mb-4">Detalles</flux:heading>
                <div class="space-y-4">
                    <div>
                        <flux:label>Resumen</flux:label>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $post->excerpt }}</p>
                    </div>
                    
                    <div>
                        <flux:label>Estado</flux:label>
                        <div class="mt-1">
                            <flux:badge :color="$post->is_published ? 'green' : 'zinc'">
                                {{ $post->is_published ? 'Publicado' : 'Borrador' }}
                            </flux:badge>
                        </div>
                    </div>

                    <div>
                        <flux:label>Etiquetas</flux:label>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @forelse ($post->tags as $tag)
                                <flux:badge size="sm" variant="outline">{{ $tag->name }}</flux:badge>
                            @empty
                                <span class="text-xs text-zinc-400">Sin etiquetas</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </flux:card>

            <flux:card class="bg-zinc-50 dark:bg-zinc-900/50">
                <flux:heading size="sm" class="mb-2">Información de autor</flux:heading>
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-500">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ $post->user->name }}</p>
                        <p class="text-xs text-zinc-500">{{ $post->user->email }}</p>
                    </div>
                </div>
            </flux:card>
        </div>
    </div>

    {{-- Estilos para el contenido de Quill --}}
    <style>
        .prose img {
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .prose blockquote {
            border-left-color: #e5e7eb;
            font-style: italic;
            color: #4b5563;
        }
        .dark .prose blockquote {
            border-left-color: #3f3f46;
            color: #a1a1aa;
        }
    </style>
</x-layouts::app>
