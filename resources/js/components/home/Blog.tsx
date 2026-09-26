import { ArrowRight, CalendarDays } from 'lucide-react'
import SectionHeading from '@/components/home/SectionHeading'
import { Card, CardContent } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { img } from '@/lib/media'
import type { BlogPost } from '@/types/models'

export default function Blog({ data }: { data: BlogPost[] }) {
  if (!data.length) return null

  return (
    <section id="blog" className="py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="Blog"
          title="Tips & Artikel Renang"
          description="Wawasan, tips latihan, dan kabar terbaru seputar dunia renang."
        />
        <div className="mt-14 grid gap-6 md:grid-cols-3">
          {data.map((post) => (
            <Card key={post.id} className="flex flex-col overflow-hidden">
              <img
                src={img(post.image, 'services-1.jpg')}
                alt={post.title}
                className="aspect-video w-full object-cover"
                loading="lazy"
              />
              <CardContent className="flex flex-1 flex-col p-6">
                <div className="mb-3 flex items-center gap-3 text-xs text-muted-foreground">
                  {post.category && <Badge variant="accent">{post.category}</Badge>}
                  {post.date && (
                    <span className="flex items-center gap-1">
                      <CalendarDays className="h-3.5 w-3.5" />
                      {post.date}
                    </span>
                  )}
                </div>
                <h3 className="text-lg font-semibold leading-snug text-primary">{post.title}</h3>
                {post.excerpt && <p className="mt-2 line-clamp-3 text-sm text-muted-foreground">{post.excerpt}</p>}
                <a
                  href={`/blog/${post.id}`}
                  className="mt-auto inline-flex items-center gap-1.5 pt-4 text-sm font-medium text-accent hover:underline"
                >
                  Baca selengkapnya
                  <ArrowRight className="h-4 w-4" />
                </a>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>
    </section>
  )
}
