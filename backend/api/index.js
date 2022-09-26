import { Router } from "express";
import login from './login/index.js'
import scavengerhunt from './scavengerHunt/index.js'

const router = Router()

router.get("/", (req, res) => {
    res.send({ message: "hi" })
})

router.post("/test", (req, res) => {
    console.log("BODY!", req.body)
    res.status(200).send({ message: "success!" })
})

router.use("/login", login)
router.use("/scavengerhunt", scavengerhunt)

export default router