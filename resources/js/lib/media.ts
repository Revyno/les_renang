// Cloudinary cloud name is PUBLIC (it appears in every delivery URL). Kept here
// to avoid threading it through props/hooks; also mirrored server-side in
// config/services.php. ponytail: read from the Inertia shared prop
// (cloudinary.cloudName) if it ever needs to differ per environment.
const CLOUD = 'dzqantey8'
const FOLDER = 'les-renang'

// Deliver a theme asset (originally under public/assets/img) via Cloudinary CDN.
// `rel` is the path relative to assets/img, e.g. 'teacher/abo-1.jpg'.
export function cld(rel: string, transform = 'f_auto,q_auto'): string {
  const id = rel.replace(/^\/+/, '').replace(/\.[a-z0-9]+$/i, '')
  return `https://res.cloudinary.com/${CLOUD}/image/upload/${transform}/${FOLDER}/${id}`
}

// Local /public asset (non-Cloudinary), e.g. build output or files not synced.
export function asset(path: string): string {
  return `/${path.replace(/^\/+/, '')}`
}

// Use `src` when present (already an absolute URL from the server), otherwise a
// Cloudinary theme-asset fallback given by its assets/img-relative path.
export function img(src?: string | null, fallbackRel = 'logo-icon.png'): string {
  return src && src.length > 0 ? src : cld(fallbackRel)
}
