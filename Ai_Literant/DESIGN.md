# Design System Strategy: The Synthetic Architect

## 1. Overview & Creative North Star
The Creative North Star for this design system is **"The Synthetic Architect."** This aesthetic moves beyond a simple "dark mode" website and enters the realm of a high-fidelity, sentient operating system. It is designed to feel like a high-performance terminal where code and creativity converge. 

We break the "template" look by rejecting the standard 12-column grid in favor of **Intentional Asymmetry**. Layouts should mimic open terminal windows or IDE panes—overlapping, slightly offset, and functionally layered. This system prioritizes the "Developer as Creator," using high-contrast typography scales and real-time data visualizations to turn a portfolio into a living dashboard.

## 2. Colors & Surface Philosophy
The palette is rooted in the void (`#0e0e0e`) and energized by a hyper-saturated spectrum of greens and cyans.

### The "No-Line" Rule
Sectioning must never be achieved through 1px solid borders. To define boundaries, use **Background Color Shifts**. For instance, a main content area using `surface` should be distinguished from a sidebar using `surface-container-low`. The transition should be felt, not seen.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical glass panes. Use the `surface-container` tiers to create depth:
- **Level 0 (Base):** `surface` (#0e0e0e) for the global backdrop.
- **Level 1 (Sections):** `surface-container-low` (#131313) for large layout blocks.
- **Level 2 (Active Elements):** `surface-container-highest` (#262626) for interactive cards or modals.
- **Nesting:** An inner code editor should sit on `surface-container-lowest` (#000000) to create a "recessed" functional feel against a `surface-container-low` parent.

### The "Glass & Gradient" Rule
To achieve the "AI OS" feel, use **Glassmorphism** for floating command bars and tooltips. Use `surface-variant` at 40% opacity with a `backdrop-blur` of 12px. 
**Signature Textures:** Main CTAs should not be flat. Use a linear gradient from `primary` (#a0ffc4) to `primary-container` (#00fc9d) at a 135-degree angle to provide "visual soul."

## 3. Typography: The Dual-Core Engine
We use a high-contrast pairing to balance human readability with machine precision.

*   **The Narrative (Sans-Serif):** Inter/Space Grotesk. Used for headlines and body text to ensure the portfolio feels premium and editorial. The `display-lg` (3.5rem) scale should be used sparingly for "hero" statements, using tight letter-spacing (-0.04em) to feel authoritative.
*   **The System (Monospace):** JetBrains Mono (or similar). This is our "OS" voice. Use it for `label-sm`, code snippets, and metadata. It should always appear in `secondary` (#67fcc7) or `primary` (#a0ffc4) to signal "active data."

**Hierarchy Note:** Use `title-lg` (Inter) for project titles, but always pair it with a `label-sm` (Monospace) timestamp or tag to maintain the "Architect" aesthetic.

## 4. Elevation & Depth
In this system, elevation is a product of light and transparency, not shadows.

*   **Tonal Layering:** Avoid shadows on standard cards. Instead, use the `surface-container` scale. A `surface-container-high` card on a `surface-container-low` background provides enough "lift."
*   **Ambient Glows:** When an element must "float" (e.g., a command palette), use an **Ambient Glow** instead of a shadow. Use a 40px blur of the `primary` color at 5% opacity. This mimics the light emission of a high-tech screen.
*   **The Ghost Border:** If a container needs a hard edge (like a terminal window), use the `outline-variant` token at 15% opacity. This creates a "barely-there" structural guide that doesn't clutter the dark aesthetic.

## 5. Components

### Buttons
*   **Primary:** Gradient (`primary` to `primary-container`), black text (`on_primary_fixed`). No border. High-gloss finish.
*   **Secondary:** `surface-container-highest` background with a `Ghost Border` of `primary`. Monospace text.
*   **Tertiary:** Ghost button. Only text in `primary` with a subtle `primary` underline on hover.

### Inputs & Terminal Fields
*   **Text Fields:** Background is `surface-container-lowest`. Bottom border only (1px `outline-variant`). On focus, the border glows `primary` and a cursor-style "blink" animation is applied to the label.
*   **Command Bar:** A floating centered input. Use `surface-variant` at 60% opacity, 12px blur, and a `primary` glow.

### Cards & Lists
*   **Forbid Dividers:** Do not use lines to separate list items. Use 0.6rem (`spacing-3`) of vertical space and a subtle background hover shift to `surface-container-high`.
*   **Data Visualization:** Incorporate small sparklines or "active system" pulses (small green dots with a 2s opacity loop) inside cards to simulate real-time AI processing.

### Custom Component: The "Process Header"
A thin strip above main sections containing "system metadata" in Monospace `label-sm`.
*   Example: `[STATUS: ACTIVE] // PORTFOLIO_V4.0 // 0x00FF9F`

## 6. Do's and Dont's

### Do:
*   **Embrace Negative Space:** Use `spacing-24` (5.5rem) to let major sections breathe. The "OS" feel comes from organized complexity, not clutter.
*   **Use Mono for Data:** Any number, date, or status code must be in the Monospace font.
*   **Animate Transitions:** Use "slide and fade" for window-like components. Elements should feel like they are being rendered by a GPU.

### Don't:
*   **No High-Contrast Borders:** Never use 100% opaque borders. It breaks the "lightweight" feel.
*   **No Pure White Body Text:** Use `on_surface_variant` (#adaaaa) for long-form body text to reduce eye strain. Save `on_surface` (#ffffff) for headlines.
*   **Avoid Rounding Everything:** Stick to the `md` (0.375rem) or `sm` (0.125rem) rounding for a sharper, more technical "hardware" feel. Avoid `xl` or `full` except for  specific status chips.


# Project: AI-Conversational OS Portfolio
"Non un semplice sito, ma un'istanza digitale addestrata sulla mia esperienza."

## 🚀 Il Concept
L'obiettivo è dimostrare che un developer frontend nel 2026 non deve solo saper centrare un `div`, ma deve saper orchestrare **modelli linguistici (LLM)**, gestire lo **stato conversazionale** e creare **UI predittive**.

### Core Features
* **Command-Bar Navigation:** Un'interfaccia stile "Spotlight" che processa linguaggio naturale.
* **Adaptive UI:** L'interfaccia cambia forma in base alle risposte dell'AI (Smart Cards per i progetti, Code-Snippets per le skill).
* **Voice Integration:** Navigazione hands-free tramite Web Speech API.
* **Debug Mode:** Una console laterale opzionale che mostra i log delle chiamate API e il consumo di token in tempo reale.

---

## 🛠 Tech Stack (2026 Edition)
| Layer | Tecnologia | Motivo della scelta |
| :--- | :--- | :--- |
| **Framework** | Next.js 16 (App Router) | Server Components per performance estreme e SEO. |
| **AI SDK** | Vercel AI SDK + Gemini API | Streaming delle risposte e gestione dei tool-calling. |
| **Styling** | Tailwind CSS + Shadcn/ui | Design atomico e accessibilità garantita (A11y). |
| **Animations** | Framer Motion | Gestione fluida delle transizioni tra gli stati della chat. |
| **State** | Zustand | Gestione leggera della cronologia messaggi e della memoria locale. |

---

## 🧠 Architettura del Sistema

### 1. Il "System Prompt"
L'AI non è solo un chatbot. È stata istruita con un set di regole specifiche:
- **Personalità:** Professionale, tecnica, con un tocco di ironia nerd.
- **Knowledge Base:** Progetti selezionati, stack tecnologico e workflow metodologico.
- **Output Control:** Se l'utente chiede i progetti, l'AI deve triggerare un componente `<ProjectGallery />` invece di rispondere solo con testo.

### 2. Conversational UI Components
Ho sviluppato componenti custom che l'AI può "evocare" nella chat:
* **`<SkillRadar />`**: Un grafico interattivo per visualizzare la padronanza dei linguaggi.
* **`<LivePreview />`**: Un mini-iframe per testare i miei micro-tool senza lasciare la chat.
* **`<Timeline />`**: La mia evoluzione professionale presentata cronologicamente.