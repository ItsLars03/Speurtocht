const BACKEND = "http://localhost:5001"

const socket = io(":5002/")

socket.on("connection", () => {
    console.log("Connected!")
})


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
        return response.ok ? response.json : Promise.reject({ statusCode: response.status, message: "Something went wrong with the request." })
    } catch (error) {
        return Promise.reject(error)
    }
}
