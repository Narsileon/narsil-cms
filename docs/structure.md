# Structure

CMS provides content-management models and backend features.

```text
.  # Narsil CMS root
├── database/  # Database files
│   └── migrations/  # Database migrations
├── docs/  # Documentation
│   ├── commands/  # Command documentation
│   │   ├── index.md  # Command index
│   │   ├── narsil-skills.md  # Narsil Skills check and fix commands
│   │   └── pint.md  # PHP formatting commands
│   ├── index.md  # Documentation index
│   └── structure.md  # Root structure reference
├── lang/  # Translations
│   ├── de/  # German translations
│   ├── en/  # English translations
│   └── fr/  # French translations
├── resources/  # Resources
│   ├── css/  # Stylesheets
│   ├── js/  # Alpine and Livewire browser integrations
│   │   └── live-editor/  # Live Editor preview bridge and Alpine adapter
│   │       └── core/  # Shared preview logic
│   └── views/  # Blade pages and components
│       ├── components/  # Blade component groups
│       │   └── blocks/  # CMS feature blocks
│       │       ├── input/  # Input builder components
│       │       ├── live-editor/  # Live Editor components
│       │       └── status/  # Status components
│       ├── live-editor/  # Live Editor preview views
│       └── pages/  # CMS pages
│           ├── resources/  # Resource pages
│           └── summary/  # Summary pages
├── routes/  # HTTP routes
└── src/  # PHP source
    ├── Agents/  # AI agents
    ├── Console/  # Console commands
    │   └── Commands/  # Console commands
    │       └── stubs/  # Command stubs
    ├── Contracts/  # Contract definitions
    │   ├── Actions/  # Action contract definitions
    │   │   ├── Blocks/  # Block contract definitions
    │   │   ├── Elements/  # Element contract definitions
    │   │   ├── Entities/  # Entity contract definitions
    │   │   ├── Fields/  # Field contract definitions
    │   │   ├── Footers/  # Footer contract definitions
    │   │   ├── Headers/  # Header contract definitions
    │   │   ├── Hosts/  # Host contract definitions
    │   │   ├── LiveEditor/  # Live editor contract definitions
    │   │   ├── Sites/  # Site contract definitions
    │   │   └── Templates/  # Template contract definitions
    │   ├── Forms/  # Form contract definitions
    │   │   └── LiveEditor/  # Live editor contract definitions
    │   ├── Menus/  # Menu contract definitions
    │   ├── Requests/  # Request contract definitions
    │   └── Resources/  # Resource contract definitions
    ├── Database/  # Database files
    │   ├── Factories/  # Eloquent model factories
    │   ├── Migrations/  # Database migrations
    │   └── Seeders/  # Database seeders
    │       ├── Blocks/  # Block seeders
    │       ├── Fields/  # Field seeders
    │       └── Templates/  # Template seeders
    ├── Definitions/  # Resource definitions
    ├── Enums/  # Application enums
    │   └── SEO/  # SEO enums
    ├── Http/  # HTTP request handling
    │   ├── Collections/  # HTTP collection classes
    │   ├── Controllers/  # HTTP controllers
    │   │   ├── Collections/  # Collection controllers
    │   │   ├── Entities/  # Entity controllers
    │   │   ├── LiveEditor/  # Live editor controllers
    │   │   ├── Sitemaps/  # Sitemaps controllers
    │   │   └── Sites/  # Site controllers
    │   │       └── Pages/  # Page controllers
    │   ├── Data/  # HTTP data objects
    │   │   └── Forms/  # Form data objects
    │   │       └── Inputs/  # Input data objects
    │   ├── Middleware/  # HTTP middleware
    │   └── Resources/  # HTTP response resources
    │       ├── LiveEditor/  # Live editor HTTP resources
    │       ├── SitePages/  # Site pages HTTP resources
    │       └── Sites/  # Site HTTP resources
    ├── Implementations/  # Contract implementations
    │   ├── Actions/  # Action contract implementations
    │   │   ├── Blocks/  # Block contract implementations
    │   │   ├── Elements/  # Element contract implementations
    │   │   ├── Entities/  # Entity contract implementations
    │   │   ├── Fields/  # Field contract implementations
    │   │   ├── Footers/  # Footer contract implementations
    │   │   ├── Headers/  # Header contract implementations
    │   │   ├── Hosts/  # Host contract implementations
    │   │   ├── LiveEditor/  # Live editor contract implementations
    │   │   ├── Sites/  # Site contract implementations
    │   │   └── Templates/  # Template contract implementations
    │   ├── Forms/  # Form contract implementations
    │   │   └── LiveEditor/  # Live editor contract implementations
    │   ├── Hooks/  # Lifecycle hooks
    │   │   ├── Footers/  # Footer hooks
    │   │   ├── Hosts/  # Host hooks
    │   │   └── Templates/  # Template hooks
    │   ├── Menus/  # Menu contract implementations
    │   ├── Requests/  # Request contract implementations
    │   ├── Resources/  # Resource contract implementations
    │   └── Tables/  # Table contract implementations
    ├── Jobs/  # Background jobs
    ├── Livewire/  # Livewire components
    ├── Models/  # Eloquent models
    │   ├── Collections/  # Collection models
    │   ├── Entities/  # Entity models
    │   ├── Globals/  # Globals models
    │   ├── Hosts/  # Host models
    │   ├── Pages/  # Page models
    │   └── Sites/  # Site models
    ├── Observers/  # Eloquent model observers
    ├── Policies/  # Eloquent model policies
    ├── Providers/  # Laravel service providers
    ├── Services/  # Application services
    │   ├── Ai/  # AI services
    │   ├── LiveEditor/  # Live Editor services
    │   ├── Pages/  # Page services
    │   └── Sites/  # Site services
    ├── Support/  # Application support code
    │   └── Facades/  # Service facades
    ├── Traits/  # Shared traits
    └── View/  # Blade view components
        └── Components/  # CMS component groups
            └── Blocks/  # CMS feature blocks
```
