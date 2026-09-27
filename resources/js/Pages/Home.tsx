import { type ReactNode } from 'react'
import Seo from '@/components/Seo'
import SiteLayout from '@/Layouts/SiteLayout'
import Hero from '@/components/home/Hero'
import About from '@/components/home/About'
import Services from '@/components/home/Services'
import WhyUs from '@/components/home/WhyUs'
import Blog from '@/components/home/Blog'
import Faq from '@/components/home/Faq'
import Cta from '@/components/home/Cta'
import type { HomeProps } from '@/types/models'

export default function Home(props: HomeProps) {
  return (
    <>
      <Seo title={props.meta.title} description={props.meta.description} />
      <Hero data={props.hero} />
      <About data={props.about} gallery={props.gallery} />
      <Services data={props.services} />
      <WhyUs stats={props.stats} />
      <Blog data={props.blogs} />
      <Faq data={props.faqs} />
      <Cta />
    </>
  )
}

Home.layout = (page: ReactNode) => <SiteLayout>{page}</SiteLayout>
