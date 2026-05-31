# Sistema Gestor de Contenido (SGC) - Memoria Castrense

El **SGC Memoria Castrense** es una plataforma web institucional orientada a la preservación, catalogación y discusión colaborativa de documentos históricos militares (fotografías, actas, mapas estratégicos, entre otros).

El proyecto garantiza la **Paridad de Entornos**, utiliza **Arquitectura Monolítica** en Laravel (PHP) con motor **PostgreSQL/SQLite** e implementa **Integración Continua (CI/CD)**. Todo el desarrollo se rige bajo estrictas políticas de [CONTRIBUTING.md](CONTRIBUTING.md).

---

## 🏗️ Arquitectura como Código (Doc-as-Code)

A continuación, se renderiza nativamente toda la ingeniería de software aplicada en el sistema.

### 1. Diagrama de Arquitectura de Despliegue
Implementación Monolítica escalable, eliminando dependencias de microservicios externos y utilizando el servidor nativo de persistencia de archivos de Laravel.

```mermaid
flowchart TD
    Cliente[Navegador del Investigador / Admin]
    
    subgraph Cloud_Server [Servidor Monolítico en la Nube]
        Laravel[Aplicación Laravel 10<br>Frontend Blade + API Backend]
        PostgreSQL[(Base de Datos SQL)]
        LocalVol[Volumen de Storage Local<br>Archivos Físicos]
    end
    
    Cliente -- "Tráfico Web Segura HTTPS" --> Laravel
    Laravel -- "Render HTML + CSS Compilado" --> Cliente
    Laravel -- "Consultas Eloquent ORM" --> PostgreSQL
    Laravel -- "Flysystem I/O" --> LocalVol
```

---

### 2. Diagrama Entidad-Relación (ER)
Arquitectura de datos que soporta trazabilidad de usuarios y múltiples archivos adjuntos por suceso histórico.

```mermaid
erDiagram
    USERS ||--o{ REGISTROS_PATRIMONIALES : "crea (created_by)"
    CATEGORIAS ||--o{ REGISTROS_PATRIMONIALES : "clasifica"
    REGISTROS_PATRIMONIALES ||--o{ ARCHIVOS : "posee (1:N)"
    USERS ||--o{ COMENTARIOS : "escribe"
    REGISTROS_PATRIMONIALES ||--o{ COMENTARIOS : "recibe"
    USERS }|--|{ REGISTROS_PATRIMONIALES : "guarda en marcadores"

    USERS {
        BIGINT id PK
        VARCHAR name
        VARCHAR email
        VARCHAR password
        VARCHAR role "administrador, publicador, usuario"
    }
    
    CATEGORIAS {
        BIGINT id PK
        VARCHAR nombre
        TEXT descripcion
    }

    REGISTROS_PATRIMONIALES {
        UUID id PK
        VARCHAR titulo
        TEXT descripcion
        DATE fecha_suceso
        BIGINT id_categoria FK
        BIGINT created_by FK
        TIMESTAMP deleted_at
    }

    ARCHIVOS {
        BIGINT id PK
        UUID registro_id FK
        TEXT url_recurso
        VARCHAR nombre_original
        VARCHAR tipo_archivo
        INT peso_archivo_kb
    }
```

---

### 3. Diagrama de Secuencia (Ingreso de Acta Patrimonial con Manejo de Errores)
Flujo detallado demostrando el tratamiento de excepciones (bloques `alt` / `else`) durante operaciones críticas de disco.

```mermaid
sequenceDiagram
    actor Admin as Administrador
    participant GUI as Interfaz Web (Blade)
    participant Ctrl as RegistroPatrimonialController
    participant Disk as Almacenamiento Local
    participant DB as Motor SQL

    Admin->>GUI: Llena formulario y adjunta archivo PDF
    GUI->>Ctrl: POST /ingesta (Datos + Archivo)
    Ctrl->>Ctrl: Validación de datos (Request)
    
    alt Datos inválidos o archivo pesado
        Ctrl-->>GUI: Redirigir con errores (HTTP 302)
        GUI-->>Admin: Muestra mensaje de alerta
    else Datos válidos
        Ctrl->>Disk: store('patrimonio', 'public')
        
        alt Fallo de almacenamiento físico (Exception)
            Disk-->>Ctrl: Lanza Excepción
            Ctrl-->>GUI: Retorna Error 500 "Falla al guardar"
            GUI-->>Admin: Muestra pantalla de error del sistema
        else Almacenamiento exitoso
            Disk-->>Ctrl: Retorna $path de archivo seguro
            Ctrl->>DB: Insertar Registro Patrimonial
            DB-->>Ctrl: Retorna modelo con UUID
            Ctrl->>DB: Insertar relación en tabla Archivos
            DB-->>Ctrl: OK
            Ctrl-->>GUI: Redirigir a Catálogo con Éxito
            GUI-->>Admin: "Documento preservado correctamente"
        end
    end
```

---

### 4. Casos de Uso del Sistema
Sistema basado en permisos dinámicos y roles jerárquicos.

```mermaid
flowchart LR
    Guest(["Visitante (Anónimo)"])
    User(["Usuario Registrado"])
    Pub(["Publicador"])
    Admin(["Administrador"])

    subgraph "Sistema Gestor de Contenido"
        UC1("Consultar Catálogo de Registros")
        UC2("Visualizar Efemérides en Portal")
        UC3("Iniciar Sesión")
        UC4("Dejar Comentarios en Registros")
        UC5("Añadir/Quitar Marcadores")
        UC6("Ingresar Nuevos Registros Históricos")
        UC7("Archivar/Eliminar Registros Históricos")
        UC8("Moderar Comentarios")
    end

    Guest --> UC1
    Guest --> UC2

    User --> UC3
    User --> UC1
    User --> UC4
    User --> UC5

    Pub --> UC3
    Pub --> UC1
    Pub --> UC6

    Admin --> UC3
    Admin --> UC6
    Admin --> UC7
    Admin --> UC8
```

---

### 5. Plan de Acción y Ejecución Temporal
Visualización de los ciclos de desarrollo iterativo (Sprints).

```mermaid
gantt
    title Cronograma SGC (12 Semanas)
    dateFormat  YYYY-MM-DD
    section Fase 1: Análisis y Base
    Levantamiento de Info y Arquitectura :a1, 2026-03-01, 14d
    Wireframes e Identidad Visual        :a2, after a1, 7d
    section Fase 2: Core Funcional
    Migraciones y Roles Autenticados     :b1, 2026-03-22, 10d
    Lógica de Archivos y CRUD            :b2, after b1, 14d
    Portal Frontend y Buscador           :b3, after b2, 7d
    section Fase 3: Módulos Avanzados
    Discusión (Comentarios) y Favoritos  :c1, 2026-04-22, 10d
    Setup CI/CD y Documentación Final    :c2, after c1, 7d
```

---