<x-layouts::app title="Gestión de Posts">
    {{-- Dynamic Background --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-[10%] left-[20%] w-[30%] h-[30%] rounded-full bg-indigo-500/5 blur-[120px]"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[40%] h-[40%] rounded-full bg-purple-500/5 blur-[150px]"></div>
    </div>

    <div class="space-y-8 animate-in fade-in duration-700">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest">
                    <flux:icon icon="document-text" size="xs" variant="solid" />
                    <span>Panel de Administración</span>
                </div>
                <flux:heading size="xl" class="text-4xl font-black tracking-tighter">Tus Publicaciones</flux:heading>
                <flux:subheading class="text-zinc-500 dark:text-zinc-400">Gestiona, edita y publica tu contenido de forma elegante.</flux:subheading>
            </div>

            <div class="flex items-center gap-3">
                <flux:button href="{{ route('admin.posts.create') }}" 
                             class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-8 py-3 rounded-2xl font-black shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 active:scale-95 transition-all flex items-center gap-2 border-none" 
                             wire:navigate>
                    <flux:icon icon="plus" size="sm" variant="solid" />
                    Nuevo Post
                </flux:button>
            </div>
        </div>

        {{-- Stats / Quick Insights --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-6 rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:text size="xs" class="font-bold uppercase tracking-wider text-zinc-400">Total</flux:text>
                <div class="text-2xl font-black mt-1">{{ $posts->count() }}</div>
            </div>
            <div class="p-6 rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:text size="xs" class="font-bold uppercase tracking-wider text-green-500">Publicados</flux:text>
                <div class="text-2xl font-black mt-1">{{ $posts->where('is_published', true)->count() }}</div>
            </div>
            <div class="p-6 rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:text size="xs" class="font-bold uppercase tracking-wider text-orange-500">Borradores</flux:text>
                <div class="text-2xl font-black mt-1">{{ $posts->where('is_published', false)->count() }}</div>
            </div>
            <div class="p-6 rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:text size="xs" class="font-bold uppercase tracking-wider text-indigo-500">Vistas hoy</flux:text>
                <div class="text-2xl font-black mt-1">1.2k</div>
            </div>
        </div>

        {{-- Main Table Section --}}
        <div class="bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm rounded-[32px] border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="pl-8">Post / Título</flux:table.column>
                    <flux:table.column>Categoría</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column>Fecha</flux:table.column>
                    <flux:table.column align="end" class="pr-8">Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($posts as $post)
                        <flux:table.row class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <flux:table.cell class="pl-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 flex-shrink-0 border border-zinc-200 dark:border-zinc-700">
                                        @if($post->img_path)
                                            <img src="{{ Storage::url($post->img_path) }}" class="size-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div class="size-full flex items-center justify-center text-zinc-300">
                                                <flux:icon icon="photo" size="sm" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-0.5">
                                        <flux:text class="font-bold text-zinc-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $post->title }}
                                        </flux:text>
                                        <flux:text size="xs" class="text-zinc-400 line-clamp-1">{{ $post->excerpt }}</flux:text>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge size="sm" variant="outline" class="border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400">
                                    {{ $post->category->name ?? 'N/A' }}
                                </flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if($post->is_published)
                                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold text-xs">
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                        Publicado
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 text-zinc-400 font-bold text-xs uppercase tracking-tighter">
                                        <flux:icon icon="clock" size="xs" />
                                        Borrador
                                    </div>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:text size="xs" class="text-zinc-500">{{ $post->created_at->format('M d, Y') }}</flux:text>
                            </flux:table.cell>

                            <flux:table.cell align="end" class="pr-8">
                                <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <flux:button href="{{ route('admin.posts.show', $post) }}" variant="ghost" size="sm" icon="eye" 
                                                 class="rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-zinc-400 hover:text-indigo-600" wire:navigate />
                                    <flux:button href="{{ route('admin.posts.edit', $post) }}" variant="ghost" size="sm" icon="pencil-square" 
                                                 class="rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-400 hover:text-zinc-900 dark:hover:text-white" wire:navigate />
                                    
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Eliminar definitivamente?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="ghost" size="sm" icon="trash" 
                                                     class="rounded-xl hover:bg-red-50 dark:hover:bg-red-900/30 text-zinc-400 hover:text-red-600" />
                                    </form>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            @if($posts->isEmpty())
                <div class="py-20 text-center space-y-4">
                    <div class="inline-flex p-6 rounded-full bg-zinc-50 dark:bg-zinc-800 text-zinc-300">
                        <flux:icon icon="document-plus" size="xl" />
                    </div>
                    <div class="space-y-1">
                        <flux:heading>No hay posts todavía</flux:heading>
                        <flux:subheading>Comienza a escribir tu primera gran historia.</flux:subheading>
                    </div>
                    <flux:button href="{{ route('admin.posts.create') }}" 
                                 class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-3 rounded-2xl font-black shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 transition-all" 
                                 wire:navigate>
                        Crear mi primer post
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
</x-layouts::app>
