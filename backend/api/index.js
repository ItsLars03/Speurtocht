const { Router } = require("express")
const login = require('./user/login/index.js')
const scavengerhunt = require('./scavengerHunt/index.js')
const users = require('./user/users.js')
const mail = require('./mail/mail.js')

const router = Router()

router.use("/users/login", login)
router.use("/users", users)
router.use("/scavengerhunt", scavengerhunt)
router.use("/mail", mail)

module.exports = router