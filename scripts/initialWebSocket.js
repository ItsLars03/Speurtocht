const socket = io(":5002/")

socket.on("connection", () => {
    console.log("Connected!")
})