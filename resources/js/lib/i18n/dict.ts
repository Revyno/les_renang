export type Lang = 'id' | 'en'

export type Bundle = { id: Record<string, unknown>; en: Record<string, unknown> }

// Each file in dicts/ default-exports a Bundle namespaced under its own top-level
// key (e.g. { id: { home: {...} }, en: { home: {...} } }), so merging is a shallow
// Object.assign with no cross-file key collisions. Drop a new dict file and it's
// picked up automatically — no central registration, no merge conflicts.
const mods = import.meta.glob('./dicts/*.ts', { eager: true }) as Record<string, { default: Bundle }>

export const dict: Record<Lang, Record<string, unknown>> = { id: {}, en: {} }
for (const m of Object.values(mods)) {
  Object.assign(dict.id, m.default.id)
  Object.assign(dict.en, m.default.en)
}
