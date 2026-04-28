<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuario Principal
        $user = User::firstOrCreate(
            ['email' => 'mely@example.com'],
            [
                'name' => 'Mely Luna',
                'password' => bcrypt('mely123')
            ]
        );

        // 2. Categorías Reales
        $cat1 = Category::create(['name' => 'Estilo de Vida', 'slug' => 'estilo-de-vida']);
        $cat2 = Category::create(['name' => 'Tecnología', 'slug' => 'tecnologia']);
        $cat3 = Category::create(['name' => 'Viajes', 'slug' => 'viajes']);
        $cat4 = Category::create(['name' => 'Gastronomía', 'slug' => 'gastronomia']);

        // 3. Etiquetas Reales
        $tagTips = Tag::create(['name' => 'Consejos', 'slug' => 'consejos']);
        $tagReview = Tag::create(['name' => 'Reseña', 'slug' => 'resena']);
        $tagLaravel = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $tagAventuras = Tag::create(['name' => 'Aventuras', 'slug' => 'aventuras']);

        // 4. Posts Reales con Contenido Enriquecido
        
        // Post 1: Estilo de Vida
        $p1 = Post::create([
            'title' => '5 Hábitos para una mañana más productiva',
            'slug' => '5-habitos-manana-productiva',
            'excerpt' => 'Descubre cómo transformar tus mañanas para empezar el día con energía y propósito.',
            'content' => '<h2>El poder de la rutina matutina</h2><p>No es secreto que la forma en que empezamos el día define nuestro estado de ánimo para las próximas horas. Aquí te comparto mis 5 hábitos esenciales:</p><ul><li><strong>Hidratación inmediata:</strong> Bebe un vaso de agua apenas despiertes.</li><li><strong>Cero pantallas:</strong> Evita revisar el celular durante los primeros 30 minutos.</li><li><strong>Movimiento:</strong> 10 minutos de estiramientos o yoga suave.</li><li><strong>Planificación:</strong> Identifica tus 3 tareas críticas del día.</li><li><strong>Desayuno nutritivo:</strong> No saltes la comida más importante.</li></ul><p>Implementar esto cambió mi vida por completo. ¡Pruébalo!</p>',
            'user_id' => $user->id,
            'category_id' => $cat1->id,
            'is_published' => true,
            'published_at' => now(),
        ]);
        $p1->tags()->attach([$tagTips->id]);

        // Post 2: Tecnología
        $p2 = Post::create([
            'title' => '¿Por qué Laravel sigue siendo el rey de PHP en 2026?',
            'slug' => 'porque-laravel-es-el-rey-de-php',
            'excerpt' => 'Un análisis honesto sobre la evolución de Laravel y por qué sigue siendo la mejor opción para desarrolladores modernos.',
            'content' => '<h2>Más que un framework, un ecosistema</h2><p>Laravel ha logrado lo que pocos: mantenerse relevante y fresco durante más de una década. Con la llegada de <strong>Flux UI</strong> y <strong>Livewire 4</strong>, la experiencia de desarrollo ha alcanzado un nivel de simplicidad asombroso.</p><blockquote>"La elegancia es la única belleza que nunca se desvanece." - Taylor Otwell</blockquote><p>Lo que más valoro hoy en día es:</p><ol><li>La velocidad de despliegue con Forge.</li><li>La potencia de Eloquent para bases de datos complejas.</li><li>La comunidad vibrante que siempre está dispuesta a ayudar.</li></ol><p>Si estás pensando en empezar un proyecto, Laravel sigue siendo la respuesta corta.</p>',
            'user_id' => $user->id,
            'category_id' => $cat2->id,
            'is_published' => true,
            'published_at' => now()->subDays(2),
        ]);
        $p2->tags()->attach([$tagLaravel->id, $tagReview->id]);

        // Post 3: Viajes
        $p3 = Post::create([
            'title' => 'Escapada de fin de semana: Mi viaje a las montañas',
            'slug' => 'escapada-fin-de-semana-montanas',
            'excerpt' => 'A veces necesitas desconectar para volver a conectar. Te cuento mi última aventura en las cumbres nevadas.',
            'content' => '<h2>Desconexión total</h2><p>Este fin de semana decidí dejar la ciudad atrás y subir a las montañas. El aire puro y el silencio absoluto eran justo lo que necesitaba.</p><p>Subí al mirador del <em>Águila Blanca</em> y la vista era simplemente espectacular. Me quedé allí durante horas, simplemente observando el horizonte sin distracciones.</p><p><strong>Recomendación:</strong> Si vas, no olvides llevar calzado adecuado y mucha agua. El sendero es exigente pero vale cada paso.</p>',
            'user_id' => $user->id,
            'category_id' => $cat3->id,
            'is_published' => true,
            'published_at' => now()->subDays(5),
        ]);
        $p3->tags()->attach([$tagAventuras->id]);

        // Post 4: Gastronomía
        $p4 = Post::create([
            'title' => 'El secreto de la pasta al pesto perfecta',
            'slug' => 'secreto-pasta-pesto-perfecta',
            'excerpt' => 'Olvida el pesto de frasco. Con estos 3 trucos llevarás tu pasta al siguiente nivel.',
            'content' => '<h2>Sabor auténtico en casa</h2><p>Hacer pesto parece fácil, pero hay una gran diferencia entre uno bueno y uno extraordinario. Aquí están mis secretos:</p><p>1. <strong>Tuesta los piñones:</strong> Solo un par de minutos en la sartén cambia el sabor radicalmente.<br>2. <strong>Usa un mortero:</strong> La licuadora oxida la albahaca. El mortero extrae los aceites esenciales sin quemarlos.<br>3. <strong>Queso de calidad:</strong> Un buen Parmigiano Reggiano es innegociable.</p><p>Sigue estos pasos y tus invitados no creerán que lo hiciste tú mismo.</p>',
            'user_id' => $user->id,
            'category_id' => $cat4->id,
            'is_published' => true,
            'published_at' => now()->subDays(10),
        ]);
        $p4->tags()->attach([$tagTips->id, $tagReview->id]);
    }
}
