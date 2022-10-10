const { Router } = require("express")
const nodemailer = require('nodemailer')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()

router.post("/send", async (req, res) => {
    console.log("user", process.env.EMAIL_USER)
    const {
        html = "<html>Hello World</html>",
        text = "Hello World",
        subject = "Mail!",
        to = "admin@admin.nl",
        scavengerHuntId
    } = req.body

    try {
        let transporter = nodemailer.createTransport({
            host: "mail.antagonist.nl",
            port: 465,
            secure: true, // true for 465, false for other ports
            auth: {
                user: process.env.EMAIL_USER, // generated ethereal user
                pass: process.env.EMAIL_PASS, // generated ethereal password
            },
        });

        const data = await prisma.emails.create({
            data: {
                scavengerHuntId,
                email: to,
            }
        })


        let info = await transporter.sendMail({
            from: process.env.EMAIL_FROM, // sender address
            to, // list of receivers
            subject, // Subject line
            text: text.replace("{emailId}", data.emailId).replace("{host}", process.env.HOST), // plain text body
            html: html.replace("{emailId}", data.emailId).replace("{host}", process.env.HOST), // html body
        });

        if (!info.accepted.includes(to)) {
            res.status(500).json({
                success: false,
                message: "Could not send an email to this email adres."
            })
            return
        }

        res.status(200).json({
            success: true,
            data,
            info: { message: "not sending email right now." }
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: error.message.includes("too many emails") ? "Too many emails have been sent." : "Internal Server Error."
        })
    }
})

//get all from scavengerHunt
router.get("/scavengerhunt/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.emails.findMany({
            where: {
                scavengerHuntId
            },
            orderBy: {
                createdAt: "asc"
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})

//get specific email from emailId
router.get("/:emailId", async (req, res) => {
    const { emailId } = req.params

    try {
        const data = await prisma.emails.findFirst({
            where: {
                emailId
            }
        })

        if (data == null) {
            res.status(404).json({
                success: false,
                message: "Could not find an email with the specified id."
            })
            return
        }

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})


//create one for scavengerHunt
router.post("/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params
    const { email } = req.body

    try {
        const data = await prisma.emails.create({
            data: {
                scavengerHuntId,
                email
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})


module.exports = router