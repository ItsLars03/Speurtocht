import { Router } from "express";

const router = Router()

router.get("/", (req, res) => {
    res.send({ message: "hi" })
})

router.post("/test", (req, res) => {
    console.log("BODY!", req.body)
    res.status(200).send({ message: "success!" })
})

export default router