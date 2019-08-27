let songs = document.getElementsByTagName('audio');
for (let song of songs) {
    song.addEventListener("play", function() {
        for (otherSong of songs) {
            if (otherSong !== song) {
                otherSong.pause();
            }
        }
    });
}