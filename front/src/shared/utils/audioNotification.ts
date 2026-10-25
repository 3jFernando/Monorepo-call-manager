let audioPlayer: HTMLAudioElement | null = null;

const getAudioPlayer = () => {
    if (!audioPlayer) {
        audioPlayer = new Audio('/rignton.mp3');
        audioPlayer.preload = 'auto';
    }
    return audioPlayer;
};

export default function playNotificationSound() {
    const audio = getAudioPlayer();
    audio.currentTime = 0;
    audio.play()
        .then(() => {})
        .catch(() => {});
}