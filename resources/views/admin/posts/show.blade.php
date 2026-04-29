<x-layouts::app title="{{ $post->title }}">
    {{-- Custom Background Pattern --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-500/5 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[30%] h-[30%] rounded-full bg-purple-500/5 blur-[100px]"></div>
        <div class="absolute -bottom-[10%] left-[20%] w-[50%] h-[50%] rounded-full bg-blue-500/5 blur-[150px]"></div>
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
            <flux:modal name="success-modal" class="md:w-[400px] border-none shadow-2xl backdrop-blur-xl bg-white/90 dark:bg-zinc-900/90">
                <div class="text-center space-y-6 py-4">
                    <div class="flex justify-center">
                        <div class="bg-gradient-to-tr from-green-400 to-emerald-500 p-0.5 rounded-full shadow-lg shadow-green-500/20">
                            <div class="bg-white dark:bg-zinc-900 rounded-full p-4">
                                <flux:icon icon="check" class="h-10 w-10 text-emerald-500" variant="solid" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <flux:heading size="xl" class="font-bold">¡Listo!</flux:heading>
                        <flux:text size="sm" class="text-zinc-500 dark:text-zinc-400 font-medium">
                            {{ session('info') ?? session('success') }}
                        </flux:text>
                    </div>

                    <div class="flex justify-center">
                        <flux:button x-on:click="$flux.modal('success-modal').close()" 
                                     class="px-8 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:scale-105 transition-transform">
                            Continuar
                        </flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
    @endif

    <div class="max-w-4xl mx-auto space-y-12 pb-32 animate-in fade-in slide-in-from-bottom-4 duration-1000 ease-out">
        
        {{-- Floating Control Center --}}
        <div class="sticky top-6 z-50 flex items-center justify-between bg-white/70 dark:bg-zinc-950/70 backdrop-blur-xl border border-white/20 dark:border-zinc-800/50 p-2 pl-4 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)]">
            <div class="flex items-center gap-4">
                <flux:button href="{{ route('admin.posts.index') }}" variant="ghost" icon="chevron-left" size="sm" 
                             class="rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate />
                <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-800"></div>
                <flux:text size="sm" class="font-semibold text-zinc-900 dark:text-zinc-100 truncate max-w-[150px] md:max-w-[300px]">
                    {{ $post->title }}
                </flux:text>
            </div>
            
            <div class="flex items-center gap-2">
                <flux:button href="{{ route('admin.posts.edit', $post) }}" 
                             class="rounded-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-6 py-2 text-xs font-bold hover:opacity-90 transition-all shadow-md" 
                             wire:navigate>
                    Editar Contenido
                </flux:button>
            </div>
        </div>

        {{-- Hero Header --}}
        <header class="relative space-y-8 pt-10 text-center">
            <div x-data="{ hovered: false }" 
                 @mouseenter="hovered = true" @mouseleave="hovered = false"
                 class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/50 transition-all duration-300"
                 :class="hovered ? 'scale-105 shadow-md shadow-indigo-500/10' : ''">
                <flux:icon icon="tag" size="xs" variant="solid" />
                <span class="text-xs font-bold uppercase tracking-widest">{{ $post->category->name ?? 'Sin categoría' }}</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-black tracking-tighter text-zinc-900 dark:text-white leading-[1.1]">
                {{ $post->title }}
            </h1>

            <div class="flex flex-col items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        <div class="relative size-10 rounded-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center justify-center overflow-hidden shadow-sm">
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ substr($post->user->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-bold text-zinc-900 dark:text-white leading-none">{{ $post->user->name }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">Escritor principal</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 text-xs font-medium text-zinc-400 dark:text-zinc-600">
                    <span class="flex items-center gap-1.5">
                        <flux:icon icon="calendar" size="xs" />
                        {{ $post->published_at?->format('d M, Y') ?? 'Borrador' }}
                    </span>
                    <span class="size-1 rounded-full bg-zinc-300 dark:bg-zinc-700"></span>
                    <span class="flex items-center gap-1.5">
                        <flux:icon icon="clock" size="xs" />
                        {{ str_word_count(strip_tags($post->content)) / 200 < 1 ? '1' : round(str_word_count(strip_tags($post->content)) / 200) }} min de lectura
                    </span>
                </div>
            </div>
        </header>

        {{-- Hero Image with Aesthetic Glow --}}
        @if ($post->img_path)
            <div class="relative group">
                <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-[40px] blur-3xl opacity-0 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative rounded-[32px] overflow-hidden shadow-2xl border border-white/10 dark:border-zinc-800/50">
                    <img src="{{ Storage::url($post->img_path) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full aspect-[21/9] object-cover transition-transform duration-1000 group-hover:scale-105">
                </div>
            </div>
        @endif

        {{-- Content Area --}}
        <div class="relative max-w-3xl mx-auto">
            {{-- Aesthetic Sidebar (Social/Misc) --}}
            <div class="absolute -left-20 top-0 hidden xl:flex flex-col gap-4 sticky top-32">
                <div class="flex flex-col gap-2 p-2 rounded-2xl bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm border border-zinc-200 dark:border-zinc-800">
                    <flux:button variant="ghost" icon="heart" size="sm" class="rounded-xl text-zinc-400 hover:text-red-500" />
                    <flux:button variant="ghost" icon="chat-bubble-bottom-center-text" size="sm" class="rounded-xl text-zinc-400 hover:text-indigo-500" />
                    <flux:button variant="ghost" icon="share" size="sm" class="rounded-xl text-zinc-400 hover:text-blue-500" />
                </div>
            </div>

            <article class="space-y-12">
                @if($post->excerpt)
                    <div class="relative group">
                        <div class="absolute -left-6 top-0 bottom-0 w-1.5 bg-gradient-to-b from-indigo-500 to-purple-600 rounded-full opacity-80"></div>
                        <p class="text-2xl font-medium text-zinc-700 dark:text-zinc-300 leading-relaxed ps-2">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                @endif

                <div class="prose prose-xl prose-indigo dark:prose-invert max-w-none 
                            prose-headings:text-zinc-900 dark:prose-headings:text-white prose-headings:font-black prose-headings:tracking-tight
                            prose-p:text-zinc-600 dark:prose-p:text-zinc-400 prose-p:leading-relaxed
                            prose-strong:text-zinc-900 dark:prose-strong:text-white
                            prose-blockquote:border-none prose-blockquote:ps-10 prose-blockquote:relative
                            prose-img:rounded-3xl prose-img:shadow-2xl
                            prose-a:text-indigo-600 dark:prose-a:text-indigo-400 prose-a:font-bold">
                    
                    {{-- Visual Decor for Blockquotes --}}
                    <style>
                        .prose blockquote::before {
                            content: '"';
                            position: absolute;
                            left: 0;
                            top: -20px;
                            font-size: 80px;
                            font-family: serif;
                            color: #6366f1;
                            opacity: 0.2;
                        }
                    </style>

                    {!! $post->content !!}
                </div>

                {{-- Tags Section --}}
                <div class="flex flex-wrap gap-2 pt-12 border-t border-zinc-100 dark:border-zinc-800">
                    @forelse ($post->tags as $tag)
                        <a href="#" class="px-4 py-1.5 rounded-xl bg-zinc-50 dark:bg-zinc-900 text-zinc-500 dark:text-zinc-400 text-sm font-semibold hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-500 transition-all duration-300">
                            #{{ $tag->name }}
                        </a>
                    @empty
                        <span class="text-zinc-400 italic">Este post no tiene etiquetas vinculadas.</span>
                    @endforelse
                </div>
            </article>

            {{-- Post Author Card (Bottom) --}}
            <div class="mt-20 p-8 rounded-3xl bg-gradient-to-br from-zinc-50 to-white dark:from-zinc-900 dark:to-zinc-950 border border-zinc-200 dark:border-zinc-800 flex items-center gap-6 shadow-sm">
                <div class="size-20 rounded-2xl bg-indigo-500 flex items-center justify-center text-3xl font-black text-white shadow-xl shadow-indigo-500/20">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $post->user->name }}</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 max-w-md">
                        Apasionado por la creación de contenido y la tecnología. Siempre explorando nuevas formas de comunicar ideas.
                    </p>
                </div>
                <flux:button variant="outline" size="sm" class="rounded-xl border-zinc-200 dark:border-zinc-700">Seguir</flux:button>
            </div>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div x-data="{ progress: 0 }" 
         x-on:scroll.window="progress = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100"
         class="fixed top-0 left-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500 z-[100] transition-all duration-100"
         :style="'width: ' + progress + '%'"></div>

    {{-- Custom Utility Styles --}}
    <style>
        ::selection {
            background-color: #e0e7ff;
            color: #4338ca;
        }
        .dark ::selection {
            background-color: #312e81;
            color: #e0e7ff;
        }
    </style>
</x-layouts::app>
