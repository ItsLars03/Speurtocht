const socket = io(":5002/")

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}

console.log("COOKIES:",)

socket.on("connection", () => {
    console.log("Connected!")
})

console.log("emitting...")
socket.emit("socket-data", {
    userId: getCookie("user-id"),
    playerId: getCookie("player-id")
})
