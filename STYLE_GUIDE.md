# Shera Viva - Architecture & Styling Guidelines

To ensure the codebase remains maintainable, well-structured, optimized, and dry, all developers must adhere to the following rules when building new features or refactoring existing ones.

---

## 1. Global View Layouts & DRY Principle

- **Extend Shared Layouts**: Always extend the base layout (`layouts.app`) for all customer/candidate facing views. Do NOT write standalone `<html>`, `<head>`, or `<body>` blocks inside view files.
- **Yield Custom scripts/styles**: If a page requires specific stylesheets or JavaScript, use `@section('styles')` or `@section('scripts')` which are yielded in the base layouts.
- **Do Not Duplicate Typography or CDNs**: All Google Fonts, FontAwesome icons, and core CDNs must load once in `layouts/app.blade.php`.

---

## 2. CSS & Tailwind First Principle

- **Use Tailwind Utility Classes**: Standard layout, spacing, coloring, sizing, and responsive actions must be handled entirely using Tailwind CSS utility classes (e.g., `flex items-center gap-4 bg-[#111827] text-white`).
- **Minimize Manual CSS**: Page-level `<style>` blocks should be minimized or completely eliminated.
- **Centralize Custom Styles**: Any recurring complex component styles (e.g. customized scrollbars, glassmorphism, specific animations, complex gradients) must be declared in the central CSS file: [app.css](file:///home/nadim/braincraft/sheraVivaAdminApi/resources/css/app.css).
- **Vite Compilation**: Always rely on Laravel Vite compilation. Never copy assets manually into the public directory unless they are static SVGs/logos.

---

## 3. Responsive Design & UX

- **Responsive Breakpoints**: Ensure all components work seamlessly on mobile, tablet, and desktop screens. Use Tailwind's prefix classes (`sm:`, `md:`, `lg:`, `xl:`) rather than raw custom `@media` queries.
- **Micro-Animations**: Enhance interactivity with smooth transitions (`transition-all duration-300 ease-in-out`), hover states (`hover:translate-y-[-2px] hover:shadow-lg`), and active animations (`animate-pulse`).
- **Standard Palette**: Use the curated dark-theme palette variables defined in the central theme config:
  - Obsidian Dark: `#090D1A`
  - Card Background: `rgba(17, 24, 39, 0.7)`
  - Emerald Primary: `#10B981`
  - Blue Accent: `#3B82F6`
  - Orange Warning: `#F59E0B`

---

## 4. PHP Code Style (Laravel Pint)

- Enforce standard Laravel formatting using **Laravel Pint**. 
- Run styling checks before committing:
  ```bash
  ./vendor/bin/pint --test
  ```
- To auto-format rules, run:
  ```bash
  ./vendor/bin/pint
  ```

---

## 5. Flutter Architecture (Mobile App)

- **Feature-driven Layering**: Place Flutter code under `lib/features/<feature_name>/` divided strictly into three clean-architecture layers:
  1. `data`: Models, datasources, and repository implementations.
  2. `domain`: Entities, repositories interfaces, and usecases.
  3. `presentation`: Controllers/Blocs, screens, and components/widgets.
- **Strict Lint Rules**: Conform to the rules configured in `analysis_options.yaml`. Ensure all files are checked:
  - Const constructors where applicable (`prefer_const_constructors`).
  - Safe cast handling (`strict-casts`).
  - Declare explicit return types (`always_declare_return_types`).
