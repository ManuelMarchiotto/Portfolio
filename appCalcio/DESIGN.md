# Design System Strategy: The Kinetic Lens

## 1. Overview & Creative North Star
**Creative North Star: "The Kinetic Lens"**
In the world of professional soccer analytics, data is not static; it is a living, breathing representation of high-velocity movement and split-second decisions. This design system rejects the "SaaS-template" look in favor of a high-performance, editorial aesthetic that feels more like a tactical command center than a spreadsheet.

The "Kinetic Lens" focuses on **Aggressive Precision**. We break the traditional rigid grid through intentional asymmetry—using large, bleeding typography scales (Space Grotesk) against dense, high-utility data clusters (Inter). By layering translucent surfaces and utilizing vibrant, electric accents, we create a sense of depth and momentum, ensuring the user feels the speed of the game within the data.

---

## 2. Colors & Surface Philosophy
The palette is rooted in deep space blacks and tactical greys, allowing our high-energy primary and secondary tokens to "pop" with radioactive intensity.

### The "No-Line" Rule
**Borders are forbidden for sectioning.** To define boundaries, you must use background tonal shifts.
- A `surface-container-low` card sits on a `surface` background.
- A `surface-container-high` header anchors a `surface-container` body.
- Contrast is achieved through value, not outlines.

### Surface Hierarchy & Nesting
Treat the UI as a physical stack of technical glass. 
*   **Base:** `surface` (#0c0e12)
*   **Primary Containers:** `surface-container-low` (#111318) for large section blocks.
*   **Interactive Elements:** `surface-container-high` (#1d2025) for nested data widgets.
*   **Floating/Active:** `surface-container-highest` (#23262c) for elements that require immediate focus.

### The "Glass & Gradient" Rule
To elevate the platform, use Glassmorphism for floating overlays (Modals, Hover Tooltips). Apply `surface-variant` at 60% opacity with a `backdrop-filter: blur(12px)`. 
**Signature CTA Texture:** Use a linear gradient for primary buttons: `primary` (#aaffdc) to `primary-container` (#00fdc1) at a 135-degree angle. This adds a "lithium-ion" glow that flat colors lack.

---

## 3. Typography: The Industrial Editorial
We utilize a dual-font system to balance character with raw data density.

*   **Display & Headlines (Space Grotesk):** This is our "Editorial" voice. It is wide, technical, and aggressive. Use `display-lg` for match scores and `headline-md` for player names. Set letter-spacing to `-0.02em` for headlines to create a tighter, high-end feel.
*   **Body & Labels (Inter):** This is our "Functional" voice. Highly legible at small sizes. 
*   **Data Density:** For statistics (Expected Goals, Pass Completion), use `title-lg` with a "Semi-Bold" weight. The high-density layout relies on the `label-sm` token for metadata—keep these in `on-surface-variant` (#aaabb0) to maintain hierarchy.

---

## 4. Elevation & Depth
We eschew traditional drop shadows for **Tonal Layering**.

*   **The Layering Principle:** A player's heat map card should use `surface-container-lowest` (#000000) when placed on a `surface-container-low` dashboard. This creates a "recessed" look, making the data feel embedded in the interface.
*   **Ambient Shadows:** If a card must float (e.g., a predictive pop-over), use a shadow: `offset: 0 24px, blur: 48px, color: rgba(0, 0, 0, 0.5)`. Never use pure black shadows on non-black surfaces; tint the shadow with a hint of `primary` to simulate light bounce.
*   **The "Ghost Border" Fallback:** If a data table requires a separator for accessibility, use `outline-variant` (#46484d) at **15% opacity**. It should be felt, not seen.

---

## 5. Components

### Buttons
*   **Primary:** Gradient (`primary` to `primary-container`), black text (`on-primary`), `md` (0.375rem) roundedness.
*   **Secondary:** Ghost style. `outline` color for text, no background, 10% `primary` opacity on hover.
*   **Tertiary:** Text-only using `secondary` (#00e3fd).

### Data Tables & Lists
*   **Rule:** No dividers. Use `surface-container-low` for even rows and `surface-container` for odd rows, or simply 1.5 spacing units of vertical gap.
*   **Leading Elements:** Use `primary-dim` circular avatars for team logos to create a unified technical look.

### Match Cards & Predictive Indicators
*   **The "Momentum" Bar:** Use `secondary` (#00e3fd) for home team momentum and `tertiary` (#bcff5f) for away. Use a subtle glow (`box-shadow: 0 0 10px`) on the active "attacking" side.
*   **Predictive Tags:** Use `surface-bright` backgrounds with `on-surface` text and a 2px left-side accent border in `primary`.

### Performance Charts
*   **Line Graphs:** Use a 2px stroke width. The area under the curve should use a gradient from `primary` (20% opacity) to transparent.
*   **Data Points:** Only show nodes on hover to keep the "Sleek" aesthetic.

---

## 6. Do’s and Don’ts

### Do:
*   **Do** use `primary_fixed_dim` for non-interactive data highlights to avoid over-stimulating the eye.
*   **Do** use "Asymmetric Padding." Give your Headline-lg more "breathing room" (Spacing 16) at the top than the bottom to create an editorial flow.
*   **Do** use `9999px` (full) roundedness for status chips (e.g., "LIVE" or "VAR") to distinguish them from square data cards.

### Don't:
*   **Don't** use 1px white or light grey borders. It breaks the "Kinetic Lens" immersion.
*   **Don't** use "pure" red for negative stats unless it's a critical error. Use `error_dim` (#d7383b) to keep the palette sophisticated.
*   **Don't** crowd the charts. If a chart has more than 5 variables, use a "focus mode" that expands the container using `surface-container-highest`.

## 7. Frontend Program
* HTML
* CSS
* javaScript

# 8. Backend Program
* PHP and Laravel OR python and Django