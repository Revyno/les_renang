import SectionHeading from '@/components/home/SectionHeading'
import { img } from '@/lib/media'
import type { GalleryItem } from '@/types/models'

export default function Gallery({ data }: { data: GalleryItem[] }) {
  if (!data.length) return null

  return (
    <section id="galeri" className="bg-secondary/40 py-20 md:py-28">
      <div className="container">
        <SectionHeading
          eyebrow="Galeri"
          title="Momen di Kolam"
          description="Cuplikan keseruan dan pencapaian murid-murid kami."
        />
        <div className="mt-14 grid grid-cols-2 gap-4 md:grid-cols-3">
          {data.map((item) => (
            <figure
              key={item.id}
              className="group relative overflow-hidden rounded-2xl"
            >
              <img
                src={img(item.image)}
                alt={item.title ?? 'Galeri Les Renang'}
                className="aspect-square w-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
              />
              {item.title && (
                <figcaption className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-primary/80 to-transparent p-4 text-sm font-medium text-primary-foreground opacity-0 transition-opacity group-hover:opacity-100">
                  {item.title}
                </figcaption>
              )}
            </figure>
          ))}
        </div>
      </div>
    </section>
  )
}
