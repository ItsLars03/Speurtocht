const { Router } = require("express")
const login = require('./user/login/index.js')
const scavengerhunt = require('./scavengerHunt/index.js')
const users = require('./user/users.js')
const sendMail = require('./mail/mail.js')

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

module.exports = router