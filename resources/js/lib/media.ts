// Theme assets live under public/assets/img and are served locally. DB-driven
// images already arrive as resolved URLs from App\Support\Media (absolute,
// /assets/…, or /storage/…) so those pass straight through img().
// ponytail: Cloudinary delivery deferred (PRD Phase 2). When assets are uploaded
// and CLOUDINARY_CLOUD_NAME is live, point cld() at res.cloudinary.com/<cloud>/…
const BASE = '/assets/img'

/** Local theme asset by its path relative to assets/img, e.g. 'hero-bg.jpg'. */
export function cld(rel: string): string {
  return `${BASE}/${rel.replace(/^\/+/, '')}`
}

/** Local /public asset (non-theme), e.g. build output. */
export function asset(path: string): string {
  return `/${path.replace(/^\/+/, '')}`
}

/** Use `src` when present (already a resolved URL), else a theme-asset fallback. */
export function img(src?: string | null, fallbackRel = 'logo-mark.png'): string {
  return src && src.length > 0 ? src : cld(fallbackRel)
}
