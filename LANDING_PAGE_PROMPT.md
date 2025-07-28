# Cursor Prompt: Update Landing Page for pipandprofit.com

## Objective
Update the landing page design for the Forex/Volatility course platform (`pipandprofit.com`) based on the following design guidelines inspired by Learna Index-5, while ensuring the brand identity remains unique and tailored to financial education.

---

## General Aesthetic
- **Modern & Minimalist**: White space, clean typography (sans-serif), clear font hierarchy, generous line height.
- **Color Palette**: Soft gradients (teal, aqua, midnight blue) for section transitions. Dark navy for contrast sections and footer. Accent: turquoise/emerald for CTAs.
- **Icons & Illustrations**: Replace educational icons with financial/trading icons (charts, candlesticks, bull/bear, shields). Use consistent line style and pastel accents.
- **Imagery**: Use high-quality stock images or illustrations of traders, financial charts, laptops with market analysis screens. Add overlapping/floating cards for depth.
- **Micro-interactions**: Hover states on buttons/cards, subtle scroll animations.

---

## Layout & Structure

### 1. Sticky Header
- Logo (top-left), responsive hamburger menu for mobile.
- Navigation links: Home, Courses, Pricing, Testimonials, FAQ, Blog, Contact.
- CTA button: "Start Trading Now" or "Enroll in Course" in accent color with hover effect.

### 2. Hero Section
- Gradient background (teal → midnight blue) with abstract patterns.
- Headline: "Master Forex & Volatility Trading"
- Subheading: "Learn to navigate the markets, manage risk, and trade confidently."
- Primary CTA: "Get Started" + secondary link: "Watch Intro Video" (modal popup).
- Key stats: "5K+ Students", "Top-rated Mentor", "Live Market Sessions" displayed in badges.

### 3. Course/Module Categories
- Heading: "Your Trading Journey"
- Responsive card grid with module name, icon, short description, pill labels for lessons/hours, and hover scale effect.

### 4. Featured Courses
- Sidebar filter for Beginner, Intermediate, Advanced.
- Course cards: thumbnail, instructor photo/name, course title, rating, students, price (discount format optional), "Join Today" button.

### 5. Value Proposition Banner
- Full-width dark section with bold text (e.g., "Trade" or "Profit") in outline style, accent color icon, CTA button.

### 6. Feature Highlights
- Two-column layout: overlapping image + feature list (icons, short headings, CTA).

### 7. Pricing Plans
- Toggle for Monthly/Annual billing.
- Feature comparison table + plan cards for Basic, Pro, Elite with CTAs.

### 8. Testimonials
- White cards, star ratings, testimonial quotes, reviewer photo/name.

### 9. Instructor/Partner CTA
- Gradient background: "Become a Mentor" + Apply button.

### 10. FAQ Section
- Accordion-style collapsible questions with smooth animation.

### 11. Blog Section
- Grid of blog cards (image, category tag, title, excerpt).

### 12. Footer
- Dark background with 3-column layout: About + Links + Newsletter.
- Sub-footer: copyright, legal links.

---

## Action Steps for Cursor
1. Open the current `resources/js/Pages/LandingPage.vue` or equivalent landing page file.
2. Redesign the layout following the above sections in order.
3. Apply **TailwindCSS utility classes** for gradients, spacing, hover effects, and responsiveness.
4. Use placeholder images and icons now; we’ll replace them with real assets later.
5. Implement **sticky header** with responsive navbar and CTA.
6. Add **scroll-based animations** using Tailwind's `transition` utilities and Vue transitions.
7. Ensure **fully responsive design** for all sections (desktop, tablet, mobile).
8. Use **semantic HTML structure** for SEO (h1 for hero headline, h2 for section titles).
9. Keep copy placeholders minimal but descriptive (avoid lorem ipsum).
10. Save and test responsiveness on multiple screen sizes.

---

## Notes
- Maintain consistent spacing (use Tailwind padding/margin scale).
- Use gradient backgrounds for hero, feature highlights, and FAQ panels.
- Apply dark mode elements to footer and banners for contrast.
- Make sure CTAs are visually prominent and consistent across the page.

---

**Goal:** Deliver a professional, finance-themed landing page that feels modern, engaging, and user-focused, while adhering to the structure and polish of premium learning platforms like Teachable and Udemy.
