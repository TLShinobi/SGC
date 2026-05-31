# Sistema Gestor de Contenido (SGC) - Memoria Castrense

El **SGC Memoria Castrense** es una plataforma web institucional orientada a la preservación, catalogación y discusión colaborativa de documentos históricos militares (fotografías, actas, mapas estratégicos, entre otros).

El proyecto garantiza la **Paridad de Entornos**, utiliza **Arquitectura Monolítica** en Laravel (PHP) con motor **PostgreSQL/SQLite** e implementa **Integración Continua (CI/CD)**. Todo el desarrollo se rige bajo estrictas políticas de [CONTRIBUTING.md](CONTRIBUTING.md).

---

## 🏗️ Arquitectura como Código (Doc-as-Code)

A continuación, se renderiza nativamente toda la ingeniería de software aplicada en el sistema.

### 1. Diagrama de Arquitectura de Despliegue

```mermaid
flowchart TD
    Cliente["Navegador del Historiador"]
    
    subgraph Servidor_Nube ["Servidor Monolítico en la Nube"]
        Laravel["Aplicación Laravel (Backend + Frontend)"]
        PostgreSQL[("Base de Datos SQL")]
        LocalVol["Disco Local (Archivos Físicos)"]
    end
    
    Cliente -->|"Tráfico HTTPS"| Laravel
    Laravel -->|"Vistas HTML / CSS"| Cliente
    Laravel -->|"Consultas ORM"| PostgreSQL
    Laravel -->|"Lectura / Escritura"| LocalVol
```

---

### 2. Diagrama Entidad-Relación (ER)

```mermaid
erDiagram
    USERS ||--o{ REGISTROS_PATRIMONIALES : "crea (created_by)"
    CATEGORIAS ||--o{ REGISTROS_PATRIMONIALES : "clasifica"
    REGISTROS_PATRIMONIALES ||--o{ ARCHIVOS : "posee (1:N)"
    USERS ||--o{ COMENTARIOS : "escribe"
    REGISTROS_PATRIMONIALES ||--o{ COMENTARIOS : "recibe"
    USERS }|--|{ REGISTROS_PATRIMONIALES : "guarda_marcador"

    USERS {
        BIGINT id PK
        VARCHAR name
        VARCHAR email
        VARCHAR password
        VARCHAR role
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

```mermaid
sequenceDiagram
    actor Admin as Administrador
    participant GUI as Interfaz Web
    participant Ctrl as Controlador
    participant Disk as Almacenamiento
    participant DB as Motor SQL

    Admin->>GUI: Sube formulario y PDF
    GUI->>Ctrl: POST /ingesta
    Ctrl->>Ctrl: Validación de request
    
    alt Datos inválidos
        Ctrl-->>GUI: Redirigir con errores
        GUI-->>Admin: Muestra alertas rojas
    else Datos válidos
        Ctrl->>Disk: Guardar archivo fisico
        
        alt Falla de disco
            Disk-->>Ctrl: Exception / Error
            Ctrl-->>GUI: Retorna Error 500
            GUI-->>Admin: Muestra error del sistema
        else Almacenamiento exitoso
            Disk-->>Ctrl: Retorna ruta del archivo
            Ctrl->>DB: Insertar Registro
            DB-->>Ctrl: OK UUID
            Ctrl->>DB: Insertar relación Archivo
            DB-->>Ctrl: OK
            Ctrl-->>GUI: Redirigir a Catálogo
            GUI-->>Admin: Mensaje de Exito
        end
    end
```

---

### 4. Casos de Uso del Sistema

```mermaid
flowchart LR
    Guest(["Visitante Anónimo"])
    User(["Usuario Registrado"])
    Pub(["Publicador / Archivista"])
    Admin(["Administrador"])

    subgraph SGC ["Sistema Gestor de Contenido"]
        UC1("Consultar Catálogo Público")
        UC2("Ver Efemérides Históricas")
        UC3("Iniciar Sesión")
        UC4("Comentar Registros")
        UC5("Gestionar Favoritos")
        UC6("Subir Nuevos Documentos")
        UC7("Archivar Documentos (Soft Delete)")
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

```mermaid
gantt
    title Cronograma SGC (12 Semanas)
    dateFormat  YYYY-MM-DD
    section Analisis
    Levantamiento de Info y Arquitectura :a1, 2026-03-01, 14d
    Wireframes e Identidad Visual        :a2, after a1, 7d
    section Desarrollo
    Migraciones y Roles Autenticados     :b1, 2026-03-22, 10d
    Logica de Archivos y CRUD            :b2, after b1, 14d
    Portal Frontend y Buscador           :b3, after b2, 7d
    section Cierre
    Discusion y Favoritos                :c1, 2026-04-22, 10d
    Setup CI/CD y Documentacion          :c2, after c1, 7d
```

---
> Proyecto académico desarrollado para la materia Implantación de Sistemas (2026). Equipo: Eduardo Rojas & Ernesto Polanco.