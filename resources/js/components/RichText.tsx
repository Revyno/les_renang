// Renders admin-authored HTML from the Filament rich editor (trusted source)
// so <p>, <ul>, <a>, etc. render as formatting instead of showing raw tags.
export default function RichText({ html, className = '' }: { html?: string | null; className?: string }) {
  return (
    <div
      className={`[&_p]:m-0 [&_p+p]:mt-3 [&_ul]:my-2 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:my-2 [&_ol]:list-decimal [&_ol]:pl-5 [&_a]:text-brand-500 [&_a]:underline ${className}`}
      dangerouslySetInnerHTML={{ __html: html ?? '' }}
    />
  )
}
