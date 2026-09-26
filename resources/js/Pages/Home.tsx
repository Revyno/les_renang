import { type ReactNode } from 'react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import Hero from '@/components/home/Hero'
import About from '@/components/home/About'
import Stats from '@/components/home/Stats'
import Services from '@/components/home/Services'
import Programs from '@/components/home/Programs'
import Instructors from '@/components/home/Instructors'
import Gallery from '@/components/home/Gallery'
import Faq from '@/components/home/Faq'
import Blog from '@/components/home/Blog'
import Contact from '@/components/home/Contact'
import type { HomeProps } from '@/types/models'

export default function Home(props: HomeProps) {
  return (
    <>
      <Seo title={props.meta.title} description={props.meta.description} />
      <Hero data={props.hero} />
      <Stats data={props.stats} />
      <About data={props.about} />
      <Services data={props.services} />
      <Programs data={props.programs} />
      <Instructors data={props.instructors} />
      <Gallery data={props.gallery} />
      <Blog data={props.blogs} />
      <Faq data={props.faqs} />
      <Contact />
    </>
  )
}

Home.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
