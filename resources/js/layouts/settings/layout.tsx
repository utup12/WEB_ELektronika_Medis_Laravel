import type { PropsWithChildren } from 'react';

export default function SettingsLayout({ children }: PropsWithChildren) {
    return <div className="px-4 py-6">{children}</div>;
}
