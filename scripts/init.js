const BACKEND = "http://localhost:5001"

const socketConnected = false

const socket = io(":5002/")




const makeRequest = async (uri, method, data) => {
    try {
        const response = await fetch(uri, {
            method: method ?? "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: data == null ? null : JSON.stringify(data)
        })
        try {
            const json = await response.json()
            return { success: true, statusCode: response.status, response: json }
        } catch (error) {
            return response.ok ? { success: false, statusCode: response.status, message: "Something went wrong while handling the request." } :
                { success: false, statusCode: response.status, message: "Something went wrong with the server." }
        }
    } catch (error) {
        return Promise.reject(error)
    }
}


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
    socketConnected = true
})

console.log("emitting...")
socket.emit("socket-data", {
    userId: getCookie("user-id"),
    playerId: getCookie("player-id")
})
