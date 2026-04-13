<x-layouts::app.sidebar title="Editar Post">
    <flux:main>
        <div class="mb-6">
            <flux:heading size="xl" level="1">Editar Post</flux:heading>
            <flux:subheading>Actualiza la información del post: <b>{{ $post->title }}</b></flux:subheading>
        </div>

        <flux:card>
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="user_id" value="{{ $post->user_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Usamos :value para pasar la variable PHP directamente --}}
                    <flux:input label="Título" name="title" :value="old('title', $post->title)" required />
                    <flux:input label="Slug" name="slug" :value="old('slug', $post->slug)" required />
                </div>

                <flux:textarea label="Resumen (Excerpt)" name="excerpt" rows="2" required>
                    {{ old('excerpt', $post->excerpt) }}
                </flux:textarea>

                <flux:textarea label="Contenido del Post" name="content" rows="10" required>
                    {{ old('content', $post->content) }}
                </flux:textarea>

                {{-- Previsualizar imagen --}}
                <div class="space-y-2" x-data="{ preview: null }">
                    <img :src="preview ?? '{{ $post->img_path ? Storage::url($post->img_path) : '' }}'"
                        x-show="preview || {{ $post->img_path ? 'true' : 'false' }}"
                        class="h-32 w-auto rounded-lg object-cover">
                    <flux:input type="file" label="Nueva imagen (opcional)" name="img_path" accept="image/*"
                        @change="preview = URL.createObjectURL($event.target.files[0])" />
                    @error('img_path')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- En Flux Select, a veces es mejor manejar el 'selected' manualmente en los options --}}
                    <flux:select label="Categoría" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </flux:select>

                    <flux:select label="Etiquetas" name="tags[]" multiple>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ collect(old('tags', $post->tags->pluck('id')->toArray()))->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </flux:select>

                    {{-- El input datetime-local REQUIERE el formato Y-m-d\TH:i --}}
                    <flux:input type="datetime-local" label="Fecha de Publicación" name="published_at"
                        :value="old('published_at', $post->published_at?->format('Y-m-d\TH:i'))" />

                    <div class="flex items-center md:pt-8">
                        <input type="hidden" name="is_published" value="0">
                        <flux:checkbox label="¿Publicado?" name="is_published" value="1"
                            :checked="old('is_published', $post->is_published)" />
                    </div>
                </div>

                <div class="flex gap-2 justify-end">
                    <flux:button as="a" :href="route('admin.posts.index')" variant="ghost" wire:navigate>
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Actualizar Post
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </flux:main>
</x-layouts::app.sidebar>
