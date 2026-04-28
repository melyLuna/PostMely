<x-layouts::app title="Editar Categoría">
    <div class="mb-6">
        <flux:heading size="xl">Editar Categoría: {{ $category->name }}</flux:heading>
        <flux:subheading>Modifica la información de la categoría seleccionada.</flux:subheading>
    </div>

    <flux:card>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <flux:input 
                label="Nombre de la categoría" 
                name="name" 
                id="name"
                :value="old('name', $category->name)"
                required
            />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <flux:input 
                label="Slug (URL amigable)" 
                name="slug" 
                id="slug"
                :value="old('slug', $category->slug)"
                icon="link"
                required
            />
            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="flex gap-2 justify-end">
                <flux:button href="{{ route('admin.categories.index') }}" variant="ghost">
                    Cancelar
                </flux:button>
                
                <flux:button type="submit" variant="primary">
                    Actualizar Categoría
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