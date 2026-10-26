export const formatTime = (secondsTime: number): string => {
    // Evitar valores negativos inesperados
    const absoluteSeconds = Math.abs(Math.floor(secondsTime));

    const hours = Math.floor(absoluteSeconds / 3600);
    const minutes = Math.floor((absoluteSeconds % 3600) / 60);
    const seconds = absoluteSeconds % 60;

    // Asegura que cada unidad tenga siempre 2 dígitos agregando un cero a la izquierda si es necesario
    const pad = (num: number): string => num.toString().padStart(2, '0');

    return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
};