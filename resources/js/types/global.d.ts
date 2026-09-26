import type { PageProps as InertiaPageProps } from '@inertiajs/core';

export interface SharedProps {
  auth: { user: { id: number; name: string; email: string } | null };
  flash: { success: string | null; error: string | null };
  cloudinary: { cloudName: string | null };
}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaPageProps, SharedProps {}
}
