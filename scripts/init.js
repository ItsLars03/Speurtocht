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
