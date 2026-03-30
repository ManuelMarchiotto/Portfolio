```markdown
# Design System Document: The Architectural Gallery

## 1. Overview & Creative North Star
The Creative North Star for this design system is **"The Digital Curator."** 

In a physical high-end gallery, the architecture is designed to disappear, allowing the art to breathe. This system adopts the "White Cube" aesthetic—an environment of immense clarity, light, and silence. We break the "template" look by rejecting the rigid, boxy constraints of traditional web grids. Instead, we embrace **intentional asymmetry** and **expansive negative space**. 

By utilizing floating frames and layered tonal depth, we create a UI that feels less like a website and more like a curated physical space. The goal is to evoke a sense of prestige and calm, where every interaction is a deliberate, quiet movement through a high-end exhibition.

---

## 2. Colors & Tonal Atmosphere
Our palette is a study in monochromatic nuance. We move beyond simple "black and white" by utilizing a sophisticated range of surface tiers to define space.

### The Palette
- **Primary Surface:** `surface` (#f8f9fa) – The foundation of our "White Cube."
- **Core Accent:** `primary` (#000000) – Reserved strictly for high-contrast typography and essential CTAs.
- **Tonal Depth:** `surface-container-low` (#f3f4f5) through `surface-container-highest` (#e1e3e4).

### The "No-Line" Rule
**Explicit Instruction:** Do not use 1px solid borders to section content. Boundaries must be invisible. Divide sections using background shifts (e.g., a `surface-container-low` section placed against a `surface` background) or by using the `20` (7rem) spacing token to create a "void" that signals a transition.

### Surface Hierarchy & Nesting
Treat the UI as a series of physical layers. 
- Place `surface-container-lowest` (#ffffff) cards on top of a `surface-container` (#edeeef) section to create a soft, natural lift.
- **Glassmorphism:** For overlays or navigation menus, use `surface` with a 70% opacity and a `20px` backdrop-blur. This allows the artwork underneath to bleed through softly, maintaining the "White Cube" light quality.

### Signature Textures
Use subtle linear gradients for primary buttons, transitioning from `primary` (#000000) to `primary_container` (#3c3b3b). This prevents the black from feeling "flat" and adds a microscopic level of 3D depth.

---

## 3. Typography: The Architectural Voice
Typography is our primary decorative element. We use a high-contrast pairing to mimic editorial museum catalogs.

- **The Display Voice (Manrope):** Used for exhibition titles and hero statements. `display-lg` (3.5rem) should be used with tight letter-spacing (-0.02em) to feel like architectural lettering.
- **The Narrative Voice (Inter):** Used for all functional UI and body copy. Inter’s tall x-height provides the "innovative" feel required while maintaining elite readability.
- **Hierarchy as Identity:** 
    - **Captions:** Use `label-md` in `secondary` (#5f5e5e) for artwork metadata.
    - **Headlines:** `headline-lg` in `primary` (#000000) provides the "anchor" for a page, often placed asymmetrically to the left or right to break the center-aligned cliché.

---

## 4. Elevation & Depth: Tonal Layering
We do not use shadows to show "height"; we use shadows to show "atmosphere."

- **The Layering Principle:** Stack `surface-container` tiers. A `surface-container-highest` card on a `surface` background creates a "recessed" or "inset" look, mimicking a wall niche.
- **Ambient Shadows:** For floating frames (like artwork previews), use a "Soft Light" shadow: 
    - `Box-shadow: 0 20px 40px rgba(25, 28, 29, 0.04);`
    - The shadow color is a tinted version of `on-surface`, never pure gray.
- **The Ghost Border Fallback:** If a border is required for accessibility, use `outline-variant` (#c6c6c6) at **15% opacity**. It should be felt, not seen.

---

## 5. Components

### Floating Frames (Cards)
- **Styling:** No borders. `0px` radius (strictly sharp edges).
- **Depth:** Use `surface-container-lowest` (#ffffff) with the Ambient Shadow defined above.
- **Interaction:** On hover, the shadow should slightly expand, and the image should subtly scale (1.02x) to mimic the viewer stepping closer.

### Primary Buttons
- **Shape:** `0px` (Sharp).
- **Color:** `primary` (#000000) background with `on-primary` (#e5e2e1) text.
- **Spacing:** Generous horizontal padding using `8` (2.75rem) to emphasize the "spacious" brand personality.

### Navigation Cues (The Sleek Nav)
- **Global Nav:** A glassmorphic bar at the top using `surface-container-lowest` at 80% opacity. 
- **Active State:** Use a 2px horizontal bar in `primary` (#000000) positioned *above* the text, or a simple shift from `secondary` to `primary` color.

### Input Fields
- **Styling:** Underline only. Use `outline` (#777777) for the bottom border. 
- **States:** On focus, the border transitions to `primary` (#000000) and the label (Inter, `label-sm`) floats upward into the negative space.

### Additional Component: The "Curator’s Label" (Tooltips)
- **Visuals:** `surface-container-highest` (#e1e3e4) background with `on-surface` (#191c1d) text. 
- **Animation:** A soft fade-in with a 5px vertical slide to mimic the grace of a gallery guide.

---

## 6. Do’s and Don’ts

### Do:
- **Use White Space as a Material:** Treat empty space (token `24` / 8.5rem) as a physical element in your layout. It is as important as the content.
- **Embrace Asymmetry:** Place a `headline-lg` on the left and a small `body-md` block on the far right to create a sophisticated, editorial tension.
- **Use "Sharp" Geometry:** Keep all corner radii at `0px`. Roundness conveys "playful"; sharp edges convey "prestigious" and "architectural."

### Don’t:
- **Don’t use Dividers:** Never use a horizontal line to separate two items in a list. Use a `3` (1rem) spacing gap and a subtle background color shift.
- **Don’t Over-Shadow:** If more than three elements on a screen have shadows, the "White Cube" effect is lost. Shadows should be rare and intentional.
- **Don’t Use Pure Blue for Links:** All interactive text should be `primary` (#000000) with a `1px` underline, or `secondary` (#5f5e5e) transitioning to black.