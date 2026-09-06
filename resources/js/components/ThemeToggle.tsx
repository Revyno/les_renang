import { useEffect, useState } from 'react';
import { Moon, Sun } from 'lucide-react';
import { Button } from '@/components/ui/button';

/** Self-contained light/dark toggle. Initial class is set pre-paint in app.blade.php. */
export default function ThemeToggle() {
    const [dark, setDark] = useState(false);

    useEffect(() => {
        setDark(document.documentElement.classList.contains('dark'));
    }, []);

    const toggle = () => {
        const next = !dark;
        setDark(next);
        document.documentElement.classList.toggle('dark', next);
        try {
            localStorage.setItem('theme', next ? 'dark' : 'light');
        } catch {
            /* ignore */
        }
    };

    return (
        <Button
            variant="ghost"
            size="icon"
            onClick={toggle}
            aria-label={dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'}
            className="rounded-full"
        >
            {dark ? <Sun className="h-5 w-5" /> : <Moon className="h-5 w-5" />}
        </Button>
    );
}
