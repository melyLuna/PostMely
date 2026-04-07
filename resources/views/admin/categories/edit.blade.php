<x-layouts::app.sidebar title="Editar Categoría">
    <flux:main>
        <div class="mb-6">
            <flux:heading size="xl">Editar Categoría: {{ $category->name }}</flux:heading>
            <flux:subheading>Modifica la información de la categoría seleccionada.</flux:subheading>
        </div>

        <flux:card>
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT') {{-- Esto le dice a Laravel que es una actualización --}}

                <flux:input 
                    label="Nombre de la categoría" 
                    name="name" 
                    id="name"
                    :value="old('name', $category->name)" {{-- Carga el valor actual o el intento previo --}}
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

        {{-- Reutilizamos el script para el slug --}}
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
    </flux:main>
</x-layouts::app.sidebar>