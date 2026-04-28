<x-layouts::app title="Nueva Etiqueta">
    <div class="mb-6">
        <flux:heading size="xl">Crear Etiqueta</flux:heading>
        <flux:subheading>Añade una nueva etiqueta para clasificar tus posts.</flux:subheading>
    </div>

    <flux:card>
        <form action="{{ route('admin.tags.store') }}" method="POST" class="space-y-6">
            @csrf

            <flux:input 
                label="Nombre de la etiqueta" 
                placeholder="Ej: Laravel" 
                name="name" 
                id="name"
                value="{{ old('name') }}"
                required
            />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <flux:input 
                label="Slug (URL amigable)" 
                placeholder="ej-laravel" 
                name="slug" 
                id="slug"
                value="{{ old('slug') }}"
                icon="link"
                required
            />
            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="flex gap-2 justify-end">
                <flux:button href="{{ route('admin.tags.index') }}" variant="ghost">
                    Cancelar
                </flux:button>
                
                <flux:button type="submit" variant="primary">
                    Guardar Etiqueta
                </flux:button>
            </div>
        </form>
    </flux:card>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('keyup', function() {
                let title = nameInput.value;
                let slug = title.toLowerCase()
                    .trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                slugInput.value = slug;
            });
        });
    </script>
</x-layouts::app>
