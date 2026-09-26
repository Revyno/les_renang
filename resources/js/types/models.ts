// Shapes emitted by App\Http\Controllers\HomeController (and reused by subpages).
// Nullable fields mirror the DB: content is admin-managed and may be empty.

export interface Hero {
  title: string | null
  subtitle: string | null
  image: string | null
  cta_text: string | null
  cta_link: string | null
  secondary_cta_text: string | null
  secondary_cta_link: string | null
}

export interface About {
  title: string | null
  description: string | null
  img: string | null
}

export interface Stat {
  icon: string | null
  value: string | null
  label: string | null
}

export interface Service {
  icon_class: string | null
  title: string
  short_desc: string | null
  description: string | null
}

export interface Program {
  id: number
  name: string
  age_range: string | null
  schedule: string | null
  price: string | null
  thumbnail: string | null
  description: string | null
  instructor: string | null
}

export interface Instructor {
  id: number
  name: string
  specialization: string | null
  certification: string | null
  photo: string | null
  bio: string | null
  twitter: string | null
  experience: number | null
}

export interface ClientLogo {
  id: number
  image: string | null
}

export interface GalleryItem {
  id: number
  title: string | null
  image: string | null
}

export interface Faq {
  id: number
  question: string
  answer: string
}

export interface BlogPost {
  id: number
  title: string
  author: string | null
  image: string | null
  excerpt: string | null
  category: string | null
  date: string | null
}

export interface BlogDetailPost {
  id: number
  title: string
  image: string | null
  short_desc: string | null
  content: string | null
  category: string | null
  date: string | null
}

export interface SiteInfo {
  address: string | null
  phone: string | null
  email: string | null
  whatsapp: string | null
  whatsapp_message: string | null
  social: Record<string, string> | null
}

export interface SharedProps {
  auth: { user: { id: number; name: string; email: string } | null }
  flash: { success: string | null; error: string | null }
  cloudinary: { cloudName: string }
  site: SiteInfo
  [key: string]: unknown
}

// Laravel LengthAwarePaginator as serialized by Inertia.
export interface Paginated<T> {
  data: T[]
  links: { url: string | null; label: string; active: boolean }[]
  current_page: number
  last_page: number
  total: number
}

export interface HomeProps {
  meta: { title: string; description: string }
  hero: Hero | null
  about: About | null
  stats: Stat[]
  services: Service[]
  programs: Program[]
  instructors: Instructor[]
  clients: ClientLogo[]
  gallery: GalleryItem[]
  faqs: Faq[]
  blogs: BlogPost[]
}
