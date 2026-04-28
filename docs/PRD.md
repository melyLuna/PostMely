# Documento de Requisitos del Producto (PRD) - PostMely

## 1. Introducción
El proyecto **PostMely** es una aplicación web de gestión de contenido (CMS) orientada a la creación y publicación de artículos (blog). Su propósito principal es proporcionar una plataforma robusta donde los usuarios puedan crear, categorizar y etiquetar publicaciones, con un control detallado sobre su estado de publicación.

## 2. Tecnologías y Stack
El proyecto está construido sobre un stack moderno y reactivo:
* **Backend:** PHP 8.2+, Laravel Framework 12.x.
* **Frontend:** TailwindCSS 4.x, Vite, Livewire 4.0, Livewire Flux (componentes UI avanzados).
* **Seguridad y Autenticación:** Laravel Fortify, con soporte integrado para Autenticación de Dos Factores (2FA).
* **Calidad de Código:** Pest PHP para testing, Laravel Pint para el formato de código.

## 3. Arquitectura de Datos (Modelos)
El sistema cuenta con cuatro entidades principales fuertemente relacionadas:

### 3.1. User (Usuario)
Gestiona el acceso y la autoría del contenido.
* **Características:** Integración con 2FA.
* **Relaciones:** Un usuario (autor) puede escribir múltiples publicaciones (`Posts`).

### 3.2. Post (Publicación)
La entidad central del ecosistema.
* **Atributos Principales:** 
  * `title`, `slug` (URL amigable).
  * `excerpt` (resumen), `content` (cuerpo del artículo).
  * `img_path` (imagen destacada).
  * `is_published` (booleano para borradores vs publicados), `published_at` (fecha de publicación).
* **Relaciones:** Pertenece a un `User` y a una `Category`. Puede tener múltiples `Tags`.

### 3.3. Category (Categoría)
Clasificación temática principal de los artículos.
* **Atributos:** `name`, `slug`.
* **Relaciones:** Relación de "uno a muchos" con las publicaciones.

### 3.4. Tag (Etiqueta)
Clasificación transversal y más detallada.
* **Atributos:** `name`, `slug`, `color` (para personalización en la interfaz de usuario).
* **Relaciones:** Relación de "muchos a muchos" con las publicaciones a través de la tabla pivote `post_tag`.

## 4. Funcionalidades y Requerimientos Clave

### 4.1. Gestión de Contenido
* **Flujo de Publicación:** Los usuarios deben poder guardar artículos como borradores y publicarlos posteriormente (`is_published`).
* **SEO y Navegación:** Cada publicación, categoría y etiqueta requiere un `slug` para generar URLs semánticas.
* **Multimedia:** Soporte para asociar imágenes de portada a cada artículo.

### 4.2. Taxonomía y Organización
* Los artículos deben agruparse bajo **una única categoría** principal.
* Los artículos pueden tener **múltiples etiquetas**, las cuales soportan diferenciación visual mediante un atributo de color.

### 4.3. Experiencia de Usuario e Interfaz
* **Navegación Reactiva:** Gracias a Livewire y Flux, la navegación y las interacciones del panel (como formularios de creación y edición) deben sentirse fluidas y sin recargas de página.
* **Panel de Control:** Existencia de rutas separadas (`admin.php`, `settings.php`, `web.php`) que sugieren una separación clara entre el sitio público, el panel de administración y las configuraciones del usuario.

## 5. Recomendaciones y Siguientes Pasos
A partir de la estructura actual, se sugiere:
1. **Roles y Permisos:** Si aún no están implementados, agregar un sistema de roles (Ej. Spatie Permission) para diferenciar entre Administradores y Editores comunes.
2. **Filtros de Búsqueda:** Implementar filtros en el frontend para buscar artículos por texto completo, categorías y etiquetas.
3. **Editor Rico (WYSIWYG):** Asegurar la integración de un editor de texto avanzado (como Trix, Quill o un editor Markdown) para el campo `content` del modelo `Post`.
