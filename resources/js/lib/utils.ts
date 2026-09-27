import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function storageUrl(value: string | null | undefined): string | null {
  if (!value) {
    return null;
  }

  if (/^(?:https?:)?\/\//.test(value) || value.startsWith('data:') || value.startsWith('blob:')) {
    return value;
  }

  return `/storage/${value.replace(/^\/+/, '')}`;
}

export function formatDate(value: string | Date | null | undefined): string {
  if (!value) {
    return '';
  }

  const date = value instanceof Date ? value : new Date(value);

  if (Number.isNaN(date.getTime())) {
    return String(value);
  }

  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'short',
    year: 'numeric',
  }).format(date);
}
