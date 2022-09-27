import { Router } from "express";
import login from './user/login/index.js'
import scavengerhunt from './scavengerHunt/index.js'
import users from './user/users.js'
import sendMail from './mail/mail.js'

const router = Router()

// router.get("/", (req, res) => {
//     res.send({ message: "hi" })
// })

// router.post("/test", (req, res) => {
//     console.log("BODY!", req.body)
//     res.status(200).send({ message: "success!" })
// })

router.use("/users/login", login)
router.use("/users", users)
router.use("/scavengerhunt", scavengerhunt)
router.use("/mail", sendMail)

export default router