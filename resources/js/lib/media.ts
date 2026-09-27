// Theme assets live under public/assets/img. Once synced to Cloudinary
// (`php artisan cloudinary:sync-assets`, public_id = les-renang/<path-no-ext>),
// cld() delivers them from the CDN with f_auto,q_auto. If VITE_CLOUDINARY_CLOUD_NAME
// is unset it falls back to the local /assets/img path, so dev without a cloud works.
// DB-driven images already arrive as resolved URLs from App\Support\Media, so those
// pass straight through img().
const BASE = '/assets/img'
const CLOUD = import.meta.env.VITE_CLOUDINARY_CLOUD_NAME as string | undefined

/** Theme asset by its path relative to assets/img, e.g. 'teacher/abo-1.jpg'. */
export function cld(rel: string): string {
  const clean = rel.replace(/^\/+/, '')
  if (CLOUD) {
    const id = clean.replace(/\.[^/.]+$/, '') // drop ext → matches sync-assets public_id
    return `https://res.cloudinary.com/${CLOUD}/image/upload/f_auto,q_auto/les-renang/${id}`
  }
  return `${BASE}/${clean}`
}

/** Local /public asset (non-theme), e.g. build output. */
export function asset(path: string): string {
  return `/${path.replace(/^\/+/, '')}`
}

/** Use `src` when present (already a resolved URL), else a theme-asset fallback. */
export function img(src?: string | null, fallbackRel = 'logo-mark.png'): string {
  return src && src.length > 0 ? src : cld(fallbackRel)
}
