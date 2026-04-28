<x-layouts::app title="Crear Nuevo Post">
    <div class="mb-6">
        <flux:heading size="xl" level="1">Crear Nuevo Post</flux:heading>
        <flux:subheading>Completa todos los campos requeridos para el blog.</flux:subheading>
    </div>

    <flux:card>
        <form id="post-form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if ($errors->any())
                <flux:card class="bg-red-50 border-red-200">
                    <flux:heading size="sm" class="text-red-800">Hay errores en el formulario:</flux:heading>
                    <ul class="list-disc list-inside text-red-700 text-xs mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </flux:card>
            @endif

            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div x-data="{ preview: null }">
                <flux:input label="Imagen del post" name="img_path" type="file" accept="image/*"
                    @change="preview = URL.createObjectURL($event.target.files[0])" />
                <img x-show="preview" :src="preview" class="mt-2 h-32 w-auto rounded-lg object-cover">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <flux:input label="Título" name="title" :value="old('title')" required />
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <flux:input label="Slug" name="slug" :value="old('slug')" required />
                    @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <flux:textarea label="Resumen (Excerpt)" name="excerpt" rows="2" required>
                    {{ old('excerpt') }}
                </flux:textarea>
                @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <flux:label>Contenido del Post</flux:label>
                <div id="editor" class="bg-white dark:bg-zinc-800 dark:text-white min-h-[300px] rounded-lg border border-zinc-200 dark:border-zinc-700">
                    {!! old('content') !!}
                </div>
                <input type="hidden" name="content" id="content">
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <flux:select label="Categoría" name="category_id">
                        <option value="" disabled selected>Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </flux:select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <flux:input type="datetime-local" label="Fecha de Publicación" name="published_at"
                        :value="old('published_at')" />
                    @error('published_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center md:pt-8">
                    <input type="hidden" name="is_published" value="0">
                    <flux:checkbox label="¿Publicar inmediatamente?" name="is_published" value="1"
                        :checked="old('is_published')" />
                </div>
            </div>

            <div x-data="{ 
                selectedTags: {{ collect(old('tags', []))->toJson() }},
                availableTags: {{ $tags->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toJson() }},
                toggleTag(id) {
                    id = parseInt(id);
                    if (this.selectedTags.includes(id)) {
                        this.selectedTags = this.selectedTags.filter(t => t !== id);
                    } else {
                        this.selectedTags.push(id);
                    }
                }
            }" class="space-y-3">
                <flux:label>Etiquetas</flux:label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tag in availableTags" :key="tag.id">
                        <button type="button" 
                            @click="toggleTag(tag.id)"
                            :class="selectedTags.includes(tag.id) 
                                ? 'bg-zinc-800 text-white dark:bg-white dark:text-zinc-900 border-zinc-800 dark:border-white' 
                                : 'bg-white text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 hover:border-zinc-400'"
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border transition-all duration-200 shadow-sm cursor-pointer">
                            <span x-text="tag.name"></span>
                            <template x-if="selectedTags.includes(tag.id)">
                                <flux:icon icon="check" class="ml-1.5 h-3.5 w-3.5" />
                            </template>
                        </button>
                    </template>
                </div>
                <template x-for="id in selectedTags" :key="id">
                    <input type="hidden" name="tags[]" :value="id">
                </template>
                @error('tags') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-2 justify-end">
                <flux:button as="a" :href="route('admin.posts.index')" variant="ghost" wire:navigate>
                    Cancelar
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Guardar Post
                </flux:button>
            </div>
        </form>
    </flux:card>

    <script>
        function initPage() {
            // Slug Generator
            const titleInput = document.querySelector('input[name="title"]');
            const slugInput = document.querySelector('input[name="slug"]');
            
            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    let slug = this.value.toLowerCase()
                        .replace(/[^\w ]+/g, '')
                        .replace(/ +/g, '-');
                    slugInput.value = slug;
                });
            }

            // Quill Editor
            const editorElement = document.querySelector('#editor');
            if (editorElement && !editorElement.classList.contains('ql-container')) {
                console.log('Inicializando Quill...');
                const quill = new Quill('#editor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });

                // Sincronizar contenido antes de enviar el formulario
                const form = document.querySelector('#post-form');
                const contentInput = document.querySelector('#content');
                
                if (form && contentInput) {
                    form.addEventListener('submit', function(e) {
                        const html = quill.root.innerHTML;
                        console.log('Sincronizando contenido de Quill:', html);
                        contentInput.value = html;
                        
                        // Si el contenido está vacío (Quill pone <p><br></p>), avisar
                        if (html === '<p><br></p>' || html === '') {
                            console.warn('El contenido de Quill está vacío.');
                        }
                    });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', initPage);
        document.addEventListener('livewire:navigated', initPage);
    </script>
</x-layouts::app>

