# Player Notes

Module for managing notes associated with players. Built with Laravel 13, Livewire 4, and Spatie Permissions.

Módulo para gestionar notas asociadas a jugadores. Construido con Laravel 13, Livewire 4 y Spatie Permissions.

---

## Table of Contents / Índice

- [Tech Stack](#tech-stack)
- [Architecture / Arquitectura](#architecture--arquitectura)
- [Installation / Instalación](#installation--instalación)
- [Running Tests / Ejecutar Tests](#running-tests--ejecutar-tests)
- [Usage / Uso](#usage--uso)
- [Project Structure / Estructura del Proyecto](#project-structure--estructura-del-proyecto)
- [Commit History / Historial de Commits](#commit-history--historial-de-commits)

---

## Tech Stack

| Technology | Version |
|---|---|
| PHP | 8.3+ |
| Laravel | 13.x |
| Livewire | 4.x |
| Spatie Permissions | 7.x |
| Laravel Breeze | 2.x |
| Tailwind CSS | 4.x |
| PHPUnit | 12.x |
| SQLite | (testing) |

---

## Architecture / Arquitectura

```
app/
├── Livewire/
│   └── PlayerNotes.php              # Livewire component (list + create notes)
├── Models/
│   ├── Player.php                   # Player model
│   ├── PlayerNote.php               # PlayerNote model (belongsTo Player, User)
│   └── User.php                     # User model (HasRoles trait)
├── Repositories/
│   ├── Contracts/
│   │   └── PlayerNoteRepositoryInterface.php   # Repository contract
│   └── PlayerNoteRepository.php     # Eloquent implementation
└── Providers/
    └── AppServiceProvider.php       # Interface → Implementation binding
```

**Design Patterns / Patrones de Diseño:**
- **Repository Pattern**: Decouples data access from business logic / Desacopla el acceso a datos de la lógica de negocio
- **Dependency Injection**: Repository injected via Livewire method injection / Repositorio inyectado por method injection de Livewire
- **SOLID Principles**: Single Responsibility, Dependency Inversion / Principios de Responsabilidad Única e Inversión de Dependencias

---

## Installation / Instalación

### Prerequisites / Requisitos previos

- PHP >= 8.3
- Composer
- Node.js >= 18
- SQLite (included by default / incluido por defecto)

### Steps / Pasos

```bash
# 1. Clone the repository / Clonar el repositorio
git clone <repository-url>
cd player-notes

# 2. Install PHP dependencies / Instalar dependencias PHP
composer install

# 3. Install Node dependencies / Instalar dependencias Node
npm install

# 4. Environment setup / Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Run migrations and seed / Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# 6. Build frontend assets / Compilar assets del frontend
npm run build

# 7. Start the server / Iniciar el servidor
php artisan serve
```

### Default Test User / Usuario de prueba

| Field | Value |
|---|---|
| Email | `test@example.com` |
| Password | `password` |
| Permission | `create player note` |

---

## Running Tests / Ejecutar Tests

### Run all tests / Ejecutar todos los tests

```bash
php artisan test
```

### Run only PlayerNote tests / Ejecutar solo los tests de PlayerNote

```bash
php artisan test --filter=PlayerNoteTest
```

### Test coverage / Cobertura de tests

The `PlayerNoteTest` suite includes 7 tests covering:

La suite `PlayerNoteTest` incluye 7 tests que cubren:

| Test | Description / Descripción |
|---|---|
| `test_authorized_user_can_create_a_note` | Verifies a note is saved in the DB / Verifica que una nota se guarda en la BD |
| `test_note_field_is_required` | Validation: field cannot be empty / Validación: campo no puede estar vacío |
| `test_note_cannot_exceed_500_characters` | Validation: max 500 chars / Validación: máximo 500 caracteres |
| `test_notes_are_listed_for_a_player` | Notes are retrieved for a player / Las notas se listan para un jugador |
| `test_unauthorized_user_cannot_create_a_note` | Users without permission get 403 / Usuarios sin permiso reciben 403 |
| `test_form_is_hidden_for_users_without_permission` | Form hidden if no permission / Formulario oculto si no tiene permiso |
| `test_note_field_resets_after_saving` | Input clears after save / El campo se limpia después de guardar |

### Expected output / Salida esperada

```
PASS  Tests\Feature\PlayerNoteTest
  ✓ authorized user can create a note
  ✓ note field is required
  ✓ note cannot exceed 500 characters
  ✓ notes are listed for a player
  ✓ unauthorized user cannot create a note
  ✓ form is hidden for users without permission
  ✓ note field resets after saving

Tests:    7 passed (13 assertions)
```

---

## Usage / Uso

### Access the application / Acceder a la aplicación

1. Start the server: `php artisan serve`
2. Login at `/login` with the test credentials above
3. Navigate to `/players/{id}/notes` (e.g., `/players/1/notes`)

### Player Notes component / Componente Player Notes

- **Authorized users** see a form to add notes + the notes list / **Usuarios autorizados** ven un formulario para agregar notas + la lista
- **Unauthorized users** only see the notes list (no form) / **Usuarios no autorizados** solo ven la lista (sin formulario)
- Notes refresh automatically after saving (no page reload) / Las notas se actualizan automáticamente al guardar (sin recargar página)

### Blade usage / Uso en Blade

```blade
<livewire:player-notes :player-id="$player->id" />
```

---

## Project Structure / Estructura del Proyecto

```
player-notes/
├── app/
│   ├── Livewire/PlayerNotes.php           # Livewire component
│   ├── Models/
│   │   ├── Player.php                     # Player model
│   │   ├── PlayerNote.php                 # PlayerNote model
│   │   └── User.php                       # User model (+ HasRoles)
│   ├── Providers/AppServiceProvider.php   # Repository binding
│   └── Repositories/
│       ├── Contracts/
│       │   └── PlayerNoteRepositoryInterface.php
│       └── PlayerNoteRepository.php
├── database/
│   ├── factories/
│   │   ├── PlayerFactory.php
│   │   ├── PlayerNoteFactory.php
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── ...create_players_table.php
│   │   └── ...create_player_notes_table.php
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── livewire/player-notes.blade.php    # Component view
│   └── player-notes.blade.php            # Page view
├── routes/web.php                         # Routes
└── tests/Feature/PlayerNoteTest.php       # Feature tests
```

---

## Commit History / Historial de Commits

Each feature was developed and committed incrementally:

Cada funcionalidad fue desarrollada y commiteada de forma incremental:

| # | Commit | Description / Descripción |
|---|--------|---------------------------|
| 1 | `chore: install dependencies` | Livewire 4 + Spatie Permissions |
| 2 | `feat: Player model` | Model, migration & factory / Modelo, migración y factory |
| 3 | `feat: PlayerNote model` | Model with relationships, migration with FK & indexes / Modelo con relaciones, migración con FK e índices |
| 4 | `feat: repository pattern` | Interface + implementation + ServiceProvider binding |
| 5 | `feat: Livewire component` | PlayerNotes class + Blade view / Clase PlayerNotes + vista Blade |
| 6 | `feat: feature tests` | 7 tests, 13 assertions |
| 7 | `feat: route + layout` | Page view with Breeze layout integration |
| 8 | `feat: seeder` | Test user with permission + sample players |
| 9 | `feat: Breeze auth` | Authentication flow (login, register, etc.) |

---

## License

[MIT](https://opensource.org/licenses/MIT)
