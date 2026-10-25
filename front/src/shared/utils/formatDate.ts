export const formatDate = (
    dateString: string | null | undefined,
    locale: string = 'es',
    options: Intl.DateTimeFormatOptions = {},
): string => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString(locale, {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        ...options,
    });
};